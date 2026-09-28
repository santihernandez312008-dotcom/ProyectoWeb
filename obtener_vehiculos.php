<?php
// Permitir que el navegador reciba la respuesta en formato JSON
header('Content-Type: application/json; charset=utf-8');

// Incluir el archivo de conexión a MariaDB/MySQL
require_once 'conexion.php';

try {
    // Consulta SQL uniendo la tabla principal (vehiculos) con las tablas relacionadas (marcas y categorias)
    $sql = "SELECT 
                v.id, 
                m.nombre AS marca, 
                c.nombre AS categoria, 
                v.modelo, 
                v.anio, 
                v.precio, 
                v.cilindraje, 
                v.potencia, 
                v.consumo, 
                v.imagen 
            FROM vehiculos v
            INNER JOIN marcas m ON v.marca_id = m.id
            INNER JOIN categorias c ON v.categoria_id = c.id
            ORDER BY v.id DESC";

    // Preparar y ejecutar la consulta
    $stmt = $conexion->prepare($sql);
    $stmt->execute();

    // Obtener todos los registros en un arreglo asociativo
    $vehiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Enviar los datos en formato JSON
    echo json_encode($vehiculos, JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    // En caso de error, devolver una respuesta JSON con la descripción del fallo
    http_response_code(500);
    echo json_encode([
        "error" => "Error al obtener los vehículos: " . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>