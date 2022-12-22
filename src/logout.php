<?php

/**********************************************************************************************************************
 * Este script tan solo tiene que destruir la sesión y volver a la página principal.
 * 
 * UN USUARIO NO LOGEADO NO PUEDE ACCEDER A ESTE SCRIPT.
 */

/**********************************************************************************************************************
 * Lógica del programa
 * 
 * Tareas a realizar:
 * - TODO: tienes que realizar toda la lógica de este script
 */
session_start();

//Un usuario no logeado es redirigido a index.php
if (!isset($_SESSION['usuario'])) {
    header('location: index.php');
    exit();
}

session_destroy();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Sistema de autenticación</title>
</head>

<body>
    <header>
        <h1>Sistema de autenticación</h1>
    </header>

    <main>
        <section>
            <article>
                <h1>Has cerrado la sesión</h1>
                <p>Volver a la <a href="../index.php">página principal</a></p>
            </article>
        </section>
    </main>

    <footer>
        <small>&copy; sitio web</small>
    </footer>
</body>

</html>