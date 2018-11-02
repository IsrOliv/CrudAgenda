
<div class="container">

    <form id="form" action="?controller=ContatosController&<?php echo isset($contato->id) ? "method=atualizar&id={$contato->id}" : "method=salvar"; ?>" method="post" >
        <div class="card" style="top:40px">
            <div class="card-header">
                <span class="card-title">Contatos</span>
            </div>
            <div class="card-body">
                 <p></p>
            </div>
            <div class="form-group form-row">
                <label class="col-sm-2 col-form-label text-right">Nome:</label>
                <input type="text" class="form-control col-sm-8" name="nome" id="nome" value="<?php
                echo isset($contato->nome) ? $contato->nome : null;
                ?>" />
            </div>
            <div class="form-group form-row">
                <label class="col-sm-2 col-form-label text-right">Telefone:</label>
                <input type="text" class="form-control col-sm-8" name="telefone" id="telefone" value="<?php
                echo isset($contato->telefone) ? $contato->telefone : null;
                ?>" pattern="\([0-9]{2}\)[\s][0-9]{4}-[0-9]{4,5}" />
            </div>
            <div class="form-group form-row">
                <label class="col-sm-2 col-form-label text-right">Email:</label>
                <input type="text" class="form-control col-sm-8" name="email" id="email" value="<?php
                echo isset($contato->email) ? $contato->email : null;
                ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" />
            </div>           
            <div class="card-footer">
                <input type="hidden" name="id" id="id" value="<?php echo isset($contato->id) ? $contato->id : null; ?>" />
                <button class="btn btn-success" type="submit" id="submit">Salvar</button>                
                <a class="btn btn-secondary" href="?controller=ContatosController&method=limpar&id=<?php echo $contato->id; ?>">Limpar</a>
                <a class="btn btn-danger" href="?controller=ContatosController&method=listar">Cancelar</a>
            </div>
        </div>
    </form>
    <script type="text/javascript">$("#telefone").mask("(00) 0000-00009");</script>
</div>