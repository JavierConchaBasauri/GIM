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
require_once($CFG->libdir . '/formslib.php');

require_login ();
// Global
global $USER, $DB, $CFG;
$moodle = $CFG->wwwroot;
$nombre = get_string ( 'pluginname', 'local_gim' ); // nombre del sitio

$PAGE->set_context ( get_system_context () );
$PAGE->set_pagelayout ( 'admin' );
$PAGE->set_title ( $nombre );
$PAGE->set_heading ( $nombre );
$PAGE->set_url ( $CFG->wwwroot . '/local/gim/donate.php' );
$PAGE->navbar->add ( $nombre );
$self = $CFG->wwwroot . '/local/gim/donate.php';
$project_page = $CFG->wwwroot . '/local/gim/projects.php';

echo $OUTPUT->header ();

include 'templates/header.php'; // encabezado de pagina
$did = optional_param ( 'did', 0, PARAM_INT );
// si no hay ingresado un id de proyecto, o si el id es 0, significa que no hay proyectos, por ende redirijo
if ($did == 0) {
	redirect ( $project_page, '<center>' . get_string ( 'no-iddona', 'local_gim' ) . '</center>', 3 );
} else {
	class agdon_form extends moodleform {
	
		//Add elements to form
		function definition() {
			global $CFG;
	
			$mform = $this->_form; // Don't forget the underscore!
			$instance = $this->_customdata;
			$did = $instance ['did'];
			
			$mform->addElement('text', 'amount', get_string('donation', 'local_gim') . ':'); // primer elemento del formulario, caja de texto
			$mform->setType('amount', PARAM_INT); //Set type of element
			
			$mform->addElement('hidden', 'did', $did); // Elemento del formulario que no se ve, da el valor de la variable st requerido en projects.php para que asi el proyecto sea guardado correctamente, ya que esta pagina esta incluida en projects.php
			$mform->setType('did', PARAM_INT);
			$this->add_action_buttons();
		}
		//Funcion no agregada al lib.php para un mejor entendimiento del funcionamiento de la misma
		//Custom validation should be added here
		function validation($data, $files) {
			$errors = parent::validation($data, $files);
	
			$mform = $this->_form;
	
			$errors = array();
	
			//es requerido que la cantidad donada a proyecto sea declarada
			if ($mform->elementExists('amount')) {
				if ($data['amount'] < 0) {
					$errors['amount'] = get_string('amount', 'local_gim') ;
				}
			}
	
			return $errors;
		}
	
	}
	
	//Instantiate simplehtml_form
	$mform = new agdon_form(null, array('did'=>$did));
	
	//Form processing and displaying is done here
	if ($mform->is_cancelled()) {
		//Handle form cancel operation, if cancel button is present on form
		redirect('projects.php');
	} else if ($fromform = $mform->get_data()) {
				
		//In this case you process validated data. $mform->get_data() returns data posted in form.
		// y asigno los valores a guardar en la base de datos que no vienen del formulario. como por ej userid y timecreated
		$toform = new stdClass();
		$toform->idproject = $fromform->did;
		$bid = $toform->idproject;
		$toform->monto = $fromform->amount;
		$toform->idusuario = $USER->id;
		$lastinsertid = $DB->insert_record('local_donations', $toform, true);
		

	
		$url = $CFG->wwwroot.'/local/gim/vprojects.php?id='.$did;
		redirect ( $url, '<center>' . get_string ( 'successdon', 'local_gim' ) . '</center>', 3 );
	} else {
		// this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
		// or on the first display of the form.
		//Set default data (if any)
		$mform->set_data();
		//displays the form
		$mform->display();
	}
	
	
	
	
}

include 'templates/footer.php'; // pie de pagina
echo $OUTPUT->footer ();