<?php
/**********************************************************************************************************************
 * Este programa, a través del formulario que tienes que hacer debajo, en el área de la vista, realiza el inicio de
 * sesión del usuario verificando que ese usuario con esa contraseña existe en la base de datos.
 * 
 * Para mantener iniciada la sesión dentrás que usar la $_SESSION de PHP.
 * 
 * En el formulario se deben indicar los errores ("Usuario y/o contraseña no válido") cuando corresponda.
 * 
 * Dicho formulario enviará los datos por POST.
 * 
 * Cuando el usuario se haya logeado correctamente y hayas iniciado la sesión, redirige al usuario a la
 * página principal.
 * 
 * UN USUARIO LOGEADO NO PUEDE ACCEDER A ESTE SCRIPT.
 */

/**********************************************************************************************************************
 * Lógica del programa
 * 
 * Tareas a realizar:
 * - TODO: tienes que realizar toda la lógica de este script
 */

 
/*********************************************************************************************************************
 * Salida HTML
 * 
 * Tareas a realizar en la vista:
 * - TODO: añadir el menú.
 * - TODO: formulario con nombre de usuario y contraseña.
 */

//Si el usuario está logeado, que hace aquí?
if (isset($_SESSION['usuario'])) {
    header('location: index.php');
    exit();
}

//Función que recoge el usuario de el fichero json
function getUsuario(string $usuario): array
{
    $jsonString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/bd/usuarios.json');
    $jsonData = json_decode($jsonString);

    if (!$jsonData) {
        return [];
    }

    foreach ($jsonData->usuarios as $usuarioRegistrado) {
        if ($usuarioRegistrado->usuario == $usuario) {
            return ['usuario' => $usuarioRegistrado->usuario, 'clave' => $usuarioRegistrado->clave];
        }
    }

    return [];
}

//Función que comprueba si el usuario está registrado
function loginUsuario(string $usuario, string $clave): bool
{
    $usuarioRegistrado = getUsuario($usuario);
    if (!empty($usuarioRegistrado) && password_verify($clave, $usuarioRegistrado['clave'])) {
        return true;
    } else {
        return false;
    }
}


if ($_POST) {
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
    $clave = isset($_POST['clave']) ? $_POST['clave'] : '';

    //Si el usuario está registrado entonces se le redirige a la página principal
    $valido = loginUsuario($usuario, $clave);
    if ($valido) {
        $_SESSION['usuario'] = $usuario;
        header('location: index.php');
        exit();
    }
}
?>



<h1>Inicia sesión</h1>
<ul>
    <li><strong>Home</strong></li>
    <li><a href="filter.php">Filtrar imágenes</a></li>
    <li><a href="signup.php">Regístrate</a></li>
    <li><a href="login.php"><strong>Inicia sesión</strong></a></li>
</ul>
<main>
        <h1>Inicia sesión</h1>
        <?php
        if ($_POST) {
            echo "<p>Error, el usuario o la contraseña son incorrectos</p>";
        } 
        ?>
        <form action="login.php" method="post">
            <p>
                <label for="usuario">Nombre de usuario</label><br>
                <input type="text" name="usuario" id="usuario">
            </p>
            <p>
                <label for="clave">Contraseña</label><br>
                <input type="password" name="clave" id="clave">
            </p>
            <p>
                <input type="submit" value="Inicia sesión">
            </p>
        </form>
    </main>