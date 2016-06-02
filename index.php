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
$PAGE->set_url($CFG->wwwroot.'/local/gim/index.php');
$PAGE->navbar->add($nombre);
$agpro=$CFG->wwwroot.'/local/gim/projects.php?st=1'; // direccion de la pagina para agregar proyectos
$vpro=$CFG->wwwroot.'/local/gim/projects.php';  // direccion de la pagina para ver proyectos
$vpr=$CFG->wwwroot.'/local/gim/vprojects.php?id='; // direccion de la pagina para ver un proyecto segun su id



echo $OUTPUT->header();

include 'templates/header.php'; //encabezado de pagina
// Actual content goes here
//caja "que es..?"
echo html_writer::start_div(null, array('id'=>'flotizq2'));
echo $OUTPUT->heading(get_string('question','local_gim'), 2);
echo get_string('descp','local_gim');
echo html_writer::end_div();
//Caja video
echo html_writer::start_div(null, array('id'=>'flotder'));
echo html_writer::empty_tag('video', array('src' => 'templates/media/TOTO - Africa [LIVE].mp4', 'type' => 'video/mp4', 'width'=>'320', 'height' => '240','controls'=> ''));
/*echo '<video width="320" height="240" controls>
  <source src="templates/media/TOTO - Africa [LIVE].mp4" type="video/mp4">
</video>';*/
//echo '<img src="templates/media/IMG_5320.jpg" alt="Smiley face" height="380" width="480">';
echo html_writer::end_div();

//CAJA CENTRO, CONTIENE CAJAS DERECHA e IZQUIERDA
echo html_writer::start_div(null, array('id'=>'cuerpo'));
echo html_writer::empty_tag('hr');
//caja flotante izquierda empezar un proyecto
echo html_writer::start_div(null, array('id'=>'flotizq'));
echo html_writer::start_div('vertical-centered-text', array('id'=>'caja'));
echo html_writer::link($agpro, get_string('startproj','local_gim'));
echo html_writer::end_div();
echo html_writer::end_div();


//caja flotante derecha ver proyectos
echo html_writer::start_div(null, array('id'=>'flotder'));
echo html_writer::start_div(null, array('id'=>'cajader'));
echo html_writer::link($vpro, get_string('seeproj','local_gim'));
echo html_writer::end_div();
echo html_writer::end_div();


echo html_writer::end_div();

//CAJAS FINALES
//busco los dos proyectos mas visitados para luego mostrarlos en el index como los "mas vistos"
$limit = 2;
$proyectos = $DB->get_records ( 'local_projects' );
$select="id > 0 ORDER BY vistas DESC limit $limit";
$results = $DB->get_records_select('local_projects',$select);
$max = array();
$id = array();
$vistas = array();
$financiacion=array();
//recorro el resultado del query, que es un array. Luego guardo los elementos recorridos en otro arreglo conveniente
foreach($results as $result){
	$max []= $result->projectname;
	$id[] =$result->id;
	$vistas[] =$result->vistas;
	$financiacion[] =$result->financiacion;
	//echo $result->projectname.' '.$result->vistas.'<br>';
}
echo html_writer::start_div ( null, array ('id' => 'cajamasvistos'));
if (count ( $proyectos ) < 1) {
	echo $OUTPUT->heading( get_string ( 'nop-verp', 'local_gim' ));
} else {
	$idd = str_split ( $id[0] );
	$total = $DB->get_record_sql( 'SELECT sum(monto) AS monto FROM {local_donations} WHERE idproject = ?',$idd); // Busco los datos del proyecto asociados a su id
	$total = $total->monto;
	if($total == ''){
		$total = 0;
	}
	echo $OUTPUT->heading(get_string ( 'mostseen', 'local_gim' ),4);
	//se muestra la poscion [0] de los arreglos convenientes creados anteriormente
	echo html_writer::start_div(null, array('id'=>'flotizq'));
	echo html_writer::start_div('vertical-centered-text', array('id'=>'caja'));
	echo html_writer::link($vpr.array_values($id)[0], array_values($max)[0]);
	echo html_writer::label(get_string('views','local_gim').$vistas[0], null);
	echo html_writer::label(get_string('finan','local_gim').$total, null);
	echo html_writer::end_div();
	echo html_writer::end_div();
	$idd = str_split ( $id[1] );
	$total = $DB->get_record_sql( 'SELECT sum(monto) AS monto FROM {local_donations} WHERE idproject = ?',$idd); // Busco los datos del proyecto asociados a su id
	$total = $total->monto;
	if($total == ''){
		$total = 0;
	}
	//se muestra la poscion [1] de los arreglos convenientes creados anteriormente
	echo html_writer::start_div(null, array('id'=>'flotder'));
	echo html_writer::start_div('vertical-centered-text', array('id'=>'caja'));
	echo html_writer::link($vpr.array_values($id)[1], array_values($max)[1]);
	echo html_writer::label(get_string('views','local_gim').$vistas[1], null);
	echo html_writer::label(get_string('finan','local_gim').$total, null);
	echo html_writer::end_div();
	echo html_writer::end_div();
/* NO SIRVE
$proyecto = $DB->get_records('local_projects', null, 'vistas DESC', 'id,projectname,vistas', $limit);
for($i=1; $i <= $limit;$i++){
	echo $proyecto[$i]->projectname.html_writer::empty_tag('br');
}
echo $proyecto[1]->projectname;
echo $proyecto[2]->projectname;
$sql = 'SELECT `id`, `projectname`, `projectdescription`, `vistas`, `userid`, `financiacion`, `timecreated`, `timemodified` FROM mdl_local_projects  ORDER BY `vistas` DESC LIMIT 2';
$proyectos = $DB->get_records_sql($sql);

echo $proyectos[1]->projectname;
echo $proyectos[2]->projectname;*/
}
echo html_writer::end_div();




include 'templates/footer.php'; // pie de pagina
echo $OUTPUT->footer();
