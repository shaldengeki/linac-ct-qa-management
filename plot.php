<?php
include_once("global/includes.php");
if(!isset($_SESSION['username'])){
header("location:login.php");
}
start_html();
?>
<div id="container" style="width: 800px; height: 400px; margin: 0 auto"></div>
<?php
display_footer();
?>