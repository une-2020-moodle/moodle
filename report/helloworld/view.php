<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
 
/**
 * @package   helloworld
 * @copyright 2020, Matt Tolmie <mtolmie2@myune.edu.au>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->libdir . '/tablelib.php');
require_once('une_table.php');

$PAGE->set_url('/report/helloworld/view.php');
$PAGE->set_context(context_system::instance());

// Dummy function to test calling from HTML table row
function testAction($x) {
    return "this works for: " . $x[0];
}

/**
     * Creates and returns an action link.
     * @param $path The url for the link.
     * @param $title The displayed text for the link.
     * @return action_link using the defined text and url.
     */
function make_actionlink($path,$title) {
    return new action_link(new moodle_url($path),$title);
}

// Defining custom une_table
$download = optional_param('download', '', PARAM_ALPHA);

$helloworld_unetable = new une_table('uniqueid');
$helloworld_unetable->is_downloading($download, 'test', 'testing123');

/*
 * NEED TO REVISIT WHEN PAGE IS SIMPLIFIED (REMOVE OTHER TABLES AND ETC)
 * 
if (!$helloworld_unetable->is_downloading()) {
    // Only print headers if not asked to download data.
    // Print the page header.
    $PAGE->set_title('Testing');
    $PAGE->set_heading('Testing table class');
    $PAGE->navbar->add('Testing table class', new moodle_url('/report/helloworld/view.php'));
    echo $OUTPUT->header();
}
*/

// Work out the sql for the table.
$helloworld_unetable->set_sql('*', "{user}", '1=1');
$helloworld_unetable->define_baseurl("$CFG->wwwroot/report/helloworld/view.php");


// Defining rows used in HTML table
$row1 = array('Brendan','brendan@myemail.com','Active',$OUTPUT->render(make_actionlink('https://www.google.com.au','Goolge')),testAction('Brendan'));
$row2 = array('Kerrod','kerrod@myemail.com','Active',$OUTPUT->render(make_actionlink('https://www.une.edu.au','UNE')),testAction($row1));  
$row3 = array('Matt','matt@myemail.com','Active',$OUTPUT->render(make_actionlink('https://www.wikipedia.org','Wikipedia')),testAction("Matt"));

// Defining the HTML table
$helloworld_htmltable = new html_table();
$helloworld_htmltable->head = array('Name','Email','Status','Actions');
$helloworld_htmltable->data = array();
$helloworld_htmltable->data[] = new html_table_row($row1);
$helloworld_htmltable->data[] = new html_table_row($row2);
$helloworld_htmltable->data[] = new html_table_row($row3);


// Defining an SQL table
$helloworld_sqltable = new table_sql('helloworld_sqltable');
$helloworld_sqltable->set_sql('*', "{user}", '1=1');
$helloworld_sqltable->define_baseurl('/report/helloworld/view.php');


// Building the displayed page
// Header and title info
$PAGE->set_title(get_string('pagetitle','report_helloworld'));
$PAGE->set_heading(get_string('sayhello','report_helloworld', $USER->firstname));
echo $OUTPUT->header();


// Text heading and placement of custom une_table
echo $OUTPUT->box('MY CUSTOM TABLE:');
$helloworld_unetable->out(10, true);


// Text heading and placement of HTML table
echo $OUTPUT->box('MY HTML TABLE:');
echo html_writer::table($helloworld_htmltable);


// Text heading and placement of SQL table
echo $OUTPUT->box('MY SQL TABLE:');
$helloworld_sqltable->out(5,true);

// Add page footer
echo $OUTPUT->footer();

