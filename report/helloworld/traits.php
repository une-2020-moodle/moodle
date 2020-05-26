<?php

/* traits class */


trait tableTrait {

    public function traitFunc($name) {
        echo "Function called from trait for: " . $name;
    }

    /**
     * This function is called for each data row to allow processing of the
     * actions value.
     *
     * @param  object $row
     * @return $string $OUTPUT of the action link created.
     */
    public function col_actions($row) {
        global $OUTPUT;

        $linkarray = $this->table_actions($row);
        $html = '';

        foreach ($linkarray as $link) {
            $html .= $OUTPUT->render($link);
            $html .= '</br>';
          } 

          return $html;
    }

    /**
     * This function is called by the col_actions function to build the
     * action_links.
     *
     * @param  string     $urlact  - An action to perform, e.g. confirm_action
     * @param  moodle_url $linkurl - The url to use in the link
     * @param  string     $urlname - The name too be used for the link
     * @param  string     $pixicon - The icon to be used for the link
     * 
     * @return $action_link - The action link created.
     */
    public function build_actionlink($action,$linkurl,$urlname,$pixicon) {
        global $OUTPUT;

        $pix = '';

        if( !empty ( $pixicon ) ) {
            $pix = new \pix_icon($pixicon,get_string('stopsyncingcohort', 'tool_lp'));
        }
        $link = '';
        $link = $OUTPUT->action_link($linkurl, $urlname, $action, null, $pix); 
        return $link;
    }

}


