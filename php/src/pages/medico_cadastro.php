<?php

require_once "../database/MedicoDB.php";
require_once "../model/Pessoa.php";
require_once "../model/Medico.php";
require_once "../control/CPFUtils.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!CPFUtils::validaCPF($_POST['cpf'])) {
        echo "<script>alert('O CPF informado é inválido!');</script>";
        echo "<script>window.location.href='medico_cadastro.php'</script>";
    } else if (isset($_SESSION['medicoParaEditar'])) {
        MedicoDB::updateMedico($_POST);
    } else if (MedicoDB::medicoAlreadyExists($_POST['cpf'])) {
        echo "<script>alert('Este CPF já está cadastrado!');</script>";
        echo "<script>window.location.href='medico_cadastro.php'</script>";
        die();
    } else {
        MedicoDB::registerMedico($_POST);
        echo "<script>window.location.href='medico.php'</script>";
    }
}

/* fixa variável na sessão para ser mantida após o refresh() */
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['acao']) && $_GET['acao'] == 'edit') {
    $_SESSION['medicoParaEditar'] = encontrarMedicoParaEditar($_GET['id']);
}

/* limpa sessão para não atrapalhar em novos cadastros */
if (!isset($_GET['acao'])) {
    $_SESSION['medicoParaEditar'] = null;
}

function encontrarMedicoParaEditar(string $id): Object
{
    if (isset($id)) {
        $medico = MedicoDB::findMedicoById($id);
        return $medico[0];
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>HOSPITALLICVS: cadastro</title>
    <link rel="stylesheet" href="../lib/fontawesome-free-5.15.4/css/fontawesome.min.css">
    <link rel="stylesheet" href="../lib/fontawesome-free-5.15.4/css/brands.min.css">
    <link rel="stylesheet" href="../lib/fontawesome-free-5.15.4/css/solid.min.css">
    <link rel="stylesheet" href="../lib/bootstrap-5.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../lib/bootstrap-5.1.1/css/bootstrap-grid.min.css">
    <style type="text/css">
        h1 {
            font-weight: bold;
        }

        .table thead {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <br />
    <div class="container-fluid">
        <div class="row">
            <div class="col" align="center">
                <h1>Cadastro Médico</h1>
            </div>
        </div>
        <div class="row">
            <div class="col" id="button-home">
                <button type="button" class="btn btn-secondary" onclick="location.href='medico.php'">
                    <i class="fas fa-arrow-left"></i>
                    Listagem
                </button>
            </div>
        </div>
        <br />
        <div class="form-group" style="padding-left:1%;">
            <form method="post" action="medico_cadastro.php" onsubmit="return onSubmit()">
                <div class="row">
                    <div class="col col-md-1">
                        <label for="id_medico">ID</label><br />
                        <input class="form-control" readonly hiden type="text" id="id_medico" name="id_medico" value="<?= isset($_SESSION['medicoParaEditar']->id) ? $_SESSION['medicoParaEditar']->id : '' ?>" /><br /><br />
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-3">
                        <label for="nome">Nome:</label><br />
                        <input class="form-control" type="text" id="nome" name="nome" value="<?= isset($_SESSION['medicoParaEditar']->nome) ? $_SESSION['medicoParaEditar']->nome : '' ?>" required><br /><br />
                    </div>
                    <div class="col col-md-2">
                        <label for="cpf">CPF:</label><br />
                        <input class="form-control" type="text" id="cpf" name="cpf" oninput="verificarCPF(this.value)" value="<?= isset($_SESSION['medicoParaEditar']->cpf) ? str_replace(' ', '', $_SESSION['medicoParaEditar']->cpf) : '' ?>" required><br /><br />
                    </div>
                    <div class="col col-md-1" style="padding-top: 1.5%;">
                        <button type="button" class="btn btn-success" id="botao-limpar" onclick="limparCampoCPF()" title="Limpar campo CPF">
                            <i class="fas fa-broom"></i>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-5">
                        <label for="crm">CRM:</label><br />
                        <input class="form-control" type="text" id="crm" name="codigo-crm" value="<?= isset($_SESSION['medicoParaEditar']->codigo_crm) ? $_SESSION['medicoParaEditar']->codigo_crm : '' ?>" required><br /><br />
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-2">
                        <label for="telefone">Telefone:</label><br />
                        <input class="form-control" type="text" id="telefone" name="telefone" value="<?= isset($_SESSION['medicoParaEditar']->telefone) ? $_SESSION['medicoParaEditar']->telefone : '' ?>"><br /><br />
                    </div>
                    <div class="col col-md-3">
                        <label for="email">E-mail:</label><br />
                        <input class="form-control" type="text" id="email" name="email" value="<?= isset($_SESSION['medicoParaEditar']->email) ? $_SESSION['medicoParaEditar']->email : '' ?>"><br /></br>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            <?= isset($_SESSION['medicoParaEditar']) ? 'Atualizar' : 'Cadastrar' ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="../lib/jquery/jquery-3.6.0.min.js"></script>
    <script src="../lib/jquery-mask/src/jquery.mask.js"></script>
    <script src="../lib/bootstrap-5.1.1/js/bootstrap.min.js"></script>
    <script src="../lib/bootstrap-5.1.1/js/bootstrap.min.js"></script>
    <script src="../js/cpfUtils.js"></script>

    <script>
        $(document).ready(function() {
            $('#crm').mask('00000');
            $('#cpf').mask('000.000.000-00');
            $('#telefone').mask('(00) 00000-0000');
        });

        function onSubmit() {
            $('#crm').unmask('00000');
            $('#cpf').unmask('000.000.000-00');
            $('#telefone').unmask('(00) 00000-0000');
        }
    </script>

</body>

</html>