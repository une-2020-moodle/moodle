<?php  // $Id$
/**
 * Simple file test.php to drop into root of Moodle installation.
 * This is the skeleton code to print a downloadable, paged, sorted table of
 * data from a sql query.
 */
require "config.php";
require "$CFG->libdir/tablelib.php";
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/test.php');



$table = new table_sql('uniqueid');

$PAGE->set_title('Testing');
$PAGE->set_heading('Testing table class');
$PAGE->navbar->add('Testing table class', new moodle_url('/test.php'));
echo $OUTPUT->header();


// Work out the sql for the table.
$table->set_sql('*', "{user}", '1=1');

$table->define_baseurl("$CFG->wwwroot/test.php");

$table->out(40, true);

echo $OUTPUT->footer();

