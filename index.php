<?php


// The number of lines in front of config file determine the // hierarchy of files. 
require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');

require_login();
//Global
global $USER;
$nombre = get_string('pluginname','local_gim'); // nombre del sitio

$PAGE->set_context(get_system_context());
$PAGE->set_pagelayout('admin');
$PAGE->set_title($nombre);
$PAGE->set_heading($nombre);
$PAGE->set_url($CFG->wwwroot.'/local/gim/index.php');
$PAGE->navbar->add($nombre);
$agpro=$CFG->wwwroot.'/local/gim/projects.php?st=1'; // direccion de la pagina para agregar proyectos
$vpro=$CFG->wwwroot.'/local/gim/projects.php';  // direccion de la pagina para ver proyectos



echo $OUTPUT->header();

include 'templates/header.php'; //encabezado de pagina
// Actual content goes here
//caja que es..?
echo '<div id="flotizq2">';
echo '<h2>'.get_string('question','local_gim').'</h2>';
echo get_string('descp','local_gim');
echo 'prueba4';
echo '</div>';
//Caja video
echo '<div id="flotder">';
echo '<video width="320" height="240" controls>
  <source src="templates/media/TOTO - Africa [LIVE].mp4" type="video/mp4">
</video>';
//echo '<img src="templates/media/IMG_5320.jpg" alt="Smiley face" height="380" width="480">';
echo '</div>';

//CAJA CENTRO, CONTIENE CAJAS DERECHA e IZQUIERDA
echo '<div id="cuerpo">';
echo '<hr>';
//caja flotante izquierda empezar un proyecto
echo '<div id="flotizq">';
echo '<div id="caja" class="vertical-centered-text">';


echo '<a href="'.$agpro.'">'.get_string('startproj','local_gim').'</a>';
echo '</div>';
echo '</div>';


//caja flotante derecha ver proyectos
echo '<div id="flotder">';
echo '<div id="cajader">';
echo '<a href="'.$vpro.'">'.get_string('seeproj','local_gim').'</a>';
echo '</div>';
echo '</div>';

//Fin contenido index
echo '</div>';
include 'templates/footer.php'; // pie de pagina
echo $OUTPUT->footer();
