<?php

// The number of lines in front of config file determine the // hierarchy of files. 
require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');

require_login();
//Global
global $USER, $DB, $CFG;
$nombre = get_string('pluginname', 'local_gim'); // nombre del sitio

$PAGE->set_context(get_system_context());
$PAGE->set_pagelayout('admin');
$PAGE->set_title($nombre);
$PAGE->set_heading($nombre);
$PAGE->set_url($CFG->wwwroot . '/local/gim/projects.php');
$PAGE->navbar->add($nombre);
$self = $CFG->wwwroot . '/local/gim/projects.php';
$moodle = $CFG->wwwroot;



echo $OUTPUT->header();

include 'templates/header.php'; //encabezado de pagina
$estado = optional_param('st', 0, PARAM_ALPHANUM);
// Actual content goes here
    //si la variable de estado es 0, muestro la lista de proyectos actuales.
    if ($estado == 0) {
        include 'proyectos/verproyectos.php';
    }

//si la variable de estado es 1, muestro el formulario para crear proyectos
//Creacion de proyectos
    if ($estado == 1) {
        include 'proyectos/form.php';
    }
//FORMULARIO EN MODO HTML (NO FUNCIONA)
    if ($estado == 2) {
        if (!isset($_REQUEST['proyname'])) {
            include 'proyectos/formulario.php';
        } else {
            include 'uplproject.php';
        }
    }
include 'templates/footer.php'; // pie de pagina
echo $OUTPUT->footer();
