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
		if($conn->query(DeleteTable("products", "id = '{$RmvId}'")))
			header("Location: adminpanel.php");
		else $Emsg = $conn->error;
	}
	
	if(isset($_POST['addProudct'])) {
		$fields['title'] = $conn->real_escape_string($_POST['addName']);
		$fields['catid'] = $conn->real_escape_string($_POST['addCategory']);
		$fields['price'] = $conn->real_escape_string($_POST['addPrice']);
		$fields['color'] = $conn->real_escape_string($_POST['addColors']);
		$fields['stock'] = $conn->real_escape_string($_POST['addStock']);
		$fields['size'] = $conn->real_escape_string($_POST['addSize']);
		if($conn->query(InsertInTable("products", $fields))) {
			$FileName = basename($_FILES['addImage']['name']);
			$target_path = "products/". $FileName;
			$tmp_image	= $_FILES['addImage']['tmp_name'];
			
			if(move_uploaded_file($tmp_image, $target_path)) {
				$NewName = "products/f" . $conn->insert_id . ".jpg";
				rename($target_path, $NewName);
			}
			
			header("Location: adminpanel.php?Emsg=" .  urlencode("Successfully inserted products"));
		} else $Emsg = $conn->error;
	}
	
	if(isset($_POST['updateStock'])) {
		$PrId = $conn->real_escape_string($_POST['updateStock']);
		if($PrId) {
			$fields['stock'] = $conn->real_escape_string($_POST['addStock']);
			if($conn->query(UpdateTable("products", $fields, "id = '{$PrId}'")))
				header("Location: adminpanel.php?Emsg=" .  urlencode("Successfully updated products stock"));
			else $Emsg = $conn->error;
		} else $Emsg = "Invalid Product Id";
	}
	
	if(isset($_POST['filterTypehead'])) {
		$val = $conn->real_escape_string($_POST['val']);
		$Filters = $conn->query("SELECT * FROM products WHERE title LIKE '{$val}%'");
		while($C_p = $Filters->fetch_assoc()) {
			$PrName = htmlspecialchars($C_p['title']);
			$PrCat = htmlspecialchars($C_p['catid']);
			$PrColr = htmlspecialchars($C_p['color']);
			$PrStock = htmlspecialchars($C_p['stock']);
			$PrSize = htmlspecialchars($C_p['size']);
			$PrPrice = htmlspecialchars($C_p['price']);
			$PrImg = "products/f" . $C_p['id'] . ".jpg"; 
			
			echo '<li class="prDetails" data-name="'. $PrName .'" data-category="'. $PrCat .'"
					data-color="'. $PrColr .'" data-stock="'. $PrStock .'" data-size="'. $PrSize .'"
					data-price="'. $PrPrice .'" data-src="'. $PrImg .'">
				<div onclick="details(this)">				
					<img src="'. $PrImg .'" alt="" />
					<p class="pr-title">'. $PrName .'</p>
					<p>Price: '. $PrPrice .'</p>
					<div style="clear:both"></div>
				</div>
			</li>';
		}
		exit;
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
				<!--a href="Javascript:void(0)" title="Close" class="closebtn" onclick="closeSide()">&times;</a-->
				<div class="dp"><img src="" title="Admin Dp" height="100px;" width="100px;"></div>
				<p id="username" style="color:rgb(89, 156, 255);">ADMIN</p>
				<hr />
				<a href="#dashBoard"><button class="dashBtn"onclick="" title="Go to Dashboard"><i class="fa fa-dashboard" style="font-size:120%;"></i> DASHBOARD</button></a>
				
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
						<th class="th"><i class="fa fa-product-hunt" style="color:aliceblue"></i> PRODUCTS</th>
					</tr>
				<?php
					$Categories = get_some_data("categories", "1");
					while($R_c = $Categories->fetch_assoc()):
					
				?>	<tr class="tr">
						<td class="td">
							<a href="#<?= strtolower($R_c['cat_title']) ?>" class="link" onclick="closeSide()">
								<?= $R_c['cat_title'] ?>
							</a>
						</td>     
					</tr> <?php
						
					endwhile;
				?>
				</table>
				<p id="container"></p>
				<button onclick="logout();" class="logoutBtn"><i class="fa fa-sign-out"></i> LOG OUT</button>
			</div>
			
			<div class="main-body-right">
				<div class="filter">
					<input type="text" oninput="filterTypehead(this.value)" class="input"  placeholder="Search Product..."
						onfocus="this.className += ' shadow'"
						onblur="var that = this; setTimeout(function(){that.className='input'}, 300)">
					<div class="typehead" id="userInputTypehead"></div>
					<button class="searchBtn" onclick="filter();"><i class="fa fa-search"></i></button>
				</div>
				<div id="content">
				<?php
					$LowStock = get_some_data("products", "stock < 10");
					if($LowStock->num_rows):
					
				?>	<div style="padding:20px;background:#fcc">
						<ul>
						<?php
							while($L_s = $LowStock->fetch_assoc()):
						
						?>	<li style="list-style:disc">
								<strong><?= $L_s['title'] ?></strong> Stock Running Low
							</li> <?php
							
							endwhile;
						?>
						</ul>
					</div> <?php
					
					endif;
				?>
					<div id="products">
					<?php
						$Categories = get_some_data("categories", "1");
						while($R_c = $Categories->fetch_assoc()):
						
					?>	<div id="<?= strtolower($R_c['cat_title']) ?>">
							<h1 class="proHead">
								<button class="adminBtnsAdd" onclick="add('<?= $R_c['id'] ?>');" title="ADD Product" id="footwearsAdd"><i class="fa fa-plus"></i> ADD PRODUCT</button>
								<?= strtoupper($R_c['cat_title']) ?>
							</h1>	
							
							<div class="fContainer1 prContHolder">
							<?php
								$Proudcts_i = 1;
								$Container_i = 1;
								$CatProducts = get_some_data("products", "catid = '{$R_c['id']}'");
								while($C_p = $CatProducts->fetch_assoc()):
									$PrName = htmlspecialchars($C_p['title']);
									$PrCat = htmlspecialchars($R_c['cat_title']);
									$PrColr = htmlspecialchars($C_p['color']);
									$PrStock = htmlspecialchars($C_p['stock']);
									$PrSize = htmlspecialchars($C_p['size']);
									$PrPrice = htmlspecialchars($C_p['price']);
									$PrImg = "products/f" . $C_p['id'] . ".jpg"; 
								
							?>	<div class="f<?= $Proudcts_i ?> prDetails" data-name="<?= $PrName ?>" data-category="<?= $PrCat ?>"
									data-color="<?= $PrColr ?>" data-stock="<?= $PrStock ?>" data-size="<?= $PrSize ?>"
									data-price="<?= $PrPrice ?>" data-src="<?= $PrImg ?>">
									<div class="imgCover" alt="Please Wait Loading..."  onmouseover="change('f<?= $Container_i.$Proudcts_i ?>');" onmouseout="changeag('f<?= $Container_i.$Proudcts_i ?>','<?= $PrImg ?>');" id="f<?= $Container_i.$Proudcts_i ?>">
										<img src="<?= $PrImg ?>" width="100%" height="180px;"> 
										<div class="b" onclick="details(this)">+</div>
									</div>
									<p class="proInfoN" onclick="details(this)" data- id="bonzesandal1"><?= $C_p['title'] ?></p>
									<p class="proInfo">BDT.<?= $C_p['price'] ?></p>
									<p class="proInfo">Stock: <?= $C_p['stock'] ?></p>
									
									<button class="adminBtnsEdit" onclick="details(this)" title="More" ><i class="fa fa-plus"></i> MORE</button>
									<button class="adminBtnsEdit" onclick="update('<?= $C_p['id'] ?>', '<?= $PrStock ?>')" title="More" ><i class="fa fa-refresh"></i> Update</button>
									<button class="adminBtnsDelete" onclick="remove('<?= $C_p['id'] ?>');" title="Delete Product" ><i class="fa fa-trash"></i> DELETE</button>
								</div> <?php
									
									$Proudcts_i++;
									if($Proudcts_i % 4 == 0) {
										$Proudcts_i = 1;
										$Container_i++;
										echo '</div><div class="fContainer'. $Container_i .' prContHolder">';
									}
								endwhile;
							?>
							
							</div>
						</div> <?php
							
						endwhile;
					?>
					</div>
				</div>
				
				<div class="footer">		
					<hr / style="border: 1.5px solid rgb(84, 199, 84)">
					<p id="topButton" style="text-align:center;"><a href="#top"><button class="topBtn" title="Top"><i class="fa fa-arrow-up"></i></button></a></p>
					
					<div class="footer">
						<p class="footerr">@COPYRIGHTS-2020-21. All Rights Reserved.</p>
					</div>
				</div>
			</div>
		</div>
       
		
		<!-- Modals -->
		<div class="modelBox" id="modeForAdd">
			<div class="modelContent">
				<div class="headerOfSaleModel">
					<h1 class="modeH1" id="category">Add Product</h1>
				</div>
				<div class="saleInfoForm">
					<form action="" enctype="multipart/form-data" method="POST">
						<p id="errorInAdd">Note : You can daily Add only one product in each category.</p>
						<input type="hidden" name="addProudct" value="1" />
						<input type="hidden" name="addCategory" id="addCategory" value="" />
						<input type="text" class="inputOfedit" name="addName" placeholder="Product Name" required="required">
						<input type="number" class="inputOfedit" name="addPrice" placeholder="Product Price" required="required">
						<input type="text" class="inputOfedit" name="addColors" placeholder="Product Colors" required="required">
						<input type="text" class="inputOfedit" name="addStock" placeholder="Product Stock" required="required">
						<input type="text" class="inputOfedit" name="addSize" placeholder="Product Sizes" required="required">
						<input type="file" name="addImage" accept="image/jpeg" required="true" /><br/><br/>
						<input type="submit" value="+ ADD" class="submitBtnOfSale">
					</form>
				</div>
				<div class="footerOfMode" onclick="document.getElementById('modeForAdd').style.display = 'none';">
					<span><i class="fa fa-close"></i> CANCEL</span>
				</div>
			</div>
		</div>
		
		<div class="modelBox" id="updateStock">
			<div class="modelContent">
				<div class="headerOfSaleModel">
					<h1 class="modeH1" id="category">Update Stock</h1>
				</div>
				<div class="saleInfoForm">
					<form action="" enctype="multipart/form-data" method="POST">
						<input type="hidden" name="updateStock" id="uUpdateStock" value="" required />
						
						<div class="form-group">
							<label for="uAddStock">Product Stock</label>
							<input type="number" class="inputOfedit" name="addStock" id="uAddStock" required="required">
						</div>
						
						<input type="submit" value="Update" class="submitBtnOfSale">
					</form>
				</div>
				<div class="footerOfMode" onclick="document.getElementById('updateStock').style.display = 'none';">
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