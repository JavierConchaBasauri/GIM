<?php


// The number of lines in front of config file determine the // hierarchy of files. 
require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');

require_login();

//Global
$nombrenav = "Hello World"; // nombre que aparece en la pestaña del navegador
$nombre = "Hello World!"; // nombre del sitio

$PAGE->set_context(get_system_context());
$PAGE->set_pagelayout('admin');
$PAGE->set_title($nombrenav);
$PAGE->set_heading($nombre);
$PAGE->set_url($CFG->wwwroot.'/local/gim/helloworld2.php');
$PAGE->navbar->add($nombre);

$strmymoodle = get_string('helloworld');


 


echo $OUTPUT->header();


// Actual content goes here
echo "Hello World";


echo $OUTPUT->footer();
