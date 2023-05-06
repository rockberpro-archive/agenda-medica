<?php

class SituacaoConsulta
{
    public $id;
    public $nome;
    public $descricao;

    public function __construct()
    {
        //
    }

    public function __destruct()
    {
        foreach ($this as $key => $value) {
            unset($value);
        }
    }
}
