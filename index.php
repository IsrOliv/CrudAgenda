<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
spl_autoload_register(function($class) {
    if (file_exists("$class.php")) {
        require_once "$class.php";
        return true;
    }
});

?>
<!DOCTYPE html>
<html lang='pt-br'>
    <header>
        <title>Contatos</title>
    
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link href='https://use.fontawesome.com/releases/v5.1.0/css/all.css' rel='stylesheet' integrity='sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt' crossorigin='anonymous' />

        <!-- JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        
        <style type="text/css" media="all">
            body{ font-family:Arial }
            .erro{color:#ED1C24; margin:0}
            .ok{color:#006633; margin:0} 
        </style>

        <script type="text/javascript">

            $(document).ready(function() {
                 var sEmail  = $("#email").val();
                 var tel = $('#telefone').val();

                $("p").hide();               
                $('#email').hover(function(){
                                    
                    sEmail  = $("#email").val();
                    var emailFilter=/^.+@.+\..{2,}$/;
                    var illegalChars= /[\(\)\<\>\,\;\:\\\/\"\[\]]/
                    if(!(emailFilter.test(sEmail))||sEmail.match(illegalChars)){
                       
                        $("#submit").prop("disabled", true);
                        $("p").show().removeClass("ok").addClass("erro")
                        .text('Por favor, informe um email válido.');
                    }else{

                        $("#submit").prop("disabled", false);
                    }
                    
                });             
                
                $('#telefone').hover(function(){
                    exp = /\(\d{2}\)\ \d{4}\-\d{4}/
                    tel = $('#telefone').val();
                    if(!exp.test(tel)){
                        $("#submit").prop("disabled", true);
                        $("p").show().removeClass("ok").addClass("erro")
                        .text('Por favor, informe um telefone válido.');
                    }else{
                        $("#submit").prop("disabled", false);
                        
                    }
                });
                
                $('#nome').focusout(function(){
                    $("p.erro").hide();
                });
                $('#telefone').focusout(function(){
                    $("p.erro").hide();
                });
                $('#email').focusout(function(){
                    $("p.erro").hide();
                });

            });

        </script>
        <?php $chart = contato::chart(); ?>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">

            google.charts.load("current", {packages:["corechart"]});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Inicial', 'Contatos', { role: 'style' } ],
        ['A', <?php echo intval($chart['a']); ?>, 'stroke-color: black; stroke-opacity: 0.6; stroke-width: 5; fill-color: gray; fill-opacity: 0.7'],
        ['B', <?php echo intval($chart['b']); ?>, 'stroke-color: black; stroke-opacity: 0.6; stroke-width: 5; fill-color: gray; fill-opacity: 0.7'],
        ['C', <?php echo intval($chart['c']); ?>, 'stroke-color: black; stroke-opacity: 0.6; stroke-width: 5; fill-color: gray; fill-opacity: 0.7'],
        ['D', <?php echo intval($chart['d']); ?>, 'stroke-color: black; stroke-opacity: 0.6; stroke-width: 5; fill-color: gray; fill-opacity: 0.7'],
        ['TOTAL', <?php echo intval($chart['total']); ?>, 'stroke-color: black; stroke-opacity: 0.6; stroke-width: 5; fill-color: gray; fill-opacity: 0.7']
    ]);

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
               { calc: "stringify",
                 sourceColumn: 1,
                 type: "string",
                 role: "annotation" },
               2]);

    var options = {
        title: "Iniciam com a letra:",
        width: 700,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
    var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
            chart.draw(view, options);
            }
        </script>       
    </header>
    <body>
    <?php
        if ($_GET) {
            $controller = isset($_GET['controller']) ? ((class_exists($_GET['controller'])) ? new $_GET['controller'] : NULL ) : null;
            $method     = isset($_GET['method']) ? $_GET['method'] : null;
            if ($controller && $method) {
                if (method_exists($controller, $method)) {
                    $parameters = $_GET;
                    unset($parameters['controller']);
                    unset($parameters['method']);
                    call_user_func(array($controller, $method), $parameters);
                } else {
                    echo "Método não encontrado!";
                }
            } else {
                echo "Controller não encontrado!";
            }
        } else {
            echo '<h1>Contatos</h1><hr><div class="container">';
            echo 'Bem-vindo ao aplicativo de gerenciamento de Contatos! <br />';
            echo 'Você possui '.intval($chart['total']).' contatos cadastrados!  <br /><br />';
            echo '<a href="?controller=ContatosController&method=listar" class="btn btn-success">Explorar agenda</a></div>';
            echo '<div id="barchart_values" style="width: 900px; height: 300px;"></div>';
        }
    ?>
    </body>
</html>