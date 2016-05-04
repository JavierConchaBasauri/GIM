<link rel="stylesheet" type="text/css" href="templates/css/style.css" />
<?php
//MENU
echo '<div id="encabezado">';
echo '<div id="titulo">';
echo "<h5>Bienvenido a </h5>";
echo '<h1>'.get_string('pluginname','local_gim').'</h1>';
echo '<h3>'.get_string('slogan','local_gim').'</h3>';
echo '</div>';

//Header menu
echo '<div id="navegador">';
echo '<ul>';

echo '<li><a href="'.$CFG->wwwroot."/local/gim/index.php".'">Inicio</a></li>';
echo '<li><a href="'.$CFG->wwwroot."/local/gim/projects.php".'">Explorar</a></li>';

echo '</ul>';
//fin headermenu
echo '</div>';
echo '</div><hr>';
