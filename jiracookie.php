<?php 
session_start();

$ch = curl_init('https://nconnect.atlassian.net/rest/auth/1/session');
// $ch = curl_init('http://172.16.0.65:8080/rest/auth/1/session');
$jsonData = array( 'username' => $_POST['username'], 'password' => $_POST['password'] );
$jsonDataEncoded = json_encode($jsonData);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

$result = curl_exec($ch);
curl_close($ch);

$sess_arr = json_decode($result, true);

// echo '<pre>';
// var_dump($ch);
// var_dump($sess_arr);
// echo'</pre>';

$array = array();

if(isset($sess_arr['errorMessages'][0])) { 
	$array['msg'] = "Fail";
	$array['fmsg'] = $sess_arr['errorMessages'][0];
	$array['ses'] = $sess_arr ;

} else {

	if(!isset($_COOKIE[$sess_arr['session']['name']])) {
	    setcookie($sess_arr['session']['name'], $sess_arr['session']['value'], time() + (86400 * 30), "/");
	}
	$array['ses'] = $sess_arr ;

	$array['msg'] = "Success";
	$array['fmsg'] = $sess_arr['session']['value'];
	$_SESSION['uname'] = $_POST['username'];
	$_SESSION['password'] = $_POST['password'];
}

header('Content-Type: application/json');
echo json_encode($array);

?>