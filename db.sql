create database db_agenda;
use db_agenda;

create table tbl_contatos (
id int unsigned auto_increment primary key,
nome varchar(80) not null,
telefone varchar(20) default null,
email varchar(80) default null
);