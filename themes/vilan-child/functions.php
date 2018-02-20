<?php error_reporting(0);
ini_set('max_execution_time', 120);
require_once(get_stylesheet_directory().'/lib/zendesk/zendesk.php');
require_once(get_stylesheet_directory().'/lib/class.extend.mpdf.php');
	
add_action( 'wp_ajax_send_rma', 'cabman_send_rma' );
add_action( 'wp_ajax_nopriv_send_rma', 'cabman_send_rma' );
add_action( 'wp_ajax_send_opzeggen', 'cabman_send_opzeggen' );
add_action( 'wp_ajax_nopriv_send_opzeggen', 'cabman_send_opzeggen' );
add_action( 'wp_ajax_send_tariff', 'cabman_send_tariff' );
add_action( 'wp_ajax_nopriv_send_tariff', 'cabman_send_tariff' );
add_action( 'wp_ajax_send_update', 'cabman_send_update' );
add_action( 'wp_ajax_nopriv_send_update', 'cabman_send_update' );
add_action( 'wp_ajax_send_syskaart_vervangen', 'cabman_send_syskaart_vervangen' );
add_action( 'wp_ajax_nopriv_send_syskaart_vervangen', 'cabman_send_syskaart_vervangen' );
add_action( 'wp_ajax_login_zendesk', 'cabman_login_zendesk' );
add_action( 'wp_ajax_nopriv_login_zendesk', 'cabman_login_zendesk' );
add_action( 'wp_ajax_send_rmaDE', 'cabman_send_rmaDE' );
add_action( 'wp_ajax_nopriv_send_rmaDE', 'cabman_send_rmaDE' );

function cabman_send_update(){
	$parameters = $_POST['parameters'];
	$subdomain = "cabman";
	$zendesk = new Zendesk("helpdesk@cabman.nl", "Euphoria12!", $subdomain, $suffix = '.json', $test = false);
	
	$total = $parameters['total'];
	$devices = $parameters['devices'];
	$nrs = $parameters['nrs'];
	$pnrs = $parameters['pnrs'];
	
	$intern = "";
	$body = '';
	
	if(empty($pnrs)) {
		$intern .= "Serienummers: \n";
		foreach($devices as $device) 
		{
			$intern .= $device . "\n";
		}
	}
	else {
		$intern .= "P-nummers: \n";
		foreach($pnrs as $pnr) 
		{
			$intern .= $pnr . "\n";
		}
		$intern .= "\n";
		$intern .= "Kentekens: \n";
		foreach($devices as $device) 
		{
			$intern .= $device . "\n";
		}
		
		$intern .= "\n";
		$intern .= "Serienummers: \n";
		foreach($nrs as $nr) 
		{
			$intern .= $nr . "\n";
		}
	}
	
	$intern .= "\n";
	
	$body .= "Beste " . $parameters["companyPerson"] . ",\n\nUw update aanvraag is succesvol verwerkt. U ontvangt een mail, zodra deze in behandeling is genomen.\nHierbij een uiteenzetting van de aanvraag.\n\n" . $intern;
	
	$jsonNewTicket = json_encode(array(
		"ticket" => array(
			"requester" => array("name"=>$parameters["companyPerson"], "email"=>$parameters["companyEmail"]),
			"description" => "2.0 update aanvraag",
			"subject" => "2.0 update aanvraag",
			"comment" => array("public"=>true, "body"=>$body),
			"custom_fields" => array(array("id"=>22042895, "value"=>"software_aanvraag"), array("id"=>24414195, "value"=>"cabman_bct"))
			)
		)
	);
	
	$data = $zendesk->call("/tickets", $jsonNewTicket, "POST");
	$id = "/tickets/" . recursive_array_search($data, "id");
	
	//update ticket with interal comment:
	$jsonNewTicket = json_encode(array(
		"ticket" => array(
			"description" => "update aanvraag",
			"comment" => array("public"=>false, "body"=>$intern)
			)
		)
	);
	
	$data = $zendesk->call($id, $jsonNewTicket, "PUT");
	wp_die();
	echo json_encode(array("success"=>"Success"));
}

