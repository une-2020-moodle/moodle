<?php

/* traits class */


trait tableTrait {

    public function traitFunc($name) {
        echo "Function called from trait for: " . $name;
    }

    /**
     * This function is called by the col_actions function to build the
     * action_links.
     *
     * @param  string $urlact  - An action to perform, e.g. confirm_action
     * @param  string $url     - The url to use in the link
     * @param  string $params  - Any additional params for use in the link
     * @param  string $urlname - The name too be used for the link
     * @param  string $pixicon - The icon to be used for the link
     * @return $action_link    - The action link created.
     */
    public function build_actionlink($action,$basurl,$params,$urlname,$pixicon) {
        global $OUTPUT;

        $pix = '';

        $url = new moodle_url(url);

        if( !empty ( $params ) ) {
            // TODO - specify how params will be input
            $url->params(array('removecohort' => $row->id, 'sesskey' => sesskey())); 
        }

        if( !empty ( $pixicon ) ) {
            $pix = new \pix_icon($pixicon,get_string('stopsyncingcohort', 'tool_lp'));
        }
        $link = '';
        $link = $OUTPUT->action_link($url, $urlname, $action, null, $pix); 
        return $link;
    }

}


