<?php
// Configuración de parámetros de acceso a XAMPP / MariaDB
$host     = "localhost";
$user     = "root";         // Usuario por defecto en XAMPP
$password = "";             // Contraseña por defecto (vacía en XAMPP)
$database = "vehiculos_db"; // Nombre de la base de datos creada en phpMyAdmin

try {
    // Crear la conexión PDO a MySQL/MariaDB con codificación UTF-8 para tildes y caracteres especiales
    $conexion = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $user, $password);
    
    // Configurar el modo de errores para que lance excepciones en caso de fallos
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Establecer el modo de obtención predeterminado como array asociativo
    $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Si la conexión falla, detiene el proceso y muestra el mensaje de error
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>