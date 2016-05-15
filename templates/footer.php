<?php
//inicio pie de pagina
echo '<div id="footer">';
echo '<hr>';

echo '<h6>'.get_string('pluginname','local_gim').'</h6>';

echo '</div>';
?>
  <!-- javascript at the bottom for fast page loading -->
<script type="text/javascript" src="js/ext/jquery-1.8.2.min.js"></script>
		<script type="text/javascript" src="js/buscar-en-tabla.js"></script>
  <!--<a<script type="text/javascript" src="layout/js/jquery.js"></script>-->
  <script type="text/javascript" src="js/jquery.easing-sooper.js"></script>
  <script type="text/javascript" src="js/jquery.sooperfish.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('ul.sf-menu').sooperfish();
      $('.top').click(function() {$('html, body').animate({scrollTop:0}, 'fast'); return false;});
    });
  </script>
