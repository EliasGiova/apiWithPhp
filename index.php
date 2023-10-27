<?php

require 'flight/Flight.php'; //framework

Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=api', 'root', 'root'));

//lee los datos y los muestra a cualquier interfaz que lo solicita
Flight::route('GET /alumnos', function () { //ruta o solicitud
    
    $sentencia = Flight::db()->prepare("SELECT * FROM `alumnos`"); //prepara la base de datos
    
    $sentencia->execute();
   
    $datos = $sentencia->fetchAll();

    Flight::json($datos);
    
});

//recepciona los datos por metodo post y hace un insert
Flight::route('POST /alumnos', function () { //ruta o solicitud)
    
    $nombres = (Flight::request()->data->nombres); //recibe una variable que viene del metodo post
    $apellidos = (Flight::request()->data->apellidos);

    $sql = "INSERT INTO alumnos (nombres, apellidos) VALUES(?,?)";
    
    $sentencia = Flight::db()->prepare($sql);
    
    $sentencia->bindParam(1, $nombres);
   
    $sentencia->bindParam(2, $apellidos);
    
    $sentencia->execute();

    Flight::jsonp(["Alumno agregado"]);

});

//borrar registros
Flight::route('DELETE /alumnos', function () { //ruta o solicitud
   
    $id = (Flight::request()->data->id);
    
    $sql = "DELETE FROM alumnos WHERE id=?";
    
    $sentencia = Flight::db()->prepare($sql);
    
    $sentencia->bindParam(1, $id);
    
    $sentencia->execute();

    Flight::jsonp(["Alumno borrado"]);

});

//Actualizar datos
Flight::route('PUT /alumnos', function () { //ruta o solicitud
    
    $id = (Flight::request()->data->id);
    $nombres = (Flight::request()->data->nombres); 
    $apellidos = (Flight::request()->data->apellidos);
    
    $sql = "UPDATE alumnos SET nombres = ?, apellidos = ? WHERE id= ?";
   
    $sentencia = Flight::db()->prepare($sql);
    
    $sentencia->bindParam(3, $id);
    
    $sentencia->bindParam(1, $nombres);
    
    $sentencia->bindParam(2, $apellidos);
    
    $sentencia->execute();

    Flight::jsonp(["Alumno Modificado"]);

});

//lectura de un registro particular
Flight::route('GET /alumnos/@id', function ($id) { //ruta o solicitud
   
    $sentencia = Flight::db()->prepare("SELECT * FROM `alumnos` WHERE id=?"); //prepara la base de datos
    
    $sentencia->bindParam(1, $id);
    
    $sentencia->execute();
    
    $datos = $sentencia->fetchAll();

    Flight::json($datos);

});

Flight::start();
