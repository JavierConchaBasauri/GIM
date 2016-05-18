<?php 
// ===============
//
// FILE MANAGER EXAMPLE
//
// ===============
// The point of this file is to demonstrate how to manage files within Moodle 2.3
// Written by Andrew Normore
// Why? Because file management is incredibly hard for some reason.


require_once( '../../config.php' );
global $CFG, $USER, $DB, $OUTPUT;

require_login();
$PAGE->set_url('/local/filemanager/_filemanager_test.php');
$PAGE->set_pagelayout( 'admin' );
$context = get_context_instance( CONTEXT_COURSE, SITEID );
$PAGE->set_context( $context );
$strtitle = get_string( 'title', 'local_filemanager' );
$PAGE->set_title( $strtitle );
$PAGE->set_heading( $strtitle );

$tid = optional_param( 'tid', '', PARAM_RAW );

require_login();


//DEFINITIONS
require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');

 

 

 

// ===============
//
//
// (LIBRARY) this would usually be include(lib.php)
//
//
// ===============
class simplehtml_form extends moodleform {

function definition() {
  global $CFG;

  $mform =& $this->_form; // Don't forget the underscore! 

  $mform->addElement('text', 'email', get_string('email')); // Add elements to your form
  $mform->setType('email', PARAM_NOTAGS); //Set type of element
  $mform->setDefault('email', 'Please enter email'); //Default value

  // FILE MANAGER
  $mform->addElement('filemanager', 'attachments', 'test', null, array('subdirs' => 0, 'maxbytes' => 0, 'maxfiles' => 50, 'accepted_types' => array('*') ));

  // Buttons
  $this->add_action_buttons();

  }

  function validation($data, $files) {
    return array();
  }
}

 

 

 

 

 

// ===============
//
//
// FORM LOGIC
//
//
// ===============

$mform = new simplehtml_form();

if ($mform->is_cancelled()) {
  echo '<h1>Cancelled</h1>';
  echo 'Handle form cancel operation, if cancel button is present on form';
} else if ($fromform = $mform->get_data()) {
  echo '<h1>Submit Success!</h1>';
  echo 'In this case you process validated data. $mform->get_data() returns data posted in form.';
} else {
  echo '<h1>Default</h1>';
  echo 'This is the form first display OR "errors"';
  $mform->display();
}


// --------
// Form was valid, process!
// --------

// CONFIGURE FILE MANAGER
// From http://docs.moodle.org/dev/Using_the_File_API_in_Moodle_forms#filemanager
if (empty($entry->id)) {
  $entry = new stdClass;
  $entry->id = null;
}

$draftitemid = file_get_submitted_draft_itemid('attachments');

file_prepare_draft_area($draftitemid, $context->id, 'mod_glossary', 'attachment', $entry->id,
array('subdirs' => 0, 'maxbytes' => '0', 'maxfiles' => 50));

$entry->attachments = $draftitemid;

// Set form data
$mform->set_data($entry);

 

 

 


echo $OUTPUT->footer();