function roundNumber(num, dec) {
	var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
	return result;
}

function calculateTPCF() {
  if ($('#form_entry_form_values_temperature').val() != '' && $('#form_entry_form_values_pressure').val() != '') {
    var temp = parseFloat($('#form_entry_form_values_temperature').val());
    var pressure = parseFloat($('#form_entry_form_values_pressure').val());
    $('#form_entry_form_values_tpcf').val((760.0 * (273.2 + temp)) / ((273.2+22.0) * pressure));
    $('#form_entry_form_values_tpcf').trigger('change');
  }
}
function getMeasurementAverage(id_prefix) {
  qSum = 0;
  qCount = 0;
  if (!isNaN(parseFloat($('#' + id_prefix + '_q1').val()))) {
    qSum += parseFloat($('#' + id_prefix + '_q1').val());
    qCount++;
  }
  if (!isNaN(parseFloat($('#' + id_prefix + '_q2').val()))) {
    qSum += parseFloat($('#' + id_prefix + '_q2').val());
    qCount++;
  }
  if (!isNaN(parseFloat($('#' + id_prefix + '_q3').val()))) {
    qSum += parseFloat($('#' + id_prefix + '_q3').val());
    qCount++;
  }
  return qSum * 1.0 / qCount;
}

function calculateOutputCalibrationStats(type, id_prefix) {
  if ($('#' + id_prefix + '_q1').val() != '' || $('#' + id_prefix + '_q2').val() != '' || $('#' + id_prefix + '_q3').val() != '') {

    var qAvg = getMeasurementAverage(id_prefix);
    $('#' + id_prefix + '_avg').val(qAvg);
    
    switch ($('#form_entry_form_values_electrometer').val()) {
      case 'SI CDX 2000B #1 (S/N J073443, Kelec 1.000)':
        var electrometer_adjustment = 0.1;
        var electrometer_electron_adjustment = 1;
        var k_elec = 1;
        break;
      case 'SI CDX 2000B #2 (S/N J073444, Kelec 1.000)':
        var electrometer_adjustment = 0.1;
        var electrometer_electron_adjustment = 1;
        var k_elec = 1;
        break;
      default:
      case 'Keithley Model 614 (S/N 42215, Kelec 0.995)':
        var electrometer_adjustment = 1;
        var electrometer_electron_adjustment = 0.1;
        var k_elec = 0.995;
        break;
    }
    switch ($('#form_entry_form_values_ionization_chamber').val()) {
      case 'Farmer (S/N 944, ND.SW(Gy/C) 5.20E+07)':
        var chamber_constant = 0.520;
        var M_c_choices = {"6MeV": 20.5, "9MeV": 20.8, "12MeV": 21.0, "16MeV": 21.6, "20MeV": 21.8};
        break;
      case 'Farmer (S/N 269, ND.SW(Gy/C) 5.32E+07)':
        var chamber_constant = 0.532;
        var M_c_choices = {"6MeV": 20.0, "9MeV": 20.3, "12MeV": 20.4, "16MeV": 21.0, "20MeV": 21.2};
        break;
    }
    idPrefixParts = id_prefix.split("_");
    idPrefixLastPart = idPrefixParts[idPrefixParts.length-1];
    switch (type) {
      case 'electron':
        var p_ion = 1.01;
        break;
      case 'photon':
        p_ion = p_ion_choices[idPrefixLastPart];
        k_q = k_q_choices[idPrefixLastPart];
        D_w_abs = D_w_abs_choices[idPrefixLastPart];
        $('#' + id_prefix + '_Dw_abs').val(D_w_abs);
        break;
    }

    if ($('#form_entry_form_values_tpcf').val() != '') {
      var M = qAvg * parseFloat($('#form_entry_form_values_tpcf').val()) * p_ion * k_elec;
      $('#' + id_prefix + '_M').val(roundNumber(M, 7));
      $('#' + id_prefix + '_M').trigger('change');
      if (type == 'photon') {
        var D_w = M * k_q * chamber_constant * electrometer_adjustment;
        var percentDiff = (D_w - D_w_abs) / D_w_abs * 100;
        $('#' + id_prefix + '_Dw').val(roundNumber(D_w, 7));
        $('#' + id_prefix + '_Dw').trigger('change');
      } else if (type == 'electron') {
        var M_c = M_c_choices[idPrefixLastPart] * electrometer_electron_adjustment;
        var percentDiff = (M - M_c) / M_c * 100;
        $('#' + id_prefix + '_Mc').val(roundNumber(M_c, 7));
        $('#' + id_prefix + '_Mc').trigger('change');    
      }
      
      $('#' + id_prefix + '_diff').val(roundNumber(percentDiff, 4));
      if (id_prefix.indexOf('_adjusted') < 0) {
        // if we're in the non-adjustment form, then toggle the adjustment form's display status based on the percent diff calculated earlier.
        switch (type) {
          case 'electron':
            anyFailures = false;
            $('.form_entry_form_values_electron_output_calibration_diff').each(function() {
              anyFailures = anyFailures || (Math.abs($(this).val()) > 2.0);
              $(this).parent().toggleClass("error", (Math.abs($(this).val()) > 2.0));
              $(this).parent().toggleClass("success", (Math.abs($(this).val()) <= 2.0));
            });
            $('#electron_output_calibration_adjustment').toggle(anyFailures);
            break;
          default:
          case 'photon':
            anyFailures = false;
            $('.form_entry_form_values_photon_output_calibration_diff').each(function() {
              anyFailures = anyFailures || (Math.abs($(this).val()) > 2.0);
              $(this).parent().toggleClass("error", (Math.abs($(this).val()) > 2.0));
              $(this).parent().toggleClass("success", (Math.abs($(this).val()) <= 2.0));
            });
            $('#photon_output_calibration_adjustment').toggle(anyFailures);
            break;
        }
      } else {
        $('#' + id_prefix + '_diff').parent().toggleClass("error", (Math.abs(percentDiff) > 2.0));
        $('#' + id_prefix + '_diff').parent().toggleClass("success", (Math.abs(percentDiff) <= 2.0));
      }
    }
  }
}
function calculateTPRStats(id_prefix, outputCalibration_prefix) {
  if ($('#' + id_prefix + '_q1').val() != '' || $('#' + id_prefix + '_q2').val() != '' || $('#' + id_prefix + '_q3').val() != '') {
    var qAvg = getMeasurementAverage(id_prefix);
    console.log("qAvg: " + qAvg);
    $('#' + id_prefix + '_avg').val(qAvg);
    if ($('#' + outputCalibration_prefix + '_q1').val() == '' && outputCalibration_prefix.indexOf('_adjusted') > 0) {
      outputCalibration_prefix = outputCalibration_prefix.replace(/\_adjusted/gi, "");
    }
    var qAvg_outputCalibration = getMeasurementAverage(outputCalibration_prefix);
    console.log("outputCal: " + outputCalibration_prefix + " | " + qAvg_outputCalibration);

    idPrefixParts = id_prefix.split("_");
    idPrefixLastPart = idPrefixParts[idPrefixParts.length-1];
    
    TPR_abs = TPR_abs_choices[idPrefixLastPart];
    $('#' + id_prefix + '_TPR_abs').val(TPR_abs);
    
    var TPR = qAvg / qAvg_outputCalibration;
    var percentDiff = (TPR - TPR_abs) / TPR_abs * 100;

    $('#' + id_prefix + '_TPR').val(roundNumber(TPR, 7));
    $('#' + id_prefix + '_diff').val(roundNumber(percentDiff, 2));
    $('#' + id_prefix + '_diff').parent().toggleClass("error", (Math.abs(percentDiff) > 2.0));
    $('#' + id_prefix + '_diff').parent().toggleClass("success", (Math.abs(percentDiff) <= 2.0));
    $('#' + id_prefix + '_TPR').trigger('change');
  }
}
function calculateGatingStats(id_prefix, TPR_prefix) {
  if ($('#' + id_prefix + '_q1').val() != '' || $('#' + id_prefix + '_q2').val() != '' || $('#' + id_prefix + '_q3').val() != '') {
    var qAvg = getMeasurementAverage(id_prefix);
    $('#' + id_prefix + '_avg').val(qAvg);
    if ($('#' + TPR_prefix + '_q1').val() != '' || $('#' + TPR_prefix + '_q2').val() != '' || $('#' + TPR_prefix + '_q3').val() != '') {
      var qAvg_TPR = getMeasurementAverage(TPR_prefix);
      $('#' + id_prefix + '_TPR_abs').val(qAvg_TPR);
      var percentDiff = (qAvg - qAvg_TPR) / qAvg_TPR * 100;

      $('#' + id_prefix + '_TPR').val(roundNumber(qAvg, 7));
      $('#' + id_prefix + '_TPR').trigger('change');
      $('#' + id_prefix + '_diff').val(roundNumber(percentDiff, 2));
      $('#' + id_prefix + '_diff').parent().toggleClass("error", (Math.abs(percentDiff) > 2.0));
      $('#' + id_prefix + '_diff').parent().toggleClass("success", (Math.abs(percentDiff) <= 2.0));
    }
  }
}
function calculateEDWStats(id_prefix, TPR_prefix) {
  if ($('#' + id_prefix + '_q1').val() != '' || $('#' + id_prefix + '_q2').val() != '' || $('#' + id_prefix + '_q3').val() != '') {
    var qAvg = getMeasurementAverage(id_prefix);
    $('#' + id_prefix + '_avg').val(qAvg);
    var qAvg_TPR = getMeasurementAverage(TPR_prefix);

    idPrefixParts = id_prefix.split("_");
    idPrefixLastPart = idPrefixParts[idPrefixParts.length-1];
    WF_abs = WF_abs_choices[idPrefixLastPart];
    
    $('#' + id_prefix + '_WF_abs').val(WF_abs);
    
    var WF = qAvg / qAvg_TPR;
    var percentDiff = (WF - WF_abs) / WF_abs * 100;

    $('#' + id_prefix + '_WF').val(roundNumber(WF, 7));    
    $('#' + id_prefix + '_WF').trigger('change');
    $('#' + id_prefix + '_diff').val(roundNumber(percentDiff, 2));
    $('#' + id_prefix + '_diff').parent().toggleClass("error", (Math.abs(percentDiff) > 2.0));
    $('#' + id_prefix + '_diff').parent().toggleClass("success", (Math.abs(percentDiff) <= 2.0));
  }
}
function calculateEnergyRatioStats(id_prefix, outputCalibration_prefix) {
  if ($('#' + id_prefix + '_q1').val() != '' || $('#' + id_prefix + '_q2').val() != '' || $('#' + id_prefix + '_q3').val() != '') {
    var qAvg = getMeasurementAverage(id_prefix);
    $('#' + id_prefix + '_avg').val(qAvg);
    if ($('#' + outputCalibration_prefix + '_q1').val() == '' && outputCalibration_prefix.indexOf('_adjusted') > 0) {
      outputCalibration_prefix = outputCalibration_prefix.replace(/\_adjusted/gi, "");
    }
    var qAvg_outputCalibration = getMeasurementAverage(outputCalibration_prefix);
    
    percentDiff_mins = {"6MeV": 0.6921, "9MeV": 0.7763, "12MeV": 0.861, "16MeV": 0.812, "20MeV": 0.840};
    percentDiff_maxes = {"6MeV": 0.9368, "_9MeV": 0.9362, "12MeV": 0.949, "16MeV": 0.889, "20MeV": 0.884};

    idPrefixParts = id_prefix.split("_");
    idPrefixLastPart = idPrefixParts[idPrefixParts.length-1];

    var PDD = qAvg / qAvg_outputCalibration;
    var PDD_ref = PDD_ref_choices[idPrefixLastPart];
    var percentDiff = (PDD - PDD_ref) / PDD_ref * 100;

    $('#' + id_prefix + '_PDD').val(roundNumber(PDD, 7));    
    $('#' + id_prefix + '_PDD').trigger('change');
    $('#' + id_prefix + '_PDD_abs').val(roundNumber(PDD_ref, 4));    
    $('#' + id_prefix + '_PDD_abs').trigger('change');
    $('#' + id_prefix + '_diff').val(roundNumber(percentDiff, 2));
    $('#' + id_prefix + '_diff').parent().toggleClass("error", ((PDD > percentDiff_maxes[idPrefixLastPart]) || (PDD < percentDiff_mins[idPrefixLastPart])));
    $('#' + id_prefix + '_diff').parent().toggleClass("success", ((PDD <= percentDiff_maxes[idPrefixLastPart]) && (PDD >= percentDiff_mins[idPrefixLastPart])));
  }
}