function cabman_send_rma(){
	$parameters = $_POST['parameters'];
	$subdomain = "cabman";	
	$filePrefix = date("Y-m-d") . "_";
	$fileSuffix = "_RMABevestiging.pdf";	
	$fileName = $filePrefix . str_replace(" ", "_", $parameters['companyName']) . $fileSuffix;
	
	$zendesk = new Zendesk("helpdesk@cabman.nl", "Euphoria12!", $subdomain, $suffix = '.json', $test = false);
	
	$rmas = $parameters['rmas'];
	$tickets = array();
	
	foreach($rmas as $rma){
		if(!isset($rma['product']) || !isset($rma['serial']))
		{
			echo json_encode(array("error"=>true, "error_message"=>"Niet alle velden zijn ingevuld bij een Product"));
		}
		
		// Create a new ticket
		$body = "";
		$productName = $rma['other'];
		if(empty($productName))
		{
			$productName = $rma['product'];
		}
		
		if($rma['product'] == "Cabman BCT")
		{
			$body = "Product: " . $rma['product'] . "\nSerienummer: " . $rma['serial'] . "\nKenteken: " . $rma['licensePlate'] . "\nKlacht:\n" . $rma['complaint'];
		}
		else
		{
			$body = "Product: " . $productName . "\nSerienummer: " . $rma['serial'] . "\nKlacht:\n" . $rma['complaint'];
		}
		
		$jsonNewTicket = json_encode(array(
			"ticket" => array(
				"requester" => array("name"=>$parameters["companyPerson"], "email"=>$parameters["companyEmail"]),
				"subject" => "RMA " . $productName,
				"comment" => array("body" => $body),
				"custom_fields" => array(array("id" => 22042895, "value" => "rma"), array("id" => 24414195, "value" => $rma['product_tag']))
				)
			)
		);
		
		$data = $zendesk->call("/tickets", $jsonNewTicket, "POST");
		$tickets[] = $data;
	}
	
	$pdf_filename = generate_pdf($fileName, $parameters, $tickets, $zendesk);
	echo json_encode(array("success"=>true, "tickets"=>$tickets, "responseText"=>$pdf_filename));
	wp_die(); // this is required to terminate immediately and return a proper response
}

function cabman_send_rmaDE(){
	$parameters = $_POST['parameters'];
	$subdomain = "cabman";	
	$filePrefix = date("Y-m-d") . "_";
	$fileSuffix = "_Rücksendeformular.pdf";	
	$fileName = $filePrefix . str_replace(" ", "_", $parameters['companyName']) . $fileSuffix;
	
	$zendesk = new Zendesk("helpdesk@cabman.nl", "Euphoria12!", $subdomain, $suffix = '.json', $test = false);
	
	$rmas = $parameters['rmas'];
	$tickets = array();
	
	foreach($rmas as $rma){
		if(!isset($rma['product']) || !isset($rma['serial']))
		{
			echo json_encode(array("error"=>true, "error_message"=>"Niet alle velden zijn ingevuld bij een Product"));
		}
		
		// Create a new ticket
		$body = "";
		$productName = $rma['other'];
		if(empty($productName))
		{
			$productName = $rma['product'];
		}
		
		$body = "Produkt: " . $productName . "\nSeriennummer: " . $rma['serial'] . "\nBeschreibung der Problems:\n" . $rma['complaint'];
		
		$jsonNewTicket = json_encode(array(
			"ticket" => array(
				"requester" => array("name"=>$parameters["companyPerson"], "email"=>$parameters["companyEmail"]),
				"subject" => "Rücksendung " . $productName,
				"comment" => array("body" => $body),
				"custom_fields" => array(array("id" => 22042895, "value" => "rma"), array("id" => 24414195, "value" => $rma['product_tag']))
				)
			)
		);
		
		$data = $zendesk->call("/tickets", $jsonNewTicket, "POST");
		$tickets[] = $data;
	}
	
	$pdf_filename = generate_pdf_DE($fileName, $parameters, $tickets, $zendesk);
	echo json_encode(array("success"=>true, "tickets"=>$tickets, "responseText"=>$pdf_filename));
	wp_die(); // this is required to terminate immediately and return a proper response
}

