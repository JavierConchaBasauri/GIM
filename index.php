<?php


// The number of lines in front of config file determine the // hierarchy of files. 
require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');

require_login();
//Global
$nombre = get_string('pluginname','local_gim'); // nombre del sitio

$PAGE->set_context(get_system_context());
$PAGE->set_pagelayout('admin');
$PAGE->set_title($nombre);
$PAGE->set_heading($nombre);
$PAGE->set_url($CFG->wwwroot.'/local/gim/index.php');
$PAGE->navbar->add($nombre);




echo $OUTPUT->header();

include 'templates/header.php'; //encabezado de pagina
// Actual content goes here
echo '<div id="cuerpo">';
echo 'PURA MIERDA';
echo '</div>';

//Fin contenido index
include 'templates/footer.php'; // pie de pagina
echo $OUTPUT->footer();
