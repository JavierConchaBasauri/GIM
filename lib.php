<?php
/*
function local_gim_pluginfile($context, $component, $filearea,$itemid,$path, $args, $forcedownload) {
    global $CFG, $DB, $USER;
	require_login();
	
    $fs = get_file_storage();
    $relativepath = implode('/', $args);
    $fullpath = "/$context->id/local_gim/$filearea/$itemid/$relativepath";
    if (!$file = $fs->get_file_by_hash(sha1($fullpath)) or $file->is_directory()) {
        return false;
    }


    // finally send the file
    send_stored_file($file, 0, 0, true); // download MUST be forced - security!
}
*/
//funcion necesaria para la muestra de archivos subidos y almacenados en la base de datos
function local_gim_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
	
	// Make sure the filearea is one of those used by the plugin.
	if ($filearea !== 'media') {
		return false;
	}
	
	// Make sure the user is logged in and has access to the module (plugins that are not course modules should leave out the 'cm' part).
	require_login();
	
	
	// Leave this line out if you set the itemid to null in make_pluginfile_url (set $itemid to 0 instead).
	$itemid = array_shift($args); // The first item in the $args array.
	
	// Use the itemid to retrieve any relevant data records and perform any security checks to see if the
	// user really does have access to the file in question.
	
	// Extract the filename / filepath from the $args array.
	$filename = array_pop($args); // The last item in the $args array.
	if (!$args) {
		$filepath = '/'; // $args is empty => the path is '/'
	} else {
		$filepath = '/'.implode('/', $args).'/'; // $args contains elements of the filepath
	}
	
	// Retrieve the file from the Files API.
	$fs = get_file_storage();
	$file = $fs->get_file($context->id, 'local_gim', $filearea, $itemid, $filepath, $filename);
	if (!$file) {
		return false; // The file does not exist.
	}
	
	// We can now send the file back to the browser - in this case with a cache lifetime of 1 day and no filtering.
	// From Moodle 2.3, use send_stored_file instead.
	send_stored_file($file, 0, 0, $forcedownload, $options);
}