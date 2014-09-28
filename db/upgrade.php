<?php

// This file keeps track of upgrades to
// the certificate module
//
// Sometimes, changes between versions involve
// alterations to database structures and other
// major things that may break installations.
//
// The upgrade function in this file will attempt
// to perform all the necessary actions to upgrade
// your older installation to the current version.
//
// If there's something it cannot do itself, it
// will tell you what you need to do.
//
// The commands in here will all be database-neutral,
// using the functions defined in lib/ddllib.php

function xmldb_customcertificate_upgrade($oldversion=0) {

    global $CFG, $THEME, $DB;
    $dbman = $DB->get_manager();
    if ($oldversion < 2013053102) {
        
        $table = new xmldb_table('customcertificate');
        
        // Changing type of field certdatefmt on table customcertificate to char
        $field = new xmldb_field('certdatefmt', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null, 'certdate');
        
        // Launch change of type for field certdatefmt
        $dbman->change_field_type($table, $field);
        
        

        // customcertificate savepoint reached
        upgrade_mod_savepoint(true, 2013053102, 'customcertificate');

    }
    return true;
}
