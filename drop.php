<?php 

session_start();

//pull in login credentials and CURL access function
require_once("utils.php");

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="jquery-1.11.0.min.js"></script>
	
</head>
<body>
<button id="login-button" >Logout</button>
<button id="create-button" >Create New Issue</button>
<script type="text/javascript"> 
	$("#login-button").click(function(){
		window.location.href = "http://27.147.195.222:2241/jiraC/logout.php";
	});

	$("#create-button").click(function(){
		window.location.href = "http://27.147.195.222:2241/jiraC/create.php";
	});
</script>
<?php


//create a payload that we can then pass to JIRA with JSON


/*define a function that calls the right REST API
We convert the array to JSON inside of the function.*/
function get_drop() {
	//convert array to JSON string
	$ch = curl_init();
	//configure CURL
	curl_setopt_array($ch, array(
		CURLOPT_URL => JIRA_URL,
		CURLOPT_USERPWD => USERNAME . ':' . PASSWORD,
		CURLOPT_HTTPHEADER => array('Content-type: application/json'),
		CURLOPT_RETURNTRANSFER => true
	));
	$result = curl_exec($ch);
	curl_close($ch);
	//convert JSON data back to PHP array
	return json_decode($result);
}

function search_issue() {
	return get_drop();
}

//call JIRA.
$result = search_issue();
var_dump($result);
//check for errors
if (property_exists($result, 'errors')) {
	echo "Error(s) searching for issues:\n";
	var_dump($result);
} else {
	echo "<h1>Issue Title</h1>";
	$k = 1;
	foreach ($result->issues as &$issue) {
    	echo "<p>". $k . ". " . $issue->fields->summary."</p>";
    	$k++;
	}
}

?>
</body>
</html>


