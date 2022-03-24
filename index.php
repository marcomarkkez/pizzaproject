<?php

if (!isset($_GET['action'])) {
	$_GET['action'] = '';
}
session_start();

switch($_GET['action']){

	case 'addTopping': 
		$result = array();
		$result['errormsg'] = '';
		$result['success'] = 0;

		if (isset($_GET['topping']) && strlen(str_replace(' ', '', $_GET['topping'])) > 0 ) {
			if (!isset($_SESSION['toppings'])) {
				$_SESSION['toppings'] = array();
			}
			$_SESSION['toppings'][] = $_GET['topping'];
			$result['success'] = 1;
		} else {
			$result['success'] = 0;
			$result['errormsg'] = 'No Topping Entered';
		}

		echo json_encode($result);
		exit;
	break;

	case 'getToppings'; 
		$result = array();
		$result['errormsg'] = '';
		$result['success'] = 1;
		$result['toppings'] = array();

		if (isset($_SESSION['toppings'])) {
			$result['toppings'] = $_SESSION['toppings'];
			$result['success'] = 1;
		}

		echo json_encode($result);
		exit;
	break;

	case 'deleteTopping':

		$result = array();
		$result['errormsg'] = '';
		$result['success'] = 0;

		$toppingsBefore = count($_SESSION['toppings']);
		$toppings = $_SESSION['toppings'];

		if(sizeof($_SESSION['toppings']) > 1){
			array_splice($_SESSION['toppings'], $_GET['toppingId'], 1);
		}else{
			unset($_SESSION['toppings']);
		}

		if(!isset($_SESSION['toppings'])){
			$result['success'] = 1;
			echo json_encode($result);
			return;
		}

		if(count($_SESSION['toppings']) < $toppingsBefore){
			$result['success'] = 1;
		}else{
			$result['errormsg'] = "The topping was not removed";
		}
		echo json_encode($result);
		exit;
	break;

	default: 
		printForm();
}


function printForm()
{ ?>
	<!DOCTYPE html>
	<html>

	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Pizza Pizza</title>
		<script src="./jquery.min.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
		<link href="style.css" rel="stylesheet">
	</head>

	<body>

		<div class="container">
			<div class="row">
				<div class="col">
				</div>
				<div class="col-6">
					<div class="logo">
						<img src="img/pizzaprojectlogo.png">
					</div>
					<div class="input-wrapper-topping">
						<label for="topping">What topping would you like?</label><br>
						<input class="input-topping" type="text"  name="topping" id="topping" value="" >
						<div class="boton-add">
							<button class="btn btn-light" type="button" onclick="addTopping()"><i class="addimg"></i></button>
						</div>
					</div>
					<div class="alerta alert alert-danger d-flex align-items-center" role="alert">
  						<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
  						<div class="texto">
    						
  						</div>
					</div>
					<div class="list-toppings">
						<ul id="listToppings"></ul>
					</div>
				</div>
				<div class="col">
				</div>
			</div>
		</div>
		<script src="./index.js"></script>
		<script>
			getToppings();/*Start whith the saved Toppings*/
			$(".alerta").addClass("d-none");

			document.querySelector('#topping').addEventListener('keypress', function (e) {
			    if (e.key === 'Enter') {
			      addTopping();
			    }
			});
		</script>
	</body>

	</html>
<?php
}
?>