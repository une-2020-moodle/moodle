<?php
/**
 * New table class to setup defining some customization to the activity 
 * column and proccess action_links.
 */
require_once('traits.php');

class une_table extends table_sql {
    use tableTrait;

    /**
     * Constructor
     * @param int $uniqueid all tables have to have a unique id, this is used
     *      as a key when storing table properties like sort order in the session.
     */
    function __construct($uniqueid) {
        parent::__construct($uniqueid);
        // Define the list of columns to show.
        $columns = array('firstname', 'email', 'status', 'actions', 'username', 'password');
        $this->define_columns($columns);

        // Define the titles of columns to show in header.
        $headers = array('First name', 'Email', 'Status', 'Actions', 'Username', 'Password');
        $this->define_headers($headers);
    }

    /**
     * This function is called for each data row to allow processing of the
     * username value.
     *
     * @param object $values Contains object with all the values of record.
     * @return $string Return username with link to profile or username only
     *     when downloading.
     */
    function col_username($values) {
        // If the data is being downloaded than we don't want to show HTML.
        if ($this->is_downloading()) {
            return $values->username;
        } else {
            return '<a href="/user/profile.php?id='.$values->id.'">'.$values->username.'</a>';
        }
    }

    /**
     * This function is called for each data row to allow processing of the
     * status value.
     *
     * @return $string Just returns "Active".
     */
    function col_status() {
        return 'Active';
    }

    /**
     * This function is called for each data row to allow processing of the
     * actions value.
     *
     * @param  object $row
     * @return $string $OUTPUT of the action link created.
     */
    function col_actions($row) {  
        return $this->build_arraylink(
            array(
                [new \confirm_action(get_string('areyousure')),
                '$this->baseurl',
                "params(array('removecohort' => $row->id,'sesskey' => sesskey()))",
                'Delete',
                't/delete',
                $row]
                ,
                [null,
                '/user/profile.php',
                null,
                'Profile',
                't/groupn',
                $row]
            )
        );

/*        global $OUTPUT;

        $html = '';

        $action = new \confirm_action(get_string('areyousure'));
        $url = new moodle_url($this->baseurl);
        $url->params(array('removecohort' => $row->id, 'sesskey' => sesskey()));
        $html .= $OUTPUT->action_link($url, 'Delete', $action, null, new \pix_icon('t/delete',
            get_string('stopsyncingcohort', 'tool_lp')));

        $html .= '</br>';
        $url = new moodle_url('/user/profile.php');
        $url->params(array('id' => $row->id));
        $html .= $OUTPUT->action_link($url, 'Profile', null, null, new \pix_icon('t/groupn',
            get_string('stopsyncingcohort', 'tool_lp')));
        
        // would we still be returning a string to render here or action links?
        return $html;
*/    
    }

    /**
     * This function is called for each data row to allow processing of
     * columns which do not have a *_cols function.
     * @return string return processed value. Return NULL if no change has
     *     been made.
     */
    function other_cols($colname, $value) {
        // For security reasons we don't want to show the password hash.
        if ($colname == 'password') {
            return "****";
        }
    }
}
