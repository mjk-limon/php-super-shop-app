var count = 0;
setInterval(function () {
    count++;
    if (count == 2) {
        document.getElementById("a").style.width = '90%';
    }
    if (count === 4) {
        document.getElementById("a").style.width = '0';
        count = 0;
    }
}, 500)
function showSide() {
    document.getElementById("loginArea").className += ' displaySide';
}
function closeSide() {
    //document.getElementById("loginArea").className = 'area';
}
function a() {
    document.getElementById("adminLogin").className += ' displaySidee';
}
function closeSideOfAdminLogin() {
    document.getElementById("adminLogin").className = 'adminPanelLogin';
}
function e() {
    document.getElementById("employeeLogin").className += ' displaySidee';
}
function closeSideOfEmployeeLogin() {
    document.getElementById("employeeLogin").className = 'employeePanelLogin';
}
var adminAccount = {
    email: "admin@gmail.com",
    password: "admin123"
}

function adminLogin() {
    var email = document.getElementById("emailM").value;
    email.toLowerCase();
    var password = document.getElementById("passwordM").value;
    if (email === adminAccount.email && password === adminAccount.password) {
        document.getElementById("display1").style.display = 'block';
        document.getElementById("error2").style.display = 'none';
        setTimeout(function () {
            location = 'adminpanel.html'
        }, 2000)
    }
    else {
        document.getElementById("error2").style.display = 'block';
    }
}

function signUpEmployee() {
    var name = document.getElementById("fullName").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var employeeAccount = {
        name: name,
        email: email,
        password: password
    }
    var a = localStorage.setItem("Employee_Account", JSON.stringify(employeeAccount));
    document.getElementById("display").style.display = 'block';
    setTimeout(function () {
        location = 'employelogin.html'
    }, 2000)

};

function employelogin() {
    var email = document.getElementById("emailM").value;
    var password = document.getElementById("passwordM").value;
    var b = JSON.parse(localStorage.getItem("Employee_Account"));
	alert(b.password);
    if (email === b.email && password === b.password) {
        document.getElementById("display1").style.display = 'block';
        document.getElementById("error2").style.display = 'none';
        setTimeout(function () {
            location = 'employeepanel.html'
        }, 2000)
    }
    else {
        document.getElementById("error2").style.display = 'block';
    }

}

function logout() {
    var logoutArea = document.getElementById("container");
    var a = document.createElement("h1");
    a.setAttribute("class", "logout");
    var logoutFA = document.createElement("i");
    logoutFA.setAttribute("class", "fa fa-spinner");
    a.appendChild(logoutFA);
    var atext = document.createTextNode(" Logging Out...");
    a.appendChild(atext);
    logoutArea.appendChild(a);
    setTimeout(function () {
        location = 'index.php';
    }, 2000)
}

function Products(category, name, price, colors, stock, sizes) {
    this.category = category,
	this.name = name,
	this.price = price,
	this.color = colors,
	this.stock = stock,
	this.sizes = sizes
}

