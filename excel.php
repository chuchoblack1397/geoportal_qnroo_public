<?php
require 'vendor/autoload.php';
include './conexion.php';

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

if ($FileExtension['extension'] == 'xlsx' || $FileExtension['extension'] == 'xls') { // Valida extension
    if (file_exists($path . $file['name'])) { //Borra archivo si existe en proyecto
        echo "Borrando archivo si existe ya uno.</br>";
        unlink($path . $file['name']);
    }

    if (move_uploaded_file($file['tmp_name'], $path . $file['name'])) { //Guarda en carpeta uploads archivos xlsx
        echo "el archivo " . basename($file["name"]) . " ha sido cargado.";
    } else {
        echo "Hay un error en el archivo.";
    }

    try { // Inicio funcion para leer excel
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($path . $file['name']);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $spreadsheet = $reader->load($path . $file['name']);
        $worksheet = $spreadsheet->getActiveSheet();

        //Obtencion de columnas y filas
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
    } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
        die('Error loading file: ' . $e->getMessage());
    }

    pg_set_client_encoding($conexion, "UTF8");
    var_dump($highestColumnIndex, $highestRow);
    $dataArray = array();
    $datos = array();
    $updatesS = 0;
    $updatesE = 0;
    //Inicializacion de array para guardar datos    
    $lic_cve__1 = "";
    $queryArray = array();
    $setArray = array();
    $nombres = ["lic_num_li", "lic_fecha", "lic_num_es", "lic_anno", "lic_movimi", "lic_estatu", "lic_nom_co", "lic_cve_ca", "lic_cve__1", "lic_direcc", "lic_nom_pr", "lic_ap_mat", "lic_ap_pat", "lic_tipo"];
    for ($r = 2; $r <= $highestRow; $r++) { //Filas $highestRow
        for ($c = 1; $c <= $highestColumnIndex; $c++) { //Columnas 
            $value = $worksheet->getCellByColumnAndRow($c, $r)->getFormattedValue(); //Obtiene valor de la celda en columna y fila            
            if (isset($value)) { //Guarda valores de celdas que no sean nulas de lo contrario salta a siguiente fila
                $value = ltrim($value); //Quita espacios lado izquierdo de la String
                $value = rtrim($value); //Quita espacios lado derecho de la String
                if ($nombres[$c - 1] == "lic_fecha") {
                    $datos[$c - 1] = date("Y-m-d", strtotime($value));
                } else {
                    //Agrega el valor
                    $datos[$c - 1] = $value;
                }
                if ($nombres[$c - 1] == 'lic_cve__1') {
                    $lic_cve__1 = $value;
                }
            } else {
                break; //Siguiente fila
            }
        }

        $where["clave_cata"] = $lic_cve__1;

        //$res = pg_update($conexion, 'opb_licencias_202004_dvp_32616_u', $datos, $where);
        $query = 'UPDATE opb_licencias_202004_dvp_32616_u SET lic_num_li = $1, lic_fecha = $2, lic_num_es = $3, lic_anno = $4, lic_movimi = $5, lic_estatu = $6, lic_nom_co = $7, lic_cve_ca = $8, lic_cve__1 = $9, lic_direcc = $10, lic_nom_pr = $11, lic_ap_mat = $12, lic_ap_pat = $13, lic_tipo = $14 WHERE clave_cata = $9';
        $res = pg_query_params($conexion, $query, $datos);
        if ($res) {
            $updatesS++;
        } else {
            echo "User must have sent wrong inputs\n fila: $r";
            echo "</br>" . pg_last_error($conexion);
            var_dump($datos);
            $updatesE++;
        }
        $datos = array();
    }

    var_dump("Borrando archivo ya leido");
    unlink($path . $file['name']); //Borra archivo xlsx despues de leer su contenido
    $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
    echo "<h3>Total updates: $updatesS</h3>";
    echo "<h3>Tiempo transcurrido updates: $time</h3>";
    $_SESSION["updates"] = ["error" => $updatesE, "success" => $updatesS];

    return header('Location: index.php');
} else {
    return header('Location: index.php');
}
