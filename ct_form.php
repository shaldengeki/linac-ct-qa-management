<?php
  // displays a form to edit form parameters.
  echo "<form name='ct-monthly' id='ct-monthly' action='".$_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']."' method='POST' class='form-horizontal' enctype='multipart/form-data'>
  <fieldset>
".(($id === false) ? "" : "<input type='hidden' name='form_entry[id]' value='".intval($id)."' />");
  if (isset($_REQUEST['form_id'])) {
    echo "<input type='hidden' name='form_entry[form_id]' value='".intval($_REQUEST['form_id'])."' />
";
  } elseif ($id != false) {
    echo "<input type='hidden' name='form_entry[form_id]' value='".intval($formEntry->form['id'])."' />
";
  }
  echo "
    <div class='row-fluid'>
      <div class='span6'>
        <div class='control-group'>
          <label class='control-label' for='form_entry[machine_id]'>Machine</label>
          <div class='controls'>
";
  display_machine_dropdown($user, "form_entry[machine_id]", (($id === false) ? 0 : intval($formEntry->machine['id'])), intval($form->machineType['id']));
  echo "          </div>
        </div>
        <div class='control-group'>\n";
  if ($user->isAdmin()) {
    echo "          <label class='control-label' for='form_entry[machine_id]'>Performed by</label>
          <div class='controls'>\n";
  display_user_dropdown($user, "form_entry[user_id]", (($id === false) ? $user->id : intval($formEntry->user['id'])));
    echo "          </div>\n";
  } else {
    echo "            <input type='hidden' name='form_entry[user_id]' value='".(($id === false) ? intval($user->id) : intval($formEntry->user['id']))."' />\n";
  }
  echo "        </div>
      </div>
      <div class='span6'>
        <div class='control-group'>
          <label class='control-label' for='form_entry[qa_month]'>QA Month</label>
          <div class='controls'>
    ";
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
      <div class='span4'>
        <h3 class='center-horizontal'>Contrast Scale</h3>
        <h4 class='center-horizontal'>Slice 1-5 (-511 mm)</h4>
        <table class='table table-bordered table-striped'>
          <thead>
            <tr>
              <th>Plug</th>
              <th>CT #</th>
              <th>Nom.</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][contrast_scale_1_value]' class='form_entry_form_values_contrast_scale_1_value span5' id='form_entry_form_values_contrast_scale_1_value' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['contrast_scale_1_value']->value)."'")."/> &plusmn; <input type='number' step='0.01' name='form_entry[form_values][contrast_scale_1_plusmin]' class='form_entry_form_values_contrast_scale_1_plusmin span5' id='form_entry_form_values_contrast_scale_1_plusmin' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['contrast_scale_1_plusmin']->value)."'")."/></td>
              <td>-95&plusmn;15</td>
            </tr>
            <tr>
              <td>2</td>
              <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][contrast_scale_2_value]' class='form_entry_form_values_contrast_scale_2_value span5' id='form_entry_form_values_contrast_scale_2_value' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['contrast_scale_2_value']->value)."'")."/> &plusmn; <input type='number' step='0.01' name='form_entry[form_values][contrast_scale_2_plusmin]' class='form_entry_form_values_contrast_scale_2_plusmin span5' id='form_entry_form_values_contrast_scale_2_plusmin' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['contrast_scale_2_plusmin']->value)."'")."/></td>
              <td>913&plusmn;50</td>
            </tr>
            <tr>
              <td>3</td>
              <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][contrast_scale_3_value]' class='form_entry_form_values_contrast_scale_3_value span5' id='form_entry_form_values_contrast_scale_3_value' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['contrast_scale_3_value']->value)."'")."/>  &plusmn;  <input type='number' step='0.01' name='form_entry[form_values][contrast_scale_3_plusmin]' class='form_entry_form_values_contrast_scale_3_plusmin span5' id='form_entry_form_values_contrast_scale_3_plusmin' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['contrast_scale_3_plusmin']->value)."'")."/></td>
              <td>-988&plusmn;5</td>
            </tr>
            <tr>
              <td>4</td>
              <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][contrast_scale_4_value]' class='form_entry_form_values_contrast_scale_4_value span5' id='form_entry_form_values_contrast_scale_4_value' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['contrast_scale_4_value']->value)."'")."/> &plusmn; <input type='number' step='0.01' name='form_entry[form_values][contrast_scale_4_plusmin]' class='form_entry_form_values_contrast_scale_4_plusmin span5' id='form_entry_form_values_contrast_scale_4_plusmin' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['contrast_scale_4_plusmin']->value)."'")."/></td>
              <td>120&plusmn;15</td>
            </tr>
            <tr>
              <td>5</td>
              <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][contrast_scale_5_value]' class='form_entry_form_values_contrast_scale_5_value span5' id='form_entry_form_values_contrast_scale_5_value' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['contrast_scale_5_value']->value)."'")."/> &plusmn; <input type='number' step='0.01' name='form_entry[form_values][contrast_scale_5_plusmin]' class='form_entry_form_values_contrast_scale_5_plusmin span5' id='form_entry_form_values_contrast_scale_5_plusmin' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['contrast_scale_5_plusmin']->value)."'")."/></td>
              <td>0&plusmn;4</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class='span4'>
        <h3 class='center-horizontal'>Low Contrast Detectability</h3>
        <h4 class='center-horizontal'>Slice 2-5 (-471mm) (W/L=100/100)</h4>
        <table class='table table-bordered table-striped'>
          <thead>
          </thead>
          <tbody>
            <tr>
              <td>See 6mm row?</td>
              <td class='control-group'><input name='form_entry[form_values][low_contrast_detect_6mm_row]' class='form_entry_form_values_low_contrast_detect_6mm_row span12' id='form_entry_form_values_low_contrast_detect_6mm_row' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['low_contrast_detect_6mm_row']->value)."'")."/></td>
              <td>5</td>
            </tr>
          </tbody>
        </table>
        <h3 class='center-horizontal'>Spatial Integrity</h3>
        <h4 class='center-horizontal'>Slice 3-5 (-431mm)</h4>
        <table class='table table-bordered table-striped'>
          <thead>
            <tr>
              <th>BB to BB</th>
              <th>Nominal</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][spatial_integrity_bb_to_bb]' class='form_entry_form_values_spatial_integrity_bb_to_bb span12' id='form_entry_form_values_spatial_integrity_bb_to_bb' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['spatial_integrity_bb_to_bb']->value)."'")."/></td>
              <td>100&plusmn;1</td>
            </tr>
          </tbody>
        </table>
        <h3 class='center-horizontal'>High Contrast Resolution</h3>
        <h4 class='center-horizontal'>Slice 4-5 (-391mm) (W/L=100/1100)</h4>
        <table class='table table-bordered table-striped'>
          <thead>
          </thead>
          <tbody>
            <tr>
              <td>highest lp/cm block</td>
              <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][high_contrast_resolution_max_lp_cm_block]' class='form_entry_form_values_high_contrast_resolution_max_lp_cm_block span12' id='form_entry_form_values_high_contrast_resolution_max_lp_cm_block' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['high_contrast_resolution_max_lp_cm_block']->value)."'")."/></td>
              <td>8</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class='span4'>
        <h3 class='center-horizontal'>Laser Position</h3>
        <h4 class='center-horizontal'>Wilke Phantom</h4>
        <table class='table table-bordered table-striped'>
          <thead>
            <tr>
              <th>Laser</th>
              <th>Measurement</th>
              <th>Nom.</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Cor</td>
              <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][laser_position_cor]' class='form_entry_form_values_laser_position_cor span12' id='form_entry_form_values_laser_position_cor' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['laser_position_cor']->value)."'")."/></td>
              <td>0&plusmn;2</td>
            </tr>
            <tr>
              <td>Sag</td>
              <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][laser_position_sag]' class='form_entry_form_values_laser_position_sag span12' id='form_entry_form_values_laser_position_sag' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['laser_position_sag']->value)."'")."/></td>
              <td>0&plusmn;2</td>
            </tr>
            <tr>
              <td>Axial</td>
              <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][laser_position_axial]' class='form_entry_form_values_laser_position_axial span12' id='form_entry_form_values_laser_position_axial' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['laser_position_axial']->value)."'")."/></td>
              <td>0&plusmn;2</td>
            </tr>
          </tbody>
        </table>
        <h3 class='center-horizontal'>Laser Localization</h3>
        <h4 class='center-horizontal'>Pinnacle</h4>
        <table class='table table-bordered table-striped'>
          <thead>
          </thead>
          <tbody>
            <tr>
              <td>BB&plusmn;1mm?</td>
              <td class='control-group'><select id='form_entry_form_values_laser_localization' name='form_entry[form_values][laser_localization]'>
                    <option value='NULL'".(($id != false && $formEntry->formValues['laser_localization']->value == 'NULL') ? " selected='selected'" : "")."></option>
                    <option value='Y'".(($id != false && $formEntry->formValues['laser_localization']->value == 'Y') ? " selected='selected'" : "").">Y</option>
                    <option value='N'".(($id != false && $formEntry->formValues['laser_localization']->value == 'N') ? " selected='selected'" : "").">N</option>
                  </select></td>
              <td>8</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class='row-fluid'>
      <div class='span4'>
        <h3 class='center-horizontal'>Review Daily QA Logs</h3>
        <h4 class='center-horizontal'>&nbsp;</h4>
        <table class='table table-bordered table-striped'>
          <thead>
          </thead>
          <tbody>
            <tr>
              <td>Performed</td>
              <td class='control-group'><select id='form_entry_form_values_daily_qa_logs_reviewed' name='form_entry[form_values][daily_qa_logs_reviewed]'>
                    <option value='NULL'".(($id != false && $formEntry->formValues['daily_qa_logs_reviewed']->value == 'NULL') ? " selected='selected'" : "")."></option>
                    <option value='Y'".(($id != false && $formEntry->formValues['daily_qa_logs_reviewed']->value == 'Y') ? " selected='selected'" : "").">Y</option>
                    <option value='N'".(($id != false && $formEntry->formValues['daily_qa_logs_reviewed']->value == 'N') ? " selected='selected'" : "").">N</option>
                  </select></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class='span4'>
        <h3 class='center-horizontal'>Table Incrementation</h3>
        <h4 class='center-horizontal'>Ruler</h4>
        <table class='table table-bordered table-striped'>
          <thead>
          </thead>
          <tbody>
            <tr>
              <td>&plusmn;1mm?</td>
              <td class='control-group'><select id='form_entry_form_values_table_incrementation' name='form_entry[form_values][table_incrementation]'>
                    <option value='NULL'".(($id != false && $formEntry->formValues['table_incrementation']->value == 'NULL') ? " selected='selected'" : "")."></option>
                    <option value='Y'".(($id != false && $formEntry->formValues['table_incrementation']->value == 'Y') ? " selected='selected'" : "").">Y</option>
                    <option value='N'".(($id != false && $formEntry->formValues['table_incrementation']->value == 'N') ? " selected='selected'" : "").">N</option>
                  </select></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class='span4'>
        <h3 class='center-horizontal'>Slice Thickness</h3>
        <h4 class='center-horizontal'>Slice 1-5</h4>
        <table class='table table-bordered table-striped'>
          <thead>
          </thead>
          <tbody>
            <tr>
              <td>Slice Thickness (mm)</td>
              <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][slice_thickness]' class='form_entry_form_values_slice_thickness span12' id='form_entry_form_values_slice_thickness' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['slice_thickness']->value)."'")."/></td>
              <td>3</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class='row-fluid'>
      <div class='span6'>
        <h3 class='center-horizontal'>Field Uniformity (head)</h3>
        <h4 class='center-horizontal'>Slice 3-5 (-431 mm)</h4>
        <table class='table table-bordered table-striped'>
          <thead>
            <tr>
              <th>ROI</th>
              <th>CT #</th>
              <th>Nominal</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][field_uniformity_1_value]' class='form_entry_form_values_field_uniformity_1_value span12' id='form_entry_form_values_field_uniformity_1_value' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['field_uniformity_1_value']->value)."'")."/></td>
              <td>0&plusmn;5</td>
            </tr>
            <tr>
              <td>2</td>
              <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][field_uniformity_2_value]' class='form_entry_form_values_field_uniformity_2_value span12' id='form_entry_form_values_field_uniformity_2_value' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['field_uniformity_2_value']->value)."'")."/></td>
              <td>0&plusmn;5</td>
            </tr>
            <tr>
              <td>3</td>
              <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][field_uniformity_3_value]' class='form_entry_form_values_field_uniformity_3_value span12' id='form_entry_form_values_field_uniformity_3_value' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['field_uniformity_3_value']->value)."'")."/></td>
              <td>0&plusmn;5</td>
            </tr>
            <tr>
              <td>4</td>
              <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][field_uniformity_4_value]' class='form_entry_form_values_field_uniformity_4_value span12' id='form_entry_form_values_field_uniformity_4_value' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['field_uniformity_4_value']->value)."'")."/></td>
              <td>0&plusmn;5</td>
            </tr>
            <tr>
              <td>5</td>
              <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][field_uniformity_5_value]' class='form_entry_form_values_field_uniformity_5_value span12' id='form_entry_form_values_field_uniformity_5_value' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['field_uniformity_5_value']->value)."'")."/></td>
              <td>0&plusmn;5</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class='span6'>
        <h3 class='center-horizontal'>Noise (head)</h3>
        <h4 class='center-horizontal'>Slice 3-5 (-431 mm)</h4>
        <table class='table table-bordered table-striped'>
          <thead>
            <tr>
              <th>ROI</th>
              <th>Standard Deviation</th>
              <th>Nominal</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][noise_1_stddev]' class='form_entry_form_values_noise_1_stddev span12' id='form_entry_form_values_noise_1_stddev' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['noise_1_stddev']->value)."'")."/></td>
              <td>11&plusmn;2</td>
            </tr>
            <tr>
              <td>2</td>
              <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][noise_2_stddev]' class='form_entry_form_values_noise_2_stddev span12' id='form_entry_form_values_noise_2_stddev' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['noise_2_stddev']->value)."'")."/></td>
              <td>9&plusmn;2</td>
            </tr>
            <tr>
              <td>3</td>
              <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][noise_3_stddev]' class='form_entry_form_values_noise_3_stddev span12' id='form_entry_form_values_noise_3_stddev' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['noise_3_stddev']->value)."'")."/></td>
              <td>9&plusmn;2</td>
            </tr>
            <tr>
              <td>4</td>
              <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][noise_4_stddev]' class='form_entry_form_values_noise_4_stddev span12' id='form_entry_form_values_noise_4_stddev' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['noise_4_stddev']->value)."'")."/></td>
              <td>9&plusmn;2</td>
            </tr>
            <tr>
              <td>5</td>
              <td class='control-group'><input type='number' step='0.01' name='form_entry[form_values][noise_5_stddev]' class='form_entry_form_values_noise_5_stddev span12' id='form_entry_form_values_noise_5_stddev' ".(!($formEntry->formValues) ? "" : " value='".escape_output($formEntry->formValues['noise_5_stddev']->value)."'")."/></td>
              <td>9&plusmn;2</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <h3>Image</h3>
