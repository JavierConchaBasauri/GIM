<?php

// The number of lines in front of config file determine the // hierarchy of files.
require_once (dirname ( dirname ( dirname ( __FILE__ ) ) ) . '/config.php');
require_once ($CFG->dirroot . '/user/lib.php');
require_once ("$CFG->dirroot/user/profile/lib.php");
require_once ("lib.php");
require_once ($CFG->libdir . '/filelib.php');
require_once ($CFG->dirroot . '/repository/lib.php');
require_once ($CFG->dirroot . '/mod/resource/lib.php');
require_once ($CFG->dirroot . '/mod/resource/locallib.php');
require_once ($CFG->libdir . '/completionlib.php');

require_login ();
// Global
global $USER, $DB, $CFG;
$nombre = get_string ( 'pluginname', 'local_gim' ); // nombre del sitio

$PAGE->set_context ( get_system_context () );
$PAGE->set_pagelayout ( 'admin' );
$PAGE->set_title ( $nombre );
$PAGE->set_heading ( $nombre );
$PAGE->set_url ( $CFG->wwwroot . '/local/gim/bproy.php' );
$PAGE->navbar->add ( $nombre );
$self = $CFG->wwwroot . '/local/gim/bproy.php';
$project_page = $CFG->wwwroot . '/local/gim/myprojects.php';
$bproject_page = $CFG->wwwroot . '/local/gim/bproy.php?bid=';
if (! defined ( 'MOODLE_INTERNAL' )) {
	die ( 'Direct access to this script is forbidden.' ); // / It must be included from a Moodle page
}
require_once ($CFG->libdir . '/formslib.php');

echo $OUTPUT->header ();

include 'templates/header.php'; // encabezado de pagina
$userid = $USER->id;
$bid = optional_param ( 'bid', 0, 	PARAM_INT );
$proyecto = $DB->get_record ( 'local_projects', array (
		'id' => $bid 
) );
if ($proyecto->userid != $userid) {
	redirect ( $project_page, '<center>' . get_string ( 'no-idbproy', 'local_gim' ) . '</center>', 3 );
} else {
	class bpro_form extends moodleform {
		
		// Add elements to form
		function definition() {
			global $CFG;
			
			$mform = $this->_form; // Don't forget the underscore!
			$instance = $this->_customdata;
			$bid = $instance ['bid'];
			
			$radioarray = array ();
			$radioarray [] = $mform->createElement ( 'radio', 'yesno', '', get_string ( 'yes' ), 1, $attributes );
			$radioarray [] = $mform->createElement ( 'radio', 'yesno', '', get_string ( 'no' ), 0, $attributes );
			$mform->addGroup ( $radioarray, 'radioar', '', array (
					' ' 
			), false );
			$mform->setDefault('yesno', 0);
			
			$mform->addElement('hidden','bid',$bid); // Elemento del formulario que no se ve, da el valor de la variable st requerido en projects.php para que asi el proyecto sea guardado correctamente, ya que esta pagina esta incluida en projects.php
			$mform->setType('bid', PARAM_INT );
			
			$this->add_action_buttons ();
		}
		// Funcion no agregada al lib.php para un mejor entendimiento del funcionamiento de la misma
		// Custom validation should be added here
		function validation($data, $files) {
			$errors = parent::validation ( $data, $files );
			
			$mform = $this->_form;
			
			$errors = array ();
			
			return $errors;
		}
	}
	
	$mform = new bpro_form (null, array('bid'=>$bid));
	// Form processing and displaying is done here
	if ($mform->is_cancelled ()) {
		// Handle form cancel operation, if cancel button is present on form
		redirect ( $project_page, '<center>' . get_string ( 'cancelbpro', 'local_gim' ) . '</center>', 3 );
	} else if ($fromform = $mform->get_data ()) {
		// In this case you process validated data. $mform->get_data() returns data posted in form.
		// y asigno los valores a guardar en la base de datos que no vienen del formulario. como por ej userid y timecreated
		$toform = new stdClass ();
		$toform->yesno = $fromform->yesno;
		$toform->bid = $fromform->bid;
		$bid = $toform->bid;
		if($toform->yesno == 1){
		$DB->delete_records('local_projects', array('id'=> $bid));
		redirect ( $project_page, '<center>' . get_string ( 'success', 'local_gim' ) . '</center>', 3 );
		}
		else{
			redirect ( $project_page, '<center>' . get_string ( 'cancelbpro', 'local_gim' ) . '</center>', 3 );
		}
	} else {
		echo html_writer::start_div(null, array('id'=>'bproy'));
		echo $OUTPUT->heading ( get_string ( 'sure', 'local_gim' ), 2 );
		echo html_writer::end_div ();
		// this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
		// or on the first display of the form.
		// Set default data (if any)
		$mform->set_data ();
		// displays the form
		$mform->display ();
	}
}
include 'templates/footer.php'; // pie de pagina
echo $OUTPUT->footer ();