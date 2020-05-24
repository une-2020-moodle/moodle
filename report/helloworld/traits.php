<?php

/* traits class */


trait tableTrait {

    public function traitFunc($name) {
        echo "Function called from trait for: " . $name;
    }

    /**
     * This function is called by the col_actions function to build the
     * action_links from an array of defined link parameters.
     *
     * @param  string $linkarray - An array of the definitions of links.
     * @return $action_links     - A string of all the action links created.
     */
    public function build_arraylink($linkarray) {

        $html = '';

        foreach ($linkarray as $links) {
            $html .= $this->build_actionlink($links[0],$links[1],$links[2],$links[3],$links[4],$links[5]);
            $html .= '</br>';
          } 

          return $html;
    }

    /**
     * This function is called by the col_actions function to build the
     * action_links.
     *
     * @param  string $urlact  - An action to perform, e.g. confirm_action
     * @param  string $basurl  - The url to use in the link
     * @param  string $params  - Any additional params for use in the link
     * @param  string $urlname - The name too be used for the link
     * @param  string $pixicon - The icon to be used for the link
     * @return $action_link    - The action link created.
     */
    public function build_actionlink($action,$basurl,$params,$urlname,$pixicon,$row) {
        global $OUTPUT;

        $pix = '';

        $url = new moodle_url($basurl);

        if( !empty ( $params ) ) {
            // TODO - specify how params will be input
        }

        if( !empty ( $pixicon ) ) {
            $pix = new \pix_icon($pixicon,get_string('stopsyncingcohort', 'tool_lp'));
        }
        $link = '';
        $link = $OUTPUT->action_link($url, $urlname, $action, null, $pix); 
        return $link;
    }

}


