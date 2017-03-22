<?php 
error_reporting(0);
add_action( 'wp_ajax_send_rma', 'cabman_send_rma' );
add_action( 'wp_ajax_nopriv_send_rma', 'cabman_send_rma' );
add_action( 'wp_ajax_login_zendesk', 'cabman_login_zendesk' );
add_action( 'wp_ajax_nopriv_login_zendesk', 'cabman_login_zendesk' );

function cabman_send_rma(){
	require_once(get_stylesheet_directory().'/lib/zendesk/zendesk.php');
	
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
		if($rma['product'] == "Cabman BCT")
		{
			$body = "Product: " . $rma['product'] . "\nSerienummer: " . $rma['serial'] . "\nKenteken: " . $rma['licensePlate'] . "\nKlacht:\n" . $rma['complaint'];
		}
		else
		{
			$productName = property_exists($rma, 'other') ? $rma['other'] : $rma['product'];
			$body = "Product: " . $productName . "\nSerienummer: " . $rma['serial'] . "\nKlacht:\n" . $rma['complaint'];
		}
		
		$jsonNewTicket = json_encode(array(
			"ticket" => array(
				"requester" => array("name"=>$parameters["companyPerson"], "email"=>$parameters["companyEmail"]),
				"subject" => "RMA " . (property_exists($rma, 'other') ? $rma['other'] : $rma['product']),
				"comment" => array("body" => $body),
				"custom_fields" => array(array("id" => 22042895, "value" => "rma"), array("id" => 24414195, "value" => $rma['product_tag']))
				)
			)
		);
		
		$data = $zendesk->call("/tickets", $jsonNewTicket, "POST");
		$tickets[] = $data;
		$pdf_filename = generate_pdf($fileName, $parameters, $tickets);
		
		echo json_encode(array("success"=>false, "tickets"=>$tickets, "responseText"=>"T-".$pdf_filename));
	}
	
	//echo json_encode(array("success"=>true, "params"=>$parameters, "rmas"=>$rmas, "responseText"=>"test.pdf"));
	wp_die(); // this is required to terminate immediately and return a proper response
}

function cabman_login_zendesk() {
	require_once(get_stylesheet_directory().'/lib/zendesk/zendesk.php');

	$subdomain = 'cabman';
	$parameters = $_POST['parameters'];
	
	$zendesk = new Zendesk($parameters['username'], $parameters['password'], $subdomain, $suffix = '.json', $test = false);
	$user = $zendesk->call('/users/me', '', 'GET');
		
	$zendesk2 = new Zendesk('helpdesk@cabman.nl', 'Euphoria12!', $subdomain, $suffix = '.json', $test = false);
	$organization = $zendesk2->call('/organizations/'.$user->user->organization_id, '', 'GET');	
	if(is_null($user) || !property_exists($user, 'user'))
	{
		echo json_encode(array('result' => array(), 'success' => 0));
	}
	else
	{
		echo json_encode(array('result' => array('user' => $user->user, 'organization' => $organization->organization), 'success' => 1));
	}
	wp_die(); 
}

