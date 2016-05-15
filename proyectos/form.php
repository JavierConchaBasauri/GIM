<?php 

require_once($CFG->libdir.'/formslib.php');
require_once('lib.php');

$filemanageropts = array('subdirs' => 0, 'maxbytes' => '0', 'maxfiles' => 50, 'context' => $context);
$customdata = array('filemanageropts' => $filemanageropts);
$mform = new simplehtml_form(null, $customdata);


$itemid = 0; // This is used to distinguish between multiple file areas, e.g. different student's assignment submissions, or attachments to different forum posts, in this case we use '0' as there is no relevant id to use
// Fetches the file manager draft area, called 'attachments' 
$draftitemid = file_get_submitted_draft_itemid('attachments');
// Copy all the files from the 'real' area, into the draft area
file_prepare_draft_area($draftitemid, $context->id, 'local_gim', 'attachment', $itemid, $filemanageropts);
// Prepare the data to pass into the form - normally we would load this from a database, but, here, we have no 'real' record to load
$entry = new stdClass();
$entry->attachments = $draftitemid; // Add the draftitemid to the form, so that 'file_get_submitted_draft_itemid' can retrieve it

// Set form data
// This will load the file manager with your previous files
$mform->set_data($entry);



// ----------
// Form Submit Status
// ----------
if ($mform->is_cancelled()) {
    // CANCELLED
    echo '<h1>Cancelled</h1>';
    echo '<p>Handle form cancel operation, if cancel button is present on form<p>';
	echo '<a href="/local/filemanager/index.php"><input type="button" value="Try Again" /><a>';
} else if ($data = $mform->get_data()) {
    // SUCCESS
    echo '<h1>Success!</h1>';
    echo '<p>In this case you process validated data. $mform->get_data() returns data posted in form.<p>';
    // Save the files submitted
    file_save_draft_area_files($draftitemid, $context->id, 'local_filemanager', 'attachment', $itemid, $filemanageropts);
} else {
    // FAIL / DEFAULT
    echo '<h1 style="text-align:center">Display form</h1>';
    echo '<p>This is the form first display OR "errors"<p>';
    $mform->display();
}