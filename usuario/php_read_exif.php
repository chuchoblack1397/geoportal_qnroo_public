<?php

session_start();
$usuario_session = $_SESSION['usuarioSession'];
include "../conexion.php";
date_default_timezone_set('America/Mexico_City');

/* Getting file name && note */
$filename = $_FILES['file']['name'];
$nota = $_POST['nota'];

/* Location */
$imageFileType = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
$location = "/geofotos/" . $usuario_session . '_' . date('Ymd_His') . '.' . $imageFileType;
$locationBD = dirname((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 2) . $location;
$uploadOk = 1;
$exifFile = dirname(__FILE__, 2) . $location;
// echo $location;
// return;

/* Valid Extensions */
$valid_extensions = array("jpg", "jpeg", "png");
/* Check file extension */
if (!in_array(strtolower($imageFileType), $valid_extensions)) {
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo 0;
} else {
    /* Upload file */
    if (move_uploaded_file($_FILES['file']['tmp_name'],  $exifFile)) {
        $fileGPS = f_getCoord($exifFile);
        if (!$fileGPS) {
            unlink($exifFile);
            echo 2;
            return;
        }
        // Obtener timestamp de exif
        $exifTs = getTimeStamp($exifFile);
        // Obtuvo coordenadas
        $data = (object) ['id_foto' => date('YmdHis', strtotime($exifTs)) . '_' . date('YmdHis'), 'nombre' => $usuario_session . '_' . date('Ymd_His'), 'notas' => $nota, 'url_path' => $locationBD, 'datime_exi' => $exifTs, 'datime_upl' => date('Y-m-d H:i:s'), 'usuario' => $usuario_session, 'lat' => $fileGPS[0], 'lon' => $fileGPS[1]];

        $query = "INSERT INTO opb_fotos_dgc_4326u(id_foto, nombre, notas, url_path, datime_exi, datime_upl, usuario, geom) VALUES ('$data->id_foto', '$data->nombre', '$data->notas', '$data->url_path', '$data->datime_exi', '$data->datime_upl', '$data->usuario', 
        ST_SetSRID(ST_MakePoint($data->lon, $data->lat),4326))";

        $result = pg_query($conexion, $query);

        echo 3;
        // echo json_encode($filesGPS[0]);
        // echo 3;
    } else {
        echo 1;
    }
}

function f_getGps($exifCoord, $hemi)
{
    $degrees = count($exifCoord) > 0 ? f_gps2Num($exifCoord[0]) : 0;
    $minutes = count($exifCoord) > 1 ? f_gps2Num($exifCoord[1]) : 0;
    $seconds = count($exifCoord) > 2 ? f_gps2Num($exifCoord[2]) : 0;
    $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;
    return $flip * ($degrees + $minutes / 60 + $seconds / 3600);
}

//Found on stackoverflow.com
//Explodes the GPS string into usable float numbers (1° 2' 3.4'' => 1,2,3.4)
function f_gps2Num($coordPart)
{
    $parts = explode('/', $coordPart);
    if (count($parts) <= 0)
        return 0;
    if (count($parts) == 1)
        return $parts[0];
    return floatval($parts[0]) / floatval($parts[1]);
}

//Get a file's geolocalisation
function f_getCoord($v_currFileLoc)
{
    //Read the file's exif data
    $exif = exif_read_data($v_currFileLoc);
    //Check that the wanted data exists
    if (array_key_exists('GPSLongitude', $exif) && array_key_exists('GPSLatitude', $exif)) {
        //If the data exists, generate the coordinates into an array
        $photoCoord = array(f_getGps($exif["GPSLatitude"], $exif['GPSLatitudeRef']), f_getGps($exif["GPSLongitude"], $exif['GPSLongitudeRef']));
        return $photoCoord;
    } else {
        //If no data exists, return false
        return false;
    }
}

//Get a multidim array containing: folder, filename, lat, long
//Usage: $my_dir = 'fotos';
// print_r(f_fileArray($my_dir));
function f_fileArray($dir)
{
    $filesArray = array(); //Init the arrays
    if (is_dir($dir)) { //Only proceed if this is really a folder
        if ($dh = opendir($dir)) { //Open the folder
            while (($file = readdir($dh)) !== false) { //Read all objects in the folder
                if (substr($file, 0, 1) !== '.') { //Do not take the files beginning with a period (.)
                    $v_Coord = f_getCoord($dir . '/' . $file); //Get the coordinates' array for each file
                    if ($v_Coord !== false) { //Proceed only if the file has usable GPS data
                        $filesArray[] = array("folder" => $dir, "file" => $file, "lat" => $v_Coord[0], "long" => $v_Coord[1]); //Create an array of array containing all info
                    }
                } //End if (substr())
            } //End while loop
            closedir($dh); //Close the folder
        } //End if opendir
        return $filesArray; //Return array of folder, file
    } else {
        return false; //Return FALSE if it's not a folder
    } //End if is_dir
}

//Get an array of the map boundaries
//Usage: $my_dir = 'fotos';
// print_r(f_getMapBoundaries(f_fileArray($my_dir)));
function f_getMapBoundaries($coordArray)
{
    $mapArray = array();
    //This returns the whole array havng the min lat
    $lat_min = $coordArray[array_search(min($lat = array_column($coordArray, 'lat')), $lat)];
    //This returns the whole array havng the max lat
    $lat_max = $coordArray[array_search(max($lat = array_column($coordArray, 'lat')), $lat)];
    //This returns the whole array havng the min long
    $long_min = $coordArray[array_search(min($long = array_column($coordArray, 'long')), $long)];
    //This returns the whole array havng the max long
    $long_max = $coordArray[array_search(max($long = array_column($coordArray, 'long')), $long)];
    //Create an array having only lat_min,long_min,lat_max,long_max
    $mapArray = array($lat_min['lat'], $long_min['long'], $lat_max['lat'], $long_max['long']);
    return $mapArray;
}

function getTimeStamp($v_currFileLoc)
{
    //Read the file's exif data
    $exif = exif_read_data($v_currFileLoc);

    if (array_key_exists('DateTimeOriginal', $exif)) {
        return $exif['DateTimeOriginal'];
    } else
        return false;
}
