<?php
include_once("global/includes.php");
if (!$user->loggedIn($database)) {
header("location:index.php");
}
start_html($user, $database, "UCMC Radiation Oncology QA", "", $_REQUEST['status']);
?>
<div id="container" style="width: 800px; height: 400px; margin: 0 auto"></div>
<?php
display_footer();
?>