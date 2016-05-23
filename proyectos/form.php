<?php

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}
echo $OUTPUT->heading(get_string('tit-aproy', 'local_gim'),3).'<hr>';
require_once($CFG->libdir . '/formslib.php');

class agpro_form extends moodleform {

//Add elements to form
    function definition() {
        global $CFG;

        $mform = $this->_form; // Don't forget the underscore! 

        $mform->addElement('text', 'pname', get_string('nom-aproy', 'local_gim') . ':'); // primer elemento del formulario, caja de texto
        $mform->setType('pname', PARAM_NOTAGS); //Set type of element

        $mform->addElement('hidden', 'st', 1); // Elemento del formulario que no se ve, da el valor de la variable st requerido en projects.php para que asi el proyecto sea guardado correctamente, ya que esta pagina esta incluida en projects.php
        $mform->setType('st', PARAM_ALPHANUM);
        

        
        
// Editor de texto para la descripcion
        $mform->addElement('editor', 'descp', get_string('des-aproy', 'local_gim') . ':',array(
    'subdirs'=>0,
    'maxbytes'=>0,
    'maxfiles'=>0,
    'changeformat'=>0,
    'context'=>null,
    'noclean'=>0,
    'trusttext'=>0,
    'enable_filemanagement' => false));
        $mform->setType('descp', PARAM_RAW);

        //$mform->addElement('textarea', 'introduction', get_string("introtext", "survey"), 'wrap="virtual" rows="20" cols="50"');
        
        //Drag an drop files de moodle
        $mform->addElement('filemanager', 'attachments', get_string('mul-aproy', 'local_gim') . ':', null, array('subdirs' => 0, 'maxbytes' => 0, 'maxfiles' => 50, 'accepted_types' => array('*')));
        
        $this->add_action_buttons();
    }

//Custom validation should be added here
    function validation($data, $files) {
        $errors = parent::validation($data, $files);

        $mform = $this->_form;

        $errors = array();

//es requerido que el nombre del proyecto sea declarado
        if ($mform->elementExists('pname')) {
            $title = trim($data['pname']);
            if ($title == '') {
                $errors['pname'] = get_string('required');
            }
        }

        return $errors;
    }

}

//Instantiate simplehtml_form 
$mform = new agpro_form();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
//Handle form cancel operation, if cancel button is present on form
    redirect('index.php');
} else if ($fromform = $mform->get_data()) {
//In this case you process validated data. $mform->get_data() returns data posted in form.
// y asigno los valores a guardar en la base de datos que no vienen del formulario. como por ej userid y timecreated
    $toform = new stdClass();
    $toform->projectname = $fromform->pname;
    $toform->projectdescription = $fromform->descp['text'];
    $toform->userid = $USER->id;
    $toform->timecreated = time();
    $toform->timemodified = time();
    //  $options = array('subdirs' => 1, 'maxbytes' => $CFG->userquota, 'maxfiles' => -1, 'accepted_types' => '*', 'return_types' => FILE_INTERNAL);
    //$toform = file_postupdate_standard_filemanager($toform, 'files', $options, $context, 'user', 'private', 0);
    /*
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
      $lastinsertid2 = $DB->insert_record('local_projects_has_videos', $record2, false); */
//$DB->insert_record('local_projects', $toform, false);
//inserto los datos que vienen desde el formulario mas los agregados anteriormente a la base de datos
    $lastinsertid = $DB->insert_record('local_projects', $toform, true);
    /*
      $record1 = new stdClass(); //creo clase para guardar, si existe, imagenenes del proyecto
      $record1->project_id = $lastinsertid;
      $record1->data = $toform->projectname;
      $lastinsertid1 = $DB->insert_record('projects_has_images', $record1, false);
      $record2 = new stdClass(); //creo clase para guardar, si existe, imagenenes del proyecto
      $record2->project_id = $lastinsertid;
      $record2->data = $toform->projectname;
      $lastinsertid2 = $DB->insert_record('projects_has_videos', $record2, false);
     * */

    $draftid = file_get_submitted_draft_itemid('attachments');
    $usercontext = context_user::instance($USER->id);
    $fs = get_file_storage();
    $files = $fs->get_area_files($usercontext->id, 'user', 'draft', $draftid);
    $context= context_system::instance();

    foreach ($files as $uploadedfile) {
        if ($uploadedfile->get_mimetype() == NULL) {
            continue;
        }
        
        $filename = $uploadedfile->get_filename();
        // Save the submitted file to check if it's a PDF.
        $filerecord = array(
            'component' => 'local_gim',
            'filearea' => 'media',
            'contextid' => $context->id,
            'itemid' => $lastinsertid,
            'filepath' => '/',
            'filename' => $filename);
        //guardo los archivos subidos, que estaban en el draf (temp) en una carpeta definitiva
        $file = $fs->create_file_from_storedfile($filerecord, $uploadedfile->get_id());
    }
    $url = $CFG->wwwroot.'/local/gim/vprojects.php?id='.$lastinsertid;
    redirect($url);
} else {
// this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
// or on the first display of the form.
//Set default data (if any)
    $mform->set_data();
//displays the form
    $mform->display();
}