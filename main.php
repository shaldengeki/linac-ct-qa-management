<?php
include_once("global/includes.php");
if (!$user->loggedIn($database)) {
  header("Location: index.php");
}
start_html($user, $database, "UCMC Radiation Oncology QA", "", $_REQUEST['status']);
?>
<div class="hero-unit">
  <h1>Welcome!</h1>
  <p>You are now logged in. Here's what I've got on my to-do list:</p>
  <ol>
    <li>Get form creation and structure working (creation of Linac, CT QA forms)</li>
    <li>Get form entry submission working (submission of Linac, CT QA specs)</li>
    <li>Create dashboard and form entry history view (view Linac, CT QA history)</li>
    <li>Get image upload working (analysis to come later when we've hammered out exactly what it is that needs to be done)</li>
  </ol>
</div>
<?php
display_footer();
?>