";
    if ($id != false && $formEntry->imagePath != '') {
      echo "<img src='".joinPaths(ROOT_URL, escape_output($formEntry->imagePath))."' /><br />
";
    }
    echo "    <div id='image_preview' class='row-fluid'></div>
    <p>Supported formats: JPEG, PNG, GIF, WBMP, GD2</p>
    <input name='form_image' class='input-file' type='file' onChange='displayImagePreview(this.files);' />
    <h3>Comments</h3>
    <textarea name='form_entry[comments]' id='form_entry_comments' rows='10' class='span12' placeholder='Comments go here.'>".(($id === false) ? "" : escape_output($formEntry->comments))."</textarea><br />
    <div class='form-actions'>
";
    if ($id != false && $formEntry->approvedOn != '') {
    echo "      <button type='submit' class='btn btn-primary disabled' disabled='disabled'>Approved</button>
";    
    } else {
    echo "      <button type='submit' class='btn btn-primary'>".(($id === false) ? "Save" : "Save changes")."</button>
";
    }
    echo "      <a class='btn' href='#' onClick='window.location.replace(document.referrer);' >".(($id === false) ? "Go back" : "Discard changes")."</a>
";
    if ($id != false && $user->isPhysicist()) {
      if ($formEntry->approvedOn == '') {
        echo "      <a class='btn btn-success' href='form_entry.php?action=approve&id=".intval($id)."'>Approve</a>
";
      } else {
        echo "      <a class='btn btn-warning' href='form_entry.php?action=unapprove&id=".intval($id)."'>Unapprove</a>
";
      }
    }
    if ($id != false && $user->isAdmin()) {
      echo "<button class='btn btn-danger delete-button' data-id='".intval($id)."'>Delete</button>\n";
    }
    echo "    </div>
    </fieldset>
</form>
";
?>