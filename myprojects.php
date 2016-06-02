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
$PAGE->set_url ( $CFG->wwwroot . '/local/gim/myprojects.php' );
$PAGE->navbar->add ( $nombre );
$self = $CFG->wwwroot . '/local/gim/vprojects.php';
$project_page = $CFG->wwwroot . '/local/gim/projects.php';

echo $OUTPUT->header ();

include 'templates/header.php'; // encabezado de pagina
$userid = $USER->id;
/*
 * $proyectos = $DB->get_records( 'local_projects', array('userid'=> $userid), 'userid ASC, id ASC' ,'*');
 * echo $proyectos[10]->projectname.'<br>';
 * //var_dump($proyectos);
 */
$select = "userid = '$userid' ORDER BY id ASC";
$results = $DB->get_records_select ( 'local_projects', $select );
$name = array ();
$descp = array ();
$id = array ();
$vistas = array ();
$financiacion = array ();
// recorro el resultado del query, que es un array. Luego guardo los elementos recorridos en otro arreglo conveniente
foreach ( $results as $result ) {
	$name [] = $result->projectname;
	$descp [] = $result->projectdescription;
	$id [] = $result->id;
	$vistas [] = $result->vistas;
	$financiacion [] = $result->financiacion;
	// echo $result->projectname.' '.$result->vistas.'<br>';
}
echo html_writer::start_div ( null, array (
		'id' => 'myproject' 
) );
// query para seleccionar la imagen del usuario
$rs = $DB->get_recordset_select ( "user", "deleted = 0 AND picture > 0 AND id = $userid", array (), "lastaccess DESC", user_picture::fields () );
// recorro la query y luego muestro la imagen
foreach ( $rs as $user ) {
	echo "<a href=\"$CFG->wwwroot/user/view.php?id=$user->id&amp;course=1\" " . "title=\"$fullname\">";
	echo $OUTPUT->user_picture ( $user, array (
			'size' => 100 
	) );
	echo "</a> \n";
}
// mensaje de saludo
echo $OUTPUT->heading ( get_string ( 'hello', 'local_gim' ) . ' ' . $USER->firstname, 1 );
// si tiene proyectos, se señala la cantidad de los mismos
if (count ( $results ) > 0) {
	echo $OUTPUT->heading ( (get_string ( 'total', 'local_gim' ) . count ( $results )), 2 );
}// si no tiene proyectos, se señala que no tiene
elseif (count ( $results ) == 0) {
	echo $OUTPUT->heading ( get_string ( 'noproy', 'local_gim' ), 2 );
}
echo html_writer::end_div ();
// comienzo de la caja de la tabla
echo html_writer::start_div ( null, array (
		'id' => 'tablaun' 
) );
// si hay resultados (proyectos) se muestra el buscador
if (count ( $results ) > 0) {
	echo 'Buscar:&nbsp<input type="search" id="txtBuscar" autofocus placeholder="' . get_string ( 'searchb', 'local_gim' ) . '">';
	echo html_writer::start_div ( null, array (
			'id' => 'divContenido' 
	) );
	// luego del buscado, la tabla
	$table = new html_table ();
	$table->head = array (
			get_string ( 'proy-verp', 'local_gim' ),
			get_string ( 'desc-verp', 'local_gim' ),
			get_string ( 'viewsmyp', 'local_gim' ),
			get_string ( 'finanmyp', 'local_gim' ),
			get_string ( 'actions', 'local_gim' ) 
	);
	echo html_writer::start_div ( null, array (
			'id' => 'tblTabla' 
	) );
	for($i = 0; $i < count ( $results ); $i ++) {
		$idd = str_split ( $id [$i] );
		$total = $DB->get_record_sql ( 'SELECT sum(monto) AS monto FROM {local_donations} WHERE idproject = ?', $idd ); // Busco los datos del proyecto asociados a su id
		$total = $total->monto;
		if ($total == '') {
			$total = 0;
		}
		
		// arreglo los datos (formato)
		$proynomb = wordwrap ( $name [$i], 30, "<br />\n" );
		$proydesc = wordwrap ( substr ( strip_tags ( $descp [$i] ), 0, 250 ), 60, "<br />\n" );
		$nombre = wordwrap ( $nombre, 30, "<br />\n" );
		// muestro los datos en la tabla
		$row = new html_table_row ( array (
				html_writer::link ( $moodle . '/local/gim/vprojects.php?id=' . $id [$i], $proynomb ),
				$proydesc,
				$vistas [$i],
				$total,
				html_writer::link ( $moodle . '/local/gim/bproy.php?bid=' . $id [$i], get_string ( 'borrar', 'local_gim' ) ) 
		) );
		$row->attributes ['data-id'] = '1';
		$table->data [] = $row;
	}
	echo html_writer::table ( $table );
	echo html_writer::end_div ();
	echo html_writer::end_div ();
	echo html_writer::end_div ();
} else {
}

include 'templates/footer.php'; // pie de pagina
echo $OUTPUT->footer ();
