<?php
session_start();
if(!empty($_POST)) {
    if(empty($_POST['loginAlumno']) || empty($_POST['passAlumno'])) {
        echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Todos los campos son necesarios</div>';
    } else {
        require_once 'conexion.php';
        $login = $_POST['loginAlumno'];
        $pass = $_POST['passAlumno'];

        $sql = 'SELECT * FROM alumnos WHERE cedula = ?';
        $query = $pdo->prepare($sql);
        $query->execute(array($login));
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($query->rowCount() > 0) {

            date_default_timezone_set('America/La_Paz');
            $fecha = date('Y-m-d H:i:s');
            $id_alumno = $result['alumno_id'];
            $sql = "UPDATE alumnos SET u_acceso = '$fecha' WHERE alumno_id = ?";
            $query = $pdo->prepare($sql);
            $res = $query->execute(array($id_alumno));

            if($res){
                if(password_verify($pass, $result['clave'])) {
                    $_SESSION['activeA'] = true;
                    $_SESSION['alumno_id'] = $result['alumno_id'];
                    $_SESSION['nombre'] = $result['nombre_alumno'];
                    $_SESSION['cedula'] = $result['cedula'];
                    $_SESSION['u_acceso'] = $result['u_acceso'];
    
                    echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Redirecting</div>';
            }

            
            }else {
                echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Usuario o Clave incorrectos</div>';
            }
        } else {
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Usuario o Clave incorrectos</div>';
        }
    } 
}