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
$PAGE->set_url($CFG->wwwroot.'/local/gim/tester.php');
$PAGE->navbar->add($nombre);


require_login();

echo $OUTPUT->header();
include 'templates/header.php'; //encabezado de pagina
 

 
echo '<a class="example-image-link" href="templates/media/IMG_5320.jpg" data-lightbox="example-1"><img class="example-image" src="templates/media/IMG_5320.jpg" alt="image-1" /></a>';
 

echo '<hr><section><div>';
echo '<a class="example-image-link" href="templates/media/IMG_5320.jpg" data-lightbox="example-set" data-title="Or press the right arrow on your keyboard."><img class="example-image" src="templates/media/IMG_5320.jpg" alt="" /></a>';
 echo '<a class="example-image-link" href="templates/media/detele.png" data-lightbox="example-set" data-title="Or press the right arrow on your keyboard."><img class="example-image" src="templates/media/detele.png" alt="" /></a>';
html_writer::link( 'templates/media/detele.png', html_writer::img( 'templates/media/IMG_5320.jpg', 'Tigre', array (
 		'width' => '200',
 		'height' => '100',
 		'class' => 'example-image',
 		
 ) ), array(
 		'class' => 'example-image-link',
 		'data-lightbox' => 'example-set',
 ));
 echo '</div></section>';
 

include 'templates/footer.php'; // pie de pagina
echo $OUTPUT->footer();