<link rel="stylesheet" type="text/css" href="templates/css/style.css" />

<?php
//MENU
echo html_writer::start_div(null, array('id'=>'encabezado'));
echo html_writer::start_div(null, array('id'=>'titulo'));
echo $OUTPUT->heading(get_string('welcome','local_gim'),5);
echo $OUTPUT->heading(get_string('pluginname','local_gim'),1);
echo $OUTPUT->heading(get_string('slogan','local_gim'),3);
echo html_writer::end_div();

//Header menu
echo html_writer::start_div(null, array('id'=>'navegador'));
echo html_writer::empty_tag('ul');

echo html_writer::empty_tag('li').html_writer::link ($CFG->wwwroot."/local/gim/index.php",get_string('inicio','local_gim')).html_writer::empty_tag('/li');
echo html_writer::empty_tag('li').html_writer::link ($CFG->wwwroot."/local/gim/projects.php",get_string('explorar','local_gim')).html_writer::empty_tag('/li');
echo html_writer::empty_tag('li').html_writer::link ($CFG->wwwroot."/local/gim/myprojects.php",get_string('mypro','local_gim')).html_writer::empty_tag('/li');

echo html_writer::empty_tag('/ul');
//fin headermenu
echo html_writer::end_div();
echo html_writer::end_div();
echo html_writer::empty_tag('hr');