function calculateAllOutputCalibrationStats() {
  calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_6MV'); 
  calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_10MV');
  calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_15MV');
  calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_18MV');
  calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_6XFFF');
  calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_10XFFF');
  calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_6MeV'); 
  calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_9MeV'); 
  calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_12MeV'); 
  calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_16MeV'); 
  calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_20MeV'); 
  calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_adjusted_6MV'); 
  calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_adjusted_10MV');
  calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_adjusted_15MV');
  calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_adjusted_18MV');
  calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_adjusted_6XFFF');
  calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_adjusted_10XFFF');
  calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_6MeV'); 
  calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_9MeV'); 
  calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_12MeV'); 
  calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_16MeV'); 
  calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_20MeV'); 
}

function calculateAllTPRStats() {
  calculateTPRStats('form_entry_form_values_tpr_6MV', 'form_entry_form_values_photon_output_calibration_adjusted_6MV');
  calculateTPRStats('form_entry_form_values_tpr_10MV', 'form_entry_form_values_photon_output_calibration_adjusted_10MV');
  calculateTPRStats('form_entry_form_values_tpr_15MV', 'form_entry_form_values_photon_output_calibration_adjusted_15MV');
  calculateTPRStats('form_entry_form_values_tpr_18MV', 'form_entry_form_values_photon_output_calibration_adjusted_18MV');
  calculateTPRStats('form_entry_form_values_tpr_6XFFF', 'form_entry_form_values_photon_output_calibration_adjusted_6XFFF');
  calculateTPRStats('form_entry_form_values_tpr_10XFFF', 'form_entry_form_values_photon_output_calibration_adjusted_10XFFF');
}

