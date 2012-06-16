<?php
include_once("global/includes.php");
if ($user->loggedIn($database)) {
  header("Location: main.php");
}
start_html($user, $database, "UCMC Radiation Oncology QA", "", $_REQUEST['status']);
?>
<div class="hero-unit">
  <h1>Welcome!</h1>
  <p>This is the QA tracking system for the University of Chicago Medical Center's Radiation Oncology department.</p>
  <p>
    <a href="/register.php" class="btn btn-primary btn-large">
      Sign up
    </a>
  </p>
</div>
<?php
display_footer();
?>