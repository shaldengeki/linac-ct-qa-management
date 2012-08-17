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
    <li><s>Background infrastructure</s></li>
    <li><s>Linac form entry submission</s></li>
    <li><s>Linac form entry history</s></li>
    <li><s>Linac image upload</s></li>
    <li><s>CT form entry submission</s></li>
    <li><s>CT form entry history</s></li>
    <li>CT image upload</li>
    <li><s>Backups</s></li>
    <li><s>Revise forms for TrueBeam</s></li>
    <li><s>Enter TrueBeam data</s></li>
    <li>Large-graph view</li>
  </ol>
</div>
<?php
display_footer();
?>