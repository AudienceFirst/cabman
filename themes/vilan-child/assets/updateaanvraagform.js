jQuery( document ).ready(function($) {
	
	var plateIDs = [
		"license1",
		"license2",
		"license3",
		"license4",
		"license5",
		"license6",
		"license7",
		"license8",
		"license9",
		"license10",
	];
	var cerealIDs = [
		"cereal1",
		"cereal2",
		"cereal3",
		"cereal4",
		"cereal5",
		"cereal6",
		"cereal7",
		"cereal8",
		"cereal9",
		"cereal10",
	];
	
	var pnrInput = '';
	var licenseplates = [];
	var cereals = [];
	
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
					
					if(user) {
						$('#loggedUsername').html(user.name);
						$('#loggedName').val(user.name);
					}
					
					if(organization) {
						$('#loggedCompany').val(organization.name);
						$('#loggedAddress').html(organization.organization_fields.straat_huisnummer);
						$('#loggedZip').html(organization.organization_fields.postcode);
						$('#loggedTown').html(" " + (endsWith(organization.organization_fields.plaats, 'null') ? '' : organization.organization_fields.plaats));
					}
					
					$('.externalInput').hide();
					$('#updateContainer').show();
				}
				else
				{
					notify("alert-danger", "alert-success", "Error!", "Gebruikersnaam of wachtwoord is onjuist.");
				}
			},
			error: function (req) {
				$('#loaderContainer').hide();
				$('#loader').hide();
				notify("alert-danger", "alert-success", "Error!", "Er ging iets mis met het aanvragen van de inbouw");
				console.log(req);
			}
		});
	}
	
	function getLicensePlate(value, id) {
		$.ajax({
			url: '/wp-content/themes/vilan-child/theme-templates/CCPRequest.php',
			type: 'GET',
			data: { 'plate': value },
			success: function (response) {
				if(detectIE()) {
					var xml = new ActiveXObject("Microsoft.XMLDOM");
					xml.async = "false";
					xml.loadXML(response);
					var ieperson = $(xml).last();
					value = ieperson.text(); //1S-BB-13;13-50-012-455,HJ-25-9D;
				}
				else {
					var xmlDoc = $.parseXML(response);
					var $xml = $(xmlDoc);
					var person = $xml.find("GetSerialNumberWithLicensePlate");
					value = person[0].innerHTML; //1S-BB-13;13-50-012-455,HJ-25-9D;
				}
				
				if(!isNullOrEmpty(value)) {
					$(id).val(value);
				}
			}
		});
	}
	
	function endsWith(str, suffix) {
		if(str) {
			return str.indexOf(suffix, str.length - suffix.length) !== -1;
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
	
	$('.pnr1').keyup(function() {
		var value = $(this).val();
		if(value !== '') {
			var first = value.substring(0, 1);
			
			if(first.toLowerCase() !== 'p') {
				value = 'P' + value;
				$(this).val(value);
			}
			else if(first === 'p') {
				value = value.replace('p', 'P')
				$(this).val(value);
			}
		}
	});
	
	$('.pnr1').blur(function() {
		$(this).css("border-color", "#008fb7");
		if(!ValidatePNr($(this).val())) {
			$(this).css("border-color", "Red");
		}
	});
	
	$('.licenseplateBox').blur(function() {
		$(this).css("border-color", "#008fb7");
		if(!ValidateLicensePlate($(this).val())) {
			$(this).css("border-color", "Red");
		}
		else {
			var value = $(this).val();
			var id = "#cereal" + $(this).attr('id').replace("license", "");
			getLicensePlate(value, id);
		}
	});
	
	$('.cerealBox').blur(function() {
		$(this).css("border-color", "#008fb7");
		if(!ValidateCerealNr($(this).val())) {
			$(this).css("border-color", "Red");
		}
	});
	
	$('.numericOnly').keydown(function (e) { 
		// Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
	});
	
	$('.cerealBox').keyup(function (e) {
		var text = $(this).val();
		
		if(e.keyCode != 8) {
			if(text.length == 2 || text.length == 5 || text.length == 9) {
				text += '-';
				$(this).val(text);
				return;
			}
		}
	});
	
	$('#exampleLink').click(function(e) {
		e.preventDefault();  //stop the browser from following
		var value = 'http://cabman.nl/wp-content/themes/vilan-child/assets/excelreader/voorbeeldkentekens.xlsx';
		window.location.href = value;
	});
	
	function ValidateLicensePlate(value) {
		return ValidateLicensePlateSpecial(value);
	}
	
	function ValidateLicensePlateSpecial(value) {
		var count = (value.match(/-/g) || []).length;
		if(count == 2 || count == 0) {
			value = value.replace(/-/g, "");
			if(value.length != 6) {
				return false;
			}
			return true;
		}
		return false;
	}
	
	function ValidatePNr(value) {
		if(!value.match("^P")) {
			return false;
		}
		
		value = value.substring(1);
		return $.isNumeric(value);
	}
	
	function ValidateCerealNr(value) {
		var count = (value.match(/-/g) || []).length;
		if(count != 3) {
			return false;
		}
		
		value = value.replace(/-/g, "");
		if(value.length != 10) {
			return false;
		}
		return true;
	}
	
	var typingTimer;                //timer identifier
	var doneTypingInterval = 1000;  //time in ms, 5 second for example

	//on keyup, start the countdown
	$('#amountVehicle1').keyup(function() {
		clearTimeout(typingTimer);
		if ($('#amountVehicle1').val) {
			typingTimer = setTimeout(doneTyping, doneTypingInterval);
		}
	});
	
	function doneTyping () {
		var value = parseInt($("#amountVehicle1").val(), 10);
		value = (isNaN(value)) ? 0 : value;
		showPNRContainer(value);
	}
	
	function showPNRContainer(amount) {
		hideAllInput();
		$('#pnrInput').show();
		if(amount > 0 && amount < 11) {
			$('#xlf').val('');
			$('.xlf').hide();
			$('#licenseplateContainer').show();
			$('#pnrContainer').show();
			
			$('.licenseplateBox').each(function(index) {
				var element = $('#' + plateIDs[index]);
				if(index < amount) {
					element.show();
				}
				else {
					element.hide();
				}
			})
			
			$('.cerealBox').each(function(index) {
				var element = $('#' + cerealIDs[index]);
				if(index < amount) {
					element.show();
				}
				else {
					element.hide();
				}
			})
		}
		else if(amount > 10) {
			$('.externalInput').show();
			$('#pnrContainer').hide();
			$('#fileInputInfo').val('Vanaf 10 voertuigen dient u uw kentekens aan te leveren in een Excel bestand.');
			
			$('.licenseplateBox').each(function(index) {
				$(this).hide();
			})
			
			$('.cerealBox').each(function(index) {
				$(this).hide();
			})
			
			$('.xlf').show();
		}
	}
	
	function hideAllInput() {
		$('.externalInput').hide();
		$('#licenseplateContainer').hide();
		$('#cerealContainer').hide();
		$('#pnrInput').hide();
		$('#amountFound').hide();
	}
	
	function readLisenceplateWB(split) {
		licenseplates = [];
		$.each(split, function(i){
			var value = split[i];
			if(endsWith(value, ',')) {
				value = value.substring(0, value.length - 1);
			}
			
			value = $.trim(value);
			
			if(ValidateLicensePlateSpecial(value)) {
			   licenseplates.push(value);
			}
		});
		
		if (licenseplates == undefined || licenseplates == null || licenseplates.length == 0) {
			$('#xlf').css("border-color", "Red");
		}
		else {
			$('#amountFound').text(licenseplates.length + ' kentekens gevonden');
			$('#amountFound').show();
		}
	}
	
	function readCerealWB(split) {
		cereals = [];
		$.each(split, function(i){
			var value = split[i];
			if(endsWith(value, ',')) {
				value = value.substring(0, value.length - 1);
			}
			
			if(ValidateCerealNr(value)) {
				cereals.push(value);
			}
		});
		
		if (cereals == undefined || cereals == null || cereals.length == 0) {
			$('#xlf').css("border-color", "Red");
		}
		else {
			$('#amountFound').text(cereals.length + ' serienummers gevonden');
			$('#amountFound').show();
		}
	}
	
	function send() {
		// Make the overlay darker:
		$('#loaderContainer').css("background", "rgba(105, 89, 89, 0.5)");
		$('#loaderContainer').css("height", $('#layout-mode').height());
		$('#loaderContainer').css("left", "0");
		$('#loaderContainer').css("top", "0");
		$('#loaderContainer').show();
		
		InitializeForm();
		var errorString = ValidateForm();
		
		// Errors?
		if(!isNullOrEmpty(errorString)) {
			$('#loaderContainer').css("background", "rgba(255,255,255,0.5)");
			$('#loaderContainer').hide();
			alert(errorString);
			return;
		}
		
		// No errors? Good to go!
		handlePopUp();
	}
	
	function handlePopUp() {
		// Set the variables
		var infoText = '';
		var height = 300;
		var tableHeight = 50;
		
		infoText = 'Een BCT 2.0 update voor de P-nummer ' + pnrInput;
		infoText += ', met de volgende kentekens:';
		height += (40 * licenseplates.length);
		tableHeight += (40 * licenseplates.length);
		
		$('#headerInfo').val('Kenteken');
		$('#deviceOverview').empty();
		$.each(licenseplates, function(i){
			$('#deviceOverview').append('<tr><td>' + licenseplates[i] + '</td><td>' + cereals[i] + '</td></tr>');
		});
		
		if(tableHeight > 300) {
			tableHeight = 300;
		}
		
		if(height > 600) {
			height = 570;
		}
		
		$('#tableDiv').css("height", tableHeight);
		
		$('#summaryText').html(infoText);
		$('#updateSummary').css("position","absolute");
		$('#updateSummary').css("height",height);
		$('#updateSummary').css("top", Math.max(0, (($(window).height() - $($('#updateSummary')).outerHeight()) / 2) + $(window).scrollTop()) + "px");
		$('#updateSummary').show();
	}
	
	$('#confirmBtn').click(function() {
		$('#updateSummary').hide();
		$('#loaderContainer').css("background", "rgba(255,255,255,0.5)");
		
		$('#loader').css("top", Math.max(0, (($(window).height() - $($('#loader')).outerHeight()) / 3) + $(window).scrollTop()) + "px");
		$('#loader').show();
		
		handleZendeskTicket();
	});
	
	$('#cancelBtn').click(function() {
		$('#loaderContainer').css("background", "rgba(255,255,255,0.5)");
		$('#loaderContainer').hide();
		$('#updateSummary').hide();
	});
	
	function handleZendeskTicket() {
		var devices = [];
		var nrs = [];
		var pnrs = []
		var organization = document.userData.organization;
		var user = document.userData.user;
		
		pnrs.push(pnrInput);
		$.each(licenseplates, function(i){
			devices.push(licenseplates[i]);
		});
		$.each(cereals, function(i){
			nrs.push(cereals[i]);
		});
		
		var params =
		{
			companyName : organization.name,	
			companyPerson : user.name,
			companyPhone : organization.organization_fields.telefoonnummer,
			companyStreet_number : organization.organization_fields.straat_huisnummer,
			companyPostalCode : organization.organization_fields.postcode,
			companyTown : organization.organization_fields.plaats,
			companyEmail : user.email,
			devices: devices,
			nrs: nrs,
			pnrs: pnrs,
			username : document.username,
			password : document.password
		};
		
		var data = { action: "send_update", parameters: params };
		
		$.ajax
		({
			url:ajaxurl, //"/wp-admin/admin-ajax.php",
			type:'POST',
			data: data,
			success:function(req)
			{	
				$('#loaderContainer').hide();
				$('#loader').hide();
				$('#formContainer').hide();
				notify("alert-success", "alert-danger", "Succes!", "Bedankt voor uw aanvraag. U ontvangt een bevestiging per e-mail.");
				$('#successText').show();
			},
			error: function (req) {
				$('#loaderContainer').hide();
				$('#loader').hide();
				notify("alert-danger", "alert-success", "Error!", "Er ging iets mis met het versturen van de updates");
			}
		});
	}
	
	function InitializeForm() {
		var value = parseInt($("#amountVehicle1").val(), 10);
		if(value > 0 && value < 11) {
			InitializePNr();
			return InitializeCereal();
		}
		else {
			var step = 50;
			var licenseplatesVar = [];
			var cerealsVar = [];
			
			pnrInput = $('.pnr1').val();
			
			for (var i = 0; i < licenseplates.length;) {
				var body = GetLicenseRequestBody(i, i + step);
				$.ajax({
					url: '/wp-content/themes/vilan-child/theme-templates/CCPRequest.php',
					type: 'GET',
					async: false,
					data: { 'bulkplate': body },
					success: function (response) {
						// parse						
						if(detectIE()) {
							var xml = new ActiveXObject("Microsoft.XMLDOM");
							xml.async = "false";
							xml.loadXML(response);
							var ieperson = $(xml).last();
							value = ieperson.text(); //1S-BB-13;13-50-012-455,HJ-25-9D;
						}
						else {
							var xmlDoc = $.parseXML(response);
							var $xml = $(xmlDoc);
							var person = $xml.find("GetSerialNumberWithLicensePlatesString");
							value = person[0].innerHTML; //1S-BB-13;13-50-012-455,HJ-25-9D;
						}
						
						var arr = value.split(',');
						$.each(arr, function(key, item) {
							var split = item.split(';');
							if(split.length == 2) {
								licenseplatesVar.push(split[0]);
								cerealsVar.push(split[1]);
							}
						});
						
						i += step;
					}
				});
			}
			
			licenseplates = licenseplatesVar;
			cereals = cerealsVar;
		}
	}
	
	function detectIE() {
		var ua = window.navigator.userAgent;

		var msie = ua.indexOf('MSIE ');
		if (msie > 0) {
			// IE 10 or older => return version number
			return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
		}

		var trident = ua.indexOf('Trident/');
		if (trident > 0) {
			// IE 11 => return version number
			var rv = ua.indexOf('rv:');
			return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
		}

		var edge = ua.indexOf('Edge/');
		if (edge > 0) {
		   // Edge (IE 12+) => return version number
		   return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
		}

		// other browser
		return false;
	}
	
	function GetLicenseRequestBody(start, end) {
		var list = licenseplates.slice(start, end);
		var returnValue = '';
		$.each(list, function(key, value) {
			returnValue += value + ',';
		});
		
		if(!isNullOrEmpty(returnValue)) {
			returnValue = returnValue.substring(0, returnValue.length - 1);
		}
		
		return returnValue;
	}
	
	function InitializePNr() {
		pnrInput = $('.pnr1').val();
		
		licenseplates = [];
		$('.licenseplateBox').each(function(index) {
			if($(this).is(":visible")) {
				licenseplates.push($(this).val());
			}
		});
	}
	
	function InitializeCereal() {
		cereals = [];
		$('.cerealBox').each(function(index) {
			if($(this).is(":visible")) {
				cereals.push($(this).val());
			}
		});
	}
	
	function ValidateForm() {
		var value = parseInt($("#amountVehicle1").val(), 10);
		var errorString = ValidatePNrForm(value);
		if(!isNullOrEmpty(errorString)) {
			return errorString;
		}
		else {
			return ValidateCerealForm(value);
		}
	}
	
	function ValidateCerealForm(value) {
		var errorString = '';
		
		// Terms of agreement checked?
		if(!$("#termsofagreement:checked").length)
		{
			errorString += 'U dient akkoord te gaan met de algemene voorwaarden.\n';		
		}
		
		// validate the serial number input
		if(value > 0 && value < 11) {
			// manual input
			$('.cerealBox').each(function(index) {
				if($(this).is(":visible")) {
					if(!ValidateCerealNr($(this).val())) {
						errorString += 'Serienummer op rij ' + (index + 1) + ' is niet correct ingevuld.\n';
						$(this).css("border-color", "Red");
					}
				}
			});
		}
		return errorString;
	}
	
	function ValidatePNrForm(value) {
		var errorString = '';
		
		// Terms of agreement checked?
		if(!$("#termsofagreement:checked").length)
		{
			errorString += 'U dient akkoord te gaan met de algemene voorwaarden.\n';		
		}
		
		// validate the pnr + licenseplate input		
		if(value > 0 && value < 11) {
			// manual input
			$('.pnr1').each(function(index) {
				if(!ValidatePNr($(this).val())) {
					errorString += 'Geen geldig P-nummer gevonden.\n';
					$(this).css("border-color", "Red");
				}
			});
			
			$('.licenseplateBox').each(function(index) {
				if($(this).is(":visible")) {
					if(!ValidateLicensePlate($(this).val())) {
						errorString += 'Kenteken op rij ' + (index + 1) + ' is niet correct ingevuld.\n';
						$(this).css("border-color", "Red");
					}
				}
			});
		}
		else if(licenseplates.length > 0) {
			// excel input
			if(pnrInput.length == 0) {
				errorString += 'Geen geldig P-nummer gevonden.\n';
			}
		}
		else {
			errorString += 'Geen kentekens gevonden.\n';
		}
		
		return errorString;
	}
	
	function isNullOrEmpty (string) {
		return (!string || string.length === 0);
	}
	
	//implement
	$('#cabman_login').click( login_zendesk );
	$('#cabman_send_update').click( send );
	
	
	var X = XLSX;
	var XW = {
		/* worker message */
		msg: 'xlsx',
		/* worker scripts */
		rABS: './xlsxworker2.js',
		norABS: './xlsxworker1.js',
		noxfer: './xlsxworker.js'
	};

	function fixdata(data) {
		var o = "", l = 0, w = 10240;
		for(; l<data.byteLength/w; ++l) o+=String.fromCharCode.apply(null,new Uint8Array(data.slice(l*w,l*w+w)));
		o+=String.fromCharCode.apply(null, new Uint8Array(data.slice(l*w)));
		return o;
	}

	function get_radio_value( radioName ) {
		var radios = document.getElementsByName( radioName );
		for( var i = 0; i < radios.length; i++ ) {
			if( radios[i].checked || radios.length === 1 ) {
				return radios[i].value;
			}
		}
	}

	function to_csv(workbook) {
		var result = [];
		workbook.SheetNames.forEach(function(sheetName) {
			var csv = X.utils.sheet_to_csv(workbook.Sheets[sheetName]);
			if(csv.length > 0){
				result.push("SHEET: " + sheetName);
				result.push("");
				result.push(csv);
			}
		});
		return result.join("\n");
	}
	
	function process_wb(wb) {
		$('#amountFound').hide();
		$('#xlf').css("border-color", "#008fb7");
		var output = to_csv(wb);
		var split = output.split('\n');
		
		readLisenceplateWB(split);

	}
	
	var xlf = document.getElementById('xlf');
	function handleFile(e) {
		rABS = false;
		use_worker = false;
		var files = e.target.files;
		var f = files[0];
		{
			var reader = new FileReader();
			//var name = f.name;
			reader.onload = function(e) {
				if(typeof console !== 'undefined') console.log("onload", new Date(), rABS, use_worker);
				var data = e.target.result;
				if(use_worker) {
					xw(data, process_wb);
				} else {
					var wb;
					if(rABS) {
						wb = X.read(data, {type: 'binary'});
					} else {
					var arr = fixdata(data);
						wb = X.read(btoa(arr), {type: 'base64'});
					}
					process_wb(wb);
				}
			};
			if(rABS) reader.readAsBinaryString(f);
			else reader.readAsArrayBuffer(f);
		}
	}

	if(xlf && xlf.addEventListener) xlf.addEventListener('change', handleFile, false);
});
