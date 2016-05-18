<?php

// The number of lines in front of config file determine the // hierarchy of files. 
require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once($CFG->dirroot . '/user/lib.php');
require_once("$CFG->dirroot/user/profile/lib.php");

require_login();
//Global
global $USER, $DB, $CFG;
$nombre = get_string('pluginname', 'local_gim'); // nombre del sitio

$PAGE->set_context(get_system_context());
$PAGE->set_pagelayout('admin');
$PAGE->set_title($nombre);
$PAGE->set_heading($nombre);
$PAGE->set_url($CFG->wwwroot . '/local/gim/vprojects.php');
$PAGE->navbar->add($nombre);
$self = $CFG->wwwroot . '/local/gim/vprojects.php';
$project_page = $CFG->wwwroot . '/local/gim/projects.php';



echo $OUTPUT->header();

include 'templates/header.php'; //encabezado de pagina
$verproy = optional_param('id', 0, PARAM_INT);
if ($verproy == 0) {
    redirect($project_page, '<center>' . get_string('no-idproy', 'local_gim') . '</center>', 3);
} else {
   //$verproy = str_split($verproy); // cambio el id del usuario de forma. string -> array. para poder usarlo en la funcion get_record_sql
    $proyecto = $DB->get_record('local_projects', array('id'=> $verproy)); //Busco los datos del proyecto asociados a su id 
    // se muestran el titulo y la descripcion del proyecto
    $vistas = $proyecto->vistas;
    echo '<div id="cajaverp">';
    echo '<h1>' . $proyecto->projectname . '</h1>';
    echo '<p>' . $proyecto->projectdescription . '</p>';
    echo '</div>';
    // caja destinada a MEDIA
    echo '<div id="cajavermedia">';
    echo 'Holaa';
    echo'</div>';

    echo '<div id="cajaverdueño">';
    $userid = $proyecto->userid; // obtengo el id del usuario dueño del proyecto en forma de string
    $useridstring = $userid; // Guardo el id del usuario como string en otra variable
    $userid = str_split($userid); // cambio el id del usuario de forma. string -> array. para poder usarlo en la funcion get_record_sql
    $responsable = $DB->get_record_sql('SELECT firstname,lastname,description FROM {user} WHERE id = ?', $userid); //Busco el nombre del dueño del proyecto 
    $nombre = $responsable->firstname . ' ' . $responsable->lastname;
    $proyecto->vistas++;
    $DB->update_record('local_projects', $proyecto);
    $rs = $DB->get_recordset_select("user", "deleted = 0 AND picture > 0 AND id = $useridstring", array(), "lastaccess DESC", user_picture::fields());

    echo '<table class="tg">
  <tr>
    <th class="tg-i6eq" colspan="2">'.get_string('personal-idproy', 'local_gim').'</th>
  </tr>
  <tr>
    <td class="tg-huad" rowspan="2">';
    foreach ($rs as $user) {
        echo "<a href=\"$CFG->wwwroot/user/view.php?id=$user->id&amp;course=1\" " .
        "title=\"$fullname\">";
        echo $OUTPUT->user_picture($user, array('size' => 100));
        echo "</a> \n";
    }
    echo '</td>
    <td class="tg-huad">'.$nombre.'</td>
  </tr>
  <tr>
    <td class="tg-huad">'.$responsable->description.'</td>
  </tr>
</table>';
    echo '</div>';
}
include 'templates/footer.php'; // pie de pagina
echo $OUTPUT->footer();






