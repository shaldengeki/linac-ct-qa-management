<? 
include_once("global/includes.php");
if(!session_is_registered(username)){
header("location:login.html");
}
start_html();
?>
<div id="container" style="width: 800px; height: 400px; margin: 0 auto"></div>
<?php
display_footer();
?>