function calculateAllGatingStats() {
  calculateGatingStats('form_entry_form_values_gating_6MV', 'form_entry_form_values_tpr_6MV');
}

function calculateAllEDWStats() {
  calculateEDWStats('form_entry_form_values_edw_6MV', 'form_entry_form_values_tpr_6MV');
  calculateEDWStats('form_entry_form_values_edw_10MV', 'form_entry_form_values_tpr_10MV');
  calculateEDWStats('form_entry_form_values_edw_15MV', 'form_entry_form_values_tpr_15MV');
  calculateEDWStats('form_entry_form_values_edw_18MV', 'form_entry_form_values_tpr_18MV');
}

function calculateAllEnergyRatioStats() {
  calculateEnergyRatioStats('form_entry_form_values_energy_ratio_6MeV', 'form_entry_form_values_electron_output_calibration_adjusted_6MeV');
  calculateEnergyRatioStats('form_entry_form_values_energy_ratio_9MeV', 'form_entry_form_values_electron_output_calibration_adjusted_9MeV');
  calculateEnergyRatioStats('form_entry_form_values_energy_ratio_12MeV', 'form_entry_form_values_electron_output_calibration_adjusted_12MeV');
  calculateEnergyRatioStats('form_entry_form_values_energy_ratio_16MeV', 'form_entry_form_values_electron_output_calibration_adjusted_16MeV');
  calculateEnergyRatioStats('form_entry_form_values_energy_ratio_20MeV', 'form_entry_form_values_electron_output_calibration_adjusted_20MeV');
  calculateEnergyRatioStats('form_entry_form_values_energy_ratio_6MeV', 'form_entry_form_values_electron_output_calibration_adjusted_6MeV');
  calculateEnergyRatioStats('form_entry_form_values_energy_ratio_9MeV', 'form_entry_form_values_electron_output_calibration_adjusted_9MeV');
  calculateEnergyRatioStats('form_entry_form_values_energy_ratio_12MeV', 'form_entry_form_values_electron_output_calibration_adjusted_12MeV');
  calculateEnergyRatioStats('form_entry_form_values_energy_ratio_16MeV', 'form_entry_form_values_electron_output_calibration_adjusted_16MeV');
  calculateEnergyRatioStats('form_entry_form_values_energy_ratio_20MeV', 'form_entry_form_values_electron_output_calibration_adjusted_20MeV');
}

