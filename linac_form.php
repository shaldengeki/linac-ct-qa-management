<?php
  // displays a form to edit form parameters.
  echo "<form action='form_entry.php' method='POST' class='form-horizontal' enctype='multipart/form-data'>
  <fieldset>
".(($id === false) ? "" : "<input type='hidden' name='form_entry[id]' value='".intval($id)."' />");
  if (isset($_REQUEST['form_id'])) {
    echo "<input type='hidden' name='form_entry[form_id]' value='".intval($_REQUEST['form_id'])."' />
";
  } elseif ($id != false) {
    echo "<input type='hidden' name='form_entry[form_id]' value='".intval($formEntryObject['form_id'])."' />
";
  }
  echo "    <div class='control-group'>
      <label class='control-label' for='form_entry[machine_id]'>Machine</label>
      <div class='controls'>
";
  display_machine_dropdown($database, $user, "form_entry[machine_id]", (($id === false) ? 0 : intval($formEntryObject['machine_id'])));
  echo "
      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='form_entry[created_at]'>Inspection Date</label>
      <div class='controls'>
        <input name='form_entry[created_at]' type='text' class='input-xlarge' id='form_entry_created_at'".(($id === false) ? "" : " value='".escape_output($formEntryObject['created_at'])."'").">
      </div>
    </div>
    <div class='row-fluid'>
      <div class='span6'>
        <h3>Measurement parameters</h3>
        <div class='control-group'>
          <label class='control-label' for='form_entry[form_values][temperature]'>Temperature (&deg;C)</label>
          <div class='controls'>
            <input name='form_entry[form_values][temperature]' type='text' class='input-xlarge' id='form_entry_form_values_temperature'".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['temperature'])."'").">
          </div>
        </div>
        <div class='control-group'>
          <label class='control-label' for='form_entry[form_values][pressure]'>Pressure (mmHg)</label>
          <div class='controls'>
            <input name='form_entry[form_values][pressure]' type='text' class='input-xlarge' id='form_entry_form_values_pressure'".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['pressure'])."'").">
          </div>
        </div>
        <div class='control-group'>
          <label class='control-label' for='form_entry[form_values][tpcf]'>TPCF</label>
          <div class='controls'>
            <input name='form_entry[form_values][tpcf]' type='text' class='input-xlarge' id='form_entry_form_values_tpcf'".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['tpcf'])."'").">
          </div>
        </div>
      </div>
      <div class='span6'>
        <h3>Equipment</h3>
        <div class='control-group'>
          <label class='control-label' for='form_entry[form_values][ionization_chamber]'>Ionization Chamber</label>
          <div class='controls'>
    ";
      display_ionization_chamber_dropdown("form_entry_form_values_ionization_chamber", "form_entry[form_values]", (($id === false) ? "" : escape_output($formEntryObject['form_values']['ionization_chamber'])));
      echo "      </div>
        </div>
        <div class='control-group'>
          <label class='control-label' for='form_entry[form_values][electrometer]'>Electrometer</label>
          <div class='controls'>
    ";
      display_electrometer_dropdown("form_entry_form_values_electrometer", "form_entry[form_values]", (($id === false) ? "" : escape_output($formEntryObject['form_values']['electrometer'])));
      echo "      </div>
        </div>
      </div>
    </div>
    <h1>Photon Dosimetry</h1>
    <div class='row-fluid'>
      <div class='span3'>
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
            <tr>
              <td>Q1</td>
              <td><input name='form_entry[form_values][photon_output_calibration_6MV_q1]' class='form_entry_form_values_photon_output_calibration_6MV span12' id='form_entry_form_values_photon_output_calibration_6MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_6MV_q1'])."'")."/></td>
              <td><input name='form_entry[form_values][photon_output_calibration_18MV_q1]' class='form_entry_form_values_photon_output_calibration_18MV span12' id='form_entry_form_values_photon_output_calibration_18MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_18MV_q1'])."'")."/></td>
            </tr>
            <tr>
              <td>Q2</td>
              <td><input name='form_entry[form_values][photon_output_calibration_6MV_q2]' class='form_entry_form_values_photon_output_calibration_6MV span12' id='form_entry_form_values_photon_output_calibration_6MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_6MV_q2'])."'")."/></td>
              <td><input name='form_entry[form_values][photon_output_calibration_18MV_q2]' class='form_entry_form_values_photon_output_calibration_18MV span12' id='form_entry_form_values_photon_output_calibration_18MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_18MV_q2'])."'")."/></td>
            </tr>
            <tr>
              <td>Q3</td>
              <td><input name='form_entry[form_values][photon_output_calibration_6MV_q3]' class='form_entry_form_values_photon_output_calibration_6MV span12' id='form_entry_form_values_photon_output_calibration_6MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_6MV_q3'])."'")."/></td>
              <td><input name='form_entry[form_values][photon_output_calibration_18MV_q3]' class='form_entry_form_values_photon_output_calibration_18MV span12' id='form_entry_form_values_photon_output_calibration_18MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_18MV_q3'])."'")."/></td>
            </tr>
            <tr>
              <td>Avg</td><td><input name='form_entry[form_values][photon_output_calibration_6MV_avg]' class='span12' id='form_entry_form_values_photon_output_calibration_6MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_6MV_avg'])."'")."/></td>
              <td><input name='form_entry[form_values][photon_output_calibration_18MV_avg]' class='span12' id='form_entry_form_values_photon_output_calibration_18MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_18MV_avg'])."'")."/></td>
            </tr>
            <tr>
              <td>M</td>
              <td><input name='form_entry[form_values][photon_output_calibration_6MV_M]' class='span12' id='form_entry_form_values_photon_output_calibration_6MV_M' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_6MV_M'])."'")."/></td>
              <td><input name='form_entry[form_values][photon_output_calibration_18MV_M]' class='span12' id='form_entry_form_values_photon_output_calibration_18MV_M' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_18MV_M'])."'")."/></td>
            </tr>
            <tr>
              <td>Dw</td>
              <td><input name='form_entry[form_values][photon_output_calibration_6MV_Dw]' class='span12' id='form_entry_form_values_photon_output_calibration_6MV_Dw' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_6MV_Dw'])."'")."/></td>
              <td><input name='form_entry[form_values][photon_output_calibration_18MV_Dw]' class='span12' id='form_entry_form_values_photon_output_calibration_18MV_Dw' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_18MV_Dw'])."'")."/></td>
            </tr>
            <tr>
              <td>Dw(abs)</td>
              <td><input name='form_entry[constants][photon_output_calibration_6MV_Dw_abs]' class='span12' id='form_entry_form_values_photon_output_calibration_6MV_Dw_abs' /></td>
              <td><input name='form_entry[constants][photon_output_calibration_18MV_Dw_abs]' class='span12' id='form_entry_form_values_photon_output_calibration_18MV_Dw_abs' /></td>
            </tr>
            <tr>
              <td>%diff</td>
              <td><input name='form_entry[form_values][photon_output_calibration_6MV_diff]' class='span12 form_entry_form_values_photon_output_calibration_diff' id='form_entry_form_values_photon_output_calibration_6MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_6MV_diff'])."'")."/></td>
              <td><input name='form_entry[form_values][photon_output_calibration_18MV_diff]' class='span12 form_entry_form_values_photon_output_calibration_diff' id='form_entry_form_values_photon_output_calibration_18MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_18MV_diff'])."'")."/></td>
            </tr>
          </tbody>
        </table>
        <div id='photon_output_calibration_adjustment' style='display:none;'>
          <h3>Adjusted Output Calibration</h3>
          <table class='table table-bordered table-striped'>
            <thead>
              <tr>
                <th>Photon Energy</th>
                <th>6MV</th>
                <th>18MV</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Q1</td>
                <td><input name='form_entry[form_values][photon_output_calibration_adjusted_6MV_q1]' class='form_entry_form_values_photon_output_calibration_adjusted_6MV span12' id='form_entry_form_values_photon_output_calibration_adjusted_6MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_adjusted_6MV_q1'])."'")."/></td>
                <td><input name='form_entry[form_values][photon_output_calibration_adjusted_18MV_q1]' class='form_entry_form_values_photon_output_calibration_adjusted_18MV span12' id='form_entry_form_values_photon_output_calibration_adjusted_18MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_adjusted_18MV_q1'])."'")."/></td>
              </tr>
              <tr>
                <td>Q2</td>
                <td><input name='form_entry[form_values][photon_output_calibration_adjusted_6MV_q2]' class='form_entry_form_values_photon_output_calibration_adjusted_6MV span12' id='form_entry_form_values_photon_output_calibration_adjusted_6MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_adjusted_6MV_q2'])."'")."/></td>
                <td><input name='form_entry[form_values][photon_output_calibration_adjusted_18MV_q2]' class='form_entry_form_values_photon_output_calibration_adjusted_18MV span12' id='form_entry_form_values_photon_output_calibration_adjusted_18MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_adjusted_18MV_q2'])."'")."/></td>
              </tr>
              <tr>
                <td>Q3</td>
                <td><input name='form_entry[form_values][photon_output_calibration_adjusted_6MV_q3]' class='form_entry_form_values_photon_output_calibration_adjusted_6MV span12' id='form_entry_form_values_photon_output_calibration_adjusted_6MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_adjusted_6MV_q3'])."'")."/></td>
                <td><input name='form_entry[form_values][photon_output_calibration_adjusted_18MV_q3]' class='form_entry_form_values_photon_output_calibration_adjusted_18MV span12' id='form_entry_form_values_photon_output_calibration_adjusted_18MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_adjusted_18MV_q3'])."'")."/></td>
              </tr>
              <tr>
                <td>Avg</td>
                <td><input name='form_entry[form_values][photon_output_calibration_adjusted_6MV_avg]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_6MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_adjusted_6MV_avg'])."'")."/></td>
                <td><input name='form_entry[form_values][photon_output_calibration_adjusted_18MV_avg]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_18MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_adjusted_18MV_avg'])."'")."/></td>
              </tr>
              <tr>
                <td>M</td>
                <td><input name='form_entry[form_values][photon_output_calibration_adjusted_6MV_M]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_6MV_M' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_adjusted_6MV_M'])."'")."/></td>
                <td><input name='form_entry[form_values][photon_output_calibration_adjusted_18MV_M]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_18MV_M' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_adjusted_18MV_M'])."'")."/></td>
              </tr>
              <tr>
                <td>Dw</td>
                <td><input name='form_entry[form_values][photon_output_calibration_adjusted_6MV_Dw]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_6MV_Dw' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_adjusted_6MV_Dw'])."'")."/></td>
                <td><input name='form_entry[form_values][photon_output_calibration_adjusted_18MV_Dw]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_18MV_Dw' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_adjusted_18MV_Dw'])."'")."/></td>
              </tr>
              <tr>
                <td>Dw(abs)</td>
                <td><input name='form_entry[constants][photon_output_calibration_adjusted_6MV_Dw_abs]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_6MV_Dw_abs' /></td>
                <td><input name='form_entry[constants][photon_output_calibration_adjusted_18MV_Dw_abs]' class='span12' id='form_entry_form_values_photon_output_calibration_adjusted_18MV_Dw_abs' /></td>
              </tr>
              <tr>
                <td>%diff</td>
                <td><input name='form_entry[form_values][photon_output_calibration_adjusted_6MV_diff]' class='span12 form_entry_form_values_photon_output_calibration_adjusted_diff' id='form_entry_form_values_photon_output_calibration_adjusted_6MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_adjusted_6MV_diff'])."'")."/></td>
                <td><input name='form_entry[form_values][photon_output_calibration_adjusted_18MV_diff]' class='span12 form_entry_form_values_photon_output_calibration_adjusted_diff' id='form_entry_form_values_photon_output_calibration_adjusted_18MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['photon_output_calibration_adjusted_18MV_diff'])."'")."/></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class='span3'>
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
            <tr>
              <td>Q1</td>
              <td><input name='form_entry[form_values][tpr_6MV_q1]' class='form_entry_form_values_tpr_6MV span12' id='form_entry_form_values_tpr_6MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['tpr_6MV_q1'])."'")."/></td>
              <td><input name='form_entry[form_values][tpr_18MV_q1]' class='form_entry_form_values_tpr_18MV span12' id='form_entry_form_values_tpr_18MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['tpr_18MV_q1'])."'")."/></td>
            </tr>
            <tr>
              <td>Q2</td>
              <td><input name='form_entry[form_values][tpr_6MV_q2]' class='form_entry_form_values_tpr_6MV span12' id='form_entry_form_values_tpr_6MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['tpr_6MV_q2'])."'")."/></td>
              <td><input name='form_entry[form_values][tpr_18MV_q2]' class='form_entry_form_values_tpr_18MV span12' id='form_entry_form_values_tpr_18MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['tpr_18MV_q2'])."'")."/></td>
            </tr>
            <tr>
              <td>Q3</td>
              <td><input name='form_entry[form_values][tpr_6MV_q3]' class='form_entry_form_values_tpr_6MV span12' id='form_entry_form_values_tpr_6MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['tpr_6MV_q3'])."'")."/></td>
              <td><input name='form_entry[form_values][tpr_18MV_q3]' class='form_entry_form_values_tpr_18MV span12' id='form_entry_form_values_tpr_18MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['tpr_18MV_q3'])."'")."/></td>
            </tr>
            <tr>
              <td>Avg</td>
              <td><input name='form_entry[form_values][tpr_6MV_avg]' class='span12' id='form_entry_form_values_tpr_6MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['tpr_6MV_avg'])."'")."/></td>
              <td><input name='form_entry[form_values][tpr_18MV_avg]' class='span12' id='form_entry_form_values_tpr_18MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['tpr_18MV_avg'])."'")."/></td>
            </tr>
            <tr>
              <td>TPR</td>
              <td><input name='form_entry[form_values][tpr_6MV_TPR]' class='span12' id='form_entry_form_values_tpr_6MV_TPR' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['tpr_6MV_TPR'])."'")."/></td>
              <td><input name='form_entry[form_values][tpr_18MV_TPR]' class='span12' id='form_entry_form_values_tpr_18MV_TPR' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['tpr_18MV_TPR'])."'")."/></td>
            </tr>
            <tr>
              <td>TPR(ref)</td>
              <td><input name='form_entry[constants][tpr_6MV_TPR_abs]' class='span12' id='form_entry_form_values_tpr_6MV_TPR_abs' /></td>
              <td><input name='form_entry[constants][tpr_18MV_TPR_abs]' class='span12' id='form_entry_form_values_tpr_18MV_TPR_abs' /></td>
            </tr>
            <tr>
              <td>%diff</td>
              <td><input name='form_entry[form_values][tpr_6MV_diff]' class='span12' id='form_entry_form_values_tpr_6MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['tpr_6MV_diff'])."'")."/></td>
              <td><input name='form_entry[form_values][tpr_18MV_diff]' class='span12' id='form_entry_form_values_tpr_18MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['tpr_18V_diff'])."'")."/></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class='span3'>
        <h3>Gating</h3>
        <table class='table table-bordered table-striped'>
          <thead>
            <tr>
              <th>Photon Energy</th>
              <th>6MV</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Q1</td>
              <td><input name='form_entry[form_values][gating_6MV_q1]' class='form_entry_form_values_gating_6MV span12' id='form_entry_form_values_gating_6MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['gating_6MV_q1'])."'")."/></td>
            </tr>
            <tr>
              <td>Q2</td>
              <td><input name='form_entry[form_values][gating_6MV_q2]' class='form_entry_form_values_gating_6MV span12' id='form_entry_form_values_gating_6MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['gating_6MV_q2'])."'")."/></td>
            </tr>
            <tr>
              <td>Q3</td>
              <td><input name='form_entry[form_values][gating_6MV_q3]' class='form_entry_form_values_gating_6MV span12' id='form_entry_form_values_gating_6MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['gating_6MV_q3'])."'")."/></td>
            </tr>
            <tr>
              <td>Avg</td>
              <td><input name='form_entry[form_values][gating_6MV_avg]' id='form_entry_form_values_gating_6MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['gating_6MV_avg'])."'")."/></td>
            </tr>
            <tr>
              <td>TPR</td>
              <td><input name='form_entry[form_values][gating_6MV_TPR]' class='span12' id='form_entry_form_values_gating_6MV_TPR' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['gating_6MV_TPR'])."'")."/></td>
            </tr>
            <tr>
              <td>TPR(ref)</td>
              <td><input name='form_entry[constants][gating_6MV_TPR_abs]' class='span12' id='form_entry_form_values_gating_6MV_TPR_abs' /></td>
            </tr>
            <tr>
              <td>%diff</td>
              <td><input name='form_entry[form_values][gating_6MV_diff]' class='span12' id='form_entry_form_values_gating_6MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['gating_6MV_diff'])."'")."/></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class='span3'>
        <h3>EDW</h3>
        <table class='table table-bordered table-striped'>
          <thead>
            <tr>
              <th>Photon Energy</th>
              <th>6MV</th>
              <th>18MV</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Q1</td>
              <td><input name='form_entry[form_values][edw_6MV_q1]' class='form_entry_form_values_edw_6MV span12' id='form_entry_form_values_edw_6MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['edw_6MV_q1'])."'")."/></td>
              <td><input name='form_entry[form_values][edw_18MV_q1]' class='form_entry_form_values_edw_18MV span12' id='form_entry_form_values_edw_18MV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['edw_18MV_q1'])."'")."/></td>
            </tr>
            <tr>
              <td>Q2</td>
              <td><input name='form_entry[form_values][edw_6MV_q2]' class='form_entry_form_values_edw_6MV span12' id='form_entry_form_values_edw_6MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['edw_6MV_q2'])."'")."/></td>
              <td><input name='form_entry[form_values][edw_18MV_q2]' class='form_entry_form_values_edw_18MV span12' id='form_entry_form_values_edw_18MV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['edw_18MV_q2'])."'")."/></td>
            </tr>
            <tr>
              <td>Q3</td>
              <td><input name='form_entry[form_values][edw_6MV_q3]' class='form_entry_form_values_edw_6MV span12' id='form_entry_form_values_edw_6MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['edw_6MV_q3'])."'")."/></td>
              <td><input name='form_entry[form_values][edw_18MV_q3]' class='form_entry_form_values_edw_18MV span12' id='form_entry_form_values_edw_18MV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['edw_18MV_q3'])."'")."/></td>
            </tr>
            <tr>
              <td>Avg</td>
              <td><input name='form_entry[form_values][edw_6MV_avg]' class='span12' id='form_entry_form_values_edw_6MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['edw_6MV_avg'])."'")."/></td>
              <td><input name='form_entry[form_values][edw_18MV_avg]' class='span12' id='form_entry_form_values_edw_18MV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['edw_18MV_avg'])."'")."/></td>
            </tr>
            <tr>
              <td>WF</td>
              <td><input name='form_entry[form_values][edw_6MV_WF]' class='span12' id='form_entry_form_values_edw_6MV_WF' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['edw_6MV_WF'])."'")."/></td>
              <td><input name='form_entry[form_values][edw_18MV_WF]' class='span12' id='form_entry_form_values_edw_18MV_WF' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['edw_18MV_WF'])."'")."/></td>
            </tr>
            <tr>
              <td>WF(ref)</td>
              <td><input name='form_entry[constants][edw_6MV_WF_abs]' class='span12' id='form_entry_form_values_edw_6MV_WF_abs' /></td>
              <td><input name='form_entry[constants][edw_18MV_WF_abs]' class='span12' id='form_entry_form_values_edw_18MV_WF_abs' /></td>
            </tr>
            <tr>
              <td>%diff</td>
              <td><input name='form_entry[form_values][edw_6MV_diff]' class='span12' id='form_entry_form_values_edw_6MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['edw_6MV_diff'])."'")."/></td>
              <td><input name='form_entry[form_values][edw_18MV_diff]' class='span12' id='form_entry_form_values_edw_18MV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['edw_18MV_diff'])."'")."/></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <h1>Electron Dosimetry</h1>
    <div class='row-fluid'>
      <div class='span6'>
        <h3>Output Calibration</h3>
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
              <td>Q1</td>
              <td><input name='form_entry[form_values][electron_output_calibration_6MeV_q1]' class='form_entry_form_values_electron_output_calibration_6MeV span12' id='form_entry_form_values_electron_output_calibration_6MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_6MeV_q1'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_9MeV_q1]' class='form_entry_form_values_electron_output_calibration_9MeV span12' id='form_entry_form_values_electron_output_calibration_9MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_9MeV_q1'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_12MeV_q1]' class='form_entry_form_values_electron_output_calibration_12MeV span12' id='form_entry_form_values_electron_output_calibration_12MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_12MeV_q1'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_16MeV_q1]' class='form_entry_form_values_electron_output_calibration_16MeV span12' id='form_entry_form_values_electron_output_calibration_16MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_16MeV_q1'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_20MeV_q1]' class='form_entry_form_values_electron_output_calibration_20MeV span12' id='form_entry_form_values_electron_output_calibration_20MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_20MeV_q1'])."'")."/></td>
            </tr>
            <tr>
              <td>Q2</td>
              <td><input name='form_entry[form_values][electron_output_calibration_6MeV_q2]' class='form_entry_form_values_electron_output_calibration_6MeV span12' id='form_entry_form_values_electron_output_calibration_6MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_6MeV_q2'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_9MeV_q2]' class='form_entry_form_values_electron_output_calibration_9MeV span12' id='form_entry_form_values_electron_output_calibration_9MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_9MeV_q2'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_12MeV_q2]' class='form_entry_form_values_electron_output_calibration_12MeV span12' id='form_entry_form_values_electron_output_calibration_12MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_12MeV_q2'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_16MeV_q2]' class='form_entry_form_values_electron_output_calibration_16MeV span12' id='form_entry_form_values_electron_output_calibration_16MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_16MeV_q2'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_20MeV_q2]' class='form_entry_form_values_electron_output_calibration_20MeV span12' id='form_entry_form_values_electron_output_calibration_20MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_20MeV_q2'])."'")."/></td>
            </tr>
            <tr>
              <td>Q3</td>
              <td><input name='form_entry[form_values][electron_output_calibration_6MeV_q3]' class='form_entry_form_values_electron_output_calibration_6MeV span12' id='form_entry_form_values_electron_output_calibration_6MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_6MeV_q3'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_9MeV_q3]' class='form_entry_form_values_electron_output_calibration_9MeV span12' id='form_entry_form_values_electron_output_calibration_9MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_9MeV_q3'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_12MeV_q3]' class='form_entry_form_values_electron_output_calibration_12MeV span12' id='form_entry_form_values_electron_output_calibration_12MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_12MeV_q3'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_16MeV_q3]' class='form_entry_form_values_electron_output_calibration_16MeV span12' id='form_entry_form_values_electron_output_calibration_16MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_16MeV_q3'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_20MeV_q3]' class='form_entry_form_values_electron_output_calibration_20MeV span12' id='form_entry_form_values_electron_output_calibration_20MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_20MeV_q3'])."'")."/></td>
            </tr>
            <tr>
              <td>Avg</td>
              <td><input name='form_entry[form_values][electron_output_calibration_6MeV_avg]' class='span12' id='form_entry_form_values_electron_output_calibration_6MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_6MeV_avg'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_9MeV_avg]' class='span12' id='form_entry_form_values_electron_output_calibration_9MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_9MeV_avg'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_12MeV_avg]' class='span12' id='form_entry_form_values_electron_output_calibration_12MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_12MeV_avg'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_16MeV_avg]' class='span12' id='form_entry_form_values_electron_output_calibration_16MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_16MeV_avg'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_20MeV_avg]' class='span12' id='form_entry_form_values_electron_output_calibration_20MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_20MeV_avg'])."'")."/></td>
            </tr>
            <tr>
              <td>M</td>
              <td><input name='form_entry[form_values][electron_output_calibration_6MeV_M]' class='span12' id='form_entry_form_values_electron_output_calibration_6MeV_M' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_6MeV_M'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_9MeV_M]' class='span12' id='form_entry_form_values_electron_output_calibration_9MeV_M' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_9MeV_M'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_12MeV_M]' class='span12' id='form_entry_form_values_electron_output_calibration_12MeV_M' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_12MeV_M'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_16MeV_M]' class='span12' id='form_entry_form_values_electron_output_calibration_16MeV_M' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_16MeV_M'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_20MeV_M]' class='span12' id='form_entry_form_values_electron_output_calibration_20MeV_M' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_20MeV_M'])."'")."/></td>
            </tr>
            <tr>
              <td>Mc</td>
              <td><input name='form_entry[constants][electron_output_calibration_6MeV_Mc]' class='span12' id='form_entry_form_values_electron_output_calibration_6MeV_Mc' /></td>
              <td><input name='form_entry[constants][electron_output_calibration_9MeV_Mc]' class='span12' id='form_entry_form_values_electron_output_calibration_9MeV_Mc' /></td>
              <td><input name='form_entry[constants][electron_output_calibration_12MeV_Mc]' class='span12' id='form_entry_form_values_electron_output_calibration_12MeV_Mc' /></td>
              <td><input name='form_entry[constants][electron_output_calibration_16MeV_Mc]' class='span12' id='form_entry_form_values_electron_output_calibration_16MeV_Mc' /></td>
              <td><input name='form_entry[constants][electron_output_calibration_20MeV_Mc]' class='span12' id='form_entry_form_values_electron_output_calibration_20MeV_Mc' /></td>
            </tr>
            <tr>
              <td>%diff</td>
              <td><input name='form_entry[form_values][electron_output_calibration_6MeV_diff]' class='span12 form_entry_form_values_electron_output_calibration_diff' id='form_entry_form_values_electron_output_calibration_6MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_6MeV_diff'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_9MeV_diff]' class='span12 form_entry_form_values_electron_output_calibration_diff' id='form_entry_form_values_electron_output_calibration_9MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_9MeV_diff'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_12MeV_diff]' class='span12 form_entry_form_values_electron_output_calibration_diff' id='form_entry_form_values_electron_output_calibration_12MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_12MeV_diff'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_16MeV_diff]' class='span12 form_entry_form_values_electron_output_calibration_diff' id='form_entry_form_values_electron_output_calibration_16MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_16MeV_diff'])."'")."/></td>
              <td><input name='form_entry[form_values][electron_output_calibration_20MeV_diff]' class='span12 form_entry_form_values_electron_output_calibration_diff' id='form_entry_form_values_electron_output_calibration_20MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_20MeV_diff'])."'")."/></td>
            </tr>
          </tbody>
        </table>
        <div id='electron_output_calibration_adjustment' style='display:none;'>
          <h3>Adjusted Output Calibration</h3>
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
                <td>Q1</td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_6MeV_q1]' class='form_entry_form_values_electron_output_calibration_adjusted_6MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_6MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_6MeV_q1'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_9MeV_q1]' class='form_entry_form_values_electron_output_calibration_adjusted_9MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_9MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_9MeV_q1'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_12MeV_q1]' class='form_entry_form_values_electron_output_calibration_adjusted_12MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_12MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_12MeV_q1'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_16MeV_q1]' class='form_entry_form_values_electron_output_calibration_adjusted_16MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_16MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_16MeV_q1'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_20MeV_q1]' class='form_entry_form_values_electron_output_calibration_adjusted_20MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_20MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_20MeV_q1'])."'")."/></td>
              </tr>
              <tr>
                <td>Q2</td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_6MeV_q2]' class='form_entry_form_values_electron_output_calibration_adjusted_6MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_6MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_6MeV_q2'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_9MeV_q2]' class='form_entry_form_values_electron_output_calibration_adjusted_9MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_9MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_9MeV_q2'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_12MeV_q2]' class='form_entry_form_values_electron_output_calibration_adjusted_12MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_12MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_12MeV_q2'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_16MeV_q2]' class='form_entry_form_values_electron_output_calibration_adjusted_16MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_16MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_16MeV_q2'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_20MeV_q2]' class='form_entry_form_values_electron_output_calibration_adjusted_20MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_20MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_20MeV_q2'])."'")."/></td>
              </tr>
              <tr>
                <td>Q3</td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_6MeV_q3]' class='form_entry_form_values_electron_output_calibration_adjusted_6MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_6MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_6MeV_q3'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_9MeV_q3]' class='form_entry_form_values_electron_output_calibration_adjusted_9MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_9MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_9MeV_q3'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_12MeV_q3]' class='form_entry_form_values_electron_output_calibration_adjusted_12MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_12MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_12MeV_q3'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_16MeV_q3]' class='form_entry_form_values_electron_output_calibration_adjusted_16MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_16MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_16MeV_q3'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_20MeV_q3]' class='form_entry_form_values_electron_output_calibration_adjusted_20MeV span12' id='form_entry_form_values_electron_output_calibration_adjusted_20MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_20MeV_q3'])."'")."/></td>
              </tr>
              <tr>
                <td>Avg</td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_6MeV_avg]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_6MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_6MeV_avg'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_9MeV_avg]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_9MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_9MeV_avg'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_12MeV_avg]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_12MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_12MeV_avg'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_16MeV_avg]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_16MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_16MeV_avg'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_20MeV_avg]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_20MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_20MeV_avg'])."'")."/></td>
              </tr>
              <tr>
                <td>M</td>
                <td><input name='form_entry[form_values][electron_output_calibration_6eMeV_adjusted_M]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_6MeV_M' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_6MeV_M'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_9MeV_M]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_9MeV_M' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_9MeV_M'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_12MeV_M]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_12MeV_M' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_12MeV_M'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_16MeV_M]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_16MeV_M' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_16MeV_M'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_20MeV_M]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_20MeV_M' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_20MeV_M'])."'")."/></td>
              </tr>
              <tr>
                <td>Mc</td>
                <td><input name='form_entry[constants][electron_output_calibration_adjusted_6MeV_Mc]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_6MeV_Mc' /></td>
                <td><input name='form_entry[constants][electron_output_calibration_adjusted_9MeV_Mc]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_9MeV_Mc' /></td>
                <td><input name='form_entry[constants][electron_output_calibration_adjusted_12MeV_Mc]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_12MeV_Mc' /></td>
                <td><input name='form_entry[constants][electron_output_calibration_adjusted_16MeV_Mc]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_16MeV_Mc' /></td>
                <td><input name='form_entry[constants][electron_output_calibration_adjusted_20MeV_Mc]' class='span12' id='form_entry_form_values_electron_output_calibration_adjusted_20MeV_Mc' /></td>
              </tr>
              <tr>
                <td>%diff</td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_6MeV_diff]' class='span12 form_entry_form_values_electron_output_calibration_adjusted_diff' id='form_entry_form_values_electron_output_calibration_adjusted_6MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_6MeV_diff'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_9MeV_diff]' class='span12 form_entry_form_values_electron_output_calibration_adjusted_diff' id='form_entry_form_values_electron_output_calibration_adjusted_9MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_9MeV_diff'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_12MeV_diff]' class='span12 form_entry_form_values_electron_output_calibration_adjusted_diff' id='form_entry_form_values_electron_output_calibration_adjusted_12MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_12MeV_diff'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_16MeV_diff]' class='span12 form_entry_form_values_electron_output_calibration_adjusted_diff' id='form_entry_form_values_electron_output_calibration_adjusted_16MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_16MeV_diff'])."'")."/></td>
                <td><input name='form_entry[form_values][electron_output_calibration_adjusted_20MeV_diff]' class='span12 form_entry_form_values_electron_output_calibration_adjusted_diff' id='form_entry_form_values_electron_output_calibration_adjusted_20MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['electron_output_calibration_adjusted_20MeV_diff'])."'")."/></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class='span6'>
        <h3>Energy Ratio Check</h3>
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
              <td>Q1</td>
              <td><input name='form_entry[form_values][energy_ratio_6MeV_q1]' class='form_entry_form_values_energy_ratio_6MeV span12' id='form_entry_form_values_energy_ratio_6MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_6MeV_q1'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_9MeV_q1]' class='form_entry_form_values_energy_ratio_9MeV span12' id='form_entry_form_values_energy_ratio_9MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_9MeV_q1'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_12MeV_q1]' class='form_entry_form_values_energy_ratio_12MeV span12' id='form_entry_form_values_energy_ratio_12MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_12MeV_q1'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_16MeV_q1]' class='form_entry_form_values_energy_ratio_16MeV span12' id='form_entry_form_values_energy_ratio_16MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_16MeV_q1'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_20MeV_q1]' class='form_entry_form_values_energy_ratio_20MeV span12' id='form_entry_form_values_energy_ratio_20MeV_q1' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_20MeV_q1'])."'")."/></td>
            </tr>
            <tr>
              <td>Q2</td>
              <td><input name='form_entry[form_values][energy_ratio_6MeV_q2]' class='form_entry_form_values_energy_ratio_6MeV span12' id='form_entry_form_values_energy_ratio_6MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_6MeV_q2'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_9MeV_q2]' class='form_entry_form_values_energy_ratio_9MeV span12' id='form_entry_form_values_energy_ratio_9MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_9MeV_q2'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_12MeV_q2]' class='form_entry_form_values_energy_ratio_12MeV span12' id='form_entry_form_values_energy_ratio_12MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_12MeV_q2'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_16MeV_q2]' class='form_entry_form_values_energy_ratio_16MeV span12' id='form_entry_form_values_energy_ratio_16MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_16MeV_q2'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_20MeV_q2]' class='form_entry_form_values_energy_ratio_20MeV span12' id='form_entry_form_values_energy_ratio_20MeV_q2' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_20MeV_q2'])."'")."/></td>
            </tr>
            <tr>
              <td>Q3</td>
              <td><input name='form_entry[form_values][energy_ratio_6MeV_q3]' class='form_entry_form_values_energy_ratio_6MeV span12' id='form_entry_form_values_energy_ratio_6MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_6MeV_q3'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_9MeV_q3]' class='form_entry_form_values_energy_ratio_9MeV span12' id='form_entry_form_values_energy_ratio_9MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_9MeV_q3'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_12MeV_q3]' class='form_entry_form_values_energy_ratio_12MeV span12' id='form_entry_form_values_energy_ratio_12MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_12MeV_q3'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_16MeV_q3]' class='form_entry_form_values_energy_ratio_16MeV span12' id='form_entry_form_values_energy_ratio_16MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_16MeV_q3'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_20MeV_q3]' class='form_entry_form_values_energy_ratio_20MeV span12' id='form_entry_form_values_energy_ratio_20MeV_q3' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_20MeV_q3'])."'")."/></td>
            </tr>
            <tr>
              <td>Avg</td>
              <td><input name='form_entry[form_values][energy_ratio_6MeV_avg]' class='span12' id='form_entry_form_values_energy_ratio_6MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_6MeV_avg'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_9MeV_avg]' class='span12' id='form_entry_form_values_energy_ratio_9MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_9MeV_avg'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_12MeV_avg]' class='span12' id='form_entry_form_values_energy_ratio_12MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_12MeV_avg'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_16MeV_avg]' class='span12' id='form_entry_form_values_energy_ratio_16MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_16MeV_avg'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_20MeV_avg]' class='span12' id='form_entry_form_values_energy_ratio_20MeV_avg' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_20MeV_avg'])."'")."/></td>
            </tr>
              <td>PDD</td>
              <td><input name='form_entry[form_values][energy_ratio_6eMV_PDD]' class='span12' id='form_entry_form_values_energy_ratio_6MeV_PDD' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_6MeV_PDD'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_9MeV_PDD]' class='span12' id='form_entry_form_values_energy_ratio_9MeV_PDD' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_9MeV_PDD'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_12MeV_PDD]' class='span12' id='form_entry_form_values_energy_ratio_12MeV_PDD' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_12MeV_PDD'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_16MeV_PDD]' class='span12' id='form_entry_form_values_energy_ratio_16MeV_PDD' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_16MeV_PDD'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_20MeV_PDD]' class='span12' id='form_entry_form_values_energy_ratio_20MeV_PDD' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_20MeV_PDD'])."'")."/></td>
            </tr>
              <td>PDD(ref)</td>
              <td><input name='form_entry[constants][energy_ratio_6MeV_PDD_abs]' class='span12' id='form_entry_form_values_energy_ratio_6MeV_PDD_abs' /></td>
              <td><input name='form_entry[constants][energy_ratio_9MeV_PDD_abs]' class='span12' id='form_entry_form_values_energy_ratio_9MeV_PDD_abs' /></td>
              <td><input name='form_entry[constants][energy_ratio_12MeV_PDD_abs]' class='span12' id='form_entry_form_values_energy_ratio_12MeV_PDD_abs' /></td>
              <td><input name='form_entry[constants][energy_ratio_16MeV_PDD_abs]' class='span12' id='form_entry_form_values_energy_ratio_16MeV_PDD_abs' /></td>
              <td><input name='form_entry[constants][energy_ratio_20MeV_PDD_abs]' class='span12' id='form_entry_form_values_energy_ratio_20MeV_PDD_abs' /></td>
            </tr>
            <tr>
              <td>%diff</td>
              <td><input name='form_entry[form_values][energy_ratio_6MeV_diff]' class='span12' id='form_entry_form_values_energy_ratio_6MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_6MeV_diff'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_9MeV_diff]' class='span12' id='form_entry_form_values_energy_ratio_9MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_9MeV_diff'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_12MeV_diff]' class='span12' id='form_entry_form_values_energy_ratio_12MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_12MeV_diff'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_16MeV_diff]' class='span12' id='form_entry_form_values_energy_ratio_16MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_16MeV_diff'])."'")."/></td>
              <td><input name='form_entry[form_values][energy_ratio_20MeV_diff]' class='span12' id='form_entry_form_values_energy_ratio_20MeV_diff' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['energy_ratio_20MeV_diff'])."'")."/></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <h1>Mechanical QA</h1>
    <div class='row-fluid'>
      <div class='span3'>
        <h3>Laser position</h3>
        <table class='table table-bordered table-striped'>
          <thead>
            <tr>
              <th>Position</th>
              <th>Distance from IC (mm)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>L Wall Vertical</td>
              <td><input name='form_entry[form_values][laser_l_wall_vertical]' id='form_entry_form_values_laser_l_wall_vertical' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['laser_l_wall_vertical'])."'")."/></td>
            </tr>
            <tr>
              <td>R Wall Vertical</td>
              <td><input name='form_entry[form_values][laser_r_wall_vertical]' id='form_entry_form_values_laser_r_wall_vertical' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['laser_r_wall_vertical'])."'")."/></td>
            </tr>
            <tr>
              <td>L Wall Horizontal</td>
              <td><input name='form_entry[form_values][laser_l_wall_horizontal]' id='form_entry_form_values_laser_l_wall_horizontal' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['laser_l_wall_horizontal'])."'")."/></td>
            </tr>
            <tr>
              <td>R Wall Horizontal</td>
              <td><input name='form_entry[form_values][laser_r_wall_horizontal]' id='form_entry_form_values_laser_laser_r_wall_horizontal' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['laser_r_wall_horizontal'])."'")."/></td>
            </tr>
            <tr>
              <td>Sagittal</td>
              <td><input name='form_entry[form_values][laser_sagittal]' id='form_entry_form_values_laser_sagittal' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['laser_sagittal'])."'")."/></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class='span2'>
        <h3>ODI vs Light Field Isocenter</h3>
        <table class='table table-bordered table-striped'>
          <thead>
            <tr>
              <th>Gantry Angle</th>
              <th>IC ODI Reading</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>0</td>
              <td><input name='form_entry[form_values][odi_vs_light_reading_0]' class='span12' id='form_entry_form_values_odi_vs_light_reading_0' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['odi_vs_light_reading_0'])."'")."/></td>
            </tr>
            <tr>
              <td>90</td>
              <td><input name='form_entry[form_values][odi_vs_light_reading_90]' class='span12' id='form_entry_form_values_odi_vs_light_reading_90' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['odi_vs_light_reading_90'])."'")."/></td>
            </tr>
            <tr>
              <td>270</td>
              <td><input name='form_entry[form_values][odi_vs_light_reading_270]' class='span12' id='form_entry_form_values_odi_vs_light_reading_270' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['odi_vs_light_reading_270'])."'")."/></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class='span2'>
        <h3>Centering of Light Field Cross-Hair</h3>
        <table class='table table-bordered table-striped'>
          <thead>
            <tr>
              <th>Gantry Angle</th>
              <th>Distance from IC (mm)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>0</td>
              <td><input name='form_entry[form_values][light_centering_distance_0]' class='span12' id='form_entry_form_values_light_centering_distance_0' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['light_centering_distance_0'])."'")."/></td>
            </tr>
            <tr>
              <td>90</td>
              <td><input name='form_entry[form_values][light_centering_distance_90]' class='span12' id='form_entry_form_values_light_centering_distance_90' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['light_centering_distance_90'])."'")."/></td>
            </tr>
            <tr>
              <td>270</td>
              <td><input name='form_entry[form_values][light_centering_distance_270]' class='span12' id='form_entry_form_values_light_centering_distance_270' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['light_centering_distance_270'])."'")."/></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class='span3'>
        <h3>Device Angles vs Readout</h3>
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
              <td>0</td>
              <td><input name='form_entry[form_values][gantry_angle_readout_0]' class='span12' id='form_entry_form_values_gantry_angle_readout_0' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['gantry_angle_readout_0'])."'")."/></td>
            </tr>
            <tr>
              <td>Gantry</td>
              <td>90</td>
              <td><input name='form_entry[form_values][gantry_angle_readout_90]' class='span12' id='form_entry_form_values_gantry_angle_readout_90' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['gantry_angle_readout_90'])."'")."/></td>
            </tr>
            <tr>
              <td>Gantry</td>
              <td>270</td>
              <td><input name='form_entry[form_values][gantry_angle_readout_270]' class='span12' id='form_entry_form_values_gantry_angle_readout_270' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['gantry_angle_readout_270'])."'")."/></td>
            </tr>
            <tr>
              <td>Collimator</td>
              <td>0</td>
              <td><input name='form_entry[form_values][collimator_angle_readout_0]' class='span12' id='form_entry_form_values_collimator_angle_readout_0' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['collimator_angle_readout_0'])."'")."/></td>
            </tr>
            <tr>
              <td>Collimator</td>
              <td>90</td>
              <td><input name='form_entry[form_values][collimator_angle_readout_90]' class='span12' id='form_entry_form_values_collimator_angle_readout_90' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['collimator_angle_readout_90'])."'")."/></td>
            </tr>
            <tr>
              <td>Collimator</td>
              <td>270</td>
              <td><input name='form_entry[form_values][collimator_angle_readout_270]' class='span12' id='form_entry_form_values_collimator_angle_readout_270' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['collimator_angle_readout_270'])."'")."/></td>
            </tr>
            <tr>
              <td>PSA</td>
              <td>0</td>
              <td><input name='form_entry[form_values][psa_position_0]' class='span12' id='form_entry_form_values_psa_position_0' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['psa_position_0'])."'")."/></td>
            </tr>
            <tr>
              <td>PSA</td>
              <td>90</td>
              <td><input name='form_entry[form_values][psa_position_90]' class='span12' id='form_entry_form_values_psa_position_90' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['psa_position_90'])."'")."/></td>
            </tr>
            <tr>
              <td>PSA</td>
              <td>270</td>
              <td><input name='form_entry[form_values][psa_position_270]' class='span12' id='form_entry_form_values_psa_position_270' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['psa_position_270'])."'")."/></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class='span2'>
        <h3>Optical Field Size vs Digital Readout</h3>
        <table class='table table-bordered table-striped'>
          <thead>
            <tr>
              <th>Digital</th>
              <th></th>
              <th>Measured Field Size</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>x=5.0cm</td>
              <td>x1</td>
              <td><input name='form_entry[form_values][optical_field_x1_x5]' class='span12' id='form_entry_form_values_optical_field_x1_x5' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['optical_field_x1_x5'])."'")."/></td>
            </tr>
            <tr>
              <td></td>
              <td>x2</td>
              <td><input name='form_entry[form_values][optical_field_x2_x5]' class='span12' id='form_entry_form_values_optical_field_x2_x5' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['optical_field_x2_x5'])."'")."/></td>
            </tr>
            <tr>
              <td>x=10.0cm</td>
              <td>x1</td>
              <td><input name='form_entry[form_values][optical_field_x1_x10]' class='span12' id='form_entry_form_values_optical_field_x1_x10' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['optical_field_x1_x10'])."'")."/></td>
            </tr>
            <tr>
              <td></td>
              <td>x2</td>
              <td><input name='form_entry[form_values][optical_field_x2_x10]' class='span12' id='form_entry_form_values_optical_field_x2_x10' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['optical_field_x2_x10'])."'")."/></td>
            </tr>
            <tr>
              <td>x=20.0cm</td>
              <td>x1</td>
              <td><input name='form_entry[form_values][optical_field_x1_x20]' class='span12' id='form_entry_form_values_optical_field_x1_x20' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['optical_field_x1_x20'])."'")."/></td>
            </tr>
            <tr>
              <td></td>
              <td>x2</td>
              <td><input name='form_entry[form_values][optical_field_x2_x20]' class='span12' id='form_entry_form_values_optical_field_x2_x20' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['optical_field_x2_x20'])."'")."/></td>
            </tr>
            <tr>
              <td>y=5.0cm</td>
              <td>y1</td>
              <td><input name='form_entry[form_values][optical_field_y1_y5]' class='span12' id='form_entry_form_values_optical_field_y1_y5' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['optical_field_y1_y5'])."'")."/></td>
            </tr>
            <tr>
              <td></td>
              <td>y2</td>
              <td><input name='form_entry[form_values][optical_field_y2_y5]' class='span12' id='form_entry_form_values_optical_field_y2_y5' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['optical_field_y2_y5'])."'")."/></td>
            </tr>
            <tr>
              <td>y=10.0cm</td>
              <td>y1</td>
              <td><input name='form_entry[form_values][optical_field_y1_y10]' class='span12' id='form_entry_form_values_optical_field_y1_y10' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['optical_field_y1_y10'])."'")."/></td>
            </tr>
            <tr>
              <td></td>
              <td>y2</td>
              <td><input name='form_entry[form_values][optical_field_y2_y10]' class='span12' id='form_entry_form_values_optical_field_y2_y10' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['optical_field_y2_y10'])."'")."/></td>
            </tr>
            <tr>
              <td>y=20.0cm</td>
              <td>y1</td>
              <td><input name='form_entry[form_values][optical_field_y1_y20]' class='span12' id='form_entry_form_values_optical_field_y1_y20' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['optical_field_y1_y20'])."'")."/></td>
            </tr>
            <tr>
              <td></td>
              <td>y2</td>
              <td><input name='form_entry[form_values][optical_field_y2_y20]' class='span12' id='form_entry_form_values_optical_field_y2_y20' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['optical_field_y2_y20'])."'")."/></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class='row-fluid'>
      <div class='span3'>
        <h3>Door and Key Interlock</h3>
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
              <td><select id='form_entry_form_values_door_key_interlock_door_status' name='form_entry[form_values][door_key_interlock_door_status]'>
                    <option value='NULL'".(($id != false && $formEntryObject['form_values']['door_key_interlock_door_status'] == 'NULL') ? " selected='selected'" : "")."></option>
                    <option value='OK'".(($id != false && $formEntryObject['form_values']['door_key_interlock_door_status'] == 'OK') ? " selected='selected'" : "").">OK</option>
                    <option value='NOT OK'".(($id != false && $formEntryObject['form_values']['door_key_interlock_door_status'] == 'NOT OK') ? " selected='selected'" : "").">NOT OK</option>
                  </select></td>
            </tr>
            <tr>
              <td>Key</td>
              <td><select id='form_entry_form_values_door_key_interlock_key_status' name='form_entry[form_values][door_key_interlock_key_status]'>
                    <option value='NULL'".(($id != false && $formEntryObject['form_values']['door_key_interlock_key_status'] == 'NULL') ? " selected='selected'" : "")."></option>
                    <option value='OK'".(($id != false && $formEntryObject['form_values']['door_key_interlock_key_status'] == 'OK') ? " selected='selected'" : "").">OK</option>
                    <option value='NOT OK'".(($id != false && $formEntryObject['form_values']['door_key_interlock_key_status'] == 'NOT OK') ? " selected='selected'" : "").">NOT OK</option>
                  </select></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class='span6'>
        <h3>Accessory Position and Latching</h3>
        <table class='table table-bordered table-striped'>
          <thead>
          </thead>
          <tbody>
            <tr>
              <td>Wedge</td>
              <td><select id='form_entry_form_values_accessory_position_wedge' name='form_entry[form_values][accessory_position_wedge_position]'>
                    <option value='15'".(($id != false && $formEntryObject['form_values']['accessory_position_wedge_position'] == '15') ? " selected='selected'" : "").">15</option>
                    <option value='30'".(($id != false && $formEntryObject['form_values']['accessory_position_wedge_position'] == '30') ? " selected='selected'" : "").">30</option>
                    <option value='45'".(($id != false && $formEntryObject['form_values']['accessory_position_wedge_position'] == '45') ? " selected='selected'" : "").">45</option>
                    <option value='60'".(($id != false && $formEntryObject['form_values']['accessory_position_wedge_position'] == '60') ? " selected='selected'" : "").">60</option>
                  </select></td>
              <td><select id='form_entry_form_values_accessory_position_wedge_status' name='form_entry[form_values][accessory_position_wedge_status]'>
                    <option value='NULL'".(($id != false && $formEntryObject['form_values']['accessory_position_wedge_status'] == 'NULL') ? " selected='selected'" : "")."></option>
                    <option value='OK'".(($id != false && $formEntryObject['form_values']['accessory_position_wedge_status'] == 'OK') ? " selected='selected'" : "").">OK</option>
                    <option value='NOT OK'".(($id != false && $formEntryObject['form_values']['accessory_position_wedge_status'] == 'NOT OK') ? " selected='selected'" : "").">NOT OK</option>
                  </select></td>
            </tr>
            <tr>
              <td>Cone</td>
              <td><select id='form_entry_form_values_accessory_position_cone' name='form_entry[form_values][accessory_position_cone_position]'>
                    <option value='6*6'".(($id != false && $formEntryObject['form_values']['accessory_position_cone_position'] == '6*6') ? " selected='selected'" : "").">6*6</option>
                    <option value='10*10'".(($id != false && $formEntryObject['form_values']['accessory_position_cone_position'] == '10*10') ? " selected='selected'" : "").">10*10</option>
                    <option value='15*15'".(($id != false && $formEntryObject['form_values']['accessory_position_cone_position'] == '15*15') ? " selected='selected'" : "").">15*15</option>
                    <option value='20*20'".(($id != false && $formEntryObject['form_values']['accessory_position_cone_position'] == '20*20') ? " selected='selected'" : "").">20*20</option>
                    <option value='25*25'".(($id != false && $formEntryObject['form_values']['accessory_position_cone_position'] == '25*25') ? " selected='selected'" : "").">25*25</option>
                  </select></td>
              <td><select id='form_entry_form_values_accessory_position_cone_status' name='form_entry[form_values][accessory_position_cone_status]'>
                    <option value='NULL'".(($id != false && $formEntryObject['form_values']['accessory_position_cone_status'] == 'NULL') ? " selected='selected'" : "")."></option>
                    <option value='OK'".(($id != false && $formEntryObject['form_values']['accessory_position_cone_status'] == 'OK') ? " selected='selected'" : "").">OK</option>
                    <option value='NOT OK'".(($id != false && $formEntryObject['form_values']['accessory_position_cone_status'] == 'NOT OK') ? " selected='selected'" : "").">NOT OK</option>
                  </select></td>
            </tr>
            <tr>
              <td>Block</td>
              <td></td>
              <td><select id='form_entry_form_values_accessory_position_block' name='form_entry[form_values][accessory_position_block]'>
                    <option value='NULL'".(($id != false && $formEntryObject['form_values']['accessory_position_block'] == 'NULL') ? " selected='selected'" : "")."></option>
                    <option value='OK'".(($id != false && $formEntryObject['form_values']['accessory_position_block'] == 'OK') ? " selected='selected'" : "").">OK</option>
                    <option value='NOT OK'".(($id != false && $formEntryObject['form_values']['accessory_position_block'] == 'NOT OK') ? " selected='selected'" : "").">NOT OK</option>
                  </select></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class='span3'>
        <h3>BB Tray Alignment</h3>
        <table class='table table-bordered table-striped'>
          <thead>
            <tr>
              <th>Distance off relative to wires</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Cross-line</td>
              <td><input name='form_entry[form_values][bb_tray_cross_line]' class='span12' id='form_entry_form_values_bb_tray_cross_line' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['bb_tray_cross_line'])."'")."/>
            </tr>
            <tr>
              <td>In-line</td>
              <td><input name='form_entry[form_values][bb_tray_in_line]' class='span12' id='form_entry_form_values_bb_tray_in_line' ".(($id === false) ? "" : " value='".escape_output($formEntryObject['form_values']['bb_tray_in_line'])."'")."/>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <h3>Comments</h3>
    <textarea name='form_entry[comments]' id='form_entry_comments' rows='10' class='span12' placeholder='Comments go here.'>".(($id === false) ? "" : escape_output($formEntryObject['comments']))."</textarea><br />
    <h3>Image</h3>
    <input name='form_image' class='input-file' type='file' />
    <div class='form-actions'>
      <button type='submit' class='btn btn-primary'>".(($id === false) ? "Save entry" : "Save changes")."</button>
      <button class='btn'>".(($id === false) ? "Go back" : "Discard changes")."</button>
    </div>
  </fieldset>
</form>
";
?>