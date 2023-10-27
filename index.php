<?php

require 'flight/Flight.php';//framework

Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=api','root','root'));

//lee los datos y los muestra a cualquier interfaz que lo solicita
Flight::route('GET /alumnos', function () {//ruta o solicitud
    $sentencia = Flight::db()->prepare("SELECT * FROM `alumnos`"); //prepara la base de datos
    $sentencia->execute();
    $datos=$sentencia->fetchAll();

    Flight::json($datos);
});

//recepciona los datos por metodo post y hace un insert
Flight::route('POST /alumnos', function () {//ruta o solicitud)
$nombres=(Flight::request()->data->nombres);//recibe una variable que viene del metodo post
$apellidos=(Flight::request()->data->apellidos);

$sql="INSERT INTO alumnos (nombres, apellidos) VALUES(?,?)";
$sentencia = Flight::db()->prepare($sql);
$sentencia->bindParam(1,$nombres);
$sentencia->bindParam(2,$apellidos);
$sentencia->execute();

Flight::jsonp(["Alumno agregado"]);

print_r($nombres);

});
Flight::start();