function cabman_login_zendesk() {
	$subdomain = 'cabman';
	$parameters = $_POST['parameters'];
	
	$zendesk = new Zendesk($parameters['username'], $parameters['password'], $subdomain, $suffix = '.json', $test = false);
	$user = $zendesk->call('/users/me', '', 'GET');
	
	$zendesk2 = new Zendesk('helpdesk@cabman.nl', 'Euphoria12!', $subdomain, $suffix = '.json', $test = false);
	$organization = $zendesk2->call('/organizations/'.$user->user->organization_id, '', 'GET');	
	if(is_null($user->user->id) || !property_exists($user, 'user'))
	{
		echo json_encode(array('result'=>array(), 'success'=>0));
	}
	else
	{
		echo json_encode(array('result'=>array('user'=>$user->user, 'organization'=>$organization->organization), 'success'=>1));
	}
	wp_die(); 
}

function generate_pdf_DE($filename, $parameters, $tickets, $zendesk)
{
	$mpdf = new RMA_PDF('utf-8');
	$mpdf->debug = false;
	$mpdf->ignore_invalid_utf8 = true;
	$mpdf->AddPage();
	$mpdf->SetMargins(17,17,17);
	$mpdf->AliasNbPages();
	
	//Top 
	$logo = get_stylesheet_directory().'/assets/logo-euphoria-international.png';
	$mpdf->WriteHTML("");
	$mpdf->Image($logo,17,5,60,25);
	$mpdf->SetXY(95,10);
	$mpdf->SetFont('Arial','',11);
	//Contact Info
	$mpdf->MultiCell(100,5,"Cabman International BV\nWilhelminapark 36\n5041 EC Tilburg, Niederlande");
	$mpdf->SetXY(155,10);
	$mpdf->MultiCell(100,5,"+31(0)13-4609285\nsupport@cabman.de\nwww.cabman.de");	
	
	$mpdf->SetFont('Arial','',36);
	$mpdf->SetXY(45,40);
	$mpdf->Cell(40,10, 'Rücksendeformular');
	
	$mpdf->SetXY(17,60);
	$mpdf->SetFont('Arial','',11);
	$mpdf->Cell(100, 6, 'Datum: '. date("d-m-Y"));
	//Company Info	
	$mpdf->Ln();
	$mpdf->Ln();
	$mpdf->AddContactInfoDE(120, $parameters);
	
	$mpdf->Ln();	
	$mpdf->Ln();
	$mpdf->SetTextColor(18, 142, 180);
	$mpdf->SetFont('Arial','',16);
	$mpdf->Cell(176,10,'Produkte', 'B');	
	$mpdf->Ln();
	$mpdf->Ln();
	$mpdf->AddTotalsDE(176, $parameters['rmas']);
	//Table		
	$page_height = 279.4;
	$index = 0;
	foreach ($parameters['rmas'] as $rma)
	{
		if(($mpdf->y + 35) >= $page_height)
		{
			$mpdf->AddPage();
		}
		else
		{
			$mpdf->Ln();
			$mpdf->Ln();
		}
		$mpdf->AddTicketDE($rma, $tickets[$index]->ticket->id);
		$index++;
	}
	
	//Address label
	$mpdf->AddPage();
	$mpdf->Cell(176,100,'',1);
	$mpdf->Image($logo,20,25,60,25);
	$mpdf->SetXY(90,40);
	$mpdf->SetFont('Arial','',16);
	$mpdf->MultiCell(90,8,"Cabman International BV\nz.HD. von der Serviceabteilung\nWilhelminapark 36\n5041 EC Tilburg, Niederlande", 1);
	$mpdf->SetXY(25,100);
	$mpdf->SetFont('Arial','',11);
	$mpdf->Cell(50,6,'Absender: '. $parameters['companyName'] .', '. $parameters['companyPerson']);
	$mpdf->Ln();
	$mpdf->SetX(25);
	$mpdf->Cell(50,6,'Bezug: Rücksendeformular '. date("Y-m-d"));
	
	$original_filename = $filename;
	$filename = time()."_".$filename;
	$path = WP_CONTENT_DIR.'/uploads/pdf/';
	$dir = get_site_url().'/wp-content/uploads/pdf/';
	$mpdf->Output($path.$filename, 'F');
	
	# send email
	if(isset($parameters['companyEmail']) && filter_var( "helpdesk@cabman.nl", FILTER_VALIDATE_EMAIL ))
	{
		require_once(get_stylesheet_directory().'/lib/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->CharSet= "utf-8";
		$mail->Host = "smtp.danego.net";
		$mail->From = "support@cabman.de";
		$mail->FromName = "Cabman Support";
		$mail->AddReplyTo("noreply@euphoria-it.nl");
		$mail->AddAddress($parameters['companyEmail']);
		$mail->SetLanguage('nl', '/language/');
		$mail->AddStringAttachment($mpdf->Output('', 'S'), $filename, "base64", 'application/pdf');
		$mail->IsHTML(true);
		
		$mail->Subject  =  "Rücksendung Cabman"; // 
		$mail->Body     =  "Sehr geehrte(r) Herr/Frau,<br><br/>Ihre Rücksendeanfrage ist korrekt bei uns eingegangen.<br/>Im Anhang finden Sie Ihr Rücksendeformular und ein Adressetikett.<br/>Drucken Sie Ihr Rücksendeformular aus und legen Sie es mit in das Paket.<br/>Kleben Sie das Adressetikett oben auf das Paket.<br/>Bitte frankieren Sie die Rücksendung ordnungsgemäß, um extra Kosten für Sie zu vermeiden.<br/><br/>Mit freundlichen Grüßen,<br/><br/>Cabman International"; 
		$mail->Send();
	}
	
  $attachement = $zendesk->UploadFile($filename, $dir, $path);
  $attchJson = json_encode(
			array(
				"ticket" => array("comment"=>array("public"=>true, "body"=>"Rücksendeformular zugefügt.", "uploads"=>array($attachement->upload->token)))
			)
		);
	foreach($tickets as $ticket)
	{		
		$data = $zendesk->attachFile("/tickets/".strval($ticket->ticket->id), $attchJson, "PUT");
	}
	
	return $filename;
}

function generate_pdf($filename, $parameters, $tickets, $zendesk)
{
	$mpdf = new RMA_PDF("c");
	$mpdf->debug = false;
	$mpdf->ignore_invalid_utf8 = true;
	$mpdf->AddPage();
	$mpdf->SetMargins(17,17,17);
	$mpdf->AliasNbPages();
	
	//Top 
	$logo = get_stylesheet_directory().'/assets/logo_euphoria.png';
	$mpdf->WriteHTML("");
	$mpdf->Image($logo,17,5,60,25);
	$mpdf->SetXY(95,10);
	$mpdf->SetFont('Arial','',11);
	//Contact Info
	$mpdf->MultiCell(100,5,"Euphoria Software\nWilhelminapark 36\n5041 EC Tilburg");
	$mpdf->SetXY(145,10);
	$mpdf->MultiCell(100,5,"Telefoon: 013-4609286\nFax: 013-4609281\nE-mail: info@euphoria-it.nl");	
	
	$mpdf->SetFont('Arial','',36);
	$mpdf->SetXY(110,40);
	$mpdf->Cell(40,10,'RMA formulier');
	
	$mpdf->SetXY(17,60);
	$mpdf->SetFont('Arial','',11);
	$mpdf->Cell(100, 6, 'Datum: '. date("d-m-Y"));
	//Company Info	
	$mpdf->Ln();
	$mpdf->Ln();
	$mpdf->AddContactInfo(120, $parameters);
	
	$mpdf->Ln();	
	$mpdf->Ln();
	$mpdf->SetTextColor(18, 142, 180);
	$mpdf->SetFont('Arial','',16);
	$mpdf->Cell(176,10,'Producten', 'B');	
	$mpdf->Ln();
	$mpdf->Ln();
	$mpdf->AddTotals(176, $parameters['rmas']);
	//Table		
	$page_height = 279.4;
	$index = 0;
	foreach ($parameters['rmas'] as $rma)
	{
		if(($mpdf->y + 35) >= $page_height)
		{
			$mpdf->AddPage();
		}
		else
		{
			$mpdf->Ln();
			$mpdf->Ln();
		}
		$mpdf->AddTicket($rma, $tickets[$index]->ticket->id);
		$index++;
	}
	
	//Address label
	$mpdf->AddPage();
	$mpdf->Cell(176,100,'',1);
	$mpdf->Image($logo,20,25,60,25);
	$mpdf->SetXY(110,40);
	$mpdf->SetFont('Arial','',16);
	$mpdf->MultiCell(70,8,"Euphoria Software BV\nT.a.v. Afdeling RMA\nWilhelminapark 36\n5041 EC Tilburg\nNederland", 1);
	$mpdf->SetXY(25,100);
	$mpdf->SetFont('Arial','',11);
	$mpdf->Cell(50,6,'Afzender: '. $parameters['companyName'] .', '. $parameters['companyPerson']);
	$mpdf->Ln();
	$mpdf->SetX(25);
	$mpdf->Cell(50,6,'Betreft: RMA '. date("Y-m-d"));
	
	$original_filename = $filename;
	$filename = time()."_".$filename;
	$path = WP_CONTENT_DIR.'/uploads/pdf/';
	$dir = get_site_url().'/wp-content/uploads/pdf/';
	$mpdf->Output($path.$filename, 'F');
	
	# send email
	if(isset($parameters['companyEmail']) && filter_var( "helpdesk@cabman.nl", FILTER_VALIDATE_EMAIL ))
	{
		require_once(get_stylesheet_directory().'/lib/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->Host = "smtp.danego.net";
		$mail->From = "info@cabman.nl";
		$mail->FromName = "Cabman Helpdesk";
		$mail->AddReplyTo("noreply@euphoria-it.nl");
		$mail->AddAddress($parameters['companyEmail']);
		$mail->SetLanguage('nl', '/language/');
		$mail->AddStringAttachment($mpdf->Output('', 'S'), $filename, "base64", 'application/pdf');
		$mail->IsHTML(true);

		$mail->Subject  =  "RMA aanvraag"; // 
		$mail->Body     =  "Beste ".$parameters['companyPerson'].",<br><br/>Uw RMA aanvraag is correct ontvangen.<br/>Bijgesloten PDF bevat het RMA Formulier en een adreslabel.<br/>U dient het RMA Formulier af te drukken en toe te voegen aan het pakket. Het adreslabel dient u aan de bovenzijde van  uw pakket te plakken.<br/><br/>Met vriendelijke groet,<br/><br/>Euphoria Software"; 
		$mail->Send();
	}
	
  $attachement = $zendesk->UploadFile($filename, $dir, $path);
  $attchJson = json_encode(
			array(
				"ticket" => array("comment"=>array("public"=>true, "body"=>"RMA formulier toegevoegd.", "uploads"=>array($attachement->upload->token)))
			)
		);
	foreach($tickets as $ticket)
	{		
		$data = $zendesk->attachFile("/tickets/".strval($ticket->ticket->id), $attchJson, "PUT");
	}
	
	return $filename;
}

function cabman_send_opzeggen(){
	$parameters = $_POST['parameters'];
	$subdomain = "cabman";
	$zendesk = new Zendesk("helpdesk@cabman.nl", "Euphoria12!", $subdomain, $suffix = '.json', $test = false);
	
	$sims = json_decode(stripslashes($parameters['sims']));//test
	$ssas = json_decode(stripslashes($parameters['ssas']));//test
	
	$body = "Abonnementen annuleren voor:";
	
	foreach($sims as $sim) 
	{
		$body .= "\n\nType: Vodafone M2M abonnement (Simkaart)\nSimkaartnr: " . $sim;
	}
	
	foreach($ssas as $ssa) 
	{
		$body .= "\n\nType: Software en Service abonnement (Cabman BCT)\nKenteken: " . $ssa->licensePlate . "\nSerienummer: " . $ssa->serial;
	}
	
	$body .= "\n\nGewenste opzeg datum: ".$parameters['date'];
	$body .= "\nReden voor opzegging: ".$parameters['reason'];
	
	$jsonNewTicket = json_encode(array(
		"ticket" => array(
			"requester" => array("name"=>$parameters["companyPerson"], "email"=>$parameters["companyEmail"]),
			"subject" => "Abonnement(en) annuleren",
			"comment" => array("body"=>$body),
			"custom_fields" => array(array("id" => 22042895, "value" => "opzegging"), array("id" => 24414195, "value" => "overig"))
			)
		)
	);
	
	$data = $zendesk->call("/tickets", $jsonNewTicket, "POST");
	
	echo json_encode(array("success"=>"Success", "data"=>$data));
	wp_die();
}

function cabman_send_tariff(){
	$parameters = $_POST['parameters'];
	$subdomain = "cabman";
	$zendesk = new Zendesk("helpdesk@cabman.nl", "Euphoria12!", $subdomain, $suffix = '.json', $test = false);
	
	$total = $parameters['total'];
	$plates = $parameters['plates'];
	$pnr = $parameters['pnr'];
	$tariffs = $parameters['tariffs'];
	
	$intern = "Totaal bedrag:". $total ."\n";
	$body = '';
	$string1 = " vast";
	
	foreach($plates as $plate) 
	{
		$intern .= "\n" . $pnr . ";" . $plate;
	}
	
	$intern .= "\n";
	$val = "";
	
	foreach($tariffs as $tar) 
	{
		$val .= "\nNaam: " . $tar['description'];
		$val .= "\nType: " . $tar['type'];
		if($tar['type'] == $string1) {
			$val .= "\nVast tarief: " . $tar['vast'];
		}
		else {
			$val .= "\nInstap tarief: " . $tar['enter'];
			$val .= "\nBedrag per KM: " . $tar['distance'];
			$val .= "\nBedrag per minuut: " . $tar['min'];
			$val .= "\nWachttarief vooraf: " . $tar['wait'];
		}
		
		$val .= "\n\n";
	}
	
	$intern .= '' . $val;
	$body .= "Beste " . $parameters["companyPerson"] . ",\n\nUw tariefaanvraag is succesvol verwerkt. U ontvangt een mail, zodra deze in behandeling is genomen.\nHierbij een uiteenzetting van de aanvraag.\n" . $val;
	
	$jsonNewTicket = json_encode(array(
		"ticket" => array(
			"requester" => array("name"=>$parameters["companyPerson"], "email"=>$parameters["companyEmail"]),
			"description" => "Tarief aanvraag",
			"subject" => "Tarief aanvraag",
			"comment" => array("public"=>true, "body"=>$body),
			"custom_fields" => array(array("id"=>22042895, "value"=>"tariefaanvraag"), array("id"=>24414195, "value"=>"cabman_bct"))
			)
		)
	);
	
	$data = $zendesk->call("/tickets", $jsonNewTicket, "POST");
	$id = "/tickets/" . recursive_array_search($data, "id");
	
	//update ticket with interal comment:
	$jsonNewTicket = json_encode(array(
		"ticket" => array(
			"description" => "Tarief aanvraag",
			"comment" => array("public"=>false, "body"=>$intern)
			)
		)
	);
	
	$data = $zendesk->call($id, $jsonNewTicket, "PUT");
	echo json_encode(array("success"=>"Success"));
	wp_die();
}

function recursive_array_search($arr, $jackpot){
	foreach ($arr as $key => $value) { 
		if(is_array($value) || is_object($value))
		{
			$val=recursive_array_search($value,$jackpot) ;
			return $val;
		}
		else {
			if($key==$jackpot)
			return $value;
		}
	}
}

function cabman_send_syskaart_vervangen(){
	$parameters = json_decode(stripslashes($_POST["parameters"]));
	$file = $_FILES["foto"];
	
	$subdomain = "cabman";
	$zendesk = new Zendesk("helpdesk@cabman.nl", "Euphoria12!", $subdomain, $suffix = '.json', $test = false);
	
	$body = "Systeemkaartverzegeling:";
	$body .= "\n\nKlantnaam: ".$parameters->klantnaam;
	$body .= "\nVestiging: ".$parameters->vestiging;
	$body .= "\nSerienummer Cabman BCT: ".$parameters->seriesnummer_bct;
	$body .= "\nSerienummer Systeemkaart: ".$parameters->serienummer_systeemkaart;
	$body .= "\nSerienummer zegel: ".$parameters->serienummer_zegel;
	$body .= "\nKenteken: ".$parameters->kenteken;
	$body .= "\nVoertuigtype: ".$parameters->voertuigtype;
	
	$filename = time()."_".$file["name"];
	$path = WP_CONTENT_DIR.'/uploads/foto/';
	$dir = get_site_url().'/wp-content/uploads/foto/';
	$target_file = $path.$filename;
	move_uploaded_file($file["tmp_name"], $target_file);
	$attachment = file_get_contents($dir.$filename);
	
	require_once(get_stylesheet_directory().'/lib/class.phpmailer.php');
	$mail = new PHPMailer();
	$mail->Host = "smtp.danego.net";
	$mail->From = "info@cabman.nl";
	$mail->FromName = "Cabman Helpdesk";
	$mail->AddReplyTo("noreply@euphoria-it.nl");
	$mail->AddAddress($parameters->companyEmail);
	$mail->SetLanguage('nl', '/language/');
	$mail->AddStringAttachment($attachment, $filename, "base64");
	$mail->IsHTML(false);

	$mail->Subject  =  "Systeemkaartverzegeling"; // 
	$mail->Body     =  "Beste ".$parameters->companyPerson.",\n\n".$body."\n\nMet vriendelijke groet,\n\nEuphoria Software"; 
	$mail->Send();
	
	$zen_attachement = $zendesk->UploadFile($filename, $dir, $path);
	$jsonNewTicket = json_encode(array(
		"ticket" => array(
			"requester" => array("name"=>$parameters->companyPerson, "email"=>$parameters->companyEmail),
			"subject" => "Systeemkaartverzegeling",
			"comment" => array("public"=>true, "body"=>$body, "uploads"=>array($zen_attachement->upload->token)),
			"custom_fields" => array(array("id"=>22042895, "value"=>"Systeemkaartverzegeling"), array("id"=>23826976, "value"=>$parameters->voertuigtype), array("id"=>23762247, "value"=>$parameters->kenteken))
			)
		)
	);
	
	$data = $zendesk->call("/tickets", $jsonNewTicket, "POST");
	
	echo json_encode(array("success"=>"Success", "data"=>$data, "zen_attachement"=>$zen_attachement));
	wp_die();
}

/** Exclude woocommerce products from wp default search results */
add_action( 'init', 'update_custom_type', 99 );
function update_custom_type() {
  global $wp_post_types;
	
	if( is_search() || isset($_GET['s']) )
	{
		if ( post_type_exists( 'product' ) ) {
		    $wp_post_types['product']->exclude_from_search = true;
		}
	}
}





global $sitepress;
function woo_override_checkout_fields_billing( $fields ) {
	$slang = ICL_LANGUAGE_CODE;
	if ($slang == "nl") {
		$fields['billing']['billing_country'] = array(
	        'type'      => 'select',
	        'options'   => array('NL' => 'Netherlands')
	    );
	}
	if ($slang == "de") {
		$fields['billing']['billing_country'] = array(
	        'type'      => 'select',
	        'options'   => array('DE' => 'Deutschland')
	    );
	    unset( $fields['billing']['vat_number'] );
	}
    return $fields;
} 
add_filter( 'woocommerce_checkout_fields' , 'woo_override_checkout_fields_billing' );

function woo_override_checkout_fields_shipping( $fields ) { 
	$slang = ICL_LANGUAGE_CODE;
	if ($slang == "nl") {
	    $fields['shipping']['shipping_country'] = array(
	        'type'      => 'select',
	        'options'   => array('NL' => 'Netherlands')
	    );
	}
	if ($slang == "de") {
	    $fields['shipping']['shipping_country'] = array(
	        'type'      => 'select',
	        'options'   => array('DE' => 'Deutschland')
	    );
	    unset( $fields['billing']['vat_number'] );
	}
    return $fields; 
} 
add_filter( 'woocommerce_checkout_fields' , 'woo_override_checkout_fields_shipping' );



function disable_shipping_calc_on_cart( $show_shipping ) {
    if( is_cart() ) {
        return false;
    }
    return $show_shipping;
}
add_filter( 'woocommerce_cart_ready_to_calc_shipping', 'disable_shipping_calc_on_cart', 99 );


add_filter('wc_session_expiration', 'so_26545001_filter_session_expired' );

function so_26545001_filter_session_expired($seconds) {
    return 60 * 60 * 24; // 24 hours
}






// Change sender adress
add_filter( 'woocommerce_email_from_address', function( $from_email, $wc_email ){
	global $woocommerce, $post;
	$order = new WC_Order($post->ID);
	$order_id = trim(str_replace('#', '', $order->get_order_number()));
	
	$order = wc_get_order( $order_id );
	$order_data = $order->get_data();
	$order_billing_country = $order_data['billing']['country'];
	
	if ($order_billing_country == 'NL') {
    	if( $wc_email->id == 'customer_processing_order' )
        	$from_email = 'info@cabman.nl';
    }
    if ($order_billing_country == 'DE') {
    	if( $wc_email->id == 'customer_processing_order' )
        	$from_email = 'info@cabman.de';
    }
    return $from_email;
}, 10, 2 );





add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
  echo '<style>
    .wrap #message,
    .wrap .activation-notice {
    	display:none;
    } 
  </style>';
}