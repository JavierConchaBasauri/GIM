<?php

global $DB;
$proyectos = $DB->get_records('local_projects');
if (count($proyectos) < 1) {
    echo get_string('nop-verp', 'local_gim');
} else {
    echo '<div id="tablaun">Buscar:&nbsp<input type="search" id="txtBuscar" autofocus placeholder="' . get_string('searchb', 'local_gim') . '">
<div id="divContenido"><table id="tblTabla">';
    echo '<tr><th width="25%">' . get_string('proy-verp', 'local_gim') . '</th><th width="50%">' . get_string('desc-verp', 'local_gim') . '</th><th width="25%">' . get_string('resp-verp', 'local_gim') . '</th></tr>';
    for ($i = 1; $i <= count($proyectos); $i++) {
        $userid = $proyectos[$i]->userid;// obtengo el id del usuario dueño del proyecto en forma de string
        $useridstring = $userid; // Guardo el id del usuario como string en otra variable
        $userid = str_split($userid); // cambio el id del usuario de forma. string -> array. para poder usarlo en la funcion get_record_sql
        $responsable=$DB->get_record_sql('SELECT firstname,lastname FROM {user} WHERE id = ?', $userid); //Busco el nombre del dueño del proyecto 
        $nombre = $responsable->firstname.' '.$responsable->lastname;
        //muestro los datos
        echo '<tr><td><a href="'.$moodle.'/local/gim/vprojects.php?id='.$i.'">'.$proyectos[$i]->projectname.'</a></td><td>'.substr($proyectos[$i]->projectdescription,0,250).'</td><td><a href="'.$moodle.'/user/profile.php?id='.$useridstring.'">'.$nombre.'</a></td>';
        echo '</tr>';
    }
    echo '</table>
         </div></div>';
    /* echo '<div>
      <a class="anterior"  href="">'.get_string('previous','local_gim').'</a>
      <a class="siguiente" href="">'.get_string('next','local_gim').'</a>
      </div>'; */
}