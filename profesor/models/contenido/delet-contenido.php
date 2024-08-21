<?php

require_once '../../../includes/conexion.php';

if($_POST) {
    $idcontenido = $_POST['idcontenido'];

    $sql = "SELECT * FROM contenidos WHERE contenido_id = ?";
    $query = $pdo->prepare(($sql));
    $query->execute(array($idcontenido));
    $data = $query->fetch(PDO::FETCH_ASSOC);

    $sqle = "SELECT * FROM evaluaciones WHERE contenido_id = ?";
    $querye = $pdo->prepare(($sqle));
    $querye->execute(array($idcontenido));
    $data2 = $querye->fetch(PDO::FETCH_ASSOC);

    if(empty($data2)){
        $sql_update = "DELETE FROM contenidos WHERE contenido_id = ?";
        $query_update = $pdo->prepare($sql_update);
        $result = $query_update->execute(array($idcontenido));
        if($result) {
            if($data['material'] != ''){
                  unlink($data['material']);
            }
            $arrResponse = array('status' => true,'msg' => 'Eliminado Correctamente');
        } else {
            $arrResponse = array('status' => false,'msg' => 'Error al eliminar');
        }
    } else {
        $arrResponse = array('status' => false,'msg' => 'No se puede eliminar, ya tiene una evaluacion asignada');
    }

    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
}