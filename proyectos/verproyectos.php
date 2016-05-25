<?php
global $DB;
$proyectos = $DB->get_records ( 'local_projects' );
$select="userid > 0 ORDER BY id ASC";
$results = $DB->get_records_select('local_projects',$select);
$name = array();
$descp = array();
$id = array();
$owner = array();
$vistas = array();
$financiacion=array();
//recorro el resultado del query, que es un array. Luego guardo los elementos recorridos en otro arreglo conveniente
foreach($results as $result){
	$name []= $result->projectname;
	$descp []= $result->projectdescription;
	$id[] =$result->id;
	$vistas[] =$result->vistas;
	$owner[] =$result->userid;
	$financiacion[] =$result->financiacion;
	//echo $result->projectname.' '.$result->vistas.'<br>';
}
if (count ( $results ) < 1) {
	echo get_string ( 'nop-verp', 'local_gim' );
} else {
	echo html_writer::start_div ( null, array (
			'id' => 'tablaun' 
	) );
	echo 'Buscar:&nbsp<input type="search" id="txtBuscar" autofocus placeholder="' . get_string ( 'searchb', 'local_gim' ) . '">';
	echo html_writer::start_div ( null, array (
			'id' => 'divContenido' 
	) );
	/*
	 * echo '<table id="tblTabla">';
	 * echo '<tr><th width="25%">' . get_string('proy-verp', 'local_gim') . '</th><th width="50%">' . get_string('desc-verp', 'local_gim') . '</th><th width="25%">' . get_string('resp-verp', 'local_gim') . '</th></tr>';
	 * for ($i = 1; $i <= count($proyectos); $i++) {
	 * $userid = $proyectos[$i]->userid;// obtengo el id del usuario dueño del proyecto en forma de string
	 * $useridstring = $userid; // Guardo el id del usuario como string en otra variable
	 * $userid = str_split($userid); // cambio el id del usuario de forma. string -> array. para poder usarlo en la funcion get_record_sql
	 * $responsable=$DB->get_record_sql('SELECT firstname,lastname FROM {user} WHERE id = ?', $userid); //Busco el nombre del dueño del proyecto
	 * $nombre = $responsable->firstname.' '.$responsable->lastname;
	 * //muestro los datos
	 * echo '<tr><td><a href="'.$moodle.'/local/gim/vprojects.php?id='.$i.'">'.$proyectos[$i]->projectname.'</a></td><td>'.substr($proyectos[$i]->projectdescription,0,250).'</td><td><a href="'.$moodle.'/user/profile.php?id='.$useridstring.'">'.$nombre.'</a></td>';
	 * echo '</tr>';
	 * }
	 * echo '</table>';
	 */
	
	$table = new html_table ();
	$table->head = array (
			get_string ( 'proy-verp', 'local_gim' ),
			get_string ( 'desc-verp', 'local_gim' ),
			get_string ( 'resp-verp', 'local_gim' ) 
	);
	echo html_writer::start_div ( null, array (
			'id' => 'tblTabla' 
	) );
	for($i = 0; $i < count ( $results ); $i ++) {
		$userid = $owner[$i]; // obtengo el id del usuario dueño del proyecto en forma de string
		$useridstring = $userid; // Guardo el id del usuario como string en otra variable
		$userid = str_split ( $userid ); // cambio el id del usuario de forma. string -> array. para poder usarlo en la funcion get_record_sql
		$responsable = $DB->get_record_sql ( 'SELECT firstname,lastname FROM {user} WHERE id = ?', $userid ); // Busco el nombre del dueño del proyecto
		$nombre = $responsable->firstname . ' ' . $responsable->lastname;
		// muestro los datos
		$proynomb = wordwrap ( $name[$i], 30, "<br />\n" );
		$proydesc = wordwrap ( substr (strip_tags( $descp[$i]), 0, 250 ), 70, "<br />\n" );
		$nombre = wordwrap ( $nombre, 30, "<br />\n" );
		$row = new html_table_row ( array (
				html_writer::link ( $moodle . '/local/gim/vprojects.php?id=' . $i, $proynomb ),
				$proydesc,
				html_writer::link ( $moodle . '/user/profile.php?id=' . $useridstring, $nombre ) 
		) );
		$row->attributes ['data-id'] = '1';
		$table->data [] = $row;
	}
	
	echo html_writer::table ( $table );
	echo html_writer::end_div ();
	echo html_writer::end_div ();
	echo html_writer::end_div ();
	/*
	 * echo '<div>
	 * <a class="anterior" href="">'.get_string('previous','local_gim').'</a>
	 * <a class="siguiente" href="">'.get_string('next','local_gim').'</a>
	 * </div>';
	 */
}