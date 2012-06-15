<?php
include_once("global/includes.php");
if(!isset($_SESSION['username'])){
header("location:login.php");
}
session_destroy();
start_html();
print "Logout Successfully!";
?>
<p>
<a href="login.php">Return to the CT DATA Main Page.</a>
</p>
<?php
display_footer();
?>