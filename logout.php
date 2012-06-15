<? 
include_once("global/includes.php");
if(!session_is_registered(username)){
header("location:login.html");
}
session_destroy();
start_html();
print "Logout Successfully!";
?>
<p>
<a href="login.html">Return to the CT DATA Main Page.</a>
</p>
<?php
display_footer();
?>