<?php
$servername = "10.85.75.154";
$username = "joymiweb";
$password = "Okgaden1506!@#";
$dbname = "game_portal";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

//Detect special conditions devices
$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
$webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");
$os = '';
$utm = $_GET['utm'];
$campaign = $_GET['c'];
$g = $_GET['g']; // Game ID
$ip = '';
$ip = $_SERVER['REMOTE_ADDR'];
//do something with this information
if( $iPod || $iPhone || $iPad){
    //browser reported as an iPhone/iPod touch -- do something here
	if ($g == 'hocvienmanga')
		$url = 'https://itunes.apple.com/vn/app/hoc-vien-manga/id1116913993?l=vi&ls=1&mt=8';
	else 
		$url = 'http://edge.vncdn.vn/TINHTX/joymidownload/JoyMi.html';
	//$url = 'https://app.appsflyer.com/id1155970978?pid=hipstore_int&c='.$campaign;
	$os = 'iOS';
}else if($Android){ 
    //browser reported as an Android device -- do something here
	if ($utm)
		$url = 'https://play.google.com/store/apps/details?id=mongvuongthan.joymi.vn&referrer=utm_source%3D'.$utm;
	else
		$url = 'https://play.google.com/store/apps/details?id=mongvuongthan.joymi.vn';
	
	if ($g == 'hocvienmanga')
		$url = 'https://play.google.com/store/apps/details?id=hocvienmanga.joymi.vn';
	else 
		$url = 'http://edge.vncdn.vn/TINHTX/joymidownload/JoyMi.apk';
	$os = 'Android';
}else{
    //browser reported as a webOS device -- do something here
	
	if ($g == 'hocvienmanga')
		$url = 'http://hocvienmanga.vn';
	else  
		$url = 'http://joymi.vn';
	$os = 'webOS';
}
file_put_contents('log_click.txt', date(mktime()).':'.$url.$_SERVER['HTTP_USER_AGENT']."\n", FILE_APPEND );

$sql = "INSERT INTO log_click_utm (utm, os, raw_data, time, ip) VALUES ('".$utm."', '".$os."', '".$_SERVER['HTTP_USER_AGENT']."', '".date("Y-m-d H:i:s")."','".$ip."')";
$result = $conn->query($sql);
// if ($utm)
// {
	// echo $result;
	// die;
// }

header('Location: '.$url);
?> 
