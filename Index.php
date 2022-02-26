<?php
	session_start();
	include "config.php";
	include "functions.php";
	if(isset($_POST['admin_login'])) {
		$Email = $conn->real_escape_string($_POST['emailM']);
		$Password = $conn->real_escape_string($_POST['passwordM']);
		$UserInfo = get_single_data("users", "binary email = '{$Email}' AND binary password = '{$Password}' AND type = '1'");
		if($UserInfo) {
			$_SESSION['_admin_logged_in'] = $UserInfo['email'];
			exit(header("Location: adminpanel.php"));
		}
		
		$Emsg = "Invalid username or password !";
	}
	
	if(isset($_POST['employee_signup'])) {
		$fields['email']	= $conn->real_escape_string($_POST['email']);
		$fields['fullname']	= $conn->real_escape_string($_POST['fullName']);
		$fields['password']	= $conn->real_escape_string($_POST['password']);
		$fields['type']	= 2;
		if($conn->query(InsertInTable("users", $fields))) {
			$_SESSION['_employee_logged_in'] = $_POST['email'];
			exit(header("Location: employeepanel.php"));
		}
		
		$Emsg = $conn->error;
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Store Managment System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
<?php
	if(isset($Emsg)):
	
?>	<script type="text/javascript">
		alert('<?= htmlentities($Emsg) ?>');
	</script> <?php
		
	endif;
?>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 class="head" title="Store Managment System">
                <i class="fa fa-renren"></i> Store Managment<span class="halfHead"> System<sup style="font-size:40%; color: white;">&reg</sup>
                </span>
            </h1>    
            <button class="logInBtnNavBar" title="Log in" onclick="showSide();">
                <i class="fa fa-sign-in" aria-hidden="true"> </i> LOG IN
            </button>
        </div>
        <div id="loginArea" class="area">
            <a href="javascript:void(0)" title="Close" class="closebtn" onclick="closeSide()">&times;</a>
            <button class="panelBtn" title="Login On Admin Panel" onclick="a();">Admin Panel</button>
            <br />
            <button class="panelBtn" title="Login On Employee Panel" onclick="e();">Employee Panel</button>
        </div>
        <div class="adminPanelLogin" id="adminLogin">
            <a href="javascript:void(0)" title="Close" class="closebtn" onclick="closeSideOfAdminLogin()">&times;</a>
            <h1 class="headd" title="Store Managment System">
                <i class="fa fa-renren"></i> Store Managment<span class="halfHead">System<sup style="font-size:40%; color: white;">&reg</sup>
                </span>
            </h1>
            <p class="panels">ADMIN PANEL</p>
            <i class="fa fa-angle-double-down"></i>
            <div class="signUpForm">
                <p class="signUpHeading">LOG IN</p>
                <p id="error2">You have entered a wrong email or password!</p>
                <form action="" method="POST">
					<input type="hidden" name="admin_login" />
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
        </div>

        <div class="employeePanelLogin" id="employeeLogin">
            <a href="javascript:void(0)" title="Close" class="closebtn" onclick="closeSideOfEmployeeLogin()">&times;</a>
            <h1 class="headd" title="Store Managment System">
                <i class="fa fa-renren"></i> Store Managment<span class="halfHead">System<sup style="font-size:40%; color: white;">&reg</sup>
                </span>
            </h1>
            <p class="panels">EMPLOYEE PANEL</p>
            <i class="fa fa-angle-double-down"></i>
            <div class="signUpForm">
                <p class="signUpHeading">SIGN UP</p>
                <form action="" method="POST">
					<input type="hidden" name="employee_signup" />
                    <label class="text">Full Name
                        <br />
                        <input type="text" class="input" name="fullName" placeholder="Full Name..." required="required" id="fullName" onfocus="this.className += ' inputfocus'"
                            onblur="this.className='input'">
                    </label>
                    <br />
                    <label class="text">Email
                        <br />
                        <input type="email" class="input" name="email" placeholder="Email..." required="required" id="email" onfocus="this.className += ' inputfocus'"
                            onblur="this.className='input'">
                    </label>
                    <br />
                    <label class="text">Password
                        <br />
                        <input type="password" class="input" name="password" placeholder="Password..." required="required" id="password" onfocus="this.className += ' inputfocus'"
                            onblur="this.className='input'">
                    </label>
                    <br />
                    <label class="agreement">
                        <input type="checkbox" required="required" checked=""> Accept the terms and polices.</label>
                    <br />
                    <input type="submit" value="SIGN UP" class="submitBtn">
                </form>
                <hr / style="width:70%; opacity:0.5; size:0.5px">
                <p class="acc" onclick="window.location='employelogin.php'">Already have an account?</p>
                <button class="loginbtn"  onclick="window.location='employelogin.php'">LOG IN</button>
            </div>
        </div>
        <div class="intro">
            <h1 class="welcomeHead" id="a">Store Managment System</h1>
            <p class="welcomeSubHead">This is for a marketing store in Bangladesh.</p>
            <a href="#knowMore"><button class="subScribeBtn"><i class="fa fa-angle-double-down" style="color:#454955"></i> KNOW MORE!</button></a>
        </div>
        <div class="abot" id="about">
            <div id="knowMore"class="img" title="Store Managment System"><img src="ab.jpg" width="150px;" height="150px;"></div>
            <h1 class="samoohead" title="Store Managment System">Store Managment System</h1>
            <p class="bio"><span class="coma">❝</span>Story of the Store<span class="coma"> ❞</span> </p>
            <p class="bio"><span class="coma">❝</span>Story of the Store<span class="coma"> ❞</span> </p>
        </div>
        <div class="footer">
            <p class="footerr">@COPYRIGHTS-2020-21. All Rights Reserved.</p>
        </div>
    </div>
    <script src="app.js"></script>
    <script src="sweetalert2.js"></script>
</body>

</html>