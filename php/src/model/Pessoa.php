<?php

class Pessoa
{
    public $id;
    public $nome;
    public $cpf;
    public $telefone;
    public $email;
    public $data_cadastro;

    public function __construct()
    {
        //
    }

    public function __destruct()
    {
        foreach ($this as $key => $row) {
            unset($row);
        }
    }
}
