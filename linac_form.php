<?php
  // displays a form to edit form parameters.
  echo "<form action='form_entry.php' method='POST' class='form-horizontal'>
  <fieldset>
".(($id === false) ? "" : "<input type='hidden' name='form_entry[id]' value='".intval($id)."' />")."
".((!isset($_REQUEST['form_id'])) ? "" : "<input type='hidden' name='form_entry[form_id]' value='".intval($_REQUEST['form_id'])."' />")."
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
    <div class='row-fluid'>
      <div class='span6'>
        <h3>Measurement parameters</h3>
        <div class='control-group'>
          <label class='control-label' for='form_entry[form_values][temperature]'>Temperature (°C)</label>
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
      display_ionization_chamber_dropdown("form_entry_form_values_ionization_chamber", "form_entry[form_values]");
      echo "      </div>
        </div>
        <div class='control-group'>
          <label class='control-label' for='form_entry[form_values][electrometer]'>Electrometer</label>
          <div class='controls'>
    ";
      display_electrometer_dropdown("form_entry_form_values_electrometer", "form_entry[form_values]");
      echo "      </div>
        </div>
      </div>
    </div>
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
            <tr><td>Q1</td><td><input name='form_entry[form_values][photon_output_calibration_6MV_q1]' class='form_entry_form_values_photon_output_calibration_6MV span12' id='form_entry_form_values_photon_output_calibration_6MV_q1' /></td><td><input name='form_entry[form_values][photon_output_calibration_18MV_q1]' class='form_entry_form_values_photon_output_calibration_18MV span12' id='form_entry_form_values_photon_output_calibration_18MV_q1' /></td></tr>
            <tr><td>Q2</td><td><input name='form_entry[form_values][photon_output_calibration_6MV_q2]' class='form_entry_form_values_photon_output_calibration_6MV span12' id='form_entry_form_values_photon_output_calibration_6MV_q2' /></td><td><input name='form_entry[form_values][photon_output_calibration_18MV_q2]' class='form_entry_form_values_photon_output_calibration_18MV span12' id='form_entry_form_values_photon_output_calibration_18MV_q2' /></td></tr>
            <tr><td>Q3</td><td><input name='form_entry[form_values][photon_output_calibration_6MV_q3]' class='form_entry_form_values_photon_output_calibration_6MV span12' id='form_entry_form_values_photon_output_calibration_6MV_q3' /></td><td><input name='form_entry[form_values][photon_output_calibration_18MV_q3]' class='form_entry_form_values_photon_output_calibration_18MV span12' id='form_entry_form_values_photon_output_calibration_18MV_q3' /></td></tr>
            <tr><td>M</td><td><input name='form_entry[form_values][photon_output_calibration_6MV_M]' class='span12' id='form_entry_form_values_photon_output_calibration_6MV_M' /></td><td><input name='form_entry[form_values][photon_output_calibration_18MV_M]' class='span12' id='form_entry_form_values_photon_output_calibration_18MV_M' /></td></tr>
            <tr><td>Dw</td><td><input name='form_entry[form_values][photon_output_calibration_6MV_Dw]' class='span12' id='form_entry_form_values_photon_output_calibration_6MV_Dw' /></td><td><input name='form_entry[form_values][photon_output_calibration_18MV_Dw]' class='span12' id='form_entry_form_values_photon_output_calibration_18MV_Dw' /></td></tr>
            <tr><td>%diff</td><td><input name='form_entry[form_values][photon_output_calibration_6MV_diff]' class='span12' id='form_entry_form_values_photon_output_calibration_6MV_diff' /></td><td><input name='form_entry[form_values][photon_output_calibration_18MV_diff]' class='span12' id='form_entry_form_values_photon_output_calibration_18MV_diff' /></td></tr>
          </tbody>
        </table>
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
            <tr><td>Q1</td><td><input name='form_entry[form_values][tpr_6MV_q1]' class='form_entry_form_values_tpr_6MV span12' id='form_entry_form_values_tpr_6MV_q1 span12' /></td><td><input name='form_entry[form_values][tpr_18MV_q1]' class='form_entry_form_values_tpr_18MV span12' id='form_entry_form_values_tpr_18MV_q1' /></td></tr>
            <tr><td>Q2</td><td><input name='form_entry[form_values][tpr_6MV_q2]' class='form_entry_form_values_tpr_6MV span12' id='form_entry_form_values_tpr_6MV_q2 span12' /></td><td><input name='form_entry[form_values][tpr_18MV_q2]' class='form_entry_form_values_tpr_18MV span12' id='form_entry_form_values_tpr_18MV_q2' /></td></tr>
            <tr><td>Q3</td><td><input name='form_entry[form_values][tpr_6MV_q3]' class='form_entry_form_values_tpr_6MV span12' id='form_entry_form_values_tpr_6MV_q3 span12' /></td><td><input name='form_entry[form_values][tpr_18MV_q3]' class='form_entry_form_values_tpr_18MV span12' id='form_entry_form_values_tpr_18MV_q3' /></td></tr>
            <tr><td>TPR</td><td><input name='form_entry[form_values][tpr_6MV_TPR]' class='span12' id='form_entry_form_values_tpr_6MV_TPR' /></td><td><input name='form_entry[form_values][tpr_18MV_TPR]' class='span12' id='form_entry_form_values_tpr_18MV_TPR' /></td></tr>
            <tr><td>%diff</td><td><input name='form_entry[form_values][tpr_6MV_diff]' class='span12' id='form_entry_form_values_tpr_6MV_diff' /></td><td><input name='form_entry[form_values][tpr_18MV_diff]' class='span12' id='form_entry_form_values_tpr_18MV_diff' /></td></tr>
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
            <tr><td>Q1</td><td><input name='form_entry[form_values][gating_6MV_q1]' class='form_entry_form_values_gating_6MV span12' id='form_entry_form_values_gating_6MV_q1' /></td></tr>
            <tr><td>Q2</td><td><input name='form_entry[form_values][gating_6MV_q2]' class='form_entry_form_values_gating_6MV span12' id='form_entry_form_values_gating_6MV_q2' /></td></tr>
            <tr><td>Q3</td><td><input name='form_entry[form_values][gating_6MV_q3]' class='form_entry_form_values_gating_6MV span12' id='form_entry_form_values_gating_6MV_q3' /></td></tr>
            <tr><td>TPR(5)</td><td><input name='form_entry[form_values][gating_6MV_TPR]' class='span12' id='form_entry_form_values_gating_6MV_TPR' /></td></tr>
            <tr><td>%diff</td><td><input name='form_entry[form_values][gating_6MV_diff]' class='span12' id='form_entry_form_values_gating_6MV_diff' /></td></tr>
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
            <tr><td>Q1</td><td><input name='form_entry[form_values][edw_6MV_q1]' class='form_entry_form_values_edw_6MV span12' id='form_entry_form_values_edw_6MV_q1' /></td><td><input name='form_entry[form_values][edw_18MV_q1]' class='form_entry_form_values_edw_18MV span12' id='form_entry_form_values_edw_18MV_q1' /></td></tr>
            <tr><td>Q2</td><td><input name='form_entry[form_values][edw_6MV_q2]' class='form_entry_form_values_edw_6MV span12' id='form_entry_form_values_edw_6MV_q2' /></td><td><input name='form_entry[form_values][edw_18MV_q2]' class='form_entry_form_values_edw_18MV span12' id='form_entry_form_values_edw_18MV_q2' /></td></tr>
            <tr><td>Q3</td><td><input name='form_entry[form_values][edw_6MV_q3]' class='form_entry_form_values_edw_6MV span12' id='form_entry_form_values_edw_6MV_q3' /></td><td><input name='form_entry[form_values][edw_18MV_q3]' class='form_entry_form_values_edw_18MV span12' id='form_entry_form_values_edw_18MV_q3' /></td></tr>
            <tr><td>WF(5)</td><td><input name='form_entry[form_values][edw_6MV_WF]' class='span12' id='form_entry_form_values_edw_6MV_WF' /></td><td><input name='form_entry[form_values][edw_18MV_WF]' class='span12' id='form_entry_form_values_edw_18MV_WF' /></td></tr>
            <tr><td>%diff</td><td><input name='form_entry[form_values][edw_6MV_diff]' class='span12' id='form_entry_form_values_edw_6MV_diff' /></td><td><input name='form_entry[form_values][edw_18MV_diff]' class='span12' id='form_entry_form_values_edw_18MV_diff' /></td></tr>
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
              <td><input name='form_entry[form_values][electron_output_calibration_6MV_q1]' class='form_entry_form_values_electron_output_calibration_6MeV span12' id='form_entry_form_values_electron_output_calibration_6MeV_q1' /></td>
              <td><input name='form_entry[form_values][electron_output_calibration_9MeV_q1]' class='form_entry_form_values_electron_output_calibration_9MeV span12' id='form_entry_form_values_electron_output_calibration_9MeV_q1' /></td>
              <td><input name='form_entry[form_values][electron_output_calibration_12MeV_q1]' class='form_entry_form_values_electron_output_calibration_12MeV span12' id='form_entry_form_values_electron_output_calibration_12MeV_q1' /></td>
              <td><input name='form_entry[form_values][electron_output_calibration_16MeV_q1]' class='form_entry_form_values_electron_output_calibration_16MeV span12' id='form_entry_form_values_electron_output_calibration_16MeV_q1' /></td>
              <td><input name='form_entry[form_values][electron_output_calibration_20MeV_q1]' class='form_entry_form_values_electron_output_calibration_20MeV span12' id='form_entry_form_values_electron_output_calibration_20MeV_q1' /></td>
            </tr>
            <tr>
              <td>Q2</td>
              <td><input name='form_entry[form_values][electron_output_calibration_6MV_q2]' class='form_entry_form_values_electron_output_calibration_6MeV span12' id='form_entry_form_values_electron_output_calibration_6MeV_q2' /></td>
              <td><input name='form_entry[form_values][electron_output_calibration_9MeV_q2]' class='form_entry_form_values_electron_output_calibration_9MeV span12' id='form_entry_form_values_electron_output_calibration_9MeV_q2' /></td>
              <td><input name='form_entry[form_values][electron_output_calibration_12MeV_q2]' class='form_entry_form_values_electron_output_calibration_12MeV span12' id='form_entry_form_values_electron_output_calibration_12MeV_q2' /></td>
              <td><input name='form_entry[form_values][electron_output_calibration_16MeV_q2]' class='form_entry_form_values_electron_output_calibration_16MeV span12' id='form_entry_form_values_electron_output_calibration_16MeV_q2' /></td>
              <td><input name='form_entry[form_values][electron_output_calibration_20MeV_q2]' class='form_entry_form_values_electron_output_calibration_20MeV span12' id='form_entry_form_values_electron_output_calibration_20MeV_q2' /></td>
            </tr>
            <tr>
              <td>Q3</td>
              <td><input name='form_entry[form_values][electron_output_calibration_6MV_q3]' class='form_entry_form_values_electron_output_calibration_6MeV span12' id='form_entry_form_values_electron_output_calibration_6MeV_q3' /></td>
              <td><input name='form_entry[form_values][electron_output_calibration_9MeV_q3]' class='form_entry_form_values_electron_output_calibration_9MeV span12' id='form_entry_form_values_electron_output_calibration_9MeV_q3' /></td>
              <td><input name='form_entry[form_values][electron_output_calibration_12MeV_q3]' class='form_entry_form_values_electron_output_calibration_12MeV span12' id='form_entry_form_values_electron_output_calibration_12MeV_q3' /></td>
              <td><input name='form_entry[form_values][electron_output_calibration_16MeV_q3]' class='form_entry_form_values_electron_output_calibration_16MeV span12' id='form_entry_form_values_electron_output_calibration_16MeV_q3' /></td>
              <td><input name='form_entry[form_values][electron_output_calibration_20MeV_q3]' class='form_entry_form_values_electron_output_calibration_20MeV span12' id='form_entry_form_values_electron_output_calibration_20MeV_q3' /></td>
            </tr>
            <tr>
              <td>M</td>
              <td><input name='form_entry[form_values][electron_output_calibration_6MV_M]' class='span12' id='form_entry_form_values_electron_output_calibration_6MeV_M' /></td>
              <td><input name='form_entry[form_values][electron_output_calibration_9MeV_M]' class='span12' id='form_entry_form_values_electron_output_calibration_9MeV_M' /></td>
              <td><input name='form_entry[form_values][electron_output_calibration_12MeV_M]' class='span12' id='form_entry_form_values_electron_output_calibration_12MeV_M' /></td>
              <td><input name='form_entry[form_values][electron_output_calibration_16MeV_M]' class='span12' id='form_entry_form_values_electron_output_calibration_16MeV_M' /></td>
              <td><input name='form_entry[form_values][electron_output_calibration_20MeV_M]' class='span12' id='form_entry_form_values_electron_output_calibration_20MeV_M' /></td>
            </tr>
            <tr>
              <td>%diff</td>
              <td><input name='form_entry[form_values][electron_output_calibration_6MV_diff]' class='span12' id='form_entry_form_values_electron_output_calibration_6MeV_diff' /></td>
              <td><input name='form_entry[form_values][electron_output_calibration_9MeV_diff]' class='span12' id='form_entry_form_values_electron_output_calibration_9MeV_diff' /></td>
              <td><input name='form_entry[form_values][electron_output_calibration_12MeV_diff]' class='span12' id='form_entry_form_values_electron_output_calibration_12MeV_diff' /></td>
              <td><input name='form_entry[form_values][electron_output_calibration_16MeV_diff]' class='span12' id='form_entry_form_values_electron_output_calibration_16MeV_diff' /></td>
              <td><input name='form_entry[form_values][electron_output_calibration_20MeV_diff]' class='span12' id='form_entry_form_values_electron_output_calibration_20MeV_diff' /></td>
            </tr>
          </tbody>
        </table>
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
              <td><input name='form_entry[form_values][energy_ratio_6MV_q1]' class='form_entry_form_values_energy_ratio_6MeV span12' id='form_entry_form_values_energy_ratio_6MeV_q1' /></td>
              <td><input name='form_entry[form_values][energy_ratio_9MeV_q1]' class='form_entry_form_values_energy_ratio_9MeV span12' id='form_entry_form_values_energy_ratio_9MeV_q1' /></td>
              <td><input name='form_entry[form_values][energy_ratio_12MeV_q1]' class='form_entry_form_values_energy_ratio_12MeV span12' id='form_entry_form_values_energy_ratio_12MeV_q1' /></td>
              <td><input name='form_entry[form_values][energy_ratio_16MeV_q1]' class='form_entry_form_values_energy_ratio_16MeV span12' id='form_entry_form_values_energy_ratio_16MeV_q1' /></td>
              <td><input name='form_entry[form_values][energy_ratio_20MeV_q1]' class='form_entry_form_values_energy_ratio_20MeV span12' id='form_entry_form_values_energy_ratio_20MeV_q1' /></td>
            </tr>
            <tr>
              <td>Q2</td>
              <td><input name='form_entry[form_values][energy_ratio_6MV_q2]' class='form_entry_form_values_energy_ratio_6MeV span12' id='form_entry_form_values_energy_ratio_6MeV_q2' /></td>
              <td><input name='form_entry[form_values][energy_ratio_9MeV_q2]' class='form_entry_form_values_energy_ratio_9MeV span12' id='form_entry_form_values_energy_ratio_9MeV_q2' /></td>
              <td><input name='form_entry[form_values][energy_ratio_12MeV_q2]' class='form_entry_form_values_energy_ratio_12MeV span12' id='form_entry_form_values_energy_ratio_12MeV_q2' /></td>
              <td><input name='form_entry[form_values][energy_ratio_16MeV_q2]' class='form_entry_form_values_energy_ratio_16MeV span12' id='form_entry_form_values_energy_ratio_16MeV_q2' /></td>
              <td><input name='form_entry[form_values][energy_ratio_20MeV_q2]' class='form_entry_form_values_energy_ratio_20MeV span12' id='form_entry_form_values_energy_ratio_20MeV_q2' /></td>
            </tr>
            <tr>
              <td>Q3</td>
              <td><input name='form_entry[form_values][energy_ratio_6MV_q3]' class='form_entry_form_values_energy_ratio_6MeV span12' id='form_entry_form_values_energy_ratio_6MeV_q3' /></td>
              <td><input name='form_entry[form_values][energy_ratio_9MeV_q3]' class='form_entry_form_values_energy_ratio_9MeV span12' id='form_entry_form_values_energy_ratio_9MeV_q3' /></td>
              <td><input name='form_entry[form_values][energy_ratio_12MeV_q3]' class='form_entry_form_values_energy_ratio_12MeV span12' id='form_entry_form_values_energy_ratio_12MeV_q3' /></td>
              <td><input name='form_entry[form_values][energy_ratio_16MeV_q3]' class='form_entry_form_values_energy_ratio_16MeV span12' id='form_entry_form_values_energy_ratio_16MeV_q3' /></td>
              <td><input name='form_entry[form_values][energy_ratio_20MeV_q3]' class='form_entry_form_values_energy_ratio_20MeV span12' id='form_entry_form_values_energy_ratio_20MeV_q3' /></td>
            </tr>
            <tr>
              <td>PDD</td>
              <td><input name='form_entry[form_values][energy_ratio_6MV_PDD]' class='span12' id='form_entry_form_values_energy_ratio_6MeV_PDD' /></td>
              <td><input name='form_entry[form_values][energy_ratio_9MeV_PDD]' class='span12' id='form_entry_form_values_energy_ratio_9MeV_PDD' /></td>
              <td><input name='form_entry[form_values][energy_ratio_12MeV_PDD]' class='span12' id='form_entry_form_values_energy_ratio_12MeV_PDD' /></td>
              <td><input name='form_entry[form_values][energy_ratio_16MeV_PDD]' class='span12' id='form_entry_form_values_energy_ratio_16MeV_PDD' /></td>
              <td><input name='form_entry[form_values][energy_ratio_20MeV_PDD]' class='span12' id='form_entry_form_values_energy_ratio_20MeV_PDD' /></td>
            </tr>
            <tr>
              <td>%diff</td>
              <td><input name='form_entry[form_values][energy_ratio_6MV_diff]' class='span12' id='form_entry_form_values_energy_ratio_6MeV_diff' /></td>
              <td><input name='form_entry[form_values][energy_ratio_9MeV_diff]' class='span12' id='form_entry_form_values_energy_ratio_9MeV_diff' /></td>
              <td><input name='form_entry[form_values][energy_ratio_12MeV_diff]' class='span12' id='form_entry_form_values_energy_ratio_12MeV_diff' /></td>
              <td><input name='form_entry[form_values][energy_ratio_16MeV_diff]' class='span12' id='form_entry_form_values_energy_ratio_16MeV_diff' /></td>
              <td><input name='form_entry[form_values][energy_ratio_20MeV_diff]' class='span12' id='form_entry_form_values_energy_ratio_20MeV_diff' /></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <h1>Mechanical QA</h1>
    <h3>Laser position (mm from light field IC)</h3>
    <table class='table table-bordered table-striped'>
      <thead>
        <tr>
          <th></th>
          <th>L Wall Vertical</th>
          <th>R Wall Vertical</th>
          <th>L Wall Horizontal</th>
          <th>R Wall Horizontal</th>
          <th>Sagittal</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Gantry = 0<br />Coll = 0</td>
          <td><input name='form_entry[form_values][laser_l_wall_vertical]' id='form_entry_form_values_laser_l_wall_vertical' /></td>
          <td><input name='form_entry[form_values][laser_r_wall_vertical]' id='form_entry_form_values_laser_r_wall_vertical' /></td>
          <td><input name='form_entry[form_values][laser_l_wall_horizontal]' id='form_entry_form_values_laser_l_wall_horizontal' /></td>
          <td><input name='form_entry[form_values][laser_r_wall_horizontal]' id='form_entry_form_values_laser_laser_r_wall_horizontal' /></td>
          <td><input name='form_entry[form_values][laser_sagittal]' id='form_entry_form_values_laser_sagittal' /></td>
        </tr>
      </tbody>
    </table>
    <div class='row-fluid'>
      <div class='span4'>
        <h3>ODI vs Light Field Isocenter</h3>
        <table class='table table-bordered table-striped'>
          <thead>
            <tr>
              <th>Gantry Angle</th>
              <th>ODI Reading at IC</th>
              <th>Comments</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>0</td>
              <td><input name='form_entry[form_values][odi_vs_light_reading_0]' class='span12' id='form_entry_form_values_odi_vs_light_reading_0' /></td>
              <td><input name='form_entry[form_values][odi_vs_light_comments_0]' class='span12' id='form_entry_form_values_odi_vs_light_comments_0' /></td>
            </tr>
            <tr>
              <td>90</td>
              <td><input name='form_entry[form_values][odi_vs_light_reading_90]' class='span12' id='form_entry_form_values_odi_vs_light_reading_90' /></td>
              <td><input name='form_entry[form_values][odi_vs_light_comments_90]' class='span12' id='form_entry_form_values_odi_vs_light_comments_90' /></td>
            </tr>
            <tr>
              <td>270</td>
              <td><input name='form_entry[form_values][odi_vs_light_reading_270]' class='span12' id='form_entry_form_values_odi_vs_light_reading_270' /></td>
              <td><input name='form_entry[form_values][odi_vs_light_comments_270]' class='span12' id='form_entry_form_values_odi_vs_light_comments_270' /></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class='span4'>
        <h3>Centering of Light Field Cross-Hair</h3>
        <table class='table table-bordered table-striped'>
          <thead>
            <tr>
              <th>Gantry Angle</th>
              <th>Distance from IC (mm)</th>
              <th>Comments</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>0</td>
              <td><input name='form_entry[form_values][light_centering_distance_0]' class='span12' id='form_entry_form_values_light_centering_distance_0' /></td>
              <td><input name='form_entry[form_values][light_centering_comments_0]' class='span12' id='form_entry_form_values_light_centering_comments_0' /></td>
            </tr>
            <tr>
              <td>90</td>
              <td><input name='form_entry[form_values][light_centering_distance_90]' class='span12' id='form_entry_form_values_light_centering_distance_90' /></td>
              <td><input name='form_entry[form_values][light_centering_comments_90]' class='span12' id='form_entry_form_values_light_centering_comments_90' /></td>
            </tr>
            <tr>
              <td>270</td>
              <td><input name='form_entry[form_values][light_centering_distance_270]' class='span12' id='form_entry_form_values_light_centering_distance_270' /></td>
              <td><input name='form_entry[form_values][light_centering_comments_270]' class='span12' id='form_entry_form_values_light_centering_comments_270' /></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class='span4'>
        <h3>Gantry and Collimator Angles vs Readout</h3>
        <table class='table table-bordered table-striped'>
          <thead>
            <tr>
              <th>Setting</th>
              <th>Digital Readout</th>
              <th>Comments</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Gantry = 0</td>
              <td><input name='form_entry[form_values][gantry_angle_readout_0]' class='span12' id='form_entry_form_values_gantry_angle_readout_0' /></td>
              <td><input name='form_entry[form_values][gantry_angle_comments_0]' class='span12' id='form_entry_form_values_gantry_angle_comments_0' /></td>
            </tr>
            <tr>
              <td>Gantry = 90</td>
              <td><input name='form_entry[form_values][gantry_angle_readout_90]' class='span12' id='form_entry_form_values_gantry_angle_readout_90' /></td>
              <td><input name='form_entry[form_values][gantry_angle_comments_90]' class='span12' id='form_entry_form_values_gantry_angle_comments_90' /></td>
            </tr>
            <tr>
              <td>Gantry = 270</td>
              <td><input name='form_entry[form_values][gantry_angle_readout_270]' class='span12' id='form_entry_form_values_gantry_angle_readout_270' /></td>
              <td><input name='form_entry[form_values][gantry_angle_comments_270]' class='span12' id='form_entry_form_values_gantry_angle_comments_270' /></td>
            </tr>
            <tr>
              <td>Collimator = 0</td>
              <td><input name='form_entry[form_values][collimator_angle_readout_0]' class='span12' id='form_entry_form_values_collimator_angle_readout_0' /></td>
              <td><input name='form_entry[form_values][collimator_angle_comments_0]' class='span12' id='form_entry_form_values_collimator_angle_comments_0' /></td>
            </tr>
            <tr>
              <td>Collimator = 90</td>
              <td><input name='form_entry[form_values][collimator_angle_readout_90]' class='span12' id='form_entry_form_values_collimator_angle_readout_90' /></td>
              <td><input name='form_entry[form_values][collimator_angle_comments_90]' class='span12' id='form_entry_form_values_collimator_angle_comments_90' /></td>
            </tr>
            <tr>
              <td>Collimator = 270</td>
              <td><input name='form_entry[form_values][collimator_angle_readout_270]' class='span12' id='form_entry_form_values_collimator_angle_readout_270' /></td>
              <td><input name='form_entry[form_values][collimator_angle_comments_270]' class='span12' id='form_entry_form_values_collimator_angle_comments_270' /></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <h3>Optical Field Size vs Digital Readout</h3>
    <table class='table table-bordered table-striped'>
      <thead>
        <tr>
          <th>Digital</th>
          <th>Measured Field Size</th>
          <th>Comments</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>x=5.0cm</td>
          <td>x1 = <input name='form_entry[form_values][optical_field_x1_x5]' id='form_entry_form_values_optical_field_x1_x5' />
              x2 = <input name='form_entry[form_values][optical_field_x2_x5]' id='form_entry_form_values_optical_field_x2_x5' /></td>
          <td><input name='form_entry[form_values][optical_field_comments_x5]' id='form_entry_form_values_optical_field_comments_x5' /></td>
        </tr>
        <tr>
          <td>x=10.0cm</td>
          <td>x1 = <input name='form_entry[form_values][optical_field_x1_x10]' id='form_entry_form_values_optical_field_x1_x10' />
              x2 = <input name='form_entry[form_values][optical_field_x2_x10]' id='form_entry_form_values_optical_field_x2_x10' /></td>
          <td><input name='form_entry[form_values][optical_field_comments_x10]' id='form_entry_form_values_optical_field_comments_x10' /></td>
        </tr>
        <tr>
          <td>x=20.0cm</td>
          <td>x1 = <input name='form_entry[form_values][optical_field_x1_x20]' id='form_entry_form_values_optical_field_x1_x20' />
              x2 = <input name='form_entry[form_values][optical_field_x2_x20]' id='form_entry_form_values_optical_field_x2_x20' /></td>
          <td><input name='form_entry[form_values][optical_field_comments_x20]' id='form_entry_form_values_optical_field_comments_x20' /></td>
        </tr>
        <tr>
          <td>y=5.0cm</td>
          <td>y1 = <input name='form_entry[form_values][optical_field_y1_y5]' id='form_entry_form_values_optical_field_y1_y5' />
              y2 = <input name='form_entry[form_values][optical_field_y2_y5]' id='form_entry_form_values_optical_field_y2_y5' /></td>
          <td><input name='form_entry[form_values][optical_field_comments_y5]' id='form_entry_form_values_optical_field_comments_y5' /></td>
        </tr>
        <tr>
          <td>y=10.0cm</td>
          <td>y1 = <input name='form_entry[form_values][optical_field_y1_y10]' id='form_entry_form_values_optical_field_y1_y10' />
              y2 = <input name='form_entry[form_values][optical_field_y2_y10]' id='form_entry_form_values_optical_field_y2_y10' /></td>
          <td><input name='form_entry[form_values][optical_field_comments_y10]' id='form_entry_form_values_optical_field_comments_y10' /></td>
        </tr>
        <tr>
          <td>y=20.0cm</td>
          <td>y1 = <input name='form_entry[form_values][optical_field_y1_y20]' id='form_entry_form_values_optical_field_y1_y20' />
              y2 = <input name='form_entry[form_values][optical_field_y2_y20]' id='form_entry_form_values_optical_field_y2_y20' /></td>
          <td><input name='form_entry[form_values][optical_field_comments_y20]' id='form_entry_form_values_optical_field_comments_y20' /></td>
        </tr>
      </tbody>
    </table>
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
                    <option value='NULL'></option>
                    <option value='OK'>OK</option>
                    <option value='NOT OK'>NOT OK</option>
                  </select></td>
            </tr>
            <tr>
              <td>Key</td>
              <td><select id='form_entry_form_values_door_key_interlock_key_status' name='form_entry[form_values][door_key_interlock_key_status]'>
                    <option value='NULL'></option>
                    <option value='OK'>OK</option>
                    <option value='NOT OK'>NOT OK</option>
                  </select></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class='span3'>
        <h3>Accessory Position and Latching</h3>
        <table class='table table-bordered table-striped'>
          <thead>
          </thead>
          <tbody>
            <tr>
              <td>Wedge</td>
              <td><select id='form_entry_form_values_accessory_position_wedge' name='form_entry[form_values][accessory_position_wedge]'>
                    <option value='15'>15</option>
                    <option value='30'>30</option>
                    <option value='45'>45</option>
                    <option value='60'>60</option>
                  </select></td>
            </tr>
            <tr>
              <td>Cone</td>
              <td><select id='form_entry_form_values_accessory_position_cone' name='form_entry[form_values][accessory_position_cone]'>
                    <option value='6*6'>6*6</option>
                    <option value='10*10'>10*10</option>
                    <option value='15*15'>15*15</option>
                    <option value='20*20'>20*20</option>
                    <option value='25*25'>25*25</option>
                  </select></td>
            </tr>
            <tr>
              <td>Block</td>
              <td><select id='form_entry_form_values_accessory_position_block' name='form_entry[form_values][accessory_position_block]'>
                    <option value='NULL'></option>
                    <option value='OK'>OK</option>
                    <option value='NOT OK'>NOT OK</option>
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
              <td><input name='form_entry[form_values][bb_tray_cross_line]' class='span12' id='form_entry_form_values_bb_tray_cross_line' />
            </tr>
            <tr>
              <td>In-line</td>
              <td><input name='form_entry[form_values][bb_tray_in_line]' class='span12' id='form_entry_form_values_bb_tray_in_line' />
            </tr>
          </tbody>
        </table>
      </div>
      <div class='span3'>
        <h3>PSA Position Indicator</h3>
        <table class='table table-bordered table-striped'>
          <thead>
            <tr>
              <th>Digital Readout vs Floor</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>0</td>
              <td><input name='form_entry[form_values][psa_position_0]' class='span12' id='form_entry_form_values_psa_position_0' />
            </tr>
            <tr>
              <td>90</td>
              <td><input name='form_entry[form_values][psa_position_90]' class='span12' id='form_entry_form_values_psa_position_90' />
            </tr>
            <tr>
              <td>270</td>
              <td><input name='form_entry[form_values][psa_position_270]' class='span12' id='form_entry_form_values_psa_position_270' />
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <h3>Comments</h3>
    <textarea name='form_entry[comments]' id='form_entry_comments'></textarea>
    <div class='form-actions'>
      <button type='submit' class='btn btn-primary'>".(($id === false) ? "Save entry" : "Save changes")."</button>
      <button class='btn'>".(($id === false) ? "Go back" : "Discard changes")."</button>
    </div>
  </fieldset>
</form>
";
?>