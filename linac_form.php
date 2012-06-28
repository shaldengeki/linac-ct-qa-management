<?php
  // displays a form to edit form parameters.
  echo "<form action='form_entry.php".(($id === false) ? "" : "?id=".intval($id))."' method='POST' class='form-horizontal'>
  <fieldset>
    <div class='control-group'>
      <label class='control-label' for='form_entry[machine_id]'>Machine</label>
      <div class='controls'>
";
  display_machine_dropdown($database, "form_entry[machine_id]", (($id === false) ? 0 : intval($formEntryObject['machine_id'])));
  echo "
      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='form_entry[created_at]'>Inspection Date</label>
      <div class='controls'>
        <input name='form_entry[created_at]' type='text' class='input-xlarge' id='form_entry_created_at'".(($id === false) ? "" : " value='".escape_output($formEntryObject['created_at'])."'").">
      </div>
    </div>
    <h1>Photon Dosimetry</h1>
    <h3>Measurement parameters</h3>
    <div class='control-group'>
      <label class='control-label' for='form_entry[form_values][0][temperature]'>Temperature (°C)</label>
      <div class='controls'>
        <input name='form_entry[form_values][0][temperature]' type='text' class='input-xlarge' id='form_entry_form_values_temperature'".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['temperature'])."'").">
      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='form_entry[form_values][1][pressure]'>Pressure (mmHg)</label>
      <div class='controls'>
        <input name='form_entry[form_values][1][pressure]' type='text' class='input-xlarge' id='form_entry_form_values_pressure'".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['pressure'])."'").">
      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='form_entry[form_values][2][tpcf]'>TPCF</label>
      <div class='controls'>
        <input name='form_entry[form_values][2][tpcf]' type='text' class='input-xlarge' id='form_entry_form_values_tpcf'".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['tpcf'])."'").">
      </div>
    </div>
    <h3>Equipment</h3>
    <div class='control-group'>
      <label class='control-label' for='form_entry[form_values][3][ionization_chamber]'>Ionization Chamber</label>
      <div class='controls'>
";
  display_ionization_chamber_dropdown("form_entry_form_values_ionization_chamber", "form_entry[form_values][3]");
  echo "      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='form_entry[form_values][4][electrometer]'>Electrometer</label>
      <div class='controls'>
";
  display_electrometer_dropdown("form_entry_form_values_electrometer", "form_entry[form_values][4]");
  echo "      </div>
    </div>
    <h3>Output Calibration</h3>
    <table class='table table-bordered table-striped'>
      <thead>
        <tr>
          <th>Photon Energy</th>
          <th>6MV</th>
          <th>18MV</th>
        </tr>
      </thead>
      <tbody>
        <tr><td>Q1</td><td><input name='form_entry[form_values][5][output_calibration_6MV_q1]' class='form_entry_form_values_output_calibration_6MV' id='form_entry_form_values_output_calibration_6MV_q1' /></td><td><input name='form_entry[form_values][5][output_calibration_18MV_q1]' class='form_entry_form_values_output_calibration_18MV' id='form_entry_form_values_output_calibration_18MV_q1' /></td></tr>
        <tr><td>Q2</td><td><input name='form_entry[form_values][6][output_calibration_6MV_q2]' class='form_entry_form_values_output_calibration_6MV' id='form_entry_form_values_output_calibration_6MV_q2' /></td><td><input name='form_entry[form_values][6][output_calibration_18MV_q2]' class='form_entry_form_values_output_calibration_18MV' id='form_entry_form_values_output_calibration_18MV_q2' /></td></tr>
        <tr><td>Q3</td><td><input name='form_entry[form_values][7][output_calibration_6MV_q3]' class='form_entry_form_values_output_calibration_6MV' id='form_entry_form_values_output_calibration_6MV_q3' /></td><td><input name='form_entry[form_values][7][output_calibration_18MV_q3]' class='form_entry_form_values_output_calibration_18MV' id='form_entry_form_values_output_calibration_18MV_q3' /></td></tr>
        <tr><td>M</td><td><input name='form_entry[form_values][8][output_calibration_6MV_M]' id='form_entry_form_values_output_calibration_6MV_M' /></td><td><input name='form_entry[form_values][8][output_calibration_18MV_M]' id='form_entry_form_values_output_calibration_18MV_M' /></td></tr>
        <tr><td>Dw</td><td><input name='form_entry[form_values][9][output_calibration_6MV_Dw]' id='form_entry_form_values_output_calibration_6MV_Dw' /></td><td><input name='form_entry[form_values][9][output_calibration_18MV_Dw]' id='form_entry_form_values_output_calibration_18MV_Dw' /></td></tr>
        <tr><td>%diff</td><td><input name='form_entry[form_values][10][output_calibration_6MV_diff]' id='form_entry_form_values_output_calibration_6MV_diff' /></td><td><input name='form_entry[form_values][10][output_calibration_18MV_diff]' id='form_entry_form_values_output_calibration_18MV_diff' /></td></tr>
      </tbody>
    </table>
    <h3>TPR Check</h3>
    <table class='table table-bordered table-striped'>
      <thead>
        <tr>
          <th>Photon Energy</th>
          <th>6MV</th>
          <th>18MV</th>
        </tr>
      </thead>
      <tbody>
        <tr><td>Q1</td><td><input name='form_entry[form_values][5][tpr_6MV_q1]' class='form_entry_form_values_tpr_6MV' id='form_entry_form_values_tpr_6MV_q1' /></td><td><input name='form_entry[form_values][5][tpr_18MV_q1]' class='form_entry_form_values_tpr_18MV' id='form_entry_form_values_tpr_18MV_q1' /></td></tr>
        <tr><td>Q2</td><td><input name='form_entry[form_values][6][tpr_6MV_q2]' class='form_entry_form_values_tpr_6MV' id='form_entry_form_values_tpr_6MV_q2' /></td><td><input name='form_entry[form_values][6][tpr_18MV_q2]' class='form_entry_form_values_tpr_18MV' id='form_entry_form_values_tpr_18MV_q2' /></td></tr>
        <tr><td>Q3</td><td><input name='form_entry[form_values][7][tpr_6MV_q3]' class='form_entry_form_values_tpr_6MV' id='form_entry_form_values_tpr_6MV_q3' /></td><td><input name='form_entry[form_values][7][tpr_18MV_q3]' class='form_entry_form_values_tpr_18MV' id='form_entry_form_values_tpr_18MV_q3' /></td></tr>
        <tr><td>TPR</td><td><input name='form_entry[form_values][8][tpr_6MV_TPR]' id='form_entry_form_values_tpr_6MV_TPR' /></td><td><input name='form_entry[form_values][8][tpr_18MV_TPR]' id='form_entry_form_values_tpr_18MV_TPR' /></td></tr>
        <tr><td>%diff</td><td><input name='form_entry[form_values][9][tpr_6MV_diff]' id='form_entry_form_values_tpr_6MV_diff' /></td><td><input name='form_entry[form_values][9][tpr_18MV_diff]' id='form_entry_form_values_tpr_18MV_diff' /></td></tr>
      </tbody>
    </table>
    <div class='form-actions'>
      <button type='submit' class='btn btn-primary'>".(($id === false) ? "Create entry" : "Save changes")."</button>
      <button class='btn'>".(($id === false) ? "Go back" : "Discard changes")."</button>
    </div>
  </fieldset>
</form>
";
?>