function calculateAllDosimetryStats() {
  calculateAllOutputCalibrationStats();
  calculateAllTPRStats();
  calculateAllGatingStats();
  calculateAllEDWStats();
  calculateAllEnergyRatioStats();
}

function bindAllOutputCalibrationStats() {
  // bind all events related to the output calibration tables.
  $('#form_entry\\[machine_id\\]').change(function() {
    $.getScript("machine.php?action=get_parameters&id=" + $(this).val(), function() {
      calculateAllDosimetryStats();
    });
  });


  entries = [ 
    {'name': '6MV', 'type': 'photon'},
    {'name': '10MV', 'type': 'photon'},
    {'name': '15MV', 'type': 'photon'},
    {'name': '18MV', 'type': 'photon'},
    {'name': '6XFFF', 'type': 'photon'},
    {'name': '10XFFF', 'type': 'photon'},
    {'name': '6MeV', 'type': 'electron'},
    {'name': '9MeV', 'type': 'electron'},
    {'name': '12MeV', 'type': 'electron'},
    {'name': '16MeV', 'type': 'electron'},
    {'name': '20MeV', 'type': 'electron'}
  ];
  for (var i = 0; i < entries.length; i++) {
    if (entries[i]['type'] == 'photon') {
      $('.form_entry_form_values_photon_output_calibration_adjusted_' + entries[i]['name']).each(function() {
        $(this).change({entry: entries[i]}, function(event) {
          calculateOutputCalibrationStats(event.data.entry['type'], 'form_entry_form_values_photon_output_calibration_adjusted_' + event.data.entry['name']);
        });
      });
      $('.form_entry_form_values_photon_output_calibration_' + entries[i]['name']).each(function() {
        $(this).change({entry: entries[i]}, function(event) {
          calculateOutputCalibrationStats(event.data.entry['type'], 'form_entry_form_values_photon_output_calibration_' + event.data.entry['name']);
        });
      });
    } else if (entries[i]['type'] == 'electron') {
      $('.form_entry_form_values_electron_output_calibration_adjusted_' + entries[i]['name']).each(function() {
        $(this).change({entry: entries[i]}, function(event) {
          calculateOutputCalibrationStats(event.data.entry['type'], 'form_entry_form_values_electron_output_calibration_adjusted_' + event.data.entry['name']);
          calculateEnergyRatioStats('form_entry_form_values_energy_ratio_' + event.data.entry['name'], 'form_entry_form_values_electron_output_calibration_adjusted_' + event.data.entry['name']);
        });
      });
      $('.form_entry_form_values_electron_output_calibration_' + entries[i]['name']).each(function() {
        $(this).change({entry: entries[i]}, function(event) {
          calculateOutputCalibrationStats(event.data.entry['type'], 'form_entry_form_values_electron_output_calibration_' + event.data.entry['name']);
          calculateEnergyRatioStats('form_entry_form_values_energy_ratio_' + event.data.entry['name'], 'form_entry_form_values_electron_output_calibration_adjusted_' + event.data.entry['name']);
        });
      });
    }
  }
}

