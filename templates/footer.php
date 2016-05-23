<?php
// inicio pie de pagina
echo html_writer::start_div ( null, array (
		'id' => 'footer' 
) );
echo html_writer::empty_tag ( 'hr' );

echo $OUTPUT->heading ( get_string ( 'pluginname', 'local_gim' ), 6 );

echo html_writer::end_div ();
?>
<!-- javascript at the bottom for fast page loading -->
<script type="text/javascript" src="js/ext/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="js/buscar-en-tabla.js"></script>
<script type="text/javascript">
	var text = "<?php echo get_string('noresults','local_gim'); ?>";
	</script>
<!--<a<script type="text/javascript" src="layout/js/jquery.js"></script>
  <script type="text/javascript" src="js/jquery.easing-sooper.js"></script>
  <script type="text/javascript" src="js/jquery.sooperfish.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('ul.sf-menu').sooperfish();
      $('.top').click(function() {$('html, body').animate({scrollTop:0}, 'fast'); return false;});
    });
  </script>-->