function generate_pdf($filename, $parameters, $tickets)
{
	/*
	require_once(get_stylesheet_directory().'/lib/class.phpmailer.php');
	$mail = new PHPMailer();

	$mail->Host = "smtp.danego.net";
	$mail->From = "noreply@euphoria-it.nl";
	$mail->FromName = "Cabman Helpdesk";
	#$mail->AddAddress($parameters['companyEmail']);
	$mail->AddAddress("luis@makedevelopment.com");
	$mail->SetLanguage('nl', '/language/');
	#$mail->AddStringAttachment($pdf->Output('', 'S'), $filename, "base64", 'application/pdf');
	$mail->IsHTML(True);
	$mail->Subject  =  "RMA aanvraag"; //
	$mail->Body     =  "Beste ".$parameters['companyPerson'].",<br><br/>Uw RMA aanvraag is correct ontvangen.<br/>Bijgesloten PDF bevat het RMA Formulier en een adreslabel.(LET OP! Ons adres is gewijzigd!)<br/>U dient het RMA Formulier af te drukken en toe te voegen aan het pakket. Het adreslabel dient u aan de bovenzijde van  uw pakket te plakken.<br/><br/>Met vriendelijke groet,<br/><br/>Euphoria Software"; 
	$mail->Send();
	
	return "test.pdf";
	*/
	
	require_once(get_stylesheet_directory().'/lib/class.extend.fpdf.php');
	
	$pdf = new RMA_PDF();
	$pdf->AddPage();
	$pdf->SetMargins(17,17,17);
	$pdf->AliasNbPages();
	//Top
	$pdf->Image(get_stylesheet_directory().'/assets/logo-euphoria-pdf.png',17,5,60,25);
	$pdf->SetXY(95,10);
	$pdf->SetFont('Arial','',11);
	//Contact Info
	$pdf->MultiCell(100,5,"Euphoria Software\nWilhelminapark 36\n5041 EC Tilburg");
	$pdf->SetXY(145,10);
	$pdf->MultiCell(100,5,"Telefoon: 013-4609286\nFax: 013-4609281\nE-mail: info@euphoria-it.nl");	
	
	$pdf->SetFont('Arial','',36);
	$pdf->SetXY(110,40);
	$pdf->Cell(40,10,'RMA formulier');
	
	$pdf->SetXY(17,60);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(100, 6, 'Datum: '. date("d-m-Y"));
	//Company Info	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->AddContactInfo(120, $_POST);
	
	$pdf->Ln();	
	$pdf->Ln();
	$pdf->SetTextColor(18, 142, 180);
	$pdf->SetFont('Arial','',16);
	$pdf->Cell(176,10,'Producten', 'B');	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->AddTotals(176, $rmas);
	//Table		
	$page_height = 279.4;
	$index = 0;
	foreach ($rmas as $rma) {			
		if(($pdf->GetY() + 35) >= $page_height)
		{
			$pdf->AddPage();
		}
		else
		{
			$pdf->Ln();
			$pdf->Ln();
		}
		$pdf->AddTicket($rma, $tickets[$index]->ticket->id);
		$index++;
	}
	
	//Address label
	$pdf->AddPage();
	$pdf->Cell(176,100,'',1);
	$pdf->Image(get_stylesheet_directory().'/assets/logo-euphoria-pdf.png',17,5,60,25);
	$pdf->SetXY(110,40);
	$pdf->SetFont('Arial','',16);
	$pdf->MultiCell(70,8,"Euphoria Software BV\nT.a.v. Afdeling RMA\nWilhelminapark 36\n5041 EC Tilburg\nNederland", 1);
	$pdf->SetXY(25,100);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(50,6,'Afzender: '. $parameters['companyName'] .', '. $parameters['companyPerson']);
	$pdf->Ln();
	$pdf->SetX(25);
	$pdf->Cell(50,6,'Betreft: RMA '. date("Y-m-d"));
		
	$pdf->Output($filename, "F");	
	
	if(isset($parameters['companyEmail']) && filter_var( "helpdesk@cabman.nl", FILTER_VALIDATE_EMAIL ))
	{
		require_once(get_stylesheet_directory().'/lib/class.phpmailer.php');
		
		$mail = new PHPMailer();
		$mail->Host = "smtp.danego.net";

		$mail->From = "noreply@euphoria-it.nl";
		$mail->FromName = "Cabman Helpdesk";
		#$mail->AddAddress($parameters['companyEmail']);
		$mail->AddAddress("luis@makedevelopment.com");
		$mail->SetLanguage('nl', '/language/');
		$mail->AddStringAttachment($pdf->Output('', 'S'), $filename, "base64", 'application/pdf');
		$mail->IsHTML(True);

		$mail->Subject  =  "RMA aanvraag"; // 
		$mail->Body     =  "Beste ".$parameters['companyPerson'].",<br><br/>Uw RMA aanvraag is correct ontvangen.<br/>Bijgesloten PDF bevat het RMA Formulier en een adreslabel.(LET OP! Ons adres is gewijzigd!)<br/>U dient het RMA Formulier af te drukken en toe te voegen aan het pakket. Het adreslabel dient u aan de bovenzijde van  uw pakket te plakken.<br/><br/>Met vriendelijke groet,<br/><br/>Euphoria Software"; 

		$mail->Send();		
	}
	$attachement = $zendesk->UploadFile($fileName);
  $attchJson = json_encode(
			array(
				"ticket" => array("comment"=>array("public"=>false, "body"=>"RMA formulier toegevoegd.", "uploads"=>array($attachement->upload->token)))
			)
		);
	foreach($tickets as $ticket) {						
		$data = $zendesk->call("/tickets/".strval($ticket->ticket->id), $attchJson, "PUT");		
	}
	
	return $filename;
	/**/
}
