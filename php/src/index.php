<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="lib/fontawesome-free-5.15.4/css/fontawesome.min.css">
    <link rel="stylesheet" href="lib/fontawesome-free-5.15.4/css/brands.min.css">
    <link rel="stylesheet" href="lib/fontawesome-free-5.15.4/css/solid.min.css">
    <link rel="stylesheet" href="lib/bootstrap-5.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="lib/bootstrap-5.1.1/css/bootstrap-grid.min.css">
    <title>HOSPITALLICVS</title>
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
            <div class="col" style="padding-bottom:2%;">
                <img src="img/logo/logo4.png" type="img/png" >
            </div>
        </div>
        <div class="row"></div>
        <div class="row">
            <div class="col-2">
                <button type="button" class="btn btn-primary btn-lg" onclick="location.href='pages/medico.php'">
                    <i class="fas fa-user-md"></i>
                    Médicos
                </button>
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-primary btn-lg" onclick="location.href='pages/paciente.php'">
                    <i class="fas fa-hospital-user"></i>
                    Pacientes
                </button>
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-primary btn-lg" onclick="location.href='pages/consulta.php';">
                    <i class="fas fa-stethoscope"></i>
                    Consultas
                </button>
            </div>
            <div class="col-lg-6">
            </div>
        </div>
    </div>

    <script src="lib/jquery/jquery-3.6.0.min.js"></script>
    <script src="lib/bootstrap-5.1.1/js/bootstrap.min.js"></script>
    <script src="lib/bootstrap-5.1.1/js/bootstrap.min.js"></script>
</body>

</html>