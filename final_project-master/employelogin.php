<?php
	session_start();
	include "config.php";
	include "functions.php";
	
	if(isset($_POST['employee_login'])) {
		$Email = $conn->real_escape_string($_POST['emailM']);
		$Password = $conn->real_escape_string($_POST['passwordM']);
		$UserInfo = get_single_data("users", "binary email = '{$Email}' AND binary password = '{$Password}' AND type = '2'");
		if($UserInfo) {
			$_SESSION['_employee_logged_in'] = $UserInfo['email'];
			exit(header("Location: employeepanel.php"));
		}
		
		$Emsg = "Invalid username or password !";
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employee Login</title>
    <link rel="stylesheet" href="loginStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
	if(isset($Emsg)):
	
?>	<script type="text/javascript">
		alert('<?= htmlentities($Emsg) ?>');
	</script> <?php
		
	endif;
?>
</head>
<body>
    <div class="header">
        <h1 class="head">
            <i class="fa fa-renren"></i> Store Managment<span class="halfHead"> System<sup style="font-size:40%; color: white;">&reg</sup>
            </span>
        </h1>
        </div>  
        <p class="panels">EMPLOYEE PANEL</p>
            <i class="fa fa-angle-double-down"></i>
        <div class="signUpForm">
            <p class="signUpHeading">LOG IN</p>
            <p id="error2">You have entered a wrong email or password!</p>
            <form action="" method="POST">
				<input type="hidden" name="employee_login" value="1" />
                <label class="text">Email
                    <br />
                    <input type="email" class="input" name="emailM" placeholder="Email..." required="required" id="emailM" onfocus="this.className += ' inputfocus'"
                        onblur="this.className='input'">
                </label>
                <br />
                <label class="text">Password
                    <br />
                    <input type="password" class="input" name="passwordM" placeholder="Password..." required="required" id="passwordM" onfocus="this.className += ' inputfocus'"
                        onblur="this.className='input'">
                </label>
                <br />
                <input type="submit" value="LOG IN" class="submitBtn">
            </form>
        </div>
        <script src="app.js"></script>
</body>
</html>