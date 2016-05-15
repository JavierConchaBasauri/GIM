<?php

echo '<div id="tablaun">Buscar:&nbsp<input type="search" id="txtBuscar" autofocus placeholder="'.get_string('searchb','local_gim').'">
<div id="divContenido"><table id="tblTabla">';
    echo '<tr><th>Nombre</th><th>Precio</th><th>Direccion</th><th>E-Mail</th><th>Telefono</th></tr>';
        echo '<tr><td>Hola</td><td>Perro</td><td>Tigre</td><td>jaconcha@alumnos.uai.cl</td><td>78887951</td>';
        echo '</tr>';
        echo '<tr><td>chao</td><td>Gato</td><td>elefante</td><td>javier.concha.basauri@hotmail.com</td><td>56978887951</td>';
        echo '</tr>';
echo '</table>
         </div></div>';
echo '<div>
    <a class="anterior"  href="">'.get_string('previous','local_gim').'</a>
    <a class="siguiente" href="">'.get_string('next','local_gim').'</a>
</div>';