<?php
include_once("global/includes.php");
if (!$user->loggedIn($database)) {
  header("Location: index.php");
}
start_html($database, $user, "UCMC Radiation Oncology QA", "", $_REQUEST['status']);
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
    <li><s>CT image upload</s></li>
    <li><s>Backups</s></li>
    <li><s>Revise forms for TrueBeam</s></li>
    <li><s>Enter TrueBeam2 data</s></li>
    <li><s>Review TrueBeam2 data</s></li>
    <li><s>Enter TrueBeam1 data</s></li>
    <li>Review TrueBeam1 data</li>
    <li><s>User creation and modification</s></li>
    <li>Large-graph view</li>
    <li>Imaging fields</li>
    <li><s>Entry approval/review</s></li>
    <li>Red input boxes</li>
    <li>Python image analysis</li>
    <li>Print to PDF</li>
  </ol>
</div>
<?php
display_footer();
?>