var products = {
    footwears: {
        bonzesandal: new Products("Footwears", "Bonze sandal", 1200, "Brown/Blue", "Yes", "35/32/30"),
        learshoes: new Products("Footwears", "Lear shoes", 800, "Brown/Blue/Black", "Yes", "18/21/38"),
        candyshoes: new Products("Footwears", "Candy shoes", 1900, "Light-Blue", "Yes", "30/27"),
        cattyshoes: new Products("Footwears", "Catty shoes", 1300, "Burgendy", "No", "32"),
        skvlfsandal: new Products("Footwears", "Skvlf sandal", 700, "Black", "Yes", "26/30"),
        peshawarisandal: new Products("Footwears", "Peshawari sandal", 2400, "Black/Brown/Grey", "No", "35/32"),
    },
    clothes: {
        addidashoody: new Products("Clothes", "Addidas hoody", 2100, "Grey/Light-Red", "Yes", "32-26"),
        bossshirt: new Products("Clothes", "Boss shirt", 1000, "Blue/Off-White", "No", "24-28"),
        chinospant: new Products("Clothes", "Chinos pant", 650, "Green-Dark", "Yes", "28-34"),
        handytshirt: new Products("Clothes", "Handy tshirt", 300, "Red/Mehrun", "No", "23-27"),
        khankurta: new Products("Clothes", "Khan kurta", 1650, "Black/Blue/Grey", "Yes", "20-41"),
        denimnarrow: new Products("Clothes", "Denim narrow", 1900, "Blue/Dark-Blue", "Yes", "28-32"),
    },
    watches: {
        bosswrist: new Products("Watches", "Boss wrist", 1400, "Mehrun", "Yes", "28"),
        eaglecandy: new Products("Watches", "Eagle candy", 750, "Light-Yello", "No", "23"),
        armanicab: new Products("Watches", "Armani cab", 2180, "Grey", "Yes", "26"),
        rolexraz: new Products("Watches", "Rolex raz", 3800, "Light-Grey", "Yes", "32"),
        radoblacky: new Products("Watches", "Rado blacky", 3300, "Black", "Yes", "30"),
        appleiclock: new Products("Watches", "Apple iclock", 2730, "Black/Grey", "No", "24")
    },
}
function filter() {
    var userInput = document.getElementById("userInput").value;
    var a = userInput;
    a = a.toLowerCase();
    for (var i = 0; i < a.length; i++) {
        if (a[i] === " ") {
            a = a.slice(0, i) + a.slice(i + 1);
        }
    }
    var firstLetter = userInput.charAt(0).toUpperCase();
    var remain = userInput.slice(1).toLowerCase();
    userInput = firstLetter + remain;
    var flag = false;
    if (userInput != "" && userInput != undefined && userInput != " " && userInput != null) {
        for (var key in products) {
            for (var key2 in products[key]) {
                if (a === key2) {
                    flag = true;
                    document.getElementById("userInput").value = '';
                    document.getElementById("displaye").style.display = 'none';
                    document.getElementById("products").style.display = 'none';
                    document.getElementById("displayc").style.display = 'block';
                    document.getElementById("displayc").innerHTML = document.getElementById(key2).innerHTML;
                    document.getElementById("topButton").style.display = 'none';
                    document.getElementById("homeButton").style.display = 'block';
                }
                else if (userInput === products[key][key2].name) {
                    flag = true;
                    document.getElementById("userInput").value = '';
                    document.getElementById("displaye").style.display = 'none';
                    document.getElementById("products").style.display = 'none';
                    document.getElementById("displayc").style.display = 'block';
                    document.getElementById("displayc").innerHTML = document.getElementById(products[key][key2].name).innerHTML;
                    document.getElementById("topButton").style.display = 'none';
                    document.getElementById("homeButton").style.display = 'block';
                }
            }
        }
        if (flag != true) {
            document.getElementById("displayc").style.display = 'none';
            document.getElementById("products").style.display = 'none';
            document.getElementById("displaye").style.display = 'block';
            document.getElementById("topButton").style.display = 'none';
            document.getElementById("displaye").innerText = "NO RESULTS FOUND!";
            document.getElementById("homeButton").style.display = 'block';
        }
    }
}
function home() {
    setTimeout(function () {
        document.getElementById("userInput").value = '';
        document.getElementById("displayc").style.display = 'none';
        document.getElementById("products").style.display = 'block';
        document.getElementById("homeButton").style.display = 'none';
        document.getElementById("displaye").style.display = 'none';
    }, 1000)
}
function change(id) {
    //document.getElementById(id).childNodes[1].style.display = "none";
    document.getElementById(id).childNodes[3].style.display = 'block';
}
function changee(id) {
    document.getElementById(id).childNodes[0].style.display = "none";
    document.getElementById(id).childNodes[1].style.display = 'block';
}
function changeag(id, src) {
    //document.getElementById(id).childNodes[1].style.display = "block";
    document.getElementById(id).childNodes[3].style.display = 'none';
}
function changeeag(id, src) {
    document.getElementById(id).childNodes[0].style.display = "block";
    document.getElementById(id).childNodes[1].style.display = 'none';
}

