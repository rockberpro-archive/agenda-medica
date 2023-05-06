<?php

require_once "../database/PacienteDB.php";
require_once "../model/Pessoa.php";
require_once "../model/Paciente.php";
require_once "../control/CPFUtils.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!CPFUtils::validaCPF($_POST['cpf'])) {
        echo "<script>alert('O CPF informado é inválido!');</script>";
        echo "<script>window.location.href='medico_cadastro.php'</script>";
    } 
    else if (isset($_SESSION['pacienteParaEditar'])) {
        PacienteDB::updatePaciente($_POST);
    } 
    else if (PacienteDB::pacienteAlreadyExists($_POST['cpf'])) {
        echo "<script>alert('Este CPF já está cadastrado!');</script>";
        echo "<script>window.location.href='paciente_cadastro.php'</script>";
        die();
    } 
    else {
        PacienteDB::registerPaciente($_POST);
        echo "<script>window.location.href='paciente.php'</script>";
    }
}

/* fixa variável na sessão para ser mantida após o refresh() */
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['acao']) && $_GET['acao'] == 'edit') {
    $_SESSION['pacienteParaEditar'] = encontrarPacienteParaEditar($_GET['id']);
}

/* limpa sessão para não atrapalhar em novos cadastros */
if (!isset($_GET['acao'])) {
    $_SESSION['pacienteParaEditar'] = null;
}

function encontrarPacienteParaEditar(string $id): Object
{
    if (isset($id)) {
        $paciente = PacienteDB::findPacienteById($id);
        return $paciente[0];
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
                <h1>Cadastro Paciente</h1>
            </div>
        </div>
        <div class="row">
            <div class="col" id="button-home" style="padding-left:1%;">
                <button type="button" class="btn btn-secondary" onclick="location.href='paciente.php'">
                    <i class="fas fa-arrow-left"></i>
                    Listagem
                </button>
            </div>
        </div>
        <br />
        <div class="form-group" style="padding-left:1%;">
            <form method="post" action="paciente_cadastro.php" onsubmit="onSubmit()">
                <div class="row">
                    <div class="col col-md-1">
                        <label for="id_paciente">ID</label><br />
                        <input class="form-control" readonly hiden type="text" id="id_paciente" name="id_paciente" value="<?= isset($_SESSION['pacienteParaEditar']->id) ? $_SESSION['pacienteParaEditar']->id : '' ?>" /><br /><br />
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-3">
                        <label for="nome">Nome:</label><br />
                        <input class="form-control" type="text" id="nome" name="nome" value="<?= isset($_SESSION['pacienteParaEditar']->nome) ? $_SESSION['pacienteParaEditar']->nome : '' ?>" required><br /><br />
                    </div>
                    <div class="col col-md-2">
                        <label for="cpf">CPF:</label><br />
                        <input class="form-control" type="text" id="cpf" name="cpf" oninput="verificarCPF(this.value)" value="<?= isset($_SESSION['pacienteParaEditar']->cpf) ? str_replace(' ', '', $_SESSION['pacienteParaEditar']->cpf) : '' ?>" required><br /><br />
                    </div>
                    <div class="col col-md-1" style="padding-top: 1.5%;">
                        <button type="button" class="btn btn-success" id="botao-limpar" onclick="limparCampoCPF()" title="Limpar campo CPF">
                            <i class="fas fa-broom"></i>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-2">
                        <label for="telefone">Telefone:</label><br />
                        <input class="form-control" type="text" id="telefone" name="telefone" value="<?= isset($_SESSION['pacienteParaEditar']->telefone) ? $_SESSION['pacienteParaEditar']->telefone : '' ?>" /><br /><br />
                    </div>
                    <div class="col col-md-3">
                        <label for="email">E-mail:</label><br />
                        <input class="form-control" type="text" id="email" name="email" value="<?= isset($_SESSION['pacienteParaEditar']->email) ? $_SESSION['pacienteParaEditar']->email : '' ?>"><br /></br>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            <?= isset($_SESSION['pacienteParaEditar']) ? 'Atualizar' : 'Cadastrar' ?>
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
            $('#cpf').mask('000.000.000-00');
            $('#telefone').mask('(00) 00000-0000');
        });

        function onSubmit() {
            $('#cpf').unmask('000.000.000-00');
            $('#telefone').unmask('(00) 00000-0000');
        }
    </script>

</body>

</html>