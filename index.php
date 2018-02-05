<?php  
// $salt = '$2a$08$' . substr(strtr(base64_encode(getRandomBytes(16)), '+', '.'), 0, 22) . '$';
// echo $hash = crypt('123456', $salt);

// function getRandomBytes($length) {
//     for ($i=0; $i<$length; $i++) {
//       $sha  = hash('sha256',$sha.mt_rand());
//       $char = mt_rand(0,62);
//       $rnd .= chr(hexdec($sha[$char].$sha[$char+1]));
//     }
//     return $rnd;
// }
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="jquery-1.11.0.min.js"></script>
</head>
<body> 
	<form id="login-form" action="jiracookie.php" method="post">
		<input type="text" id="username-input" name="username" placeholder="username" /><br />
		<input type="password" id="password" name="password" placeholder="password" /><br />
	</form> 
	<button id="login-button" >login oauth</button>
	<div id="errorDiv"></div>
	<script type="text/javascript"> 
		$("#login-button").click(function(){
			$.ajax({
	            url: 'jiracookie.php',
	            type: 'POST',
	            data: $("#login-form").serialize(),
	            dataType: "json",
				success: function (data, textStatus) {
	                console.log(data);

	                if(data.msg == 'Success'){
	                	window.location.href = "http://27.147.195.222:2241/jira/search.php";
	                }else{
	                	$("#errorDiv").html(data.fmsg);
	                }
	            },
	            error: function (jqXHR, textStatus, errorThrown) {
	                console.log(jqXHR);
	                console.log(textStatus);
	                console.log(errorThrown);
	            }
	        });
		});
	</script>
</body>
</html>