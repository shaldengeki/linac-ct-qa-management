<?php
include_once("global/includes.php");
if (!$user->loggedIn()) {
  print_r($user);
  exit;
  header("Location: index.php");
}
start_html($database, $user, "UC Medicine QA", "", $_REQUEST['status'], $_REQUEST['class']);

?>
<div class="row-fluid">
  <div class="span4">
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
      <li><s>Review TrueBeam1 data</s></li>
      <li><s>User creation and modification</s></li>
      <li>Large-graph view</li>
      <li><s>Imaging fields</s></li>
      <li><s>Entry approval/review</s></li>
      <li><s>Change backups to zip</s></li>
      <li><s>User password changes</s></li>
      <li><s>Red input boxes</s></li>
      <li><s>Save form button</s></li>
      <li><s>Restructure machines to account for machine-specific parameters</s></li>
      <li><s>Linac Monthly form tabs</s></li>
      <li><s>Allow admins to reassign form entries</s></li>
      <li>Print to PDF</li>
      <li>Form entry pass/fail</li>
      <li>Domain name change (ucqa.org)</li>
      <li>Python image analysis</li>
      <li>Make forms more user-friendly</li>
    </ol>
  </div>
  <div class="span4">
    <div class="row-fluid">
      <h2>Notifications</h2>
<?php
  /* TODO: entries here for out-of-bounds values, upcoming and passed QA deadlines */
  echo "Coming soon!";
?>
    </div>
    <div class="row-fluid">
      <h2>Entries needing approval</h2>
<?php
// get a list of all form entries that have not been approved for machines within this user's facility.
$entriesNeedingApproval = $database->stdQuery("SELECT `machines`.`name` AS `machine_name`, `form_entries`.`id`, `form_entries`.`qa_month`, `form_entries`.`qa_year` FROM `form_entries` LEFT OUTER JOIN `machines` ON `machines`.`id` = `form_entries`.`machine_id` WHERE (`approved_on` IS NULL && `machines`.`facility_id` = ".intval($user->facility_id).") ORDER BY `qa_year` ASC, `qa_month` ASC LIMIT 10");
if (!$entriesNeedingApproval) {
  echo "None!";
} else {
  echo "<ul>
";
  while ($entry = mysqli_fetch_assoc($entriesNeedingApproval)) {
    if ($entry['machine_name'] == '') {
      $entry['machine_name'] = "Unknown machine";
    }
    echo "<li><a href='form_entry.php?action=edit&id=".intval($entry['id'])."'>".escape_output($entry['machine_name'])." for ".escape_output(intval($entry['qa_month'])."/".intval($entry['qa_year']))."</a></li>
";
  }

}
?>
    </div>
  </div>
  <div class="span4">
    <div class="row-fluid">
      <h2>Latest updates</h2>
<?php
// get a list of all form entries for machines within this user's facility.
$entries = $database->stdQuery("SELECT `machines`.`name` AS `machine_name`, `form_entries`.`id`, `form_entries`.`qa_month`, `form_entries`.`qa_year`, `form_entries`.`approved_on` FROM `form_entries` LEFT OUTER JOIN `machines` ON `machines`.`id` = `form_entries`.`machine_id` WHERE `machines`.`facility_id` = ".intval($user->facility_id)." ORDER BY `form_entries`.`updated_at` DESC LIMIT 20");
if (!$entries) {
  echo "None!";
} else {
  echo "<ul>
";
  while ($entry = mysqli_fetch_assoc($entries)) {
    if ($entry['machine_name'] == '') {
      $entry['machine_name'] = "Unknown machine";
    }
    echo "<li><a href='form_entry.php?action=edit&id=".intval($entry['id'])."'>".escape_output($entry['machine_name'])." for ".escape_output(intval($entry['qa_month'])."/".intval($entry['qa_year'])).(($entry['approved_on'] != '') ? "(approved)" : "")."</a></li>
";
  }

}
?>
    </div>
  </div>
</div>
<?php
display_footer();
?>