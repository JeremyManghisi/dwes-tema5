<?php
/**********************************************************************************************************************
 * Este script simplemente elimina la imagen de la base de datos y de la carpeta <imagen>
 *
 * La información de la imagen a eliminar viene vía GET. Por GET se tiene que indicar el id de la imagen a eliminar
 * de la base de datos.
 * 
 * Busca en la documentación de PHP cómo borrar un fichero.
 * 
 * Si no existe ninguna imagen con el id indicado en el GET o no se ha inicado GET, este script redirigirá al usuario
 * a la página principal.
 * 
 * En otro caso seguirá la ejecución del script y mostrará la vista de debajo en la que se indica al usuario que
 * la imagen ha sido eliminada.
 */

/**********************************************************************************************************************
 * Lógica del programa
 * 
 * Tareas a realizar:
 * - TODO: tienes que desarrollar toda la lógica de este script.
 */


/*********************************************************************************************************************
 * Salida HTML
 */
?>
<h1>Galería de imágenes</h1>
<?php
$mysqli = new mysqli("db", "dwes", "dwes", "dwes", 3306);
if ($mysqli->connect_errno) {
    echo "No ha podido conectarse a la base de datos";
    exit();
}
if ($_GET && isset($_GET['id'])) {
    $id = htmlentities(trim($_GET['id']));

    $resultado = $mysqli->query("delete from post where id={$id}");
    if ($resultado && $mysqli->affected_rows > 0) {
        echo "<p>Se ha borrado el registro con id igual a {$id}.</p>";
        echo "<a href='index.php'> Para volver </a>";
    } else {
        echo "<p>Hubo un error y no se ha podido borrar el registro.</p>";
        echo "<a href='index.php'> Para volver </a>";
    }
} else {
    echo "<p>Hubo un error y no se ha podido borrar el registro.</p>";
    echo "<a href='index.php'> Para volver </a>";
}
?>
<p>Imagen eliminada correctamente</p>
<p>Vuelve a la <a href="index.php">página de inicio</a></p>