function bindAllTPREvents() {
  // bind all events related to the TPR.
  entries = [
    {'name': '6MV', 'type': 'photon'},
    {'name': '10MV', 'type': 'photon'},
    {'name': '15MV', 'type': 'photon'},
    {'name': '18MV', 'type': 'photon'},
    {'name': '6XFFF', 'type': 'photon'},
    {'name': '10XFFF', 'type': 'photon'}
  ];
  $('#form_entry_form_values_photon_output_calibration_6MV_Dw').change(function() {
    calculateTPRStats('form_entry_form_values_tpr_6MV', 'form_entry_form_values_photon_output_calibration_adjusted_6MV');
  });
  $('#form_entry_form_values_photon_output_calibration_18MV_Dw').change(function() {
    calculateTPRStats('form_entry_form_values_tpr_18MV', 'form_entry_form_values_photon_output_calibration_adjusted_18MV');
  });
  $('#form_entry_form_values_photon_output_calibration_adjusted_6MV_Dw').change(function() {
    calculateTPRStats('form_entry_form_values_tpr_6MV', 'form_entry_form_values_photon_output_calibration_adjusted_6MV');
  });
  $('#form_entry_form_values_photon_output_calibration_adjusted_18MV_Dw').change(function() {
    calculateTPRStats('form_entry_form_values_tpr_18MV', 'form_entry_form_values_photon_output_calibration_adjusted_18MV');
  });
  for (var i = 0; i < entries.length; i++) {
    $('.form_entry_form_values_tpr_' + entries[i]['name']).each(function() {
      $(this).change({entry: entries[i]}, function(event) {
        calculateTPRStats('form_entry_form_values_tpr_' + event.data.entry['name'], 'form_entry_form_values_photon_output_calibration_adjusted_' + event.data.entry['name']);
      });
    });
  }
}

