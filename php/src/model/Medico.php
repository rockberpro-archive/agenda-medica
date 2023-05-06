<?php

class Medico extends Pessoa
{
    public $ref_pessoa;
    public $codigo_crm;

    public function __construct() {}

    public function __destruct()
    {
        foreach ($this as $key => $value) {
            unset($value);
        }
    }
}
