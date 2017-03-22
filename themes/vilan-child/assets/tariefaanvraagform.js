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
	
	var tariffTags = {
		TAXI : "taxi",
		BUS : "bus",
		VAST : "vast",
	};
	
	var licenseplates = [];
	var tariffs = [];
	
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
					$('#loggedCompany').val(organization.name);
					$('#loggedName').val(user.name);
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
	
	function endsWith(str, suffix) {
	    return str.indexOf(suffix, str.length - suffix.length) !== -1;
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
	
	$('.licenseplateBox').blur(function() {
		$(this).css("border-color", "#008fb7");
		if(!ValidateLicensePlate($(this).val())) {
			$(this).css("border-color", "Red");
		}
	});
	
	$('#pnr1').blur(function() {
		$(this).css("border-color", "#008fb7");
		var value = $(this).val();
		if(!ValidatePNummer($(this).val())) {
			$(this).css("border-color", "Red");
		}
	});
	
	function ValidatePNummer(value) {
		if(value.toLowerCase().indexOf("p") != 0) {
			return false;
		}
		else if(!$.isNumeric(value.substring(1, value.length))) {
			return false;
		}
		return true;
	}
	
	function ValidateLicensePlate(value) {
		var count = (value.match(/-/g) || []).length;
		if(count != 2) {
			return false;
		}
		
		value = value.replace(/-/g, "");
		if(value.length != 6) {
			return false;
		}
		return true;
	}
	
	function ValidateTariff(value) {
		if(!isNullOrEmpty(value)) {
			return true;
		}
		return false;
	}
	
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
	
	$('#tariffContainer').on('keydown', '.euroNumberic', function (e) {
		var text = $(this).val();
		if(text.indexOf('€ ') != 0 || (text.indexOf('€ ') == 0 && text.length == 2)) {
			if(e.keyCode == 188 || e.keyCode == 110 || e.keyCode == 190) {
				var value = '€ 0.';
				$(this).val(value);
				e.preventDefault();
				return;
			}
			else if(text.indexOf('€ ') != 0) {
				$(this).val('€ ');
			}
		}
		
		// turn , into .
		if(e.keyCode == 188) {
			var value = $(this).val() + ".";
			$(this).val(value);
			e.preventDefault();
		}
		
		// max two decimals after . and only one .
		if(text.indexOf('.') > 0) {
			if(text.length - text.indexOf('.') > 2 || (e.keyCode == 188 || e.keyCode == 110 || e.keyCode == 190)) {
				// Allow: backspace, delete, tab, escape, enter and .
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
					 // Allow: Ctrl+A, Command+A
					(e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
					 // Allow: home, end, left, right, down, up
					(e.keyCode >= 35 && e.keyCode <= 40)) {
						 // let it happen, don't do anything
						 return;
				}
				
				$(this).val(text);
				e.preventDefault();
				return;
			}
		}
		
	
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
	
	//setup before functions
	var typingTimer;                //timer identifier
	var doneTypingInterval = 1000;  //time in ms, 5 second for example

	//on keyup, start the countdown
	$('#amountVehicle1').keyup(function() {
		clearTimeout(typingTimer);
		if ($('#amountVehicle1').val) {
			typingTimer = setTimeout(doneTyping, doneTypingInterval);
		}
	});
	
	$('#pnr1').keyup(function() {
		var value = $(this).val();
		if(value !== '') {
			var first = value.substring(0, 1);
			
			if(first.toLowerCase() !== 'p') {
				value = 'P' + value;
				$('#pnr1').val(value);
			}
			else if(first === 'p') {
				value = value.replace('p', 'P')
				$('#pnr1').val(value);
			}
		}
	});
	
	function doneTyping () {
		if ($("#amountVehicle1").val()) {
			var value = parseInt($("#amountVehicle1").val(), 10);
			$('#licenseplateContainer').show();
			if(value > 0 && value < 11) {
				$('.xlf').hide();
				$('.licenseplateBox').each(function(index) {
					var element = $('#' + plateIDs[index]);
					if(index < value) {
						element.show();
					}
					else {
						element.hide();
					}
				})
			}
			else if(value > 10) {
				$('.licenseplateBox').each(function(index) {
					$(this).hide();
				})
				
				$('.xlf').show();
			}
		}
		else {
			$('#licenseplateContainer').hide();
		}
	}
	
	$('#exampleLink').click(function(e) {
		e.preventDefault();  //stop the browser from following
		window.location.href = 'http://cabman.nl/wp-content/themes/vilan-child/assets/excelreader/voorbeeld.xlsx';
	});
	
	function addRow ()
	{	
		var rows = $('#tariffContainer .product-fieldset');	
		var numrows = rows.length + 1;
		
		var type = $('#tariff_selector_1').val();
		var elementString = '';
		
		if(type == tariffTags.TAXI) {
			var numItems = $('.taxi').length + 1;
			elementString = addTaxiTariff(numrows, 'Taxi tarief ' + numItems, 'taxi');
		}
		else if (type == tariffTags.BUS) {
			elementString = addBusTariff(numrows);
		}
		else if(type == tariffTags.VAST) {
			elementString = addVastTariff(numrows);
		}
		
	    $("#tariffContainer").append(elementString);
	}
	
	function addTaxiTariff(numrows, description, className) {
		var elementString =
			'<div class="form-group col-md-12 product-fieldset '+className+'" style="background-color: #F7F7F7;padding-left: 0px;" id="append-fieldset'+numrows+'">'+
				'<button type="button" class="close" data-dismiss="append-fieldset'+numrows+'" aria-label="Close"style="right: 5px;font-size: 30px;"><span aria-hidden="true" onclick="javascript: removeRow('+numrows+');">&times;</span></button>'+
			
				'<div class="form-group col-md-1" style="padding-left: 0px;">'+
					'<label class="numLabel" style="font-size: 20px;color: #fff;background-color: #008fb7;width: 30px;text-align: center;height: 30px;vertical-align: middle;line-height: 1.5;">'+numrows+'</label>'+
				'</div>'+
				
				'<div class="form-group col-md-2" style="clear:left;">'+
					'<label style="margin-top: 15px;">Omschrijving</label>'+
				'</div>'+
				'<div class="form-group col-md-9">'+
					'<input value="'+description+'" type="text" name="description'+numrows+'" id="description'+numrows+'" class="required form-control" style="width: 350px;" />'+
				'</div>'+
				
				'<div class="form-group col-md-2" style="margin-top: 10px;">'+
					'<label>Instap tarief</label>'+
				'</div>'+
				'<div class="form-group col-md-2">'+
					'<input placeholder="€" type="text" name="enter'+numrows+'" id="enter'+numrows+'" class="required form-control euroNumberic" style="width: 150px;" />'+
				'</div>'+
				
				'<div class="form-group col-md-3">'+
					'<label style="margin-top: 10px;">Bedrag per minuut</label>'+
				'</div>'+
				'<div class="form-group col-md-5">'+
					'<input placeholder="€" type="text" name="min'+numrows+'" id="min'+numrows+'" class="required form-control euroNumberic" style="width: 150px;" />'+
				'</div>'+
				
				'<div class="form-group col-md-2" style="margin-top: 10px;">'+
					'<label>Bedrag per KM</label>'+
				'</div>'+
				'<div class="form-group col-md-2">'+
					'<input placeholder="€" type="text" name="distance'+numrows+'" id="distance'+numrows+'" class="required form-control euroNumberic" style="width: 150px;" />'+
				'</div>'+
				
				'<div class="form-group col-md-3">'+
					'<label style="margin-top: 15px;">Wachttarief vooraf(optioneel)</label>'+
				'</div>'+
				'<div class="form-group col-md-3">'+
					'<input placeholder="€" type="text" id="wait'+numrows+'" id="wait'+numrows+'" class="required form-control euroNumberic" style="width: 150px;" />'+
				'</div>'+
			'</div>';
		return elementString;
	}
	
	function addVastTariff(numrows) {
		var numItems = $('.vast').length + 1;
		var elementString =
			'<div class="form-group col-md-12 product-fieldset vast" style="background-color: #F7F7F7;padding-left: 0px;" id="append-fieldset'+numrows+'">'+
				'<button type="button" class="close" data-dismiss="append-fieldset'+numrows+'" aria-label="Close"style="right: 5px;font-size: 30px;"><span aria-hidden="true" onclick="javascript: removeRow('+numrows+');">&times;</span></button>'+
			
				'<div class="form-group col-md-1" style="padding-left: 0px;">'+
					'<label class="numLabel" style="font-size: 20px;color: #fff;background-color: #008fb7;width: 30px;text-align: center;height: 30px;vertical-align: middle;line-height: 1.5;">'+numrows+'</label>'+
				'</div>'+
				
				'<div class="form-group col-md-2" style="clear:left;">'+
					'<label style="margin-top: 15px;">Omschrijving</label>'+
				'</div>'+
				'<div class="form-group col-md-9">'+
					'<input value="Vast tarief ' + numItems+'" type="text" name="description'+numrows+'" id="description'+numrows+'" class="required form-control" style="width: 350px;" />'+
				'</div>'+
				
				'<div class="form-group col-md-2" style="margin-top: 10px;">'+
					'<label>Vast tarief</label>'+
				'</div>'+
				'<div class="form-group col-md-2">'+
					'<input placeholder="€" type="text" name="vast'+numrows+'" id="vast'+numrows+'" class="required form-control euroNumberic" style="width: 150px;" />'+
				'</div>'+
			'</div>';
		return elementString;
	}
	
	function addBusTariff(numrows) {
		var numItems = $('.bus').length + 1;
		return addTaxiTariff(numrows, 'Bus tarief ' + numItems, 'bus');
	}
	
	function isNullOrEmpty (string)
	{
		return (!string || string.length === 0);
	}
	
	function ValidateForm() {
		var errorString = '';
		tariffs = [];
		
		// Validate pnr
		var pnr = $('#pnr1').val();
		if(!ValidatePNummer(pnr)) {
			errorString += 'Geen geldig P-nummer gevonden.\n';
			$('#pnr1').css("border-color", "Red");
		}
		
		// Validate license plate
		$('.licenseplateBox').each(function(index) {
			if($(this).is(":visible")) {
				if(!ValidateLicensePlate($(this).val())) {
					errorString += 'Kenteken op rij ' + (index + 1) + ' is niet correct ingevuld.\n';
					$(this).css("border-color", "Red");
				}
			}
		});
		
		var vehicleValue = parseInt($("#amountVehicle1").val(), 10);
		if(vehicleValue > 10 && $('#xlf').val().length == 0) {
			errorString += 'Er is geen kenteken bestand gevonden.\n';
			$('#xlf').css("border-color", "Red");
		}
		else if(isNullOrEmpty($("#amountVehicle1").val())) {
			errorString += 'Er zijn geen kentekens gevonden.\n';
		}
		else if(vehicleValue > 10 && (licenseplates == undefined || licenseplates == null || licenseplates.length == 0)) {
			errorString += 'Er is geen geldig kenteken bestand gevonden.\n';
			$('#xlf').css("border-color", "Red");
		}
		else if(vehicleValue < 11) {
			licenseplates = [];
			$('.licenseplateBox').each(function(index) {
				if($(this).is(":visible")) {
					licenseplates.push($(this).val());
				}
			});
		}
		
		// Validate tariff
		var count = $('.product-fieldset').length;
		if(count == 0) {
			errorString += 'Er zijn geen tarieven gevonden.\n';
		}
		else {
			$('.product-fieldset').each(function(index, row) {
				var tariff = {};
				// Name
				tariff.description = $(row).find('input[id^="description"]').val();
				if(tariff.description.length == 0) {
					errorString += 'Tarief ' + (index + 1) + 'heeft geen naam.\n';
					return false;
				}
				
				// Values
				var myClass = $(this).attr("class").replace("form-group col-md-12 product-fieldset", "");
				tariff.type = myClass;
				if (myClass.indexOf("vast") >= 0) {
					tariff.vast = $(row).find('input[id^="vast"]').val();
					if(!ValidateTariff(tariff.vast)) {
						errorString += 'Tarief ' + (index + 1) + ' is niet geldig.\n';
						return false;
					}
				}
				else if(myClass.indexOf("bus") >= 0 || myClass.indexOf("taxi") >= 0) {
					tariff.enter = $(row).find('input[id^="enter"]').val();
					tariff.min = $(row).find('input[id^="min"]').val();
					tariff.distance = $(row).find('input[id^="distance"]').val();
					tariff.wait = $(row).find('input[id^="wait"]').val();
					
					if(!ValidateTariff(tariff.enter) || !ValidateTariff(tariff.min) || !ValidateTariff(tariff.distance)) {
						errorString += 'Tarief ' + (index + 1) + ' is niet geldig.\n';
						return false;
					}
				}
				
				tariffs.push(tariff);
			});
		}
		
		// Terms of agreement checked?
		if(!$("#termsofagreement:checked").length)
		{
			errorString += 'U dient akkoord te gaan met de algemene voorwaarden.\n';		
		}
		
		return errorString;
	}
	
	function send() {
		var errorString = ValidateForm();
		
		// Errors?
		if(!isNullOrEmpty(errorString))
		{
			alert(errorString);
			return;
		}
		
		// No errors? Good to go!
		handlePopUp();
	}
	
	function handlePopUp() {
		// Set the variables
		var count = licenseplates.length;
		var total = 20;
		if(count < 21) {
			total += count * 15;
			$('#overTwentyRow').hide();
			$('#amountTillTwenty').html(count);
			$('#totalTillTwenty').html('€ ' + toCurrency(count * 15));
		}
		else {
			total += 20 * 15;
			count = count - 20;
			total += count * 10;
			$('#amountOverTwenty').html(count);
			$('#totalOverTwenty').html('€ ' + toCurrency(count * 10));
		}
		
		$('#totalLabel').text('€ ' + toCurrency(total));
		
		// Make the overlay darker:
		$('#loaderContainer').css("background", "rgba(105, 89, 89, 0.5)");
		$('#loaderContainer').css("height", $('#layout-mode').height());
		$('#loaderContainer').css("left", "0");
		$('#loaderContainer').css("top", "0");
		$('#loaderContainer').show();
		
		$('#costSummary').css("position","absolute");
		$('#costSummary').css("top", Math.max(0, (($(window).height() - $($('#costSummary')).outerHeight()) / 2) + $(window).scrollTop()) + "px");
		$('#costSummary').show();
	}
	
	$('#confirmBtn').click(function() {
		$('#costSummary').hide();
		$('#loaderContainer').css("background", "rgba(255,255,255,0.5)");
		
		$('#loader').css("top", Math.max(0, (($(window).height() - $($('#loader')).outerHeight()) / 3) + $(window).scrollTop()) + "px");
		$('#loader').show();
		
		handleZendeskTicket();
	});
	
	$('#cancelBtn').click(function() {
		$('#loaderContainer').css("background", "rgba(255,255,255,0.5)");
		$('#loaderContainer').hide();
		$('#costSummary').hide();
	});
	
	function handleZendeskTicket() {
		var total = 20;
		var count = licenseplates.length;
		var organization = document.userData.organization;
		var user = document.userData.user;
		var plates = [];
			
		if(count < 21) {
			total += count * 15;
		}
		else {
			total += 20 * 15;
			count = count - 20;
			total += count * 10;
		}
		
		for (i = 0; i < licenseplates.length; ++i) {
			var plate = licenseplates[i].replace(/-/g, "");
			plates.push(plate);
		}
		
		var params =
		{
			companyName : organization.name,	
			companyPerson : user.name,
			companyPhone : organization.organization_fields.telefoonnummer,
			companyStreet_number : organization.organization_fields.straat_huisnummer,				
			companyPostalCode : organization.organization_fields.postcode,
			companyTown : organization.organization_fields.plaats,
			companyEmail : user.email,
			total: total,
			plates: plates,
			pnr: $('#pnr1').val(),
			tariffs : tariffs,
			username : document.username,
			password : document.password
		};
		
		var data = { action: "send_tariff", parameters: params };
		
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
				notify("alert-danger", "alert-success", "Error!", "Er ging iets mis met het versturen van de tarieven");
			}
		});
	}
	
	function toCurrency(total) {
		return parseFloat(total, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "€ 1,").toString();
	}
	
	//implement
	$('#cabman_login').click( login_zendesk );
	$('#cabman_add_tarif').click( addRow );
	$('#cabman_send_tarief').click( send );
	
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
		$('#amountLicenseplateFound').hide();
		licenseplates = [];
		$('#xlf').css("border-color", "#008fb7");
		var output = to_csv(wb);
		var split = output.split('\n');
		
		$.each(split, function(i){
			if(ValidateLicensePlate(split[i])) {
			   licenseplates.push(split[i]);
		   }
		});
		
		if (licenseplates == undefined || licenseplates == null || licenseplates.length == 0) {
			$('#xlf').css("border-color", "Red");
		}
		else {
			$('#amountLicenseplateFound').text(licenseplates.length + ' kentekens gevonden');
			$('#amountLicenseplateFound').show();
		}
	}
	
	var xlf = document.getElementById('xlf');
	function handleFile(e) {
		rABS = false;
		use_worker = false;
		var files = e.target.files;
		var f = files[0];
		{
			var reader = new FileReader();
			var name = f.name;
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

	if(xlf.addEventListener) xlf.addEventListener('change', handleFile, false);
});

function removeRow(id) {
	jQuery('#append-fieldset'+id).remove();
	
	jQuery('.numLabel').each(function(index) {
		jQuery(this).text(index + 1);
	})
}