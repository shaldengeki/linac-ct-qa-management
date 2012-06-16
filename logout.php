<?php
include_once("global/includes.php");
if (!$user->loggedIn($database)) {
header("location:index.php");
}
session_destroy();
start_html($user, $database, "UCMC Radiation Oncology QA", "", $_REQUEST['status']);
print "Logout Successfully!";
?>
<p>
<a href="login.php">Return to the CT DATA Main Page.</a>
</p>
<?php
display_footer();
?>