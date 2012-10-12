<?php
  // displays a form to edit form parameters.
  echo "<form name='linac-monthly' id='linac-monthly' action='form_entry.php' method='POST' class='form-horizontal' enctype='multipart/form-data'>
  <fieldset>\n".(($id === false) ? "" : "<input type='hidden' name='form_entry[id]' value='".intval($id)."' />");
  if (isset($_REQUEST['form_id'])) {
    echo "<input type='hidden' name='form_entry[form_id]' value='".intval($_REQUEST['form_id'])."' />\n";
  } elseif ($id != false) {
    echo "<input type='hidden' name='form_entry[form_id]' value='".intval($formEntry->form['id'])."' />\n";
  }
  echo "
<div class='row-fluid'>
  <div class='span6'>
    <div class='control-group'>
        <label class='control-label' for='form_entry[machine_id]'>Machine</label>
        <div class='controls'>\n";
  display_machine_dropdown($user, "form_entry[machine_id]", (($id === false) ? 0 : intval($formEntry->machine['id'])), intval($form->machineType['id']));
  echo "        </div>
      </div>
      <div class='control-group'>\n";
  if ($user->isAdmin()) {
    echo "        <label class='control-label' for='form_entry[machine_id]'>Performed by</label>
        <div class='controls'>\n";
  display_user_dropdown($user, "form_entry[user_id]", (($id === false) ? $user->id : intval($formEntry->user['id'])));
    echo "        </div>\n";
  } else {
    echo "<input type='hidden' name='form_entry[user_id]' value='".(($id === false) ? intval($user->id) : intval($formEntry->user['id']))."' />\n";
  }
  echo "      </div>
    </div>
    <div class='span6'>
      <div class='control-group'>
        <label class='control-label' for='form_entry[qa_month]'>QA Month</label>
        <div class='controls'>\n";
  display_month_year_dropdown("form_entry[qa_month]", "form_entry", (($id === false) ? False : array(intval($formEntry->qaMonth),intval($formEntry->qaYear))));
  echo "
        </div>
      </div>
      <div class='control-group'>
        <label class='control-label' for='form_entry[created_at]'>Inspection Date</label>
        <div class='controls'>
          <input name='form_entry[created_at]' type='datetime-local' readonly='true' class='input-xlarge enabled' id='form_entry_created_at'".(($id === false) ? "" : " value='".escape_output($formEntry->createdAt)."'").">
        </div>
      </div>
    </div>
  </div>
    <div class='row-fluid'>
      <div class='span6'>
        <h3>Measurement parameters</h3>
        <div class='control-group'>
          <label class='control-label' for='form_entry[form_values][temperature]'>Temperature (&deg;C)</label>
          <div class='controls'>
            <input name='form_entry[form_values][temperature]' type='number' step='0.0000000000000001' step='0.1' class='input-xlarge' id='form_entry_form_values_temperature'".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['temperature']->value)."'").">
          </div>
        </div>
        <div class='control-group'>
          <label class='control-label' for='form_entry[form_values][pressure]'>Pressure (mmHg)</label>
          <div class='controls'>
            <input name='form_entry[form_values][pressure]' type='number' step='0.0000000000000001' step='0.1' class='input-xlarge' id='form_entry_form_values_pressure'".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['pressure']->value)."'").">
          </div>
        </div>
        <div class='control-group'>
          <label class='control-label' for='form_entry[form_values][tpcf]'>TPCF</label>
          <div class='controls'>
            <input name='form_entry[form_values][tpcf]' type='number' step='0.0000000000000001' step='0.0000000000000001' class='input-xlarge' id='form_entry_form_values_tpcf'".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpcf']->value)."'").">
          </div>
        </div>
      </div>
      <div class='span6'>
        <h3>Equipment</h3>
        <div class='control-group'>
          <label class='control-label' for='form_entry[form_values][ionization_chamber]'>Ionization Chamber</label>
          <div class='controls'>
    ";
      display_ionization_chamber_dropdown("form_entry_form_values_ionization_chamber", "form_entry[form_values]", (($id === false) ? "" : escape_output($formEntry->formValues['ionization_chamber']->value)));
      echo "      </div>
        </div>
        <div class='control-group'>
          <label class='control-label' for='form_entry[form_values][electrometer]'>Electrometer</label>
          <div class='controls'>
    ";
      display_electrometer_dropdown("form_entry_form_values_electrometer", "form_entry[form_values]", (($id === false) ? "" : escape_output($formEntry->formValues['electrometer']->value)));
      echo "      </div>
        </div>
      </div>
    </div>
    <div class='tabbable'>
      <ul class='nav nav-tabs'>
        <li class='active'><a href='#tab-dosimetry' data-toggle='tab'>Dosimetry</a></li>
        <li><a href='#tab-mechanical' data-toggle='tab'>Mechanical</a></li>
        <li><a href='#tab-imaging' data-toggle='tab'>Imaging</a></li>
      </ul>
      <div class='tab-content'>
        <div class='tab-pane active' id='tab-dosimetry'>
      <h1>Photon Dosimetry</h1>
      <div class='row-fluid'>
        <div class='span6'>
          <h3 class='center-horizontal'>Output Calibration</h3>
          <table class='table table-bordered table-striped'>
            <thead>
              <tr>
                <th>Photon Energy</th>
                <th>6MV</th>
                <th>10MV</th>
                <th>15MV</th>
                <th>18MV</th>
                <th>6XFFF</th>
                <th>10XFFF</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Q<sub>1</sub></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_6MV_q1]' class='form_entry_form_values_photon_output_calibration_6MV span12' id='form_entry_form_values_photon_output_calibration_6MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_6MV_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_10MV_q1]' class='form_entry_form_values_photon_output_calibration_10MV span12' id='form_entry_form_values_photon_output_calibration_10MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_10MV_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_15MV_q1]' class='form_entry_form_values_photon_output_calibration_15MV span12' id='form_entry_form_values_photon_output_calibration_15MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_15MV_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_18MV_q1]' class='form_entry_form_values_photon_output_calibration_18MV span12' id='form_entry_form_values_photon_output_calibration_18MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_18MV_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_6XFFF_q1]' class='form_entry_form_values_photon_output_calibration_6XFFF span12' id='form_entry_form_values_photon_output_calibration_6XFFF_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_6XFFF_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_10XFFF_q1]' class='form_entry_form_values_photon_output_calibration_10XFFF span12' id='form_entry_form_values_photon_output_calibration_10XFFF_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_10XFFF_q1']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Q<sub>2</sub></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_6MV_q2]' class='form_entry_form_values_photon_output_calibration_6MV span12' id='form_entry_form_values_photon_output_calibration_6MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_6MV_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_10MV_q2]' class='form_entry_form_values_photon_output_calibration_10MV span12' id='form_entry_form_values_photon_output_calibration_10MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_10MV_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_15MV_q2]' class='form_entry_form_values_photon_output_calibration_15MV span12' id='form_entry_form_values_photon_output_calibration_15MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_15MV_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_18MV_q2]' class='form_entry_form_values_photon_output_calibration_18MV span12' id='form_entry_form_values_photon_output_calibration_18MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_18MV_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_6XFFF_q2]' class='form_entry_form_values_photon_output_calibration_6XFFF span12' id='form_entry_form_values_photon_output_calibration_6XFFF_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_6XFFF_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_10XFFF_q2]' class='form_entry_form_values_photon_output_calibration_10XFFF span12' id='form_entry_form_values_photon_output_calibration_10XFFF_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_10XFFF_q2']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Q<sub>3</sub></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_6MV_q3]' class='form_entry_form_values_photon_output_calibration_6MV span12' id='form_entry_form_values_photon_output_calibration_6MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_6MV_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_10MV_q3]' class='form_entry_form_values_photon_output_calibration_10MV span12' id='form_entry_form_values_photon_output_calibration_10MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_10MV_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_15MV_q3]' class='form_entry_form_values_photon_output_calibration_15MV span12' id='form_entry_form_values_photon_output_calibration_15MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_15MV_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_18MV_q3]' class='form_entry_form_values_photon_output_calibration_18MV span12' id='form_entry_form_values_photon_output_calibration_18MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_18MV_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_6XFFF_q3]' class='form_entry_form_values_photon_output_calibration_6XFFF span12' id='form_entry_form_values_photon_output_calibration_6XFFF_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_6XFFF_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_10XFFF_q3]' class='form_entry_form_values_photon_output_calibration_10XFFF span12' id='form_entry_form_values_photon_output_calibration_10XFFF_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_10XFFF_q3']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Avg</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_6MV_avg]' class='span12' id='form_entry_form_values_photon_output_calibration_6MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_6MV_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_10MV_avg]' class='span12' id='form_entry_form_values_photon_output_calibration_10MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_10MV_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_15MV_avg]' class='span12' id='form_entry_form_values_photon_output_calibration_15MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_15MV_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_18MV_avg]' class='span12' id='form_entry_form_values_photon_output_calibration_18MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_18MV_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_6XFFF_avg]' class='span12' id='form_entry_form_values_photon_output_calibration_6XFFF_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_6XFFF_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_10XFFF_avg]' class='span12' id='form_entry_form_values_photon_output_calibration_10XFFF_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_10XFFF_avg']->value)."'")."/></td>
              </tr>
              <tr>
                <td>M</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_6MV_M]' class='span12' id='form_entry_form_values_photon_output_calibration_6MV_M' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_6MV_M']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_10MV_M]' class='span12' id='form_entry_form_values_photon_output_calibration_10MV_M' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_10MV_M']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_15MV_M]' class='span12' id='form_entry_form_values_photon_output_calibration_15MV_M' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_15MV_M']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_18MV_M]' class='span12' id='form_entry_form_values_photon_output_calibration_18MV_M' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_18MV_M']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_6XFFF_M]' class='span12' id='form_entry_form_values_photon_output_calibration_6XFFF_M' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_6XFFF_M']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_10XFFF_M]' class='span12' id='form_entry_form_values_photon_output_calibration_10XFFF_M' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_10XFFF_M']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Dw</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_6MV_Dw]' class='span12' id='form_entry_form_values_photon_output_calibration_6MV_Dw' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_6MV_Dw']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_10MV_Dw]' class='span12' id='form_entry_form_values_photon_output_calibration_10MV_Dw' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_10MV_Dw']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_15MV_Dw]' class='span12' id='form_entry_form_values_photon_output_calibration_15MV_Dw' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_15MV_Dw']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_18MV_Dw]' class='span12' id='form_entry_form_values_photon_output_calibration_18MV_Dw' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_18MV_Dw']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_6XFFF_Dw]' class='span12' id='form_entry_form_values_photon_output_calibration_6XFFF_Dw' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_6XFFF_Dw']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_10XFFF_Dw]' class='span12' id='form_entry_form_values_photon_output_calibration_10XFFF_Dw' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_10XFFF_Dw']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Dw(abs)</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_constants][photon_output_calibration_6MV_Dw_abs]' class='span12' id='form_entry_form_values_photon_output_calibration_6MV_Dw_abs' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_6MV_Dw_abs']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_constants][photon_output_calibration_10MV_Dw_abs]' class='span12' id='form_entry_form_values_photon_output_calibration_10MV_Dw_abs' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_10MV_Dw_abs']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_constants][photon_output_calibration_15MV_Dw_abs]' class='span12' id='form_entry_form_values_photon_output_calibration_15MV_Dw_abs' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_15MV_Dw_abs']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_constants][photon_output_calibration_18MV_Dw_abs]' class='span12' id='form_entry_form_values_photon_output_calibration_18MV_Dw_abs' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_18MV_Dw_abs']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_constants][photon_output_calibration_6XFFF_Dw_abs]' class='span12' id='form_entry_form_values_photon_output_calibration_6XFFF_Dw_abs' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_6XFFF_Dw_abs']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_constants][photon_output_calibration_10XFFF_Dw_abs]' class='span12' id='form_entry_form_values_photon_output_calibration_10XFFF_Dw_abs' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_10XFFF_Dw_abs']->value)."'")."/></td>
              </tr>
              <tr>
                <td>%diff</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0001' name='form_entry[form_values][photon_output_calibration_6MV_diff]' class='span12 form_entry_form_values_photon_output_calibration_diff' id='form_entry_form_values_photon_output_calibration_6MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_6MV_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0001' name='form_entry[form_values][photon_output_calibration_10MV_diff]' class='span12 form_entry_form_values_photon_output_calibration_diff' id='form_entry_form_values_photon_output_calibration_10MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_10MV_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0001' name='form_entry[form_values][photon_output_calibration_15MV_diff]' class='span12 form_entry_form_values_photon_output_calibration_diff' id='form_entry_form_values_photon_output_calibration_15MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_15MV_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0001' name='form_entry[form_values][photon_output_calibration_18MV_diff]' class='span12 form_entry_form_values_photon_output_calibration_diff' id='form_entry_form_values_photon_output_calibration_18MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_18MV_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0001' name='form_entry[form_values][photon_output_calibration_6XFFF_diff]' class='span12 form_entry_form_values_photon_output_calibration_diff' id='form_entry_form_values_photon_output_calibration_6XFFF_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_6XFFF_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0001' name='form_entry[form_values][photon_output_calibration_10XFFF_diff]' class='span12 form_entry_form_values_photon_output_calibration_diff' id='form_entry_form_values_photon_output_calibration_10XFFF_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_10XFFF_diff']->value)."'")."/></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class='span6'>
          <h3 class='center-horizontal'>TPR Check</h3>
          <table class='table table-bordered table-striped'>
            <thead>
              <tr>
                <th>Photon Energy</th>
                <th>6MV</th>
                <th>10MV</th>
                <th>15MV</th>
                <th>18MV</th>
                <th>6XFFF</th>
                <th>10XFFF</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Q<sub>1</sub></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_6MV_q1]' class='form_entry_form_values_tpr_6MV span12' id='form_entry_form_values_tpr_6MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_6MV_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_10MV_q1]' class='form_entry_form_values_tpr_10MV span12' id='form_entry_form_values_tpr_10MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_10MV_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_15MV_q1]' class='form_entry_form_values_tpr_15MV span12' id='form_entry_form_values_tpr_15MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_15MV_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_18MV_q1]' class='form_entry_form_values_tpr_18MV span12' id='form_entry_form_values_tpr_18MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_18MV_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_6XFFF_q1]' class='form_entry_form_values_tpr_6XFFF span12' id='form_entry_form_values_tpr_6XFFF_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_6XFFF_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_10XFFF_q1]' class='form_entry_form_values_tpr_10XFFF span12' id='form_entry_form_values_tpr_10XFFF_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_10XFFF_q1']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Q<sub>2</sub></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_6MV_q2]' class='form_entry_form_values_tpr_6MV span12' id='form_entry_form_values_tpr_6MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_6MV_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_10MV_q2]' class='form_entry_form_values_tpr_10MV span12' id='form_entry_form_values_tpr_10MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_10MV_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_15MV_q2]' class='form_entry_form_values_tpr_15MV span12' id='form_entry_form_values_tpr_15MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_15MV_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_18MV_q2]' class='form_entry_form_values_tpr_18MV span12' id='form_entry_form_values_tpr_18MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_18MV_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_6XFFF_q2]' class='form_entry_form_values_tpr_6XFFF span12' id='form_entry_form_values_tpr_6XFFF_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_6XFFF_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_10XFFF_q2]' class='form_entry_form_values_tpr_10XFFF span12' id='form_entry_form_values_tpr_10XFFF_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_10XFFF_q2']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Q<sub>3</sub></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_6MV_q3]' class='form_entry_form_values_tpr_6MV span12' id='form_entry_form_values_tpr_6MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_6MV_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_10MV_q3]' class='form_entry_form_values_tpr_10MV span12' id='form_entry_form_values_tpr_10MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_10MV_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_15MV_q3]' class='form_entry_form_values_tpr_15MV span12' id='form_entry_form_values_tpr_15MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_15MV_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_18MV_q3]' class='form_entry_form_values_tpr_18MV span12' id='form_entry_form_values_tpr_18MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_18MV_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_6XFFF_q3]' class='form_entry_form_values_tpr_6XFFF span12' id='form_entry_form_values_tpr_6XFFF_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_6XFFF_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_10XFFF_q3]' class='form_entry_form_values_tpr_10XFFF span12' id='form_entry_form_values_tpr_10XFFF_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_10XFFF_q3']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Avg</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][tpr_6MV_avg]' class='span12' id='form_entry_form_values_tpr_6MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_6MV_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][tpr_10MV_avg]' class='span12' id='form_entry_form_values_tpr_10MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_10MV_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][tpr_15MV_avg]' class='span12' id='form_entry_form_values_tpr_15MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_15MV_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][tpr_18MV_avg]' class='span12' id='form_entry_form_values_tpr_18MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_18MV_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][tpr_6XFFF_avg]' class='span12' id='form_entry_form_values_tpr_6XFFF_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_6XFFF_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][tpr_10XFFF_avg]' class='span12' id='form_entry_form_values_tpr_10XFFF_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_10XFFF_avg']->value)."'")."/></td>
              </tr>
              <tr>
                <td>TPR</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][tpr_6MV_tpr]' class='span12' id='form_entry_form_values_tpr_6MV_TPR' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_6MV_tpr']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][tpr_10MV_tpr]' class='span12' id='form_entry_form_values_tpr_10MV_TPR' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_10MV_tpr']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][tpr_15MV_tpr]' class='span12' id='form_entry_form_values_tpr_15MV_TPR' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_15MV_tpr']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][tpr_18MV_tpr]' class='span12' id='form_entry_form_values_tpr_18MV_TPR' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_18MV_tpr']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][tpr_6XFFF_tpr]' class='span12' id='form_entry_form_values_tpr_6XFFF_TPR' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_6XFFF_tpr']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][tpr_10XFFF_tpr]' class='span12' id='form_entry_form_values_tpr_10XFFF_TPR' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_10XFFF_tpr']->value)."'")."/></td>
              </tr>
              <tr>
                <td>TPR(ref)</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[constants][tpr_6MV_TPR_abs]' class='span12' id='form_entry_form_values_tpr_6MV_TPR_abs' /></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[constants][tpr_10MV_TPR_abs]' class='span12' id='form_entry_form_values_tpr_10MV_TPR_abs' /></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[constants][tpr_15MV_TPR_abs]' class='span12' id='form_entry_form_values_tpr_15MV_TPR_abs' /></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[constants][tpr_18MV_TPR_abs]' class='span12' id='form_entry_form_values_tpr_18MV_TPR_abs' /></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[constants][tpr_6XFFF_TPR_abs]' class='span12' id='form_entry_form_values_tpr_6XFFF_TPR_abs' /></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[constants][tpr_10XFFF_TPR_abs]' class='span12' id='form_entry_form_values_tpr_10XFFF_TPR_abs' /></td>
              </tr>
              <tr>
                <td>%diff</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_6MV_diff]' class='span12' id='form_entry_form_values_tpr_6MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_6MV_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_10MV_diff]' class='span12' id='form_entry_form_values_tpr_10MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_10MV_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_15MV_diff]' class='span12' id='form_entry_form_values_tpr_15MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_15MV_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_18MV_diff]' class='span12' id='form_entry_form_values_tpr_18MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_18MV_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_6XFFF_diff]' class='span12' id='form_entry_form_values_tpr_6XFFF_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_6XFFF_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][tpr_10XFFF_diff]' class='span12' id='form_entry_form_values_tpr_10XFFF_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['tpr_10XFFF_diff']->value)."'")."/></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class='row-fluid'>
        <div class='span6' id='photon_output_calibration_adjustment' style='display:none;'>
          <h3 class='center-horizontal'>Adjusted Output Calibration</h3>
          <table class='table table-bordered table-striped'>
            <thead>
              <tr>
                <th>Photon Energy</th>
                <th>6MV</th>
                <th>10MV</th>
                <th>15MV</th>
                <th>18MV</th>
                <th>6XFFF</th>
                <th>10XFFF</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Q<sub>1</sub></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_adjusted_6MV_q1]' class='form_entry_form_values_photon_output_calibration_adjusted_6MV span12' id='form_entry_form_values_photon_output_calibration_adjusted_6MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_6MV_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_adjusted_10MV_q1]' class='form_entry_form_values_photon_output_calibration_adjusted_10MV span12' id='form_entry_form_values_photon_output_calibration_adjusted_10MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_10MV_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_adjusted_15MV_q1]' class='form_entry_form_values_photon_output_calibration_adjusted_15MV span12' id='form_entry_form_values_photon_output_calibration_adjusted_15MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_15MV_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_adjusted_18MV_q1]' class='form_entry_form_values_photon_output_calibration_adjusted_18MV span12' id='form_entry_form_values_photon_output_calibration_adjusted_18MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_18MV_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_adjusted_6XFFF_q1]' class='form_entry_form_values_photon_output_calibration_adjusted_6XFFF span12' id='form_entry_form_values_photon_output_calibration_adjusted_6XFFF_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_6XFFF_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_adjusted_10XFFF_q1]' class='form_entry_form_values_photon_output_calibration_adjusted_10XFFF span12' id='form_entry_form_values_photon_output_calibration_adjusted_10XFFF_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_10XFFF_q1']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Q<sub>2</sub></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_adjusted_6MV_q2]' class='form_entry_form_values_photon_output_calibration_adjusted_6MV span12' id='form_entry_form_values_photon_output_calibration_adjusted_6MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_6MV_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_adjusted_10MV_q2]' class='form_entry_form_values_photon_output_calibration_adjusted_10MV span12' id='form_entry_form_values_photon_output_calibration_adjusted_10MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_10MV_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_adjusted_15MV_q2]' class='form_entry_form_values_photon_output_calibration_adjusted_15MV span12' id='form_entry_form_values_photon_output_calibration_adjusted_15MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_15MV_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_adjusted_18MV_q2]' class='form_entry_form_values_photon_output_calibration_adjusted_18MV span12' id='form_entry_form_values_photon_output_calibration_adjusted_18MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_18MV_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_adjusted_6XFFF_q2]' class='form_entry_form_values_photon_output_calibration_adjusted_6XFFF span12' id='form_entry_form_values_photon_output_calibration_adjusted_6XFFF_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_6XFFF_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_adjusted_10XFFF_q2]' class='form_entry_form_values_photon_output_calibration_adjusted_10XFFF span12' id='form_entry_form_values_photon_output_calibration_adjusted_10XFFF_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_10XFFF_q2']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Q<sub>3</sub></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_adjusted_6MV_q3]' class='form_entry_form_values_photon_output_calibration_adjusted_6MV span12' id='form_entry_form_values_photon_output_calibration_adjusted_6MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_6MV_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_adjusted_10MV_q3]' class='form_entry_form_values_photon_output_calibration_adjusted_10MV span12' id='form_entry_form_values_photon_output_calibration_adjusted_10MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_10MV_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_adjusted_15MV_q3]' class='form_entry_form_values_photon_output_calibration_adjusted_15MV span12' id='form_entry_form_values_photon_output_calibration_adjusted_15MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_15MV_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_adjusted_18MV_q3]' class='form_entry_form_values_photon_output_calibration_adjusted_18MV span12' id='form_entry_form_values_photon_output_calibration_adjusted_18MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_18MV_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_adjusted_6XFFF_q3]' class='form_entry_form_values_photon_output_calibration_adjusted_6XFFF span12' id='form_entry_form_values_photon_output_calibration_adjusted_6XFFF_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_6XFFF_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.001' name='form_entry[form_values][photon_output_calibration_adjusted_10XFFF_q3]' class='form_entry_form_values_photon_output_calibration_adjusted_10XFFF span12' id='form_entry_form_values_photon_output_calibration_adjusted_10XFFF_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_10XFFF_q3']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Avg</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_6MV_avg]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_6MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_6MV_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_10MV_avg]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_10MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_10MV_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_15MV_avg]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_15MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_15MV_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_18MV_avg]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_18MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_18MV_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_6XFFF_avg]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_6XFFF_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_6XFFF_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_10XFFF_avg]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_10XFFF_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_10XFFF_avg']->value)."'")."/></td>
              </tr>
              <tr>
                <td>M</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_6MV_M]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_6MV_M' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_6MV_M']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_10MV_M]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_10MV_M' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_10MV_M']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_15MV_M]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_15MV_M' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_15MV_M']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_18MV_M]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_18MV_M' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_18MV_M']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_6XFFF_M]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_6XFFF_M' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_6XFFF_M']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_10XFFF_M]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_10XFFF_M' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_10XFFF_M']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Dw</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_6MV_Dw]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_6MV_Dw' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_6MV_Dw']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_10MV_Dw]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_10MV_Dw' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_10MV_Dw']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_15MV_Dw]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_15MV_Dw' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_15MV_Dw']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_18MV_Dw]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_18MV_Dw' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_18MV_Dw']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_6XFFF_Dw]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_6XFFF_Dw' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_6XFFF_Dw']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_10XFFF_Dw]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_10XFFF_Dw' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_10XFFF_Dw']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Dw(abs)</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_constants][photon_output_calibration_adjusted_6MV_Dw_abs]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_6MV_Dw_abs' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_6MV_Dw_abs']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_constants][photon_output_calibration_adjusted_10MV_Dw_abs]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_10MV_Dw_abs' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_10MV_Dw_abs']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_constants][photon_output_calibration_adjusted_15MV_Dw_abs]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_15MV_Dw_abs' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_15MV_Dw_abs']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_constants][photon_output_calibration_adjusted_18MV_Dw_abs]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_18MV_Dw_abs' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_18MV_Dw_abs']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_constants][photon_output_calibration_adjusted_6XFFF_Dw_abs]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_6XFFF_Dw_abs' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_6XFFF_Dw_abs']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_constants][photon_output_calibration_adjusted_10XFFF_Dw_abs]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_10XFFF_Dw_abs' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_10XFFF_Dw_abs']->value)."'")."/></td>
              </tr>
              <tr>
                <td>%diff</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_6MV_diff]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_6MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_6MV_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_10MV_diff]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_10MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_10MV_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_15MV_diff]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_15MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_15MV_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_18MV_diff]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_18MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_18MV_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_6XFFF_diff]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_6XFFF_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_6XFFF_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][photon_output_calibration_adjusted_10XFFF_diff]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_10XFFF_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['photon_output_calibration_adjusted_10XFFF_diff']->value)."'")."/></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class='span2'>
          <h3 class='center-horizontal'>Gating</h3>
          <table class='table table-bordered table-striped'>
            <thead>
              <tr>
                <th>Photon Energy</th>
                <th>6MV</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Q<sub>1</sub></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][gating_6MV_q1]' class='form_entry_form_values_gating_6MV span12' id='form_entry_form_values_gating_6MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['gating_6MV_q1']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Q<sub>2</sub></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][gating_6MV_q2]' class='form_entry_form_values_gating_6MV span12' id='form_entry_form_values_gating_6MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['gating_6MV_q2']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Q<sub>3</sub></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][gating_6MV_q3]' class='form_entry_form_values_gating_6MV span12' id='form_entry_form_values_gating_6MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['gating_6MV_q3']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Avg</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][gating_6MV_avg]' class='span12' id='form_entry_form_values_gating_6MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['gating_6MV_avg']->value)."'")."/></td>
              </tr>
              <tr>
                <td>TPR</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][gating_6MV_TPR]' class='span12' id='form_entry_form_values_gating_6MV_TPR' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['gating_6MV_TPR']->value)."'")."/></td>
              </tr>
              <tr>
                <td>TPR(ref)</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[constants][gating_6MV_TPR_abs]' class='span12' id='form_entry_form_values_gating_6MV_TPR_abs' /></td>
              </tr>
              <tr>
                <td>%diff</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][gating_6MV_diff]' class='span12' id='form_entry_form_values_gating_6MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['gating_6MV_diff']->value)."'")."/></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class='span4'>
          <h3 class='center-horizontal'>EDW</h3>
          <table class='table table-bordered table-striped'>
            <thead>
              <tr>
                <th>Photon Energy</th>
                <th>6MV</th>
                <th>10MV</th>
                <th>15MV</th>
                <th>18MV</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Q<sub>1</sub></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_6MV_q1]' class='form_entry_form_values_edw_6MV span12' id='form_entry_form_values_edw_6MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_6MV_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_10MV_q1]' class='form_entry_form_values_edw_10MV span12' id='form_entry_form_values_edw_10MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_10MV_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_15MV_q1]' class='form_entry_form_values_edw_15MV span12' id='form_entry_form_values_edw_15MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_15MV_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_18MV_q1]' class='form_entry_form_values_edw_18MV span12' id='form_entry_form_values_edw_18MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_18MV_q1']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Q<sub>2</sub></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_6MV_q2]' class='form_entry_form_values_edw_6MV span12' id='form_entry_form_values_edw_6MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_6MV_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_10MV_q2]' class='form_entry_form_values_edw_10MV span12' id='form_entry_form_values_edw_10MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_10MV_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_15MV_q2]' class='form_entry_form_values_edw_15MV span12' id='form_entry_form_values_edw_15MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_15MV_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_18MV_q2]' class='form_entry_form_values_edw_18MV span12' id='form_entry_form_values_edw_18MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_18MV_q2']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Q<sub>3</sub></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_6MV_q3]' class='form_entry_form_values_edw_6MV span12' id='form_entry_form_values_edw_6MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_6MV_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_10MV_q3]' class='form_entry_form_values_edw_10MV span12' id='form_entry_form_values_edw_10MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_10MV_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_15MV_q3]' class='form_entry_form_values_edw_15MV span12' id='form_entry_form_values_edw_15MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_15MV_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_18MV_q3]' class='form_entry_form_values_edw_18MV span12' id='form_entry_form_values_edw_18MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_18MV_q3']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Avg</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_6MV_avg]' class='span12' id='form_entry_form_values_edw_6MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_6MV_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_10MV_avg]' class='span12' id='form_entry_form_values_edw_10MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_10MV_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_15MV_avg]' class='span12' id='form_entry_form_values_edw_15MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_15MV_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_18MV_avg]' class='span12' id='form_entry_form_values_edw_18MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_18MV_avg']->value)."'")."/></td>
              </tr>
              <tr>
                <td>WF</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_6MV_WF]' class='span12' id='form_entry_form_values_edw_6MV_WF' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_6MV_WF']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_10MV_WF]' class='span12' id='form_entry_form_values_edw_10MV_WF' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_10MV_WF']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_15MV_WF]' class='span12' id='form_entry_form_values_edw_15MV_WF' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_15MV_WF']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_18MV_WF]' class='span12' id='form_entry_form_values_edw_18MV_WF' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_18MV_WF']->value)."'")."/></td>
              </tr>
              <tr>
                <td>WF(ref)</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[constants][edw_6MV_WF_abs]' class='span12' id='form_entry_form_values_edw_6MV_WF_abs' /></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[constants][edw_10MV_WF_abs]' class='span12' id='form_entry_form_values_edw_10MV_WF_abs' /></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[constants][edw_15MV_WF_abs]' class='span12' id='form_entry_form_values_edw_15MV_WF_abs' /></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[constants][edw_18MV_WF_abs]' class='span12' id='form_entry_form_values_edw_18MV_WF_abs' /></td>
              </tr>
              <tr>
                <td>%diff</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_6MV_diff]' class='span12' id='form_entry_form_values_edw_6MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_6MV_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_10MV_diff]' class='span12' id='form_entry_form_values_edw_10MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_10MV_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_15MV_diff]' class='span12' id='form_entry_form_values_edw_15MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_15MV_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][edw_18MV_diff]' class='span12' id='form_entry_form_values_edw_18MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['edw_18MV_diff']->value)."'")."/></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <h1>Electron Dosimetry</h1>
      <div class='row-fluid'>
        <div class='span6'>
          <h3 class='center-horizontal'>Output Calibration</h3>
          <table class='table table-bordered table-striped'>
            <thead>
              <tr>
                <th>Electron Energy</th>
                <th>6MeV</th>
                <th>9MeV</th>
                <th>12MeV</th>
                <th>16MeV</th>
                <th>20MeV</th>
              </tr>
              <tr>
                <th>Depth(cm)</th>
                <th>1.5</th>
                <th>2.5</th>
                <th>2.5</th>
                <th>2.5</th>
                <th>2.5</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Q<sub>1</sub></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_6MeV_q1]' class='form_entry_form_values_electron_output_calibration_6MeV span12' id='form_entry_form_values_electron_output_calibration_6MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_6MeV_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_9MeV_q1]' class='form_entry_form_values_electron_output_calibration_9MeV span12' id='form_entry_form_values_electron_output_calibration_9MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_9MeV_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_12MeV_q1]' class='form_entry_form_values_electron_output_calibration_12MeV span12' id='form_entry_form_values_electron_output_calibration_12MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_12MeV_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_16MeV_q1]' class='form_entry_form_values_electron_output_calibration_16MeV span12' id='form_entry_form_values_electron_output_calibration_16MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_16MeV_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_20MeV_q1]' class='form_entry_form_values_electron_output_calibration_20MeV span12' id='form_entry_form_values_electron_output_calibration_20MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_20MeV_q1']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Q<sub>2</sub></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_6MeV_q2]' class='form_entry_form_values_electron_output_calibration_6MeV span12' id='form_entry_form_values_electron_output_calibration_6MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_6MeV_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_9MeV_q2]' class='form_entry_form_values_electron_output_calibration_9MeV span12' id='form_entry_form_values_electron_output_calibration_9MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_9MeV_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_12MeV_q2]' class='form_entry_form_values_electron_output_calibration_12MeV span12' id='form_entry_form_values_electron_output_calibration_12MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_12MeV_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_16MeV_q2]' class='form_entry_form_values_electron_output_calibration_16MeV span12' id='form_entry_form_values_electron_output_calibration_16MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_16MeV_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_20MeV_q2]' class='form_entry_form_values_electron_output_calibration_20MeV span12' id='form_entry_form_values_electron_output_calibration_20MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_20MeV_q2']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Q<sub>3</sub></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_6MeV_q3]' class='form_entry_form_values_electron_output_calibration_6MeV span12' id='form_entry_form_values_electron_output_calibration_6MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_6MeV_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_9MeV_q3]' class='form_entry_form_values_electron_output_calibration_9MeV span12' id='form_entry_form_values_electron_output_calibration_9MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_9MeV_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_12MeV_q3]' class='form_entry_form_values_electron_output_calibration_12MeV span12' id='form_entry_form_values_electron_output_calibration_12MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_12MeV_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_16MeV_q3]' class='form_entry_form_values_electron_output_calibration_16MeV span12' id='form_entry_form_values_electron_output_calibration_16MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_16MeV_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_20MeV_q3]' class='form_entry_form_values_electron_output_calibration_20MeV span12' id='form_entry_form_values_electron_output_calibration_20MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_20MeV_q3']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Avg</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_6MeV_avg]' class='span12' id='form_entry_form_values_electron_output_calibration_6MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_6MeV_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_9MeV_avg]' class='span12' id='form_entry_form_values_electron_output_calibration_9MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_9MeV_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_12MeV_avg]' class='span12' id='form_entry_form_values_electron_output_calibration_12MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_12MeV_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_16MeV_avg]' class='span12' id='form_entry_form_values_electron_output_calibration_16MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_16MeV_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_20MeV_avg]' class='span12' id='form_entry_form_values_electron_output_calibration_20MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_20MeV_avg']->value)."'")."/></td>
              </tr>
              <tr>
                <td>M</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_6MeV_M]' class='span12' id='form_entry_form_values_electron_output_calibration_6MeV_M' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_6MeV_M']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_9MeV_M]' class='span12' id='form_entry_form_values_electron_output_calibration_9MeV_M' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_9MeV_M']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_12MeV_M]' class='span12' id='form_entry_form_values_electron_output_calibration_12MeV_M' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_12MeV_M']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_16MeV_M]' class='span12' id='form_entry_form_values_electron_output_calibration_16MeV_M' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_16MeV_M']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_20MeV_M]' class='span12' id='form_entry_form_values_electron_output_calibration_20MeV_M' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_20MeV_M']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Mc</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[constants][electron_output_calibration_6MeV_Mc]' class='span12' id='form_entry_form_values_electron_output_calibration_6MeV_Mc' /></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[constants][electron_output_calibration_9MeV_Mc]' class='span12' id='form_entry_form_values_electron_output_calibration_9MeV_Mc' /></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[constants][electron_output_calibration_12MeV_Mc]' class='span12' id='form_entry_form_values_electron_output_calibration_12MeV_Mc' /></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[constants][electron_output_calibration_16MeV_Mc]' class='span12' id='form_entry_form_values_electron_output_calibration_16MeV_Mc' /></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[constants][electron_output_calibration_20MeV_Mc]' class='span12' id='form_entry_form_values_electron_output_calibration_20MeV_Mc' /></td>
              </tr>
              <tr>
                <td>%diff</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_6MeV_diff]' class='span12 form_entry_form_values_electron_output_calibration_diff' id='form_entry_form_values_electron_output_calibration_6MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_6MeV_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_9MeV_diff]' class='span12 form_entry_form_values_electron_output_calibration_diff' id='form_entry_form_values_electron_output_calibration_9MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_9MeV_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_12MeV_diff]' class='span12 form_entry_form_values_electron_output_calibration_diff' id='form_entry_form_values_electron_output_calibration_12MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_12MeV_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_16MeV_diff]' class='span12 form_entry_form_values_electron_output_calibration_diff' id='form_entry_form_values_electron_output_calibration_16MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_16MeV_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_20MeV_diff]' class='span12 form_entry_form_values_electron_output_calibration_diff' id='form_entry_form_values_electron_output_calibration_20MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_20MeV_diff']->value)."'")."/></td>
              </tr>
            </tbody>
          </table>
          <div id='electron_output_calibration_adjustment' style='display:none;'>
            <h3 class='center-horizontal'>Adjusted Output Calibration</h3>
            <table class='table table-bordered table-striped'>
              <thead>
                <tr>
                  <th>Electron Energy</th>
                  <th>6MeV</th>
                  <th>9MeV</th>
                  <th>12MeV</th>
                  <th>16MeV</th>
                  <th>20MeV</th>
                </tr>
                <tr>
                  <th>Depth(cm)</th>
                  <th>1.5</th>
                  <th>2.5</th>
                  <th>2.5</th>
                  <th>2.5</th>
                  <th>2.5</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Q<sub>1</sub></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_6MeV_q1]' class='form_entry_form_values_electron_output_calibration_adjusted_6MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_6MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_6MeV_q1']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_9MeV_q1]' class='form_entry_form_values_electron_output_calibration_adjusted_9MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_9MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_9MeV_q1']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_12MeV_q1]' class='form_entry_form_values_electron_output_calibration_adjusted_12MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_12MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_12MeV_q1']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_16MeV_q1]' class='form_entry_form_values_electron_output_calibration_adjusted_16MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_16MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_16MeV_q1']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_20MeV_q1]' class='form_entry_form_values_electron_output_calibration_adjusted_20MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_20MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_20MeV_q1']->value)."'")."/></td>
                </tr>
                <tr>
                  <td>Q<sub>2</sub></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_6MeV_q2]' class='form_entry_form_values_electron_output_calibration_adjusted_6MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_6MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_6MeV_q2']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_9MeV_q2]' class='form_entry_form_values_electron_output_calibration_adjusted_9MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_9MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_9MeV_q2']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_12MeV_q2]' class='form_entry_form_values_electron_output_calibration_adjusted_12MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_12MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_12MeV_q2']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_16MeV_q2]' class='form_entry_form_values_electron_output_calibration_adjusted_16MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_16MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_16MeV_q2']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_20MeV_q2]' class='form_entry_form_values_electron_output_calibration_adjusted_20MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_20MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_20MeV_q2']->value)."'")."/></td>
                </tr>
                <tr>
                  <td>Q<sub>3</sub></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_6MeV_q3]' class='form_entry_form_values_electron_output_calibration_adjusted_6MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_6MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_6MeV_q3']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_9MeV_q3]' class='form_entry_form_values_electron_output_calibration_adjusted_9MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_9MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_9MeV_q3']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_12MeV_q3]' class='form_entry_form_values_electron_output_calibration_adjusted_12MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_12MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_12MeV_q3']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_16MeV_q3]' class='form_entry_form_values_electron_output_calibration_adjusted_16MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_16MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_16MeV_q3']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_20MeV_q3]' class='form_entry_form_values_electron_output_calibration_adjusted_20MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_20MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_20MeV_q3']->value)."'")."/></td>
                </tr>
                <tr>
                  <td>Avg</td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_6MeV_avg]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_6MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_6MeV_avg']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_9MeV_avg]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_9MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_9MeV_avg']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_12MeV_avg]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_12MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_12MeV_avg']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_16MeV_avg]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_16MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_16MeV_avg']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_20MeV_avg]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_20MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_20MeV_avg']->value)."'")."/></td>
                </tr>
                <tr>
                  <td>M</td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_6eMeV_adjusted_M]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_6MeV_M' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_6MeV_M']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_9MeV_M]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_9MeV_M' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_9MeV_M']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_12MeV_M]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_12MeV_M' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_12MeV_M']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_16MeV_M]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_16MeV_M' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_16MeV_M']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_20MeV_M]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_20MeV_M' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_20MeV_M']->value)."'")."/></td>
                </tr>
                <tr>
                  <td>Mc</td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[constants][electron_output_calibration_adjusted_6MeV_Mc]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_6MeV_Mc' /></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[constants][electron_output_calibration_adjusted_9MeV_Mc]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_9MeV_Mc' /></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[constants][electron_output_calibration_adjusted_12MeV_Mc]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_12MeV_Mc' /></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[constants][electron_output_calibration_adjusted_16MeV_Mc]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_16MeV_Mc' /></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[constants][electron_output_calibration_adjusted_20MeV_Mc]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_20MeV_Mc' /></td>
                </tr>
                <tr>
                  <td>%diff</td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_6MeV_diff]' class='span12 form_entry_form_values_electron_output_calibration_adjusted_diff' id='form_entry_form_values_electron_output_calibration_adjusted_6MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_6MeV_diff']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_9MeV_diff]' class='span12 form_entry_form_values_electron_output_calibration_adjusted_diff' id='form_entry_form_values_electron_output_calibration_adjusted_9MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_9MeV_diff']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_12MeV_diff]' class='span12 form_entry_form_values_electron_output_calibration_adjusted_diff' id='form_entry_form_values_electron_output_calibration_adjusted_12MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_12MeV_diff']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_16MeV_diff]' class='span12 form_entry_form_values_electron_output_calibration_adjusted_diff' id='form_entry_form_values_electron_output_calibration_adjusted_16MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_16MeV_diff']->value)."'")."/></td>
                  <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][electron_output_calibration_adjusted_20MeV_diff]' class='span12 form_entry_form_values_electron_output_calibration_adjusted_diff' id='form_entry_form_values_electron_output_calibration_adjusted_20MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['electron_output_calibration_adjusted_20MeV_diff']->value)."'")."/></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class='span6'>
          <h3 class='center-horizontal'>Energy Ratio Check</h3>
          <table class='table table-bordered table-striped'>
            <thead>
              <tr>
                <th>Electron Energy</th>
                <th>6MeV</th>
                <th>9MeV</th>
                <th>12MeV</th>
                <th>16MeV</th>
                <th>20MeV</th>
              </tr>
              <tr>
                <th>Depth(cm)</th>
                <th>2.0</th>
                <th>3.0</th>
                <th>4.0</th>
                <th>5.5</th>
                <th>6.5</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Q<sub>1</sub></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_6MeV_q1]' class='form_entry_form_values_energy_ratio_6MeV span12' id='form_entry_form_values_energy_ratio_6MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_6MeV_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_9MeV_q1]' class='form_entry_form_values_energy_ratio_9MeV span12' id='form_entry_form_values_energy_ratio_9MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_9MeV_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_12MeV_q1]' class='form_entry_form_values_energy_ratio_12MeV span12' id='form_entry_form_values_energy_ratio_12MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_12MeV_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_16MeV_q1]' class='form_entry_form_values_energy_ratio_16MeV span12' id='form_entry_form_values_energy_ratio_16MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_16MeV_q1']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_20MeV_q1]' class='form_entry_form_values_energy_ratio_20MeV span12' id='form_entry_form_values_energy_ratio_20MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_20MeV_q1']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Q<sub>2</sub></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_6MeV_q2]' class='form_entry_form_values_energy_ratio_6MeV span12' id='form_entry_form_values_energy_ratio_6MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_6MeV_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_9MeV_q2]' class='form_entry_form_values_energy_ratio_9MeV span12' id='form_entry_form_values_energy_ratio_9MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_9MeV_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_12MeV_q2]' class='form_entry_form_values_energy_ratio_12MeV span12' id='form_entry_form_values_energy_ratio_12MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_12MeV_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_16MeV_q2]' class='form_entry_form_values_energy_ratio_16MeV span12' id='form_entry_form_values_energy_ratio_16MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_16MeV_q2']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_20MeV_q2]' class='form_entry_form_values_energy_ratio_20MeV span12' id='form_entry_form_values_energy_ratio_20MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_20MeV_q2']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Q<sub>3</sub></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_6MeV_q3]' class='form_entry_form_values_energy_ratio_6MeV span12' id='form_entry_form_values_energy_ratio_6MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_6MeV_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_9MeV_q3]' class='form_entry_form_values_energy_ratio_9MeV span12' id='form_entry_form_values_energy_ratio_9MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_9MeV_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_12MeV_q3]' class='form_entry_form_values_energy_ratio_12MeV span12' id='form_entry_form_values_energy_ratio_12MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_12MeV_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_16MeV_q3]' class='form_entry_form_values_energy_ratio_16MeV span12' id='form_entry_form_values_energy_ratio_16MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_16MeV_q3']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_20MeV_q3]' class='form_entry_form_values_energy_ratio_20MeV span12' id='form_entry_form_values_energy_ratio_20MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_20MeV_q3']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Avg</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_6MeV_avg]' class='span12' id='form_entry_form_values_energy_ratio_6MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_6MeV_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_9MeV_avg]' class='span12' id='form_entry_form_values_energy_ratio_9MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_9MeV_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_12MeV_avg]' class='span12' id='form_entry_form_values_energy_ratio_12MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_12MeV_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_16MeV_avg]' class='span12' id='form_entry_form_values_energy_ratio_16MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_16MeV_avg']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_20MeV_avg]' class='span12' id='form_entry_form_values_energy_ratio_20MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_20MeV_avg']->value)."'")."/></td>
              </tr>
                <td>PDD</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_6eMV_PDD]' class='span12' id='form_entry_form_values_energy_ratio_6MeV_PDD' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_6MeV_PDD']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_9MeV_PDD]' class='span12' id='form_entry_form_values_energy_ratio_9MeV_PDD' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_9MeV_PDD']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_12MeV_PDD]' class='span12' id='form_entry_form_values_energy_ratio_12MeV_PDD' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_12MeV_PDD']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_16MeV_PDD]' class='span12' id='form_entry_form_values_energy_ratio_16MeV_PDD' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_16MeV_PDD']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_20MeV_PDD]' class='span12' id='form_entry_form_values_energy_ratio_20MeV_PDD' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_20MeV_PDD']->value)."'")."/></td>
              </tr>
                <td>PDD(ref)</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[constants][energy_ratio_6MeV_PDD_abs]' class='span12' id='form_entry_form_values_energy_ratio_6MeV_PDD_abs' /></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[constants][energy_ratio_9MeV_PDD_abs]' class='span12' id='form_entry_form_values_energy_ratio_9MeV_PDD_abs' /></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[constants][energy_ratio_12MeV_PDD_abs]' class='span12' id='form_entry_form_values_energy_ratio_12MeV_PDD_abs' /></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[constants][energy_ratio_16MeV_PDD_abs]' class='span12' id='form_entry_form_values_energy_ratio_16MeV_PDD_abs' /></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[constants][energy_ratio_20MeV_PDD_abs]' class='span12' id='form_entry_form_values_energy_ratio_20MeV_PDD_abs' /></td>
              </tr>
              <tr>
                <td>%diff</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_6MeV_diff]' class='span12' id='form_entry_form_values_energy_ratio_6MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_6MeV_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_9MeV_diff]' class='span12' id='form_entry_form_values_energy_ratio_9MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_9MeV_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_12MeV_diff]' class='span12' id='form_entry_form_values_energy_ratio_12MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_12MeV_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_16MeV_diff]' class='span12' id='form_entry_form_values_energy_ratio_16MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_16MeV_diff']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][energy_ratio_20MeV_diff]' class='span12' id='form_entry_form_values_energy_ratio_20MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['energy_ratio_20MeV_diff']->value)."'")."/></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class='tab-pane' id='tab-mechanical'>
    <h1>Mechanical QA</h1>
      <div class='row-fluid'>
        <div class='span3'>
          <h3 class='center-horizontal'>Laser position</h3>
          <table class='table table-bordered table-striped'>
            <thead>
              <tr>
                <th>Position</th>
                <th>IC Distance (mm)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>L Wall Vertical</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' class='span12' name='form_entry[form_values][laser_l_wall_vertical]' id='form_entry_form_values_laser_l_wall_vertical' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['laser_l_wall_vertical']->value)."'")."/></td>
              </tr>
              <tr>
                <td>R Wall Vertical</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' class='span12' name='form_entry[form_values][laser_r_wall_vertical]' id='form_entry_form_values_laser_r_wall_vertical' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['laser_r_wall_vertical']->value)."'")."/></td>
              </tr>
              <tr>
                <td>L Wall Horizontal</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' class='span12' name='form_entry[form_values][laser_l_wall_horizontal]' id='form_entry_form_values_laser_l_wall_horizontal' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['laser_l_wall_horizontal']->value)."'")."/></td>
              </tr>
              <tr>
                <td>R Wall Horizontal</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' class='span12' name='form_entry[form_values][laser_r_wall_horizontal]' id='form_entry_form_values_laser_laser_r_wall_horizontal' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['laser_r_wall_horizontal']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Sagittal</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' class='span12' name='form_entry[form_values][laser_sagittal]' id='form_entry_form_values_laser_sagittal' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['laser_sagittal']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Ceiling Superior</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' class='span12' name='form_entry[form_values][laser_ceiling_superior]' id='form_entry_form_values_laser_ceiling_superior' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['laser_ceiling_superior']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Ceiling Inferior</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' class='span12' name='form_entry[form_values][laser_ceiling_inferior]' id='form_entry_form_values_laser_ceiling_inferior' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['laser_ceiling_inferior']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Ceiling Left</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' class='span12' name='form_entry[form_values][laser_ceiling_left]' id='form_entry_form_values_laser_ceiling_left' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['laser_ceiling_left']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Ceiling Right</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' class='span12' name='form_entry[form_values][laser_ceiling_right]' id='form_entry_form_values_laser_ceiling_right' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['laser_ceiling_right']->value)."'")."/></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class='span3'>
          <h3 class='center-horizontal'>ODI vs Light Field Isocenter</h3>
          <table class='table table-bordered table-striped'>
            <thead>
              <tr>
                <th>Gantry Angle</th>
                <th>IC ODI Reading</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>0&deg;</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][odi_vs_light_reading_0]' class='span12' id='form_entry_form_values_odi_vs_light_reading_0' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['odi_vs_light_reading_0']->value)."'")."/></td>
              </tr>
              <tr>
                <td>90&deg;</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][odi_vs_light_reading_90]' class='span12' id='form_entry_form_values_odi_vs_light_reading_90' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['odi_vs_light_reading_90']->value)."'")."/></td>
              </tr>
              <tr>
                <td>270&deg;</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][odi_vs_light_reading_270]' class='span12' id='form_entry_form_values_odi_vs_light_reading_270' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['odi_vs_light_reading_270']->value)."'")."/></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class='span3'>
          <h3 class='center-horizontal'>Centering of Light Field Cross-Hair</h3>
          <table class='table table-bordered table-striped'>
            <thead>
              <tr>
                <th>Gantry Angle</th>
                <th>IC Distance (mm)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>0&deg;</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][light_centering_distance_0]' class='span12' id='form_entry_form_values_light_centering_distance_0' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['light_centering_distance_0']->value)."'")."/></td>
              </tr>
              <tr>
                <td>90&deg;</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][light_centering_distance_90]' class='span12' id='form_entry_form_values_light_centering_distance_90' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['light_centering_distance_90']->value)."'")."/></td>
              </tr>
              <tr>
                <td>270&deg;</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][light_centering_distance_270]' class='span12' id='form_entry_form_values_light_centering_distance_270' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['light_centering_distance_270']->value)."'")."/></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class='span3'>
          <h3 class='center-horizontal'>Device Angles vs Readout</h3>
          <table class='table table-bordered table-striped'>
            <thead>
              <tr>
                <th>Device</th>
                <th>Angle</th>
                <th>Digital Readout</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Gantry</td>
                <td>0&deg;</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][gantry_angle_readout_0]' class='span12' id='form_entry_form_values_gantry_angle_readout_0' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['gantry_angle_readout_0']->value)."'")."/></td>
              </tr>
              <tr>
                <td></td>
                <td>90&deg;</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][gantry_angle_readout_90]' class='span12' id='form_entry_form_values_gantry_angle_readout_90' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['gantry_angle_readout_90']->value)."'")."/></td>
              </tr>
              <tr>
                <td></td>
                <td>270&deg;</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][gantry_angle_readout_270]' class='span12' id='form_entry_form_values_gantry_angle_readout_270' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['gantry_angle_readout_270']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Collimator</td>
                <td>0&deg;</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][collimator_angle_readout_0]' class='span12' id='form_entry_form_values_collimator_angle_readout_0' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['collimator_angle_readout_0']->value)."'")."/></td>
              </tr>
              <tr>
                <td></td>
                <td>90&deg;</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][collimator_angle_readout_90]' class='span12' id='form_entry_form_values_collimator_angle_readout_90' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['collimator_angle_readout_90']->value)."'")."/></td>
              </tr>
              <tr>
                <td></td>
                <td>270&deg;</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][collimator_angle_readout_270]' class='span12' id='form_entry_form_values_collimator_angle_readout_270' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['collimator_angle_readout_270']->value)."'")."/></td>
              </tr>
              <tr>
                <td>PSA</td>
                <td>0&deg;</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][psa_position_0]' class='span12' id='form_entry_form_values_psa_position_0' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['psa_position_0']->value)."'")."/></td>
              </tr>
              <tr>
                <td></td>
                <td>90&deg;</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][psa_position_90]' class='span12' id='form_entry_form_values_psa_position_90' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['psa_position_90']->value)."'")."/></td>
              </tr>
              <tr>
                <td></td>
                <td>270&deg;</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][psa_position_270]' class='span12' id='form_entry_form_values_psa_position_270' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['psa_position_270']->value)."'")."/></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class='row-fluid'>
        <div class='span5'>
          <h3 class='center-horizontal'>Optical Field Size vs Digital Readout</h3>
          <table class='table table-bordered table-striped'>
            <thead>
              <tr>
                <th>Digital (cm)</th>
                <th>x<sub>1</sub></th>
                <th>x<sub>2</sub></th>
                <th>y<sub>1</sub></th>
                <th>y<sub>2</sub></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>5.0x5.0</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][optical_field_x1_x5]' class='span12' id='form_entry_form_values_optical_field_x1_x5' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['optical_field_x1_x5']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][optical_field_x2_x5]' class='span12' id='form_entry_form_values_optical_field_x2_x5' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['optical_field_x2_x5']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][optical_field_y1_y5]' class='span12' id='form_entry_form_values_optical_field_y1_y5' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['optical_field_y1_y5']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][optical_field_y2_y5]' class='span12' id='form_entry_form_values_optical_field_y2_y5' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['optical_field_y2_y5']->value)."'")."/></td>
              </tr>
              <tr>
                <td>10.0x10.0</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][optical_field_x1_x10]' class='span12' id='form_entry_form_values_optical_field_x1_x10' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['optical_field_x1_x10']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][optical_field_x2_x10]' class='span12' id='form_entry_form_values_optical_field_x2_x10' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['optical_field_x2_x10']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][optical_field_y1_y10]' class='span12' id='form_entry_form_values_optical_field_y1_y10' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['optical_field_y1_y10']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][optical_field_y2_y10]' class='span12' id='form_entry_form_values_optical_field_y2_y10' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['optical_field_y2_y10']->value)."'")."/></td>
              </tr>
              <tr>
                <td>20.0x20.0</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][optical_field_x1_x20]' class='span12' id='form_entry_form_values_optical_field_x1_x20' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['optical_field_x1_x20']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][optical_field_x2_x20]' class='span12' id='form_entry_form_values_optical_field_x2_x20' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['optical_field_x2_x20']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][optical_field_y1_y20]' class='span12' id='form_entry_form_values_optical_field_y1_y20' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['optical_field_y1_y20']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][optical_field_y2_y20]' class='span12' id='form_entry_form_values_optical_field_y2_y20' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['optical_field_y2_y20']->value)."'")."/></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class='span6'>
          <h3 class='center-horizontal'>BB Tray Alignment</h3>
          <table class='table table-bordered table-striped'>
            <thead>
              <tr>
                <th>Distance off relative to wires</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Cross-line</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][bb_tray_cross_line]' class='span12' id='form_entry_form_values_bb_tray_cross_line' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['bb_tray_cross_line']->value)."'")."/>
              </tr>
              <tr>
                <td>In-line</td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][bb_tray_in_line]' class='span12' id='form_entry_form_values_bb_tray_in_line' ".(($id === false) ? "" : " value='".escape_output($formEntry->formValues['bb_tray_in_line']->value)."'")."/>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class='row-fluid'>
        <div class='span4'>
          <h3 class='center-horizontal'>Door and Key Interlock</h3>
          <table class='table table-bordered table-striped'>
            <thead>
              <tr>
                <th></th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Door</td>
                <td class='control-group'>\n";
  display_ok_notok_dropdown('form_entry[form_values][door_key_interlock_door_status]', ($id != false) ? $formEntry->formValues['door_key_interlock_door_status']->value : '');
  echo "               </td>
              </tr>
              <tr>
                <td>Key</td>
                <td class='control-group'>\n";
  display_ok_notok_dropdown('form_entry[form_values][door_key_interlock_key_status]', ($id != false) ? $formEntry->formValues['door_key_interlock_key_status']->value : '');
  echo "               </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class='span8'>
          <h3 class='center-horizontal'>Accessory Position and Latching</h3>
          <table class='table table-bordered table-striped'>
            <thead>
            </thead>
            <tbody>
              <tr>
                <td>Wedge</td>
                <td class='control-group'><select id='form_entry_form_values_accessory_position_wedge' name='form_entry[form_values][accessory_position_wedge_position]'>
                      <option value='15'".(($id != false && $formEntry->formValues['accessory_position_wedge_position']->value == '15') ? " selected='selected'" : "").">15&deg; upper</option>
                      <option value='15'".(($id != false && $formEntry->formValues['accessory_position_wedge_position']->value == '-15') ? " selected='selected'" : "").">15&deg; lower</option>
                      <option value='30'".(($id != false && $formEntry->formValues['accessory_position_wedge_position']->value == '30') ? " selected='selected'" : "").">30&deg; upper</option>
                      <option value='30'".(($id != false && $formEntry->formValues['accessory_position_wedge_position']->value == '-30') ? " selected='selected'" : "").">30&deg; lower</option>
                      <option value='45'".(($id != false && $formEntry->formValues['accessory_position_wedge_position']->value == '45') ? " selected='selected'" : "").">45&deg; upper</option>
                      <option value='45'".(($id != false && $formEntry->formValues['accessory_position_wedge_position']->value == '-45') ? " selected='selected'" : "").">45&deg; lower</option>
                      <option value='60'".(($id != false && $formEntry->formValues['accessory_position_wedge_position']->value == '60') ? " selected='selected'" : "").">60&deg; upper</option>
                      <option value='60'".(($id != false && $formEntry->formValues['accessory_position_wedge_position']->value == '-60') ? " selected='selected'" : "").">60&deg; lower</option>
                    </select></td>
                <td class='control-group'>\n";
  display_ok_notok_dropdown('form_entry[form_values][accessory_position_wedge_status]', ($id != false) ? $formEntry->formValues['accessory_position_wedge_status']->value : '');
  echo "                </td>
              </tr>
              <tr>
                <td>Cone</td>
                <td class='control-group'><select id='form_entry_form_values_accessory_position_cone' name='form_entry[form_values][accessory_position_cone_position]'>
                      <option value='6*6'".(($id != false && $formEntry->formValues['accessory_position_cone_position']->value == '6*6') ? " selected='selected'" : "").">6*6</option>
                      <option value='10*10'".(($id != false && $formEntry->formValues['accessory_position_cone_position']->value == '10*10') ? " selected='selected'" : "").">10*10</option>
                      <option value='15*15'".(($id != false && $formEntry->formValues['accessory_position_cone_position']->value == '15*15') ? " selected='selected'" : "").">15*15</option>
                      <option value='20*20'".(($id != false && $formEntry->formValues['accessory_position_cone_position']->value == '20*20') ? " selected='selected'" : "").">20*20</option>
                      <option value='25*25'".(($id != false && $formEntry->formValues['accessory_position_cone_position']->value == '25*25') ? " selected='selected'" : "").">25*25</option>
                    </select></td>
                <td class='control-group'>\n";
  display_ok_notok_dropdown('form_entry[form_values][accessory_position_cone_status]', ($id != false) ? $formEntry->formValues['accessory_position_cone_status']->value : '');
  echo "               </td>
              </tr>
              <tr>
                <td>Block</td>
                <td></td>
                <td class='control-group'>\n";
  display_ok_notok_dropdown('form_entry[form_values][accessory_position_block]', ($id != false) ? $formEntry->formValues['accessory_position_block']->value : '');
  echo "               </td>
              </tr>
            </tbody>
          </table>
        </div>
    </div>
    </div>
    <div class='tab-pane' id='tab-imaging'>
      <div class='row-fluid'>
            <div class='span6'>
          <h3 class='center-horizontal'>MV/kV/CBCT</h3>
          <table class='table table-bordered table-striped'>
            <thead>
              <tr>
                <th>Imager</th>
                <th>MV</th>
                <th>kV</th>
                <th>CBCT</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Resolution (lp/mm)</td>
                <td class='control-group'>\n";
  display_ok_notok_dropdown('form_entry[form_values][resolution_lp_mm_status]', ($id != false) ? $formEntry->formValues['resolution_lp_mm']->value : '');
  echo "                </td>
                <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][resolution_lp_mm_measurement]' class='span12' id='form_entry_form_values_resolution_lp_mm_measurement' ".(($id === false) ? " placeholder='>1.25'" : " value='".escape_output($formEntry->formValues['resolution_lp_mm_measurement']->value)."'")."/></td>
                <td class='control-group'><input name='form_entry[form_values][resolution_lp_mm_row]' class='span12' id='form_entry_form_values_resolution_lp_mm_row' ".(($id === false) ? " placeholder='row 5'" : " value='".escape_output($formEntry->formValues['resolution_lp_mm_row']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Contrast (disks)</td>
                <td class='control-group'>\n";
  display_ok_notok_dropdown('form_entry[form_values][contrast_disks_status]', ($id != false) ? $formEntry->formValues['contrast_disks']->value : '');
  echo "               </td>
                <td class='control-group'><input type='number' step='0.1' name='form_entry[form_values][contrast_disks_measurement]' class='span12' id='form_entry_form_values_contrast_disks_measurement' ".(($id === false) ? " placeholder='18'" : " value='".escape_output($formEntry->formValues['contrast_disks_measurement']->value)."'")."/></td>
                <td class='control-group'><input name='form_entry[form_values][contrast_disks_row]' class='span12' id='form_entry_form_values_contrast_disks_row' ".(($id === false) ? " placeholder='8mm disk'" : " value='".escape_output($formEntry->formValues['contrast_disks_row']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Scaling (mm)</td>
                <td class='control-group'><input type='number' step='0.1' name='form_entry[form_values][scaling_mv]' class='span12' id='form_entry_form_values_scaling_mv' ".(($id === false) ? " placeholder='97'" : " value='".escape_output($formEntry->formValues['scaling_mv']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.1' name='form_entry[form_values][scaling_kv]' class='span12' id='form_entry_form_values_scaling_kv' ".(($id === false) ? " placeholder='125'" : " value='".escape_output($formEntry->formValues['scaling_kv']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.1' name='form_entry[form_values][scaling_cbct]' class='span12' id='form_entry_form_values_scaling_cbct' ".(($id === false) ? " placeholder='50'" : " value='".escape_output($formEntry->formValues['scaling_cbct']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Uniformity/HU</td>
                <td class='control-group'></td>
                <td class='control-group'></td>
                <td class='control-group'><input type='number' step='0.0000000000000001' name='form_entry[form_values][uniformity_center_cbct]' class='span12' id='form_entry_form_values_max_diff_wr_cbct' ".(($id === false) ? " placeholder='center'" : " value='".escape_output($formEntry->formValues['max_diff_wr_cbct']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Top</td>
                <td class='control-group'><input type='number' step='1' name='form_entry[form_values][uniformity_mv_top]' class='span12' id='form_entry_form_values_uniformity_mv_top' ".(($id === false) ? " placeholder='1160&plusmn;30'" : " value='".escape_output($formEntry->formValues['uniformity_mv_top']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='1' name='form_entry[form_values][uniformity_kv_top]' class='span12' id='form_entry_form_values_uniformity_kv_top' ".(($id === false) ? " placeholder='203000&plusmn;3000'" : " value='".escape_output($formEntry->formValues['uniformity_kv_top']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='1' name='form_entry[form_values][uniformity_cbct_top]' class='span12' id='form_entry_form_values_uniformity_cbct_top' ".(($id === false) ? " placeholder=''" : " value='".escape_output($formEntry->formValues['uniformity_cbct_top']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Bottom</td>
                <td class='control-group'><input type='number' step='1' name='form_entry[form_values][uniformity_mv_bottom]' class='span12' id='form_entry_form_values_uniformity_mv_bottom' ".(($id === false) ? " placeholder='1160&plusmn;30'" : " value='".escape_output($formEntry->formValues['uniformity_mv_bottom']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='1' name='form_entry[form_values][uniformity_kv_bottom]' class='span12' id='form_entry_form_values_uniformity_kv_bottom' ".(($id === false) ? " placeholder='203000&plusmn;3000'" : " value='".escape_output($formEntry->formValues['uniformity_kv_bottom']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='1' name='form_entry[form_values][uniformity_cbct_bottom]' class='span12' id='form_entry_form_values_uniformity_cbct_bottom' ".(($id === false) ? " placeholder=''" : " value='".escape_output($formEntry->formValues['uniformity_cbct_bottom']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Left</td>
                <td class='control-group'><input type='number' step='1' name='form_entry[form_values][uniformity_mv_left]' class='span12' id='form_entry_form_values_uniformity_mv_left' ".(($id === false) ? " placeholder='1160&plusmn;30'" : " value='".escape_output($formEntry->formValues['uniformity_mv_left']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='1' name='form_entry[form_values][uniformity_kv_left]' class='span12' id='form_entry_form_values_uniformity_kv_left' ".(($id === false) ? " placeholder='203000&plusmn;3000'" : " value='".escape_output($formEntry->formValues['uniformity_kv_left']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='1' name='form_entry[form_values][uniformity_cbct_left]' class='span12' id='form_entry_form_values_uniformity_cbct_left' ".(($id === false) ? " placeholder=''" : " value='".escape_output($formEntry->formValues['uniformity_cbct_left']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Right</td>
                <td class='control-group'><input type='number' step='1' name='form_entry[form_values][uniformity_mv_right]' class='span12' id='form_entry_form_values_uniformity_mv_right' ".(($id === false) ? " placeholder='1160&plusmn;30'" : " value='".escape_output($formEntry->formValues['uniformity_mv_right']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='1' name='form_entry[form_values][uniformity_kv_right]' class='span12' id='form_entry_form_values_uniformity_kv_right' ".(($id === false) ? " placeholder='203000&plusmn;3000'" : " value='".escape_output($formEntry->formValues['uniformity_kv_right']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='1' name='form_entry[form_values][uniformity_cbct_right]' class='span12' id='form_entry_form_values_uniformity_cbct_right' ".(($id === false) ? " placeholder=''" : " value='".escape_output($formEntry->formValues['uniformity_cbct_right']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Noise</td>
                <td class='control-group'></td>
                <td class='control-group'></td>
                <td class='control-group'></td>
              </tr>
              <tr>
                <td>Top</td>
                <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][noise_mv_top]' class='span12' id='form_entry_form_values_noise_mv_top' ".(($id === false) ? " placeholder='1160&plusmn;30'" : " value='".escape_output($formEntry->formValues['noise_mv_top']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][noise_kv_top]' class='span12' id='form_entry_form_values_noise_kv_top' ".(($id === false) ? " placeholder='203000&plusmn;3000'" : " value='".escape_output($formEntry->formValues['noise_kv_top']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][noise_cbct_top]' class='span12' id='form_entry_form_values_noise_cbct_top' ".(($id === false) ? " placeholder=''" : " value='".escape_output($formEntry->formValues['noise_cbct_top']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Bottom</td>
                <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][noise_mv_bottom]' class='span12' id='form_entry_form_values_noise_mv_bottom' ".(($id === false) ? " placeholder='1160&plusmn;30'" : " value='".escape_output($formEntry->formValues['noise_mv_bottom']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][noise_kv_bottom]' class='span12' id='form_entry_form_values_noise_kv_bottom' ".(($id === false) ? " placeholder='203000&plusmn;3000'" : " value='".escape_output($formEntry->formValues['noise_kv_bottom']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][noise_cbct_bottom]' class='span12' id='form_entry_form_values_noise_cbct_bottom' ".(($id === false) ? " placeholder=''" : " value='".escape_output($formEntry->formValues['noise_cbct_bottom']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Left</td>
                <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][noise_mv_left]' class='span12' id='form_entry_form_values_noise_mv_left' ".(($id === false) ? " placeholder='1160&plusmn;30'" : " value='".escape_output($formEntry->formValues['noise_mv_left']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][noise_kv_left]' class='span12' id='form_entry_form_values_noise_kv_left' ".(($id === false) ? " placeholder='203000&plusmn;3000'" : " value='".escape_output($formEntry->formValues['noise_kv_left']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][noise_cbct_left]' class='span12' id='form_entry_form_values_noise_cbct_left' ".(($id === false) ? " placeholder=''" : " value='".escape_output($formEntry->formValues['noise_cbct_left']->value)."'")."/></td>
              </tr>
              <tr>
                <td>Right</td>
                <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][noise_mv_right]' class='span12' id='form_entry_form_values_noise_mv_right' ".(($id === false) ? " placeholder='1160&plusmn;30'" : " value='".escape_output($formEntry->formValues['noise_mv_right']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][noise_kv_right]' class='span12' id='form_entry_form_values_noise_kv_right' ".(($id === false) ? " placeholder='203000&plusmn;3000'" : " value='".escape_output($formEntry->formValues['noise_kv_right']->value)."'")."/></td>
                <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][noise_cbct_right]' class='span12' id='form_entry_form_values_noise_cbct_right' ".(($id === false) ? " placeholder=''" : " value='".escape_output($formEntry->formValues['noise_cbct_right']->value)."'")."/></td>
              </tr>
            </tbody>
          </table>
          <table class='table table-bordered table-striped'>
            <thead>
              <tr>
                <th>CBCT</th>
              </tr>
              <tr>
                <th>HU Calibration</th>
                <th>Air</th>
                <th>Acrylic</th>
                <th>LDPE</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type='number' step='0.01' name='form_entry[form_values][hu_calibration_cbct]' class='span12' id='form_entry_form_values_hu_calibration_cbct' ".(($id === false) ? " placeholder=''" : " value='".escape_output($formEntry->formValues['hu_calibration_cbct']->value)."'")."/></td>
                <td><input type='number' step='1' name='form_entry[form_values][air_cbct]' class='span12' id='form_entry_form_values_air_cbct' ".(($id === false) ? " placeholder='-1000&plusmn;30'" : " value='".escape_output($formEntry->formValues['air_cbct']->value)."'")."/></td>
                <td><input type='number' step='1' name='form_entry[form_values][acrylic_cbct]' class='span12' id='form_entry_form_values_acrylic_cbct' ".(($id === false) ? " placeholder='120&plusmn;40'" : " value='".escape_output($formEntry->formValues['acrylic_cbct']->value)."'")."/></td>
                <td><input type='number' step='1' name='form_entry[form_values][ldpe_cbct]' class='span12' id='form_entry_form_values_ldpe_cbct' ".(($id === false) ? " placeholder='1160&plusmn;30'" : " value='".escape_output($formEntry->formValues['ldpe_cbct']->value)."'")."/></td>
              </tr>
            </tbody>
          </table>
        </div>
    </div>
    </div>
    <h3>Image</h3>\n";
    if ($id != false && $formEntry->imagePath != '') {
      echo "
      <div class='center-horizontal'>
        <img src='".escape_output($formEntry->imagePath)."' class='image-fluid'/>
      </div>\n";
    }
    echo "    <div id='image_preview' class='row-fluid'></div>
    <p>Supported formats: JPEG, PNG, GIF, WBMP, GD2</p>
    <input name='form_image' class='input-file' type='file' onChange='displayImagePreview(this.files);' />
    <h3>Comments</h3>
    <textarea name='form_entry[comments]' id='form_entry_comments' rows='10' class='span12' placeholder='Comments go here.'>".(($id === false) ? "" : escape_output($formEntry->comments))."</textarea><br />
    <div class='form-actions'>\n";
    if ($id != false && $formEntry->approvedOn != '') {
    echo "      <button type='submit' class='btn btn-primary disabled' disabled='disabled'>Approved</button>\n";    
    } else {
    echo "      <button type='submit' class='btn btn-primary'>".(($id === false) ? "Save" : "Save changes")."</button>\n";
    }
    echo "      <a class='btn' href='#' onClick='window.location.replace(document.referrer);' >".(($id === false) ? "Go back" : "Discard changes")."</a>\n";
    if ($id != false && $user->isPhysicist()) {
      if ($formEntry->approvedOn == '') {
        echo "      <a class='btn btn-success' href='form_entry.php?action=approve&id=".intval($id)."'>Approve</a>\n";
      } else {
        echo "      <a class='btn btn-warning' href='form_entry.php?action=unapprove&id=".intval($id)."'>Unapprove</a>\n";
      }
    }
    echo "    </div>
  </fieldset>
</form>\n";
?>