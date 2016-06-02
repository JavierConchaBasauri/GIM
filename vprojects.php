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
$moodle = $CFG->wwwroot;
$nombre = get_string ( 'pluginname', 'local_gim' ); // nombre del sitio

$PAGE->set_context ( get_system_context () );
$PAGE->set_pagelayout ( 'admin' );
$PAGE->set_title ( $nombre );
$PAGE->set_heading ( $nombre );
$PAGE->set_url ( $CFG->wwwroot . '/local/gim/vprojects.php' );
$PAGE->navbar->add ( $nombre );
$self = $CFG->wwwroot . '/local/gim/vprojects.php';
$project_page = $CFG->wwwroot . '/local/gim/projects.php';

echo $OUTPUT->header ();

include 'templates/header.php'; // encabezado de pagina
$verproy = optional_param ( 'id', 0, PARAM_INT );
// si no hay ingresado un id de proyecto, o si el id es 0, significa que no hay proyectos, por ende redirijo
if ($verproy == 0) {
	redirect ( $project_page, '<center>' . get_string ( 'no-idproy', 'local_gim' ) . '</center>', 3 );
} else {
	// $verproy = str_split($verproy); // cambio el id del usuario de forma. string -> array. para poder usarlo en la funcion get_record_sql
	$proyecto = $DB->get_record ( 'local_projects', array (
			'id' => $verproy 
	) ); // Busco los datos del proyecto asociados a su id
	     // se muestran el titulo y la descripcion del proyecto
	$vistas = $proyecto->vistas;
	echo html_writer::start_div ( null, array (
			'id' => 'cajaverp' 
	) );
	echo $OUTPUT->heading ( $proyecto->projectname, 1 );
	echo html_writer::label ( $proyecto->projectdescription, null );
	// Get day, month and year for creation date of the project.
	$date = $proyecto->timecreated;
	$mod = $proyecto->timemodified;
	
	// Print formatted date
	$ago = '.';
	if (current_language () == 'en') {
		$ago = ' ago.';
	}
	echo $OUTPUT->heading ( (get_string ( 'creado', 'local_gim' ) . gmdate ( "D, Y-m-d  \  H:i:s  ", $date )), 5 );
	if ($date != $mod) {
		echo $OUTPUT->heading ( (get_string ( 'modificado', 'local_gim' ) . format_time ( $mod - time () )) . $ago, 5 );
	}
	echo html_writer::end_div ();
	// caja destinada a MEDIA
	echo html_writer::start_div ( null, array (
			'id' => 'cajavermedia' 
	) );
	
	// Comienzo a llamar los archivos almacenados en la base de datos
	$context = context_system::instance ();
	$contextid = $context->id;
	$table_files = "files";
	$fs = get_file_storage ();
	$files = $fs->get_area_files ( $contextid, 'local_gim', 'media', $verproy );
	// Get the file details here::::
	if (count ( $files ) == 0) {
		echo $OUTPUT->heading ( get_string ( 'nomedia', 'local_gim' ), 1 );
	} else {
		echo $OUTPUT->heading ( get_string ( 'media', 'local_gim' ), 1 );
		// recorro el arreglo con los archivos para luego mostrarlos
		foreach ( $files as $file ) {
			$filename = $file->get_filename ();
			$url = moodle_url::make_pluginfile_url ( $file->get_contextid (), $file->get_component (), $file->get_filearea (), $file->get_itemid (), $file->get_filepath (), $file->get_filename (), true );
			$out = html_writer::link ( $url, $filename );
			$ext = explode ( '.', $filename );
			// como moodle guarda dos elementos por archivo subido, uno con tama�o de archivo 0, que por ende no podemos leer y no nos sirve, filtro
			if ($file->get_filesize () > 0) {
				// en esta condicion, veo si son archivos del tipo imagen para mostrarlos como tal
				if ($file->get_mimetype () == 'image/bmp' || $file->get_mimetype () == 'image/vnd.dwg' || $file->get_mimetype () == 'image/x-dwg' || $file->get_mimetype () == 'image/gif' || $file->get_mimetype () == 'image/jpeg' || $file->get_mimetype () == 'image/png') {
					/*echo html_writer::img ( $url, $filename, array (
							'width' => '400',
							'height' => '300' 
					) );*/
					echo html_writer::link( $url, html_writer::img( $url, $filename, array (
							'width' => '200',
							'height' => '150',
							'class' => 'example-image'
					) ), array(
							'class' => 'example-image-link',
							'data-lightbox' => 'example-set',
							'data-title'=> $filename
					));
					echo html_writer::empty_tag ( 'br' );
					$ext [1] = 'jpeg';
					// en esta condicion veo si son archivos del tipo video para mostrarlos como tal
				} elseif ($file->get_mimetype () == 'video/avi' || $file->get_mimetype () == 'video/msvideo' || $file->get_mimetype () == 'video/x-msvideo' || $file->get_mimetype () == 'video/mpeg' || $file->get_mimetype () == 'video/quicktime' || $file->get_mimetype () == 'video/mp4') {
					echo html_writer::empty_tag ( 'video', array (
							'src' => $url,
							'type' => $file->get_mimetype (),
							'width' => '400',
							'height' => '300',
							'controls' => '' 
					) );
					echo html_writer::end_tag ( 'video' );
					echo html_writer::empty_tag ( 'br' );
					$ext [1] = 'video';
				} else {
				}
				if ($ext [1] == 'ddoc' || $ext [1] == 'doc' || $ext [1] == 'docm' || $ext [1] == 'docx' || $ext [1] == 'dotm' || $ext [1] == 'dotx') {
					$ext [1] = 'document';
				}
				if ($ext [1] == 'potm' || $ext [1] == 'potx' || $ext [1] == 'ppam' || $ext [1] == 'pps' || $ext [1] == 'ppsm' || $ext [1] == 'ppsx' || $ext [1] == 'ppt' || $ext [1] == 'pptx') {
					$ext [1] = 'powerpoint';
				}
				if ($ext [1] == 'txt' || $ext [1] == 'asc' || $ext [1] == 'txt') {
					$ext [1] = 'text';
				}
				if ($ext [1] == 'xlam' || $ext [1] == 'xls' || $ext [1] == 'xlsb' || $ext [1] == 'xlsm' || $ext [1] == 'xlsx' || $ext [1] == 'xltm' || $ext [1] == 'xltx' || $ext [1] == 'csv') {
					$ext [1] = 'spreadsheet';
				}
				$icon = $CFG->wwwroot . '/theme/image.php/clean/core/1463981173/f/';
				$icon = $icon . $ext [1] . '-24';
				echo html_writer::img ( $icon, $filename );
				// muestro el link de descarga de los archivos
				echo $out . html_writer::empty_tag ( 'br' );
			}
		}
	}
	
	echo html_writer::end_div ();
	// fin media
	$idd = str_split ( $verproy );
	$total = $DB->get_record_sql ( 'SELECT sum(monto) AS monto FROM {local_donations} WHERE idproject = ?', $idd ); // Busco los datos del proyecto asociados a su id
	$total = $total->monto;
	if ($total == '') {
		$total = 0;
	}
	
	echo html_writer::start_div ( null, array (
			'id' => 'navegadorproy' 
	) );
	echo $OUTPUT->heading ( get_string ( 'finan', 'local_gim' ) . ' ' . $total, 3 );
	echo html_writer::empty_tag ( 'ul' );
	
	echo html_writer::empty_tag ( 'li' ) . html_writer::link ( $CFG->wwwroot . "/local/gim/donate.php?did=" . $verproy, get_string ( 'donate', 'local_gim' ) ) . html_writer::empty_tag ( '/li' );
	
	echo html_writer::empty_tag ( '/ul' );
	// fin boton donar
	echo html_writer::end_div ();
	
	// comienzo caja "sobre el due�o"
	echo html_writer::start_div ( null, array (
			'id' => 'cajaverdueno' 
	) );
	
	$userid = $proyecto->userid; // obtengo el id del usuario dueño del proyecto en forma de string
	$useridstring = $userid; // Guardo el id del usuario como string en otra variable
	$userid = str_split ( $userid ); // cambio el id del usuario de forma. string -> array. para poder usarlo en la funcion get_record_sql
	$responsable = $DB->get_record_sql ( 'SELECT firstname,lastname,description FROM {user} WHERE id = ?', $userid ); // Busco el nombre del dueño del proyecto
	$nombre = $responsable->firstname . ' ' . $responsable->lastname;
	$proyecto->vistas ++;
	$DB->update_record ( 'local_projects', $proyecto );
	$rs = $DB->get_recordset_select ( "user", "deleted = 0 AND picture > 0 AND id = $useridstring", array (), "lastaccess DESC", user_picture::fields () );
	// muestro los datos del due�o del proyecto en una tabla especial.
	echo '<table class="tg">
  <tr>
    <th class="tg-i6eq" colspan="2">' . get_string ( 'personal-idproy', 'local_gim' ) . '</th>
  </tr>
  <tr>
    <td class="tg-huad" rowspan="2">';
	foreach ( $rs as $user ) {
		echo "<a href=\"$CFG->wwwroot/user/view.php?id=$user->id&amp;course=1\" " . "title=\"$fullname\">";
		echo $OUTPUT->user_picture ( $user, array (
				'size' => 100 
		) );
		echo "</a> \n";
	}
	echo '</td>
    <td class="tg-huad">' . $nombre . '</td>
  </tr>
  <tr>
    <td class="tg-huad">' . $responsable->description . '</td>
  </tr>
</table>';
	echo html_writer::end_div ();
	
	if ($proyecto->userid == $USER->id) {
		echo html_writer::start_div ( null, array (
				'id' => 'cajaversiesdueno' 
		) );
		$results = $DB->get_records ( 'local_donations', array (
				'idproject' => $verproy 
		) );
		$donadorid = array ();
		$monto = array ();
		// recorro el resultado del query, que es un array. Luego guardo los elementos recorridos en otro arreglo conveniente
		foreach ( $results as $result ) {
			$donadorid [] = $result->idusuario;
			$monto [] = $result->monto;
		}
		if ( count ( $results )> 0) {
			echo html_writer::empty_tag ( 'br' ) . $OUTPUT->heading ( get_string ( 'donreal', 'local_gim' ), 3 );
			echo html_writer::start_div ( null, array (
					'id' => 'tablaadmin'
			) );
			$table = new html_table ();
			$table->head = array (
					get_string ( 'finanmyp', 'local_gim' ),
					get_string ( 'donby', 'local_gim' ) 
			);
			for($i = 0; $i < count ( $results ); $i ++) {
				$userid = $donadorid [$i]; // obtengo el id del usuario dueño del proyecto en forma de string
				$useridstring = $userid; // Guardo el id del usuario como string en otra variable
				$userid = str_split ( $userid ); // cambio el id del usuario de forma. string -> array. para poder usarlo en la funcion get_record_sql
				$responsable = $DB->get_record_sql ( 'SELECT firstname,lastname FROM {user} WHERE id = ?', $userid ); // Busco el nombre del dueño del proyecto
				$nombre = $responsable->firstname . ' ' . $responsable->lastname;
				$row = new html_table_row ( array (
						$monto[$i],
						html_writer::link ( $moodle . '/user/profile.php?id=' . $useridstring, $nombre ) 
				) );
				$row->attributes ['data-id'] = '1';
				$table->data [] = $row;
			}
			echo html_writer::table ( $table );
			echo html_writer::end_div ();
			echo html_writer::empty_tag ( 'br' );
		}
		if(count ( $results ) == 0){
		echo $OUTPUT->heading ( get_string ( 'nodon', 'local_gim' ), 3 );
		}
		echo html_writer::end_div ();
	} else {
	}
}
include 'templates/footer.php'; // pie de pagina
echo $OUTPUT->footer ();