function bindAllEDWEvents() {
  // bind all events related to the EDW.
  entries = [
    {'name': '6MV', 'type': 'photon'},
    {'name': '10MV', 'type': 'photon'},
    {'name': '15MV', 'type': 'photon'},
    {'name': '18MV', 'type': 'photon'},
  ];
  for (var i = 0; i < entries.length; i++) {
    $('.form_entry_form_values_edw_' + entries[i]['name']).each(function() {
      $(this).change({entry: entries[i]}, function(event) {
        calculateEDWStats('form_entry_form_values_edw_' + event.data.entry['name'], 'form_entry_form_values_tpr_' + event.data.entry['name']);
      });
    });
  }
}

function displayImagePreview(files) {
  for (var i = 0; i < files.length; i++) {
    var file = files[i];
    var imageType = /image.*/;
    
    if (!file.type.match(imageType)) {
      continue;
    }
    var img = document.createElement("img");
    img.classList.add("obj");
    img.file = file;
    
    $('#image_preview').empty().append($('<div class="span6"></div>')).append($('<div class="span6"></div>'));
    $('#image_preview').children(':first-child').each(function() {
      $(this).append(img);
      $(this).children().each(function() {
        $(this).addClass('image-preview');
      });
    });
    $('#image_preview').children(':nth-child(2)').each(function() {
      $(this).append($('<h4>Preview</h4>'));
    });
    
    var reader = new FileReader();
    reader.onload = (function(aImg) { return function(e) { aImg.src = e.target.result; }; })(img);
    reader.readAsDataURL(file);
  }
}

$(document).ready(function() {
  $('#form_entry_created_at').datetimepicker();
  $('#form_entry_form_values_temperature').change(function() {calculateTPCF();});
  $('#form_entry_form_values_pressure').change(function() {calculateTPCF();});
  $('#form_entry_form_values_tpcf').change(function() { 
    calculateAllOutputCalibrationStats();
  });
  
  $('#form_entry_form_values_ionization_chamber').change(function() {
    calculateAllOutputCalibrationStats();
  });
  $('#form_entry_form_values_electrometer').change(function() {
    calculateAllOutputCalibrationStats();
  });
  $('.form_entry_form_values_gating_6MV').each(function() {
    $(this).change(function() {
      calculateGatingStats('form_entry_form_values_gating_6MV', 'form_entry_form_values_tpr_6MV');
    });
  });
  $('.form_entry_form_values_energy_ratio_6MeV').each(function() {
    $(this).change(function() {
      calculateEnergyRatioStats('form_entry_form_values_energy_ratio_6MeV', 'form_entry_form_values_electron_output_calibration_adjusted_6MeV');
    });
  });
  $('.form_entry_form_values_energy_ratio_9MeV').each(function() {
    $(this).change(function() {
      calculateEnergyRatioStats('form_entry_form_values_energy_ratio_9MeV', 'form_entry_form_values_electron_output_calibration_adjusted_9MeV');
    });
  });
  $('.form_entry_form_values_energy_ratio_12MeV').each(function() {
    $(this).change(function() {
      calculateEnergyRatioStats('form_entry_form_values_energy_ratio_12MeV', 'form_entry_form_values_electron_output_calibration_adjusted_12MeV');
    });
  });
  $('.form_entry_form_values_energy_ratio_16MeV').each(function() {
    $(this).change(function() {
      calculateEnergyRatioStats('form_entry_form_values_energy_ratio_16MeV', 'form_entry_form_values_electron_output_calibration_adjusted_16MeV');
    });
  });
  $('.form_entry_form_values_energy_ratio_20MeV').each(function() {
    $(this).change(function() {
      calculateEnergyRatioStats('form_entry_form_values_energy_ratio_20MeV', 'form_entry_form_values_electron_output_calibration_adjusted_20MeV');
    });
  });
  calculateAllOutputCalibrationStats();
  calculateAllTPRStats();
  calculateAllGatingStats();
  calculateAllEDWStats();
  calculateAllEnergyRatioStats();
  bindAllOutputCalibrationStats();
  bindAllTPREvents();
  bindAllEDWEvents();
});