<?php

require 'flight/Flight.php';//framework

flight::register('db', 'PDO', array('mysql:host = localhost;dbname =api', 'root', 'root'));

Flight::route('/saludar', function () {//ruta o solicitud
    echo 'Hola Elias!';
});

Flight::start();
