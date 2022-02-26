<?php
	session_start();
	include "config.php";
	include "functions.php";
	if(!isset($_SESSION['_admin_logged_in']) || !$_SESSION['_admin_logged_in']) 
		exit(header("Location: index.php"));
		
?><?php
	$Emsg = isset($_GET['Emsg']) ? $_GET['Emsg'] : '';
	if(isset($_GET['remove'])) {
		$RmvId = $conn->real_escape_string($_GET['remove']);
		if($conn->query(DeleteTable("categories", "id = '{$RmvId}'")))
			header("Location: admin-product-categories.php?Emsg=" .  urlencode("Successfully deleted category"));
		else $Emsg = $conn->error;
	}
	
	if(isset($_POST['addCategory'])) {
		$fields['cat_title'] = $conn->real_escape_string($_POST['addName']);
		if($conn->query(InsertInTable("categories", $fields))) {
			header("Location: admin-product-categories.php?Emsg=" .  urlencode("Successfully inserted category"));
		} else $Emsg = $conn->error;
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="stylesheetforpanles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<div class="container">
        <div class="header">
            <h1 class="head" title="Store Managment System">
                <i class="fa fa-renren"></i>Store Managment<span class="halfHead"> System<sup style="font-size:40%; color: white;">&reg</sup>
                </span>
            </h1>
            <!--button class="logInBtnNavBar" title="Log in" onclick="showSide();" class="textAcc">
                <i class="fa fa-bars" aria-hidden="true" ></i> NAVIGATION
            </button>
            <button class="FAacc"><i class="fa fa-bars" onclick="showSide();" aria-hidden="true" ></i></button-->
        </div>
		
		<div class="main-body">	
            <div id="loginArea" class="area displaySider main-body-left">
				<a href="Javascript:void(0)" title="Close" class="closebtn" onclick="closeSide()">&times;</a>
			   <div class="dp"><img src="" title="Admin Dp" height="100px;" width="100px;"></div>
				<p id="username" style="color:rgb(89, 156, 255);">ADMIN</p>
				<hr />
				<a href="#dashBoard"><button class="dashBtn"onclick="location = 'dashboard.html'" title="Go to Dashboard"><i class="fa fa-dashboard" style="font-size:120%;"></i> DASHBOARD</button></a>
				<table class="navTable">
					<tr class="tr">
						<th class="th" style="background: transparent">
							<a href="admin-product-categories.php" style="color: aliceblue;text-decoration:none">
								<i class="fa fa-list" style="color:aliceblue"></i> CATEGORIES
							</a>
						</th>
					</tr>
					<tr class="tr">
						<th class="th" style="background: transparent">
							<a href="admin-sales-report.php" style="color: aliceblue;text-decoration:none">
								<i class="fa fa-line-chart" style="color:aliceblue"></i> SALES REPORT
							</a>
						</th>
					</tr>
					<tr class="tr">
						<th class="th" style="background: transparent">
							<a href="admin-product-report.php" style="color: aliceblue;text-decoration:none">
								<i class="fa fa-line-chart" style="color:aliceblue"></i> PRODUCT REPORT
							</a>
						</th>
					</tr>
					<tr class="tr">
						<th class="th" style="background: transparent">
							<a href="admin-employees.php" style="color: aliceblue;text-decoration:none">
								<i class="fa fa-users" style="color:aliceblue"></i> EMPLOYEES
							</a>
						</th>
					</tr>
					<tr class="tr">
						<th class="th">
							<a href="adminpanel.php" style="background: transparent;color:aliceblue;text-decoration:none">
								<i class="fa fa-product-hunt" style="color:aliceblue"></i> PRODUCTS
							</a>
						</th>
					</tr>
				</table>
			   <p id="container"></p>
				<button onclick="logout();" class="logoutBtn"><i class="fa fa-sign-out"></i> LOG OUT</button>
			</div>
            
			<div class="main-body-right">			
				<div id="content">
					<h1 class="proHead">
						<button class="adminBtnsAdd" onclick="add('1');" title="ADD Category"><i class="fa fa-plus"></i> ADD CATEGORY</button>
						Product Categories
					</h1>
					
					<div class="body-right-padding">					
						<table class="table">
							<thead>
								<tr>
									<th>Id</th>
									<th>Category Title</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$Categories = get_some_data("categories", "1");
								while($R_c = $Categories->fetch_assoc()):
								
							?>	<tr class="tr">
									<td class="td"><?= $R_c['id'] ?></td>
									<td class="td"><?= $R_c['cat_title'] ?></td>
									<td class="td"><a href="?remove=<?= $R_c['id'] ?>">Delete</a></td>
								</tr> <?php
								
								endwhile;
							?>
							</tbody>
						</table>
					</div>
				</div>
				<p id="topButton" style="text-align:center;"><a href="#top"><button class="topBtn" title="Top"><i class="fa fa-arrow-up"></i></button></a></p>
				<div class="footer">
					<p class="footerr">@COPYRIGHTS-2020-21. All Rights Reserved.</p>
				</div>
			</div>
		</div>
		
		
		<div class="modelBox" id="modeForAdd">
			<div class="modelContent">
				<div class="headerOfSaleModel">
					<h1 class="modeH1">Add New Category</h1>
				</div>
				<div class="saleInfoForm">
				<form action="" enctype="multipart/form-data" method="POST">
					<input type="hidden" name="addCategory" id="addCategory" value="" />
					<input type="text" class="inputOfedit" name="addName" placeholder="Category Name" required="required">
					<input type="submit" value="+ ADD" class="submitBtnOfSale">
				</form>
				</div>
				<div class="footerOfMode" onclick="document.getElementById('modeForAdd').style.display = 'none';">
					<span><i class="fa fa-close"></i> CANCEL</span>
				</div>
			</div>
		</div>
    </div>
    <script src="app.js"></script>
    <script src="sweetalert2.js"></script>
<?php
	if(isset($Emsg) && $Emsg):
?>	<script defer type="text/javascript">
		swal({
			type: "success",
			title: "<?= addslashes($Emsg) ?>"
		})
	</script> <?php
	
	endif;
?>
</body>
</html>