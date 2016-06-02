<?php
defined('MOODLE_INTERNAL') || die();
/**
 * Execute emarking upgrade from the given old version
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_local_gim_upgrade($oldversion) {
    global $DB;
    // Loads ddl manager and xmldb classes.
    $dbman = $DB->get_manager();
    if ($oldversion < 2016051810) {

        // Define table local_donations to be created.
        $table = new xmldb_table('local_donations');

        // Adding fields to table local_donations.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('idusuario', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, null);
        $table->add_field('idproject', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, null);
        $table->add_field('monto', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table local_donations.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for local_donations.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Gim savepoint reached.
        upgrade_plugin_savepoint(true, 2016051810, 'local', 'gim');
    }
    
    if ($oldversion < 2016051800) {
    
    	// Define table local_projects to be created.
    	$table = new xmldb_table('local_projects');
    
    	// Adding fields to table local_projects.
    	$table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
    	$table->add_field('projectname', XMLDB_TYPE_TEXT, null, null, null, null, null);
    	$table->add_field('projectdescription', XMLDB_TYPE_TEXT, null, null, null, null, null);
    	$table->add_field('vistas', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '1');
    	$table->add_field('userid', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, null);
    	$table->add_field('financiacion', XMLDB_TYPE_NUMBER, '20, 3', null, null, null, '0');
    	$table->add_field('timecreated', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, null);
    	$table->add_field('timemodified', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
    
    	// Adding keys to table local_projects.
    	$table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
    
    	// Conditionally launch create table for local_projects.
    	if (!$dbman->table_exists($table)) {
    		$dbman->create_table($table);
    	}
    
    	// Gim savepoint reached.
    	upgrade_plugin_savepoint(true, 2016051800, 'local', 'gim');
    }
    
    

    return true;
    
}