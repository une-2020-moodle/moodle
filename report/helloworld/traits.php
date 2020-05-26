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
}


