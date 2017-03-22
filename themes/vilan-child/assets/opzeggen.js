jQuery( document ).ready(function($){
	$('#cabman_login').click( login_zendesk );
	$('#cabman_send_opzeggen').click( sendOpzeggen );
	
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
			}
		});
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
	
	function sendOpzeggen()
	{
		var total = jQuery('#aantal').find(':selected').val();
		var radioValue = jQuery('input[name="abotype"]:checked').val();
		var sims = [];
		var ssas = [];
		var errorString = "";
	
		jQuery('*[class*="formrow"]').each(function(index, row)
		{
			if(radioValue === "SSA" && !hasClass(row, "ssa"))
			{			
				return;
			}
		
			if(radioValue === "VMA" && !hasClass(row, "vma"))
			{			
				return;
			}

			var id = row.className.match(/\d+$/)[0];		
			if(id <= total)
			{
				if(hasClass(row, "vma"))
				{
					var simValue = row.querySelector('#off_abosim').value;
					if(isNullOrEmpty(simValue))
					{
						errorString += "Simkaartnummer is niet overal ingevuld\n";
					}
					sims.push(simValue);
				}
				if(hasClass(row, "ssa"))			
				{
					var licenseValue = row.querySelector('#off_licenceplate').value;
					if(isNullOrEmpty(licenseValue))
					{
						errorString += "Simkaartnummer is niet overal ingevuld\n";
					}
					var serialValue = row.querySelector('#off_aboserial').value;
					if(isNullOrEmpty(serialValue))
					{
						errorString += "Serienummer is niet overal ingevuld\n";
					}
					var bct = { 
						licensePlate: licenseValue,
						serial: serialValue
					}; 
					ssas.push(bct);
				}			
			}		
		});
	
		if(isNullOrEmpty(jQuery('#off_abodate').val()))
		{
			errorString += "Vul a.u.b. een datum in.\n";
		}
		else
		{
			var dateValue = new Date(jQuery('#off_abodate').val());
			var today = new Date();
			today.setHours(0,0,0,0);
			if(dateValue < today)
			{
				errorString += "Vul a.u.b. een datum na of gelijk aan vandaag in\n";
			}
		}	
	
		if(isNullOrEmpty(jQuery('#off_aboreden').val()))
		{
			errorString += "Vul a.u.b. een reden van opzegging in\n";
		}
	
		if(!jQuery("#termsofagreement:checked").length)
		{
			errorString += 'U dient akkoord te gaan met de algemene voorwaarden.\n';		
		}
	
		if(!isNullOrEmpty(errorString))
		{
			alert(errorString);
			return;
		}
	
		jQuery('#loaderContainer').show();
		jQuery('#loader').show();
		
		var user = document.userData.user;
		var params = {
					sims : JSON.stringify(sims),
					ssas: JSON.stringify(ssas),
					companyPerson : user.name,
					companyEmail : user.email,
					date: jQuery('#off_abodate').val(),
					reason: jQuery('#off_aboreden').val()
				};		
		var data = { action: "send_opzeggen", parameters: params };
		
		$.ajax({
			url:ajaxurl, //"/wp-admin/admin-ajax.php",
			type:'POST',
			data: data,
			success:function(req)
			{
				jQuery('#loaderContainer').hide();
				jQuery('#loader').hide();
				jQuery('#formContainer').hide();
				jQuery('#successText').show();
			},
			error: function (req) {
				jQuery('#loaderContainer').hide();
				jQuery('#loader').hide();	
				alert('Er ging iets mis met het met de aanvraag');
			}
		});
	}
});

function valueChanged()
{
	var total = jQuery('#aantal').find(':selected').val();
	var radioValue = jQuery('input[name="abotype"]:checked')[0].value;
	
	jQuery('*[class*="formrow"]').each(function(index, row)
	{
		if(radioValue === "SSA" && !hasClass(row, "ssa"))
		{
			row.style.display = 'none';
			return;
		}
		
		if(radioValue === "VMA" && !hasClass(row, "vma"))
		{
			row.style.display = 'none';
			return;
		}

		var id = row.className.match(/\d+$/)[0];		
		if(id > total)
		{
			row.style.display = 'none';
		}
		else
		{
			row.style.display = 'block';
		}
	});
}

function hasClass(element, cls) 
{
    return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
}

function isNullOrEmpty (string)
{
	return (!string || string.length === 0);
}
