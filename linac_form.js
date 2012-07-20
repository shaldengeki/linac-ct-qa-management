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
function calculateOutputCalibrationStats(type, id_prefix) {
  if ($('#' + id_prefix + '_q1').val() != '' && $('#' + id_prefix + '_q2').val() != '' && $('#' + id_prefix + '_q3').val() != '') {
    var qAvg = (parseFloat($('#' + id_prefix + '_q1').val()) + parseFloat($('#' + id_prefix + '_q2').val()) + parseFloat($('#' + id_prefix + '_q3').val())) / 3.0;
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
      case 'Farmer (S/N 944, ND.SW(Gy/C) 5.18E+07)':
        var chamber_constant = 0.518;
        var M_c_choices = {"_6MeV": 20.5, "_9MeV": 20.8, "12MeV": 21.0, "16MeV": 21.6, "20MeV": 21.8};
        break;
      case 'Farmer (S/N 269, ND.SW(Gy/C) 5.32E+07)':
        var chamber_constant = 0.532;
        var M_c_choices = {"_6MeV": 20.0, "_9MeV": 20.3, "12MeV": 20.4, "16MeV": 21.0, "20MeV": 21.2};
        break;
    }
    switch (type) {
      case 'electron':
        var p_ion = 1.01;
        break;
      case 'photon':
        if (id_prefix.indexOf('18MV') < 0) {
          var p_ion = 1.001;
          var k_q = 0.991;
          var D_w_abs = 0.85;
        } else {
          var p_ion = 1.004;
          var k_q = 0.965;
          var D_w_abs = 0.9;
        }
        $('#' + id_prefix + '_Dw_abs').val(D_w_abs);
        break;
    }
    
    if ($('#form_entry_form_values_tpcf').val() != '') {
      var M = qAvg * parseFloat($('#form_entry_form_values_tpcf').val()) * p_ion * k_elec;
      $('#' + id_prefix + '_M').val(roundNumber(M, 4));
      $('#' + id_prefix + '_M').trigger('change');
      if (type == 'photon') {
        var D_w = M * k_q * chamber_constant * electrometer_adjustment;
        var percentDiff = (D_w - D_w_abs) / D_w_abs * 100;
        $('#' + id_prefix + '_Dw').val(roundNumber(D_w, 4));
        $('#' + id_prefix + '_Dw').trigger('change');
      } else if (type == 'electron') {
        var M_c = M_c_choices[id_prefix.substr(-5)] * electrometer_electron_adjustment;
        var percentDiff = (M - M_c) / M_c * 100;
        $('#' + id_prefix + '_Mc').val(roundNumber(M_c, 4));
        $('#' + id_prefix + '_Mc').trigger('change');    
      }
      
      $('#' + id_prefix + '_diff').val(roundNumber(percentDiff, 4))
      if (id_prefix.indexOf('_adjusted') < 0) {
        // if we're in the non-adjustment form, then toggle the adjustment form's display status based on the percent diff calculated earlier.
        switch (type) {
          case 'electron':
            anyFailures = false;
            $('.form_entry_form_values_electron_output_calibration_diff').each(function() {
              anyFailures = anyFailures || (Math.abs($(this).val()) > 2.0);
            });
            $('#electron_output_calibration_adjustment').toggle(anyFailures);
            break;
          default:
          case 'photon':
            anyFailures = false;
            $('.form_entry_form_values_photon_output_calibration_diff').each(function() {
              anyFailures = anyFailures || (Math.abs($(this).val()) > 2.0);
            });
            $('#photon_output_calibration_adjustment').toggle(anyFailures);
            break;
        }
      }
    }
  }
}
function calculateTPRStats(id_prefix, outputCalibration_prefix) {
  if ($('#' + id_prefix + '_q1').val() != '' && $('#' + id_prefix + '_q2').val() != '' && $('#' + id_prefix + '_q3').val() != '') {
    var qAvg = (parseFloat($('#' + id_prefix + '_q1').val()) + parseFloat($('#' + id_prefix + '_q2').val()) + parseFloat($('#' + id_prefix + '_q3').val())) / 3.0;
    $('#' + id_prefix + '_avg').val(qAvg);
    if ($('#' + outputCalibration_prefix + '_q1').val() == '' && outputCalibration_prefix.indexOf('_adjusted') > 0) {
      outputCalibration_prefix = outputCalibration_prefix.replace(/\_adjusted/gi, "");
    }
      var qAvg_outputCalibration = (parseFloat($('#' + outputCalibration_prefix + '_q1').val()) + parseFloat($('#' + outputCalibration_prefix + '_q2').val()) + parseFloat($('#' + outputCalibration_prefix + '_q3').val())) / 3.0;
    if (id_prefix.indexOf('18MV') < 0) {
      var TPR_abs = 1.183;
    } else {
      var TPR_abs = 1.110;
    }
    $('#' + id_prefix + '_TPR_abs').val(TPR_abs);
    
    var TPR = qAvg / qAvg_outputCalibration;
    var percentDiff = (TPR - TPR_abs) / TPR_abs * 100;

    $('#' + id_prefix + '_TPR').val(roundNumber(TPR, 4));
    $('#' + id_prefix + '_diff').val(roundNumber(percentDiff, 2));
    $('#' + id_prefix + '_TPR').trigger('change');
  }
}
function calculateGatingStats(id_prefix, TPR_prefix) {
  if ($('#' + id_prefix + '_q1').val() != '' && $('#' + id_prefix + '_q2').val() != '' && $('#' + id_prefix + '_q3').val() != '') {
    var qAvg = (parseFloat($('#' + id_prefix + '_q1').val()) + parseFloat($('#' + id_prefix + '_q2').val()) + parseFloat($('#' + id_prefix + '_q3').val())) / 3.0;
    $('#' + id_prefix + '_avg').val(qAvg);
    if ($('#' + TPR_prefix + '_q1').val() != '' && $('#' + TPR_prefix + '_q2').val() != '' && $('#' + TPR_prefix + '_q3').val() != '') {
      var qAvg_TPR = (parseFloat($('#' + TPR_prefix + '_q1').val()) + parseFloat($('#' + TPR_prefix + '_q2').val()) + parseFloat($('#' + TPR_prefix + '_q3').val())) / 3.0;
      $('#' + id_prefix + '_TPR_abs').val(qAvg_TPR);
      var percentDiff = (qAvg - qAvg_TPR) / qAvg_TPR * 100;

      $('#' + id_prefix + '_TPR').val(roundNumber(qAvg, 4));
      $('#' + id_prefix + '_TPR').trigger('change');
      $('#' + id_prefix + '_diff').val(roundNumber(percentDiff, 2));
    }
  }
}
function calculateEDWStats(id_prefix, TPR_prefix) {
  if ($('#' + id_prefix + '_q1').val() != '' && $('#' + id_prefix + '_q2').val() != '' && $('#' + id_prefix + '_q3').val() != '') {
    var qAvg = (parseFloat($('#' + id_prefix + '_q1').val()) + parseFloat($('#' + id_prefix + '_q2').val()) + parseFloat($('#' + id_prefix + '_q3').val())) / 3.0;
    $('#' + id_prefix + '_avg').val(qAvg);
    var qAvg_TPR = (parseFloat($('#' + TPR_prefix + '_q1').val()) + parseFloat($('#' + TPR_prefix + '_q2').val()) + parseFloat($('#' + TPR_prefix + '_q3').val())) / 3.0;
    if (id_prefix.indexOf('18MV') < 0) {
      var WF_abs = 0.650;
    } else {
      var WF_abs = 0.719;
    }
    $('#' + id_prefix + '_WF_abs').val(WF_abs);
    
    var WF = qAvg / qAvg_TPR;
    var percentDiff = (WF - WF_abs) / WF_abs * 100;

    $('#' + id_prefix + '_WF').val(roundNumber(WF, 4));    
    $('#' + id_prefix + '_WF').trigger('change');
    $('#' + id_prefix + '_diff').val(roundNumber(percentDiff, 2));
  }
}
function calculateEnergyRatioStats(id_prefix, outputCalibration_prefix) {
  if ($('#' + id_prefix + '_q1').val() != '' && $('#' + id_prefix + '_q2').val() != '' && $('#' + id_prefix + '_q3').val() != '') {
    var qAvg = (parseFloat($('#' + id_prefix + '_q1').val()) + parseFloat($('#' + id_prefix + '_q2').val()) + parseFloat($('#' + id_prefix + '_q3').val())) / 3.0;
    $('#' + id_prefix + '_avg').val(qAvg);
    if ($('#' + outputCalibration_prefix + '_q1').val() == '' && outputCalibration_prefix.indexOf('_adjusted') > 0) {
      outputCalibration_prefix = outputCalibration_prefix.replace(/\_adjusted/gi, "");
    }
    var qAvg_outputCalibration = (parseFloat($('#' + outputCalibration_prefix + '_q1').val()) + parseFloat($('#' + outputCalibration_prefix + '_q2').val()) + parseFloat($('#' + outputCalibration_prefix + '_q3').val())) / 3.0;
    
    PDD_choices = {"_6MeV": 0.840, "_9MeV": 0.863, "12MeV": 0.913, "16MeV": 0.853, "20MeV": 0.862}
    
    var PDD = qAvg / qAvg_outputCalibration;
    var PDD_ref = PDD_choices[id_prefix.substr(-5)]
    var percentDiff = (PDD - PDD_ref) / PDD_ref * 100;

    $('#' + id_prefix + '_PDD').val(roundNumber(PDD, 4));    
    $('#' + id_prefix + '_PDD').trigger('change');
    $('#' + id_prefix + '_PDD_abs').val(roundNumber(PDD_ref, 4));    
    $('#' + id_prefix + '_PDD_abs').trigger('change');
    $('#' + id_prefix + '_diff').val(roundNumber(percentDiff, 2));
  }
}
$(document).ready(function() {
  $('#form_entry_created_at').datetimepicker();
  $('#form_entry_form_values_temperature').change(function() {calculateTPCF();});
  $('#form_entry_form_values_pressure').change(function() {calculateTPCF();});
  $('#form_entry_form_values_tpcf').change(function() { 
    calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_6MV'); 
    calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_18MV');
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_6MeV'); 
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_9MeV'); 
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_12MeV'); 
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_16MeV'); 
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_20MeV'); 
    calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_adjusted_6MV'); 
    calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_adjusted_18MV');
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_6MeV'); 
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_9MeV'); 
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_12MeV'); 
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_16MeV'); 
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_20MeV'); 
  });
  $('#form_entry_form_values_ionization_chamber').change(function() {
    calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_6MV'); 
    calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_18MV');
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_6MeV'); 
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_9MeV'); 
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_12MeV'); 
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_16MeV'); 
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_20MeV');
    calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_adjusted_6MV'); 
    calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_adjusted_18MV');
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_6MeV');
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_9MeV'); 
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_12MeV'); 
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_16MeV'); 
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_20MeV');
  });
  $('#form_entry_form_values_electrometer').change(function() {
    calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_6MV'); 
    calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_18MV');
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_6MeV'); 
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_9MeV'); 
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_12MeV'); 
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_16MeV'); 
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_20MeV');
    calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_adjusted_6MV'); 
    calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_adjusted_18MV');
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_6MeV'); 
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_9MeV'); 
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_12MeV'); 
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_16MeV'); 
    calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_20MeV');
  });
  $('.form_entry_form_values_photon_output_calibration_6MV').each(function() {
    $(this).change(function() {
      calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_6MV');
    });
  });
  $('.form_entry_form_values_photon_output_calibration_adjusted_6MV').each(function() {
    $(this).change(function() {
      calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_adjusted_6MV');
    });
  });
  $('.form_entry_form_values_photon_output_calibration_18MV').each(function() {
    $(this).change(function() {
      calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_18MV');
    });
  });
  $('.form_entry_form_values_photon_output_calibration_adjusted_18MV').each(function() {
    $(this).change(function() {
      calculateOutputCalibrationStats('photon', 'form_entry_form_values_photon_output_calibration_adjusted_18MV');
    });
  });
  $('#form_entry_form_values_photon_output_calibration_18MV_Dw').change(function() {
    calculateTPRStats('form_entry_form_values_tpr_18MV', 'form_entry_form_values_photon_output_calibration_18MV');
  });
  $('.form_entry_form_values_tpr_6MV').each(function() {
    $(this).change(function() {
      calculateTPRStats('form_entry_form_values_tpr_6MV', 'form_entry_form_values_photon_output_calibration_6MV');
    });
  });
  $('.form_entry_form_values_tpr_18MV').each(function() {
    $(this).change(function() {
      calculateTPRStats('form_entry_form_values_tpr_18MV', 'form_entry_form_values_photon_output_calibration_18MV');
    });
  });
  $('.form_entry_form_values_gating_6MV').each(function() {
    $(this).change(function() {
      calculateGatingStats('form_entry_form_values_gating_6MV', 'form_entry_form_values_tpr_6MV');
    });
  });
  $('.form_entry_form_values_edw_6MV').each(function() {
    $(this).change(function() {
      calculateEDWStats('form_entry_form_values_edw_6MV', 'form_entry_form_values_tpr_6MV');
    });
  });
  $('.form_entry_form_values_edw_18MV').each(function() {
    $(this).change(function() {
      calculateEDWStats('form_entry_form_values_edw_18MV', 'form_entry_form_values_tpr_18MV');
    });
  });
  $('.form_entry_form_values_electron_output_calibration_6MeV').each(function() {
    $(this).change(function() {
      calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_6MeV');
      calculateEnergyRatioStats('form_entry_form_values_energy_ratio_6MeV', 'form_entry_form_values_electron_output_calibration_adjusted_6MeV');
    });
  });
  $('.form_entry_form_values_electron_output_calibration_9MeV').each(function() {
    $(this).change(function() {
      calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_9MeV');
      calculateEnergyRatioStats('form_entry_form_values_energy_ratio_6MeV', 'form_entry_form_values_electron_output_calibration_adjusted_9MeV');
    });
  });
  $('.form_entry_form_values_electron_output_calibration_12MeV').each(function() {
    $(this).change(function() {
      calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_12MeV');
      calculateEnergyRatioStats('form_entry_form_values_energy_ratio_6MeV', 'form_entry_form_values_electron_output_calibration_adjusted_12MeV');
    });
  });
  $('.form_entry_form_values_electron_output_calibration_16MeV').each(function() {
    $(this).change(function() {
      calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_16MeV');
      calculateEnergyRatioStats('form_entry_form_values_energy_ratio_6MeV', 'form_entry_form_values_electron_output_calibration_adjusted_16MeV');
    });
  });
  $('.form_entry_form_values_electron_output_calibration_20MeV').each(function() {
    $(this).change(function() {
      calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_20MeV');
      calculateEnergyRatioStats('form_entry_form_values_energy_ratio_6MeV', 'form_entry_form_values_electron_output_calibration_adjusted_20MeV');
    });
  });
  $('.form_entry_form_values_electron_output_calibration_adjusted_6MeV').each(function() {
    $(this).change(function() {
      calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_6MeV');
      calculateEnergyRatioStats('form_entry_form_values_energy_ratio_6MeV', 'form_entry_form_values_electron_output_calibration_adjusted_6MeV');
    });
  });
  $('.form_entry_form_values_electron_output_calibration_adjusted_9MeV').each(function() {
    $(this).change(function() {
      calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_9MeV');
      calculateEnergyRatioStats('form_entry_form_values_energy_ratio_6MeV', 'form_entry_form_values_electron_output_calibration_adjusted_9MeV');
    });
  });
  $('.form_entry_form_values_electron_output_calibration_adjusted_12MeV').each(function() {
    $(this).change(function() {
      calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_12MeV');
      calculateEnergyRatioStats('form_entry_form_values_energy_ratio_6MeV', 'form_entry_form_values_electron_output_calibration_adjusted_12MeV');
    });
  });
  $('.form_entry_form_values_electron_output_calibration_adjusted_16MeV').each(function() {
    $(this).change(function() {
      calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_16MeV');
      calculateEnergyRatioStats('form_entry_form_values_energy_ratio_6MeV', 'form_entry_form_values_electron_output_calibration_adjusted_16MeV');
    });
  });
  $('.form_entry_form_values_electron_output_calibration_adjusted_20MeV').each(function() {
    $(this).change(function() {
      calculateOutputCalibrationStats('electron', 'form_entry_form_values_electron_output_calibration_adjusted_20MeV');
      calculateEnergyRatioStats('form_entry_form_values_energy_ratio_6MeV', 'form_entry_form_values_electron_output_calibration_adjusted_20MeV');
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

});