function details(env) {
	prInfo = env.closest(".prDetails").dataset;
	swal({
		title: "Name : " + prInfo.name,
		text: "Category : " + "( " + prInfo.category + " )  "
			+ " --- Color : ( " + prInfo.color + " ) "
			+ " --- Stock  : ( " + prInfo.stock + " ) "
			+ " --- Size : ( " + prInfo.size + " ) "
			+ " --- Price : ( BDT." + prInfo.price + " ) ",
		textColor: "red",
		imageUrl: prInfo.src,
		imageWidth: 300,
		imageHeight: 250,
		imageAlt: 'Custom image',
		animation: false,
	})
}
function update(id, oldStock) {
	document.getElementById("updateStock").style.display = 'block';
    document.getElementById('uUpdateStock').value = id;
    document.getElementById('uAddStock').value = oldStock;
}
function sellProductInfoGet(id, price) {
    var date = new Date();
    var todayDate = date.getDate();
    var todayMonth = date.getMonth() + 1;
    todayMonth = Number(todayMonth);
    var todayyear = date.getFullYear();
	
	document.getElementById('sellProduct').value = id;
	document.getElementById('priceOfProduct').innerText = price;
	document.getElementById("mode").style.display = 'block';
}
function addToCart(e) {
	var xhttp = new XMLHttpRequest(),
		prId = document.getElementById('sellProduct').value,
		prQty = document.getElementById('quantityOfProduct').value;
		
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var cartItem = JSON.parse(this.responseText);
			swal({
				type: "success",
				title: "Added!",
				text: "Product added to cart Successfully."
			});
			
			initCart(cartItem);
			document.getElementById('cartTotal').innerHTML = cartItem.length;
			document.getElementById('mode').style.display = 'none';
		}
	};
	xhttp.open("POST", "employeepanel.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("addCart=1&prid="+ prId +"&prqty=" + prQty);
	e.preventDefault();
}
function removeFromCart(prId) {
	var xhttp = new XMLHttpRequest();
		
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var cartItem = JSON.parse(this.responseText);
			initCart(cartItem);
			document.getElementById('cartTotal').innerHTML = cartItem.length;
		}
	};
	xhttp.open("POST", "employeepanel.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("removeCart=1&prid="+ prId);
}
function initCart(item) {
	var html = '', subtotal = 0;
	if(item.length) {
		for(var i = 0; i < item.length; i++) {
			var total = item[i].price * item[i].qty;
			subtotal += total;
			html += '<tr>';
			html += '	<td>'+ item[i].name +'</td>';
			html += '	<td>'+ item[i].price +'</td>';
			html += '	<td>'+ item[i].qty +'</td>';
			html += '	<td>'+ total +'</td>';
			html += '	<td><a href="javascript:;" onclick="removeFromCart(\''+ item[i].id +'\')">Remove</a></td>';
			html += '</tr>';
		}
	} else {
		html = '<tr><td colspan="5">Shopping Cart Empty</td></tr>';
	}
	
	document.getElementById('floatingCartTbody').innerHTML = html;
	document.getElementById('floatingCartTfoot').innerHTML = 'SubTotal: ' + subtotal;
}
function showCart() {
	document.getElementById('floatingCart').style.display = 'block';
}
var counter = 0;
var sold = [];

function remove(id) {
    swal({
        type: "question",
        title: "Are you sure you want to delete this?",
        text: "If you will delete it once you will no longer have to can access on it.",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: 'rgb(106, 162, 245)',
        confirmButtonText: 'Delete!',
        cancelButtonText: "Cancel",
        confirmButtonColor: "rgb(87, 206, 87)",
    }).then((result) => {
        if (result.value) {
            swal({
                type: "success",
                title: "Deleted!"
            });
			setTimeout(function(){				
				window.location = "?remove=" + id;
			}, 500)
        }
    })
}

function add(id) {
    document.getElementById("modeForAdd").style.display = 'block';
    document.getElementById('addCategory').value = id;
}
var counterForFoot = 6;

function filterTypehead(value) {
	var val = value.toLowerCase(),
		xhttp = new XMLHttpRequest();
		
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("userInputTypehead").innerHTML = this.responseText;
		}
	};
	xhttp.open("POST", "adminpanel.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("filterTypehead=1&val="+ val);
}
function saleDayGo() {
    setTimeout(function () {
        location = 'sale.html'
    }, 1000)
}

function soldList() {
    var b = JSON.parse(localStorage.getItem("sold"));
    console.log(b.length);
    var tp = 0;
    for (var i = 0; i < b.length; i++) {
        var D = b[i].date;
        var N = b[i].name;
        var Q = b[i].quantity;
        var TP = b[i].totalprice;
        TP = Number(TP);
        tp = tp + b[i].totalprice;
        var target = document.getElementById("Table");
        var target2 = target.childNodes[2];
        var tr = document.createElement("tr");
        var dateTd = document.createElement("td");
        var dateTdText = document.createTextNode(D);
        dateTd.appendChild(dateTdText);
        tr.appendChild(dateTd);
        var productTd = document.createElement("td");
        var productTdText = document.createTextNode(N);
        productTd.appendChild(productTdText);
        tr.appendChild(productTd);
        var quantityTd = document.createElement("td");
        var quantityTdText = document.createTextNode(Q);
        quantityTd.appendChild(quantityTdText);
        tr.appendChild(quantityTd);
        var tpTd = document.createElement("td");
        var tpTdText = document.createTextNode("RS." + TP);
        tpTd.appendChild(tpTdText);
        tr.appendChild(tpTd);
        target.insertBefore(tr, target2);
    }
    document.getElementById("some").innerHTML = b.length + " Items has been Sold!"
    document.getElementById("saleTotal").innerHTML = "RS." + tp;
}
soldList()
