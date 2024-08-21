<?php

// Variables de conexión a la base de datos
$host = 'localhost';
$user = 'root';
$db = 'intranet';
$pass = '';

// Intenta conectarse a la base de datos
try {
    // Crea una nueva instancia de PDO
    $pdo = new PDO(
        'mysql:host=' . $host . ';dbname=' . $db . ';charset=utf8',
        $user,
        $pass,
        array(
            PDO::ATTR_TIMEOUT => 10,
        )
    );

    // Establece el modo de error para PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    // Imprime un mensaje de error
    echo 'Error: ' . $e->getMessage();
}

function getDbConnection($host, $user, $db, $pass)
{
    // Intenta conectarse a la base de datos
    try {
        // Crea una nueva instancia de PDO
        $pdo = new PDO(
            'mysql:host=' . $host . ';dbname=' . $db . ';charset=utf8',
            $user,
            $pass,
            array(
                PDO::ATTR_TIMEOUT => 10,
            )
        );

        // Establece el modo de error para PDO
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    } catch (Exception $e) {
        // Imprime un mensaje de error
        echo 'Error: ' . $e->getMessage();

        return null;
    }
}

// Conectarse a la base de datos
$pdo = getDbConnection('localhost', 'root', 'intranet', '');
