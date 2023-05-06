<?php

class Paciente extends Pessoa
{
    public $ref_pessoa;

    public function __construct() {}

    public function __destruct()
    {
        foreach ($this as $key => $value) {
            unset($value);
        }
    }
}
