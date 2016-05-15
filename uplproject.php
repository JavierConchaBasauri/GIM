<?php

$pname = $_REQUEST['proyname'];
$descp = $_REQUEST['desc'];

//compruebo el tipo de archivo subido
if ((($_FILES["Archivos"]["type"] == "image/gif") || ($_FILES["Archivos"]["type"] == "image/jpeg") || ($_FILES["Archivos"]["type"] == "image/jpg") || ($_FILES["Archivos"]["type"] == "image/JPG") || ($_FILES["Archivos"]["type"] == "image/png")) && ($_FILES["Archivos"]["size"] < 200000000000000000000000) && (($_FILES["video"]["type"] == "video/avi") || ($_FILES["video"]["type"] == "video/mpeg") && ($_FILES["Archivos"]["size"] < 200000000000000000000000))) {
    if ($_FILES["Archivos"]["error"] < 0 && ($_FILES["video"]["error"] < 0)) {
        echo "Return Code: " . $_FILES["Archivos"]["error"] . "
";
    } else {
        echo "Nombre de imagen : " . $_FILES["Archivos"]["pname"] . "<br>";
        echo "Nombre de video : " . $_FILES["video"]["pname"] . "<br>";
        $nombre = $_FILES["Archivos"]["pname"];
        $nombrevid = $_FILES["video"]["pname"];
        echo "Tipo imagen: " . $_FILES["Archivos"]["type"] . "<br>";
        echo "Tipo video: " . $_FILES["video"]["type"] . "<br>";
        echo "Tamaño imagen: " . ($_FILES["Archivos"]["size"] / 1024) . " Kb<br>";
        echo "Tamaño video: " . ($_FILES["video"]["size"] / 1024) . " Kb<br>";
        echo "Carpeta temporal imagen: " . $_FILES["Archivos"]["tmp_pname"] . "<br>";
        echo "Carpeta temporal video: " . $_FILES["video"]["tmp_pname"] . "<br>";

        if (file_exists("uploads/" . $_FILES["Archivos"]["pname"]) && file_exists("uploads/" . $_FILES["video"]["pname"])) {
            echo $_FILES["Archivos"]["pname"] . " Archivos ya existen. ";
        } else {
            move_uploaded_file($_FILES["Archivos"]["tmp_pname"], "uploads/" . $_FILES["Archivos"]["name"]);
            move_uploaded_file($_FILES["video"]["tmp_pname"], "uploads/" . $_FILES["video"]["name"]);
            echo "Ficheros subidos correctamente<br> Espera seras redireccionado...";
            $record = new stdClass();//creo clase para luego guardar proyecto
            $record->projectname = $pname;
            $record->projectdescription = $descp;
            $record->userid = $USER->id;
            $lastinsertid = $DB->insert_record('local_projects', $record, true); //guardo proyecto
            $record1 = new stdClass(); //creo clase para guardar, si existe, imagenenes del proyecto
            $record1->project_id = $lastisertid;
            $record1->data = $pname.$_FILES["Archivos"]["type"];
            $lastinsertid1 = $DB->insert_record('local_projects_has_images', $record1, false);
            $record2 = new stdClass(); //creo clase para guardar, si existe, imagenenes del proyecto
            $record2->project_id = $lastisertid;
            $record2->data = $pname.$_FILES["video"]["type"];
            $lastinsertid2 = $DB->insert_record('local_projects_has_videos', $record2, false);
            header("refresh:5; url=$self");
        }
    }
} else {
    echo "Fichero invalido no permitido";
}