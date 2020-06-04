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
 * Table to show the list of steps in a tour.
 *
 * @package    tool_usertours
 * @copyright  2016 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_usertours\local\table;

defined('MOODLE_INTERNAL') || die();

use tool_usertours\helper;
use tool_usertours\tour;
use tool_usertours\step;

require_once($CFG->libdir . '/tablelib.php');

/**
 * Table to show the list of steps in a tour.
 *
 * @copyright  2016 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class step_list extends \flexible_table {
    use \action_table_trait;

    /**
     * @var     int     $tourid     The id of the tour.
     */
    protected $tourid;

    /**
     * Construct the table for the specified tour ID.
     *
     * @param   int     $tourid     The id of the tour.
     */
    public function __construct($tourid) {
        parent::__construct('steps');
        $this->tourid = $tourid;

        $baseurl = new \moodle_url('/tool/usertours/configure.php', array(
                'id' => $tourid,
            ));
        $this->define_baseurl($baseurl);

        // Column definition.
        $this->define_columns(array(
            'title',
            'content',
            'target',
            'actions',
        ));

        $this->define_headers(array(
            get_string('title',   'tool_usertours'),
            get_string('content', 'tool_usertours'),
            get_string('target',  'tool_usertours'),
            get_string('actions', 'tool_usertours'),
        ));

        $this->set_attribute('class', 'admintable generaltable steptable');
        $this->setup();
    }

    /**
     * Format the current row's title column.
     *
     * @param   step    $step       The step for this row.
     * @return  string
     */
    protected function col_title(step $step) {
        global $OUTPUT;
        return $OUTPUT->render(helper::render_stepname_inplace_editable($step));
    }

    /**
     * Format the current row's content column.
     *
     * @param   step    $step       The step for this row.
     * @return  string
     */
    protected function col_content(step $step) {
        return format_text(step::get_string_from_input($step->get_content()), FORMAT_HTML);
    }

    /**
     * Format the current row's target column.
     *
     * @param   step    $step       The step for this row.
     * @return  string
     */
    protected function col_target(step $step) {
        return $step->get_target()->get_displayname();
    }

    /**
     * This function is called by the action_table_trait's col_actions
     * function to get an array of action_links.
     *      action_link(url, text, component_action, attributes, icon)
     * 
     * @param  object $row
     * @return array  An array of action_links.
     */
    public function get_table_actions($row) {
//        $deleteurl = new \moodle_url('/user/profile.php');
//        $deleteurl->params(['id' => $row->id,'foo' => 'bar']);
        $actions = [];

        if (!$row->is_first_step()) {
            $actions[] = new \action_link(
                $row->get_moveup_link(),
                null,
                null,
                null,
                new \pix_icon('t/up',get_string('movestepup', 'tool_usertours'))
            );
        }

        if (!$row->is_last_step()) {
            $actions[] = new \action_link(
                $row->get_movedown_link(),
                null,
                null,
                null,
                new \pix_icon('t/down',get_string('movestepdown', 'tool_usertours'))
            );
        }

        $actions[] = new \action_link(
            $row->get_edit_link(),
            null,
            null,
            null,
            new \pix_icon('t/edit', get_string('edit'))
        );

        $deleteurl = new \moodle_url('/user/profile.php');
        $deleteurl->params(['id' => $row->get_id(),'foo' => 'bar']);

        $actions[] = new \action_link(
            $deleteurl,
            null,
            new \confirm_action(get_string('areyousure')),
            null,
            new \pix_icon('t/delete', get_string('delete'), 'moodle')
        );

/*        
        $actions[] = helper::format_icon_link($step->get_delete_link(), 't/delete', get_string('delete'), 'moodle', [
            'data-action'   => 'delete',
            'data-id'       => $step->get_id(),
        ]);
*/
        return $actions;
    }
}
