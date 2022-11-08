$("#seeAnotherFieldGroup").change(function() {
			if ($(this).val() == "Peridural") {
				$('#otherFieldGroupDiv').show();
				$('#nivel_e').attr('required','');
				$('#nivel_e').attr('data-error', 'Este campo es requerido.');
				$('#espacio_e').attr('required','');
				$('#espacio_e').attr('data-error', 'Este campo es requerido.');
        		$('#distancia_e').attr('required','');
				$('#distancia_e').attr('data-error', 'Este campo es requerido.');				
				$('#nivel').attr('required','');
				$('#nivel').attr('data-error', 'Este campo es requerido.');
				$('#espacio').attr('required','');
				$('#espacio').attr('data-error', 'Este campo es requerido.');
        		$('#distancia').attr('required','');
				$('#distancia').attr('data-error', 'Este campo es requerido.');
			} else {
				$('#otherFieldGroupDiv').hide();
				$('#nivel_e').removeAttr('required');
				$('#nivel_e').removeAttr('data-error');
				$('#espacio_e').removeAttr('required');
				$('#espacio_e').removeAttr('data-error');				
        		$('#distancia_e').removeAttr('required');
				$('#distancia_e').removeAttr('data-error');					
				$('#nivel').removeAttr('required');
				$('#nivel').removeAttr('data-error');
				$('#espacio').removeAttr('required');
				$('#espacio').removeAttr('data-error');				
        		$('#distancia').removeAttr('required');
				$('#distancia').removeAttr('data-error');	
			}
		});
		$("#seeAnotherFieldGroup").trigger("change");