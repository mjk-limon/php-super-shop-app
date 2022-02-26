<?php
	session_start();
	include "config.php";
	include "functions.php";
	if(!isset($_SESSION['_employee_logged_in']) || !$_SESSION['_employee_logged_in']) 
		exit(header("Location: index.php"));
		
?><?php
	$Emsg = isset($_GET['Emsg']) ? $_GET['Emsg'] : '';
	
	if(isset($_POST['submitOrder'])) {
		if(isset($_SESSION['_sCart']) && !empty($_SESSION['_sCart'])) {
			$fields['inv_no'] = rand(10000000, 99999999);
			$fields['sold_by'] = get_single_index_data("users", "email = '{$_SESSION['_employee_logged_in']}'", "id");
			
			foreach($_SESSION['_sCart'] as $C_I) {				
				$fields['prid'] = $conn->real_escape_string($C_I['id']);
				$fields['quantity'] = $conn->real_escape_string($C_I['qty']);
				
				if($conn->query(InsertInTable("sell_history", $fields))) {
					$conn->query("UPDATE products SET stock = stock - {$fields['quantity']} WHERE id = '{$fields['prid']}'");
				} else $Emsg = $conn->error;
			}
			
			unset($_SESSION['_sCart']);
			header("Location: employeepanel.php?Emsg=" .  urlencode("Successfully sell"));
		}  else $Emsg = "No items in your cart";
	}
	
	if(isset($_POST['addCart'])) {
		$_SESSION['_sCart'] = isset($_SESSION['_sCart']) ? $_SESSION['_sCart'] : array();
		$oldKey = array_search($_POST['prid'], array_column($_SESSION['_sCart'], 'id'));
		
		if($oldKey === false) {
			$PrInfo = $conn->query("SELECT * FROM products WHERE id = '{$_POST['prid']}'")->fetch_assoc();
			$_SESSION['_sCart'][] = array(
				'id' => $_POST['prid'],
				'name' => $PrInfo['title'],
				'price' => $PrInfo['price'],
				'qty' => $_POST['prqty']
			);
		} else {
			$_SESSION['_sCart'][$oldKey]['qty'] =  $_SESSION['_sCart'][$oldKey]['qty'] + $_POST['prqty'];
		}
		echo json_encode(array_values($_SESSION['_sCart']));
		exit();
	}
	
	if(isset($_POST['removeCart'])) {
		$oldKey = array_search($_POST['prid'], array_column($_SESSION['_sCart'], 'id'));
		if($oldKey !== false)
			array_splice($_SESSION['_sCart'], $oldKey, 1);
		
		exit(json_encode(array_values($_SESSION['_sCart'])));
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employe Panel</title>
    <link rel="stylesheet" href="stylesheetforpanles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
			<h1 class="head" title="Store Managment System">
				<i class="fa fa-renren"></i> Store Managment<span class="halfHead"> System<sup style="font-size:40%; color: white;">&reg</sup>
				</span>
			</h1>
			<!--button class="logInBtnNavBar" title="Nav Bar" onclick="showSide();" class="textAcc">
				<i class="fa fa-bars" aria-hidden="true" ></i> NAVIGATION
			</button>
			<button class="FAacc"><i class="fa fa-bars" onclick="showSide();" aria-hidden="true" ></i></button-->
		</div>
		<div class="main-body">	
			<div id="loginArea" class="area displaySider main-body-left">
				<div class="dp"><img src="dp.jpg" title="Employee Dp" height="100px;" width="100px;"></div>
				<p id="username" style="color:rgb(89, 156, 255);">EMPLOYEE</p>
				<hr />
				<table class="navTable">
					<tr class="tr">
						<th class="th"><i class="fa fa-product-hunt" style="color:aliceblue"></i> PRODUCTS</th>
					</tr>
					<tr class="tr">
						<td class="td"><a href="#footwears" class="link" onclick="closeSide()">Footwears</a></td>     
					</tr>
					<tr class="tr">
						<td class="td"><a href="#clothes" class="link" onclick="closeSide()">Clothes</a></td>     
					</tr>
					<tr class="tr">
						<td class="td"><a href="#watches" class="link" onclick="closeSide()">Watches</a></td>    
					</tr>
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
					<div id="products">
					<?php
						$Categories = get_some_data("categories", "1");
						while($R_c = $Categories->fetch_assoc()):
						
					?>	<div id="<?= strtolower($R_c['cat_title']) ?>">
							<h1 class="proHead"><?= strtoupper($R_c['cat_title']) ?></h1>	
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
									<button class="adminBtnsEdit" onclick="details(this)" title="More" ><i class="fa fa-arrow-up"></i> MORE</button>
									<button class="sellBtn" title="Sell Product" onclick="sellProductInfoGet('<?= $C_p['id'] ?>', '<?= $C_p['price'] ?>')"><i class="fa fa-shopping-cart"></i> Add To Cart</button>
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
				<p id="topButton" style="text-align:center;"><a href="#top"><button class="topBtn" title="Top"><i class="fa fa-arrow-up"></i></button></a></p>
				<div class="footer">
					<p class="footerr">@COPYRIGHTS-2020-21. All Rights Reserved.</p>
				</div>
            </div>
		</div>
		
		<!-- Modals -->
		<div class="modelBox" id="mode">
			<div class="modelContent">
				<div class="headerOfSaleModel">
					<h1 id="productName" class="modeH1">Add To Cart</h1>
				</div>
				<div class="saleInfoForm">
					<form action="" onsubmit="addToCart(event)" method="POST">
						<input type="hidden" name="sellProduct" id="sellProduct" required />
						<p class="saleInfo">How Much?</p>
						
						<label>
							<input type="number" class="saleInfoInput" id="quantityOfProduct" name="quantityOfProduct" placeholder="Enter Quantity..." required="required">
						</label>
						
						<p class="saleInfo">Price Per Product</p>
						<p class="saleInfoInput" id="priceOfProduct"></p>
						
						<input type="submit" value="Add To Cart" class="submitBtnOfSale">
					</form>
				</div>
				<div class="footerOfMode" onclick="document.getElementById('mode').style.display = 'none';">
						<span><i class="fa fa-close"></i> CANCEL</span>
				</div>
			</div>
		</div>
		<div class="modelBox" id="floatingCart">
			<div class="modelContent">
				<div class="headerOfSaleModel">
					<h1 class="modeH1">Shopping Cart</h1>
				</div>
				<div class="saleInfoForm">
					<div class="body-right-padding">					
						<form action="" method="POST">
							<input type="hidden" name="submitOrder" />
							
							<table class="table">
								<thead>
									<tr>
										<th>Item Name</th>
										<th>Price</th>
										<th>Qty</th>
										<th>Total</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="floatingCartTbody">
								<?php
									$SubTotal = 0;
									if(isset($_SESSION['_sCart']) && $_SESSION['_sCart']):
										foreach($_SESSION['_sCart'] as $CartItem):
											$total = $CartItem['qty'] * $CartItem['price'];
											$SubTotal += $total;
								?>	<tr>
										<td><?= $CartItem['name'] ?></td>
										<td><?= $CartItem['price'] ?></td>
										<td><?= $CartItem['qty'] ?></td>
										<td><?= $total ?></td>
										<td><a href="javascript:;" onclick="removeFromCart('<?= $CartItem['id'] ?>')">Remove</a></td>
									</tr> <?php
									
										endforeach;
									else:
									
								?>	<tr>
										<tr><td colspan="5">Shopping Cart Empty</td></tr>
									</tr> <?php
										
									endif;
								?>
								</tbody>
								<tfoot><tr><td colspan="5" style="text-align:right" id="floatingCartTfoot">SubTotal: <?= $SubTotal ?></td></tr></tfoot>
							</table>
							<input type="submit" value="Order Now" class="submitBtnOfSale">
						</form>
					</div>
				</div>
				<div class="footerOfMode" onclick="document.getElementById('floatingCart').style.display = 'none';">
					<span><i class="fa fa-close"></i> CLOSE</span>
				</div>
			</div>
		</div>
		<div onclick="showCart()" style="position: fixed;bottom: 10px;right: 10px;padding: 20px;background: #54c754;border-radius: 10px;font-weight: 600;color: #fff;cursor: pointer;">
			<i class="fa fa-shopping-cart"></i> Cart 
			(<span class="badge" id="cartTotal"><?= @count($_SESSION['_sCart']) ?></span>)
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