<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$base_url = "http://" . $_SERVER['SERVER_NAME'];
var_dump($base_url, '</br>');
if (isset($_SESSION)) {
    header('Location: ' . $base_url);
}

$file = $_FILES['archivoExcel'];
$FileExtension = pathinfo($file['name']);
var_dump($file, '</br>');
var_dump($FileExtension['extension'], '</br>');
$path = "uploads/";

if (file_exists($path . $file['name'])) {
    echo "Deleting old file.</br>";
    unlink($path . $file['name']);
}

if (move_uploaded_file($file['tmp_name'], $path . $file['name'])) {
    echo "The file " . basename($file["name"]) . " has been uploaded.";
} else {
    echo "Sorry, there was an error uploading your file.";
}

if ($FileExtension['extension'] == 'xlsx') {
    try {
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($path . $file['name']);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($path . $file['name']);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
    } catch (Exception $e) {
        echo "Fallo en encontrar archivo xlsx\n" . $e;
    }

    var_dump($highestColumnIndex, $highestRow, '</br>');
    $arrayData = array();
    for ($r = 1; $r <= $highestRow; $r++) {
        for ($c = 2; $c <= $highestColumnIndex; $c++) {
            $value = $worksheet->getCellByColumnAndRow($c, $r)->getValue();
            if (isset($value)) {
                if ($c == 2) $datos["clave_cata"] = $value;
                if ($c == 3) $datos["nombre_loc"] = $value;
                if ($c == 4) $datos["direccion"] = $value;
                if ($c == 5) $datos["documento_estatus"] = $value;
                if ($c == $highestColumnIndex) {
                    array_push($arrayData, $datos);
                }
            } else {
                break;
            }
        }
    }

    unlink($path . $file['name']);
    unset($arrayData[0]);

    var_dump("Deleting file already readed", '</br>');
    var_dump(count($arrayData), '</br>');

    echo '<h3>Data</h3>';
    echo '<table>';
    foreach ($arrayData as $row) {
        echo '<tr>';
        foreach ($row as $key => $value) {
            echo '<td>' . $value . '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';



    //return header('Location: ' . $base_url);
} else {
    echo 'Extensión del archivo incorrecta';
    echo '<script>
    setTimeout(function () {
        window.location.href = "";
    }, 5000);
</script>';
}