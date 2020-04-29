<?php
require 'vendor/autoload.php';
include './conexion.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

session_start();

$base_url = "http://" . $_SERVER['SERVER_NAME'];
var_dump($_SESSION['usuarioSession']);
if (!isset($_SESSION['usuarioSession'])) { //Validar si hay sesion activa
    header('Location: ' . $base_url);
}

$file = $_FILES['archivoExcel']; //Obtiene archivo excel uploaded
$FileExtension = pathinfo($file['name']); //Obtiene extension del archivo para verificar
var_dump($file);
var_dump($FileExtension['extension']);
$path = "uploads/";

if ($FileExtension['extension'] == 'xlsx') { // Valida extension
    if (file_exists($path . $file['name'])) { //Borra archivo si existe en proyecto
        echo "Deleting old file.</br>";
        unlink($path . $file['name']);
    }

    if (move_uploaded_file($file['tmp_name'], $path . $file['name'])) { //Guarda en carpeta uploads archivos xlsx
        echo "The file " . basename($file["name"]) . " has been uploaded.";
    } else {
        echo "Hay un error en el archivo.";
    }

    try { // Inicio funcion para leer excel
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($path . $file['name']);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($path . $file['name']);
        $worksheet = $spreadsheet->getActiveSheet();

        //Obtencion de columnas y filas
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
    } catch (Exception $e) {
        echo "Fallo en encontrar archivo xlsx\n" . $e;
    }

    var_dump($highestColumnIndex, $highestRow);
    $arrayData = array(); //Inicializacion de array para guardar datos
    for ($r = 1; $r <= $highestRow; $r++) { //Filas
        for ($c = 2; $c <= $highestColumnIndex; $c++) { //Columnas
            $value = $worksheet->getCellByColumnAndRow($c, $r)->getValue(); //Obtiene valor de la celda en columna y fila            
            if (isset($value)) { //Guarda valores de celdas que no sean nulas de lo contrario salta a siguiente fila
                $value = ltrim($value); //Quita espacios lado izquierdo de la String
                $value = rtrim($value); //Quita espacios lado derecho de la String
                if ($c == 2) $datos["clave_cata"] = $value;
                if ($c == 3) $datos["nombre_loc"] = $value;
                if ($c == 4) $datos["direccion"] = $value;
                if ($c == 5) $datos["documento_estatus"] = $value;
                if ($c == $highestColumnIndex) {
                    array_push($arrayData, $datos); //Array donde se guardan los datos del excel
                }
            } else {
                break; //Suigiente fila
            }
        }
    }

    unlink($path . $file['name']); //Borra archivo xlsx despues de leer su contenido
    unset($arrayData[0]); //Borra valores del primera posicion de array (Nombres de columnas)

    var_dump("Deleting file already readed");
    var_dump(count($arrayData));

    //Data
    /* echo '<h3>Data</h3>';
    echo '<table>';
    foreach ($arrayData as $row) {
        echo '<tr>';
        foreach ($row as $key => $value) {
            echo '<td>' . $value . '</td>';
        }
        echo '</tr>';
    }
    echo '</table>'; */

    echo '<h3>Data</h3>';
    echo '<table>';
    foreach ($arrayData as $key => $value) {
        echo '<tr>';
        $direccionArray = explode(',', $value["direccion"]);
        foreach ($direccionArray as $key2 => $value2) {
            echo '<td>' . $value2 . '</td>';
        }

        echo '</tr>';
    }
    echo '</table>';

    /* echo '<script>
    setTimeout(function () {
        window.location.href = "' . $base_url . '";
    }, 5000);
</script>'; */

    //return header('Location: ' . $base_url);
} else {
    echo 'Extensión del archivo incorrecta';
    /* echo '<script>
    setTimeout(function () {
        window.location.href = "' . $base_url . '";
    }, 2);
</script>'; */
}
