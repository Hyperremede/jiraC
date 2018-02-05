<?php
require_once("utils.php");

function search_project() {
	return getProjects('project');
}

echo "Feed Start";

$ch = curl_init();
//configure CURL
curl_setopt_array($ch, array(
	CURLOPT_URL => JIRA_URL . '/activity',
	CURLOPT_USERPWD => USERNAME . ':' . PASSWORD,
	CURLOPT_HTTPHEADER => array('Content-type: application/XML'),
	CURLOPT_RETURNTRANSFER => true
));

$result = curl_exec($ch);
curl_close($ch);

print_r($result);
echo "Feed End";

$result2 = search_project();

if(isset($_POST['submit'])) {

	$new_issue = array(
		'fields' => array(
			'project' => array('key' => $_POST['project']),
			'summary' => $_POST['title'],
			'description' => $_POST['textarea'],
			'priority' => array('name' => 'Medium'),
			'issuetype' => array('name' => 'Task'),
			'labels' => array('a','b')
			)
	);

	function create_issue($issue) {
		return post_to('issue', $issue);
	}

	$result = create_issue($new_issue);
	if (property_exists($result, 'errors')) {
		echo "Error(s) creating issue:\n";
		var_dump($result);
	} else {
		echo "New issue created at " . JIRA_URL ."/browse/{$result->key}\n";
	}

}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="jquery-1.11.0.min.js"></script>
</head>
<body>
<form id="login-form" action="#" method="post">
	<div style="width: 100%;margin-bottom: 2%;">
		<label>Select Project:</label>
		<select name="project">
			<?php 
			foreach ($result2 as &$issue2) {
				echo "<option value='".$issue2->key."'>".$issue2->name."</option>";  	
			}
			?>
			
		</select>
	</div>
	<div style="width: 100%;margin-bottom: 2%;">
	<label>Title:</label>
	<input type="text" id="username-input" name="title" placeholder="title" /><br />
	</div>
	<div style="width: 100%;margin-bottom: 2%;">
	<label>Description:</label>
	<textarea name="textarea">
		
	</textarea>
	</div>
	<input type="submit" name="submit" id="submit-button" value="Create" />
</form> 

<?php









?>
</body>
</html>



