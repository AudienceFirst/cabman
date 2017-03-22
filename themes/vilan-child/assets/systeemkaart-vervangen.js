jQuery( document ).ready(function($) {
	$('#alternative').click(function(){
		if($('#alt_address').is(':visible'))
		{
			$('#alt_address').slideUp();
		}else
		{
			$('#alt_address').slideDown();
		}
	});
	
	function sendSyskaartVervangen()
	{
		var errorString = "";	

		var listComplete = true;	
		
		if(isNullOrEmpty($('#klantnaam').val()))
		{
			errorString += 'Klantnaam is verplicht.\n';		
		}
		if(isNullOrEmpty($('#seriesnummer_bct').val()))
		{
			errorString += 'Serienummer Cabman BCT* is verplicht.\n';		
		}
		if(isNullOrEmpty($('#serienummer_systeemkaart').val()))
		{
			errorString += 'Serienummer Systeemkaart* is verplicht.\n';
		}
		if(isNullOrEmpty($('#kenteken').val()))
		{
			errorString += 'Kenteken* is verplicht.\n';
		}
		if(isNullOrEmpty($('#voertuigtype').val()))
		{
			errorString += 'Voertuigtype is verplicht.\n';
		}
		if(isNullOrEmpty($('#foto').val()))
		{
			errorString += 'Foto is verplicht.\n';
		}
			
		var useAlternativeAddress = $("#alternative:checked").length;
		if(useAlternativeAddress)
		{
			if(isNullOrEmpty($('#off_vest').val()))
			{
				errorString += 'Vestiging is verplicht.\n';		
			}
			if(isNullOrEmpty($('#off_cont').val()))
			{
				errorString += 'Contact persoon is verplicht.\n';		
			}
			if(isNullOrEmpty($('#off_strn').val()))
			{
				errorString += 'Straatnaam is verplicht.\n';
			}
			if(isNullOrEmpty($('#off_huisn').val()))
			{
				errorString += 'Huisnummer is verplicht.\n';
			}
			if(isNullOrEmpty($('#off_postc').val()))
			{
				errorString += 'Postcode is verplicht.\n';
			}
			if(isNullOrEmpty($('#off_stad').val()))
			{
				errorString += 'Plaats is verplicht.\n';
			}
		}
		
		if(!$("#termsofagreement:checked").length)
		{
			errorString += 'U dient akkoord te gaan met de algemene voorwaarden.\n';		
		}
		
		if(!isNullOrEmpty(errorString))
		{
			alert(errorString);
			return;
		}
		
		
		if(listComplete) {
			$('#loaderContainer').show();
			$('#loader').show();
			var organization = document.userData.organization;
			var user = document.userData.user;

			//i stopped here to clarify the two variables above and the php file sendRMA.php
			var params = {
					companyName : (useAlternativeAddress ? $('#off_vest').val() : organization.name),				
					companyPerson : (useAlternativeAddress ? $('#off_cont').val() : user.name),
					companyPhone : organization.organization_fields.telefoonnummer,
					companyStreet_number : (useAlternativeAddress ? ($('#off_strn').val() + ' ' + $('#off_huisn').val()) : organization.organization_fields.straat_huisnummer),				
					companyPostalCode : (useAlternativeAddress ? $('#off_postc').val() : organization.organization_fields.postcode),
					companyTown : (useAlternativeAddress ? $('#off_stad').val() : organization.organization_fields.plaats),
					companyEmail : user.email,
					klantnaam : $('#klantnaam').val(),
					vestiging : $('#vestiging').val(),
					seriesnummer_bct : $('#seriesnummer_bct').val(),
					serienummer_systeemkaart: $('#serienummer_systeemkaart').val(),
					serienummer_zegel: $('#serienummer_zegel').val(),
					kenteken : $('#kenteken').val(),
					voertuigtype : $('#voertuigtype').val(),
					foto : $('#foto').val(),
					username : document.username,
					password : document.password
				};
			
			var data = new FormData($("form#systeemkaart_vervangen_form")[0]);
			data.append('parameters', JSON.stringify(params));
			data.append('name', 'send_syskaart_vervangen');
			data.append('action', 'send_syskaart_vervangen');
			
			$.ajax({
				url:ajaxurl, //"/wp-admin/admin-ajax.php",
				type:'POST',
				data: data,
				processData: false,
	      contentType: false,
				success:function(req)
				{
					var res = $.parseJSON(req);
					$('#loaderContainer').hide();
					$('#loader').hide();	
					
					$('#formContainer').hide();
					notify("alert-success", "alert-danger", "Success!", "Formulier is verzonden");
				},
				error: function (req){
					$('#loaderContainer').hide();
					$('#loader').hide();
					notify("alert-danger", "alert-success", "Error!", "Er ging iets mis met het versturen van de Systeemkaartverzegeling");
				}
			});
		}
		
		return false;
	}
	function notify (newClass, oldClass, mainText, detailText) {
		if( $("#successText .alert").length > 0 ) {
			$('#successText').fadeOut("fast", function(){			
				$('#successText').show();
				if(oldClass.length > 0) {
					$("#successText .alert").removeClass(oldClass);
				}	
				if(newClass.length > 0) {
					$("#successText .alert").addClass(newClass);
				}
				if(mainText.length > 0) {
					$("#successText .alert strong").html(mainText);
				}
				if(detailText.length > 0) {
					$("#successText .alert .desc").html(detailText);
				}
			});
		}
		else {
			var $html = '<div class="alert '+newClass+' alert-dismissible" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '<strong>'+mainText+'</strong> <span class="desc">'+detailText+'</span>'+
                '</div>';
            $("#notify").html($html).show();
		}
	}

	function endsWith(str, suffix) {
	    return str.indexOf(suffix, str.length - suffix.length) !== -1;
	}

	function isNullOrEmpty (string)
	{
		return (!string || string.length === 0);
	}
	
	function login_zendesk()
	{
		$('#notify').hide();
		$('#loaderContainer').show();
		$('#loader').show();
		var $params = {
					action : 'login_zendesk',
					parameters : { 
						username : $('#zd_username').val(),			
						password : $('#zd_password').val()
					}		
		};

		var xhr = $.ajax({
			url:ajaxurl, //"/wp-admin/admin-ajax.php",
			type:'POST',
			data: $params,
			success: function(req)
			{
				var res = $.parseJSON(req);
				$('#loaderContainer').hide();
				$('#loader').hide();	
				
				if(res.success == '1')
				{
					document.username = $params.parameters.username;
					document.password = $params.parameters.password;
					
					document.userData = res.result;
					$('#loginContainer').toggle();
					$('#formContainer').toggle();

					var organization = document.userData.organization;
					var user = document.userData.user;
					
					$('#loggedUsername').html(user.name);
					$('#loggedCompany').html(organization.name);
					$('#loggedName').html(user.name);
					$('#loggedAddress').html(organization.organization_fields.straat_huisnummer);
					$('#loggedZip').html(organization.organization_fields.postcode);
					$('#loggedTown').html(" " + (endsWith(organization.organization_fields.plaats, 'null') ? '' : organization.organization_fields.plaats));
				}
				else
				{
					notify("alert-danger", "alert-success", "Error!", "Gebruikersnaam of wachtwoord is onjuist.");
				}
				//console.log('success');
			},
			error: function (req) {
				$('#loaderContainer').hide();
				$('#loader').hide();
				notify("alert-danger", "alert-success", "Error!", "Er ging iets mis met het aanvragen van de inbouw");
				//console.log('error');
				console.log(req);
			}
		});
	}
	
	//implement
	$('#cabman_login').click( login_zendesk );
	$('#cabman_send_syskaart_vervangen').click( sendSyskaartVervangen );
});
