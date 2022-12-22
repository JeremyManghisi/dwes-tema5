<?php
/*********************************************************************************************************************
 * Este script realiza el registro del usuario vía el POST del formulario que hay debajo, en la vista.
 * 
 * Cuando llegue POST hay que validarlo y si todo fue bien insertar en la base de datos el usuario.
 * 
 * Requisitos del POST:
 * - El nombre de usuario no tiene que estar vacío y NO PUEDE EXISTIR UN USUARIO CON ESE NOMBRE EN LA BASE DE DATOS.
 * - La contraseña tiene que ser, al menos, de 8 caracteres.
 * - Las contraseñas tiene que coincidir.
 * 
 * La contraseña la tienes que guardar en la base de datos cifrada mediante el algoritmo BCRYPT.
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
 * - TODO: los errores que se produzcan tienen que aparecer debajo de los campos.
 * - TODO: cuando hay errores en el formulario se debe mantener el valor del nombre de usuario en el campo
 *         correspondiente.
 */

session_start();

//Si el usuario está logeado se le redirige a index.php
if (isset($_SESSION['usuario'])) {
    header('location: index.php');
    exit();
}
if ($_POST) {
    $nombreValidadoRelleno = false;
    $nombreValidadoAlfanumerico = false;
    $contraseñaValidada = false;
    $contraseñaRepetidaValidada = false;
    $registracionValida = false;
    $nombreSaneado = htmlspecialchars(trim($_POST['nombre']));
    $contraseñaSaneada = htmlspecialchars(trim($_POST['clave']));
    $contraseñaRepetidaSaneada = htmlspecialchars(trim($_POST['repite_clave']));
    if (isset($nombreSaneado)){
        if($nombreSaneado != ""){
            $nombreValidadoRelleno = true;
        }
        if(ctype_alnum($nombreSaneado)){
            $nombreValidadoAlfanumerico = true;
        }
    }
    if (isset($contraseñaSaneada)){
        if (strlen ($contraseñaSaneada) >= 8){
            $contraseñaValidada = true;
        }
    }
    if (isset($contraseñaRepetidaSaneada)) {
        if ($contraseñaRepetidaSaneada === $contraseñaSaneada) {
            $contraseñaRepetidaValidada = true;
        }
    }
    if($nombreValidadoRelleno == true && $nombreValidadoAlfanumerico == true && $contraseñaValidada == true && $contraseñaRepetidaValidada == true){
        $registracionValida = true;
    }

//Función para añadir usuario
function insertUsuario(string $usuario, string $clave)
{
    $jsonString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/bd/usuarios.json');
    $jsonData = json_decode($jsonString);
    if (!$jsonData) {
        $jsonData =  [];
        $jsonData['usuarios'] = [['usuario' => $usuario, 'clave' => password_hash($clave, PASSWORD_BCRYPT)]];
    } else {
        $jsonData->usuarios[] = ['usuario' => $usuario, 'clave' => password_hash($clave, PASSWORD_BCRYPT)];    
    }
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/bd/usuarios.json', json_encode($jsonData));
}
}


?>
<h1>Regístrate</h1>
<?php  
    if(isset($registracionValida) && $registracionValida){
        insertUsuario($nombreSaneado, $contraseñaSaneada);
        echo "¡Te has registrado correctamente!";
        echo "<p><a href='index.php'>Para volver</a></p>";
    } else {
?>
<form action="signup.php" method="post">
    <p>
        <label for="nombre">Nombre de usuario</label>
        <input type="text" name="nombre" id="nombre">
    </p>
    <?php
        if (isset($nombreValidadoRelleno) && !$nombreValidadoRelleno){
            echo "<p>Error: El nombre no puede estar vacío</p>";
        }
        if (isset($nombreValidadoAlfanumerico) && !$nombreValidadoAlfanumerico){
            echo "<p>Error: El nombre tiene que ser alfanumérico</p>";
        }
    ?>
    <p>
        <label for="clave">Contraseña</label>
        <input type="password" name="clave" id="clave">
    </p>
    <?php
    if (isset($contraseñaValidada) && !$contraseñaValidada){
        echo "Error: La contraseña tiene que ser mayor a 8 caracteres";
    }
    ?>
    <p>
        <label for="repite_clave">Repite la contraseña</label>
        <input type="password" name="repite_clave" id="repite_clave">
    </p>
    <?php
    if (isset($contraseñaRepetidaValidada) && !$contraseñaRepetidaValidada){
        echo "Error: Las contraseñas no son iguales";
    }    
    ?>
    <p>
        <input type="submit" value="Regístrate">
    </p>
    <?php
    }
    ?>
</form>
