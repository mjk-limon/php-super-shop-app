<?php
	session_start();
	include "config.php";
	include "functions.php";
	if(!isset($_SESSION['_admin_logged_in']) || !$_SESSION['_admin_logged_in']) 
		exit(header("Location: index.php"));
		
?><?php
	$Emsg = isset($_GET['Emsg']) ? $_GET['Emsg'] : '';
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
			<?php
				if(!isset($_GET['prId'])):
			?>	<div style="width: 80%;margin:3em auto;text-align:center">
					<form id="" action="" method="GET">
						<h5 style="text-align:left">Select Product</h5>
						<select name="prId" style="display:block;width:100%;
										padding:10px 10px;border-radius: 10px;
										border: 1px solid #333; margin-bottom: 10px;
										box-shadow: 0px 0px 2px #ccc; outline: none">
						<?php
							$Categories = get_some_data("categories", "1");
							while($Cat = $Categories->fetch_assoc()):
							
						?>	<optgroup label="<?= htmlspecialchars($Cat['cat_title']) ?>">
							<?php
								$Products = get_some_data("products", "catid = '{$Cat['id']}'");
								while($Prs = $Products->fetch_assoc()):
								
							?>	<option value="<?= $Prs['id'] ?>">
									<?= $Prs['title'] ?>
								</option> <?php
									
								endwhile;
							?>
							</optgroup> <?php
									
							endwhile;
						?>
						</select>
						
						<input type="submit" value="Submit" class="submitBtnOfSale">
					</form>
				</div> <?php
				
				else:
					$Prid = $conn->real_escape_string($_GET['prId']);
					$PrInfo = get_single_data("products", "id = '{$Prid}'");
					$SellReport = get_some_data(
						"sell_history_-_users", 
						"sell_history.prid = '{$Prid}'",
						"sell_history.*,users.fullname",
						"sold_by_-_id"
					);
					
			?>	<div style="text-align:center">
					<div class="body-right-padding">					
						<h3>Report For: <?= $PrInfo['title'] ?></h3>
						<table class="table">
							<thead>
								<tr>
									<th>Date</th>
									<th>Sold By</th>
									<th>Sold Quantity</th>
								</tr>
							</thead>	
							<tbody>
							<?php
								$total_sold = 0;
								while($S_r = $SellReport->fetch_assoc()):
									$total_sold += $S_r['quantity'];
							?>	<tr>
									<td><?= date("M j, Y h:i A", strtotime($S_r['date'])) ?></td>
									<td><?= $S_r['fullname'] ?></td>
									<td><?= $S_r['quantity'] ?></td>
								</tr> <?php
								
								endwhile;
							?>
							</tbody>
							<tfoot>
								<tr style="font-weight:600">
									<td></td>
									<td style="text-align:right">Total Sold:</td>
									<td><?= $total_sold ?></td>
								</tr>
							</tfoot>
						</table>
						<a href="admin-product-report.php">Go Back</a>
					</div>
				</div> <?php
				
				endif;
			?>
			</div>
			
            <p id="topButton" style="text-align:center;"><a href="#top"><button class="topBtn" title="Top"><i class="fa fa-arrow-up"></i></button></a></p>
            <div class="footer">
                <p class="footerr">@COPYRIGHTS-2020-21. All Rights Reserved.</p>
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