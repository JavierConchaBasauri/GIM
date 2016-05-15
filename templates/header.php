<link rel="stylesheet" type="text/css" href="templates/css/style.css" />
 <link rel="stylesheet" type="text/css" href="js/ext/webmonsterTooltip/css/webmonster.Tooltip.css">
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>tinymce.init({ selector:'textarea' });</script>
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

echo '<li><a href="'.$CFG->wwwroot."/local/gim/index.php".'">'.get_string('inicio','local_gim').'</a></li>';
echo '<li><a href="'.$CFG->wwwroot."/local/gim/projects.php".'">'.get_string('explorar','local_gim').'</a></li>';

echo '</ul>';
//fin headermenu
echo '</div>';
echo '</div><hr>';
