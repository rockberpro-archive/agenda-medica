<?php

require_once "../../src/database/Conexao.php";

$pdo = Conexao::getConexao();

$sth = $pdo->prepare("select * from consulta");

$sth->execute();

while($result = $sth->fetchObject()) {
    var_dump($result);
}