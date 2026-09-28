<?php
// Iniciar la sesión de PHP para guardar el estado del usuario
session_start();

// Incluir el archivo de conexión a la base de datos
require_once 'conexion.php';

// Verificar que los datos hayan sido enviados mediante el método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Obtener y limpiar los datos recibidos del formulario
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validar que los campos no estén vacíos
    if (!empty($email) && !empty($password)) {
        try {
            // Consultar la tabla 'usuarios' buscando el correo ingresado
            $stmt = $conexion->prepare("SELECT id, nombre, email, password, rol FROM usuarios WHERE email = :email LIMIT 1");
            $stmt->execute([':email' => $email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar si el usuario existe y si la contraseña coincide (soporta texto plano o hash)
            if ($usuario && ($password === $usuario['password'] || password_verify($password, $usuario['password']))) {
                
                // Guardar la información del usuario en variables de sesión
                $_SESSION['usuario_id']     = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario_rol']    = $usuario['rol'];

                // Redirigir a la página principal (Dashboard)
                header("Location: index.html");
                exit();

            } else {
                // Mensaje si la contraseña o el correo son incorrectos
                echo "<script>
                        alert('Correo o contraseña incorrectos.');
                        window.location.href = 'login.html';
                      </script>";
                exit();
            }

        } catch (PDOException $e) {
            die("Error en la autenticación: " . $e->getMessage());
        }
    } else {
        echo "<script>
                alert('Por favor, ingrese el correo y la contraseña.');
                window.location.href = 'login.html';
              </script>";
        exit();
    }
} else {
    // Si intenta acceder directamente a login.php por URL, redirigir a login.html
    header("Location: login.html");
    exit();
}
?>