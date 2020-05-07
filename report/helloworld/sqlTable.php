//require "config.php";
require "$CFG->libdir/tablelib.php";
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/test.php');


// Work out the sql for the table.
$table->set_sql('*', "{user}", '1=1');

$table->define_baseurl("$CFG->wwwroot/test.php");

$table->out(40, true);

if (!$table->is_downloading()) {
    echo $OUTPUT->footer();
}
