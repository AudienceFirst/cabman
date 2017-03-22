<?php

header('Access-Control-Allow-Origin: *');

$curl = curl_init();

if (isset($_GET['plate'])) {
	$license = $_GET['plate'];
	$url = "www.cabmanonline.nl/BCTService/DataServiceBCT.svc/GetSerialNumberWithLicensePlate?licensePlate='$license'";
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_USERPWD, "werkplaats1:test12");
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml", "GrabberToken: Workshop;2", "Authorization:Basic NHV0UlRDNEB+ZHVhKXYqYHNAJS19cmo6YVdOQWA5PyhQQVhbNCdxR105cCl1bSo="));
	curl_setopt($curl, CURLOPT_UNRESTRICTED_AUTH, 1);

	$resp = curl_exec($curl);
	curl_close($curl);
	echo $resp;
}
else if(isset($_GET['bulkplate'])) {
	$license = $_GET['bulkplate'];
	$url = "www.cabmanonline.nl/BCTService/DataServiceBCT.svc/GetSerialNumberWithLicensePlatesString?licensePlates='$license'";
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_USERPWD, "werkplaats1:test12");
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml", "GrabberToken: Workshop;2", "Authorization:Basic NHV0UlRDNEB+ZHVhKXYqYHNAJS19cmo6YVdOQWA5PyhQQVhbNCdxR105cCl1bSo="));
	curl_setopt($curl, CURLOPT_UNRESTRICTED_AUTH, 1);

	$resp = curl_exec($curl);
	curl_close($curl);
	echo $resp;
}
?>