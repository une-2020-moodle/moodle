<?php
/* This is just a test class for understanding traits */

require_once 'traits.php';

class traitTest {
    use tableTrait;
    

}

$traitVar = new traitTest();
$traitVar->traitFunc("test");

