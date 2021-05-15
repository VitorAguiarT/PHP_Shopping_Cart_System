<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Stationery Store</title>
	<style type="text/css">
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}
		.title {
			background-color: #010;
			width: 100%;
			padding: 10px;
			text-align: center;
			color: white;
		}
		.store_container {
			display: flex;
			margin-top: 20px;
		}
		.product {
			width: 20%;
			padding: 0 30px;
		}
		.product a {
			display: block;
			width: 100%;
			padding: 10px;
			color: white;
			background-color: blue;
			text-align: center;
			text-decoration: none;
		}
		.product p {
			display: block;
			width: 100%;
			padding: 10px;
			color: white;
			background-color: #5fb321;
			text-align: center;
			text-decoration: none;	
		}
		.product img {
			margin:	5px auto;
			margin-left: 40px; 
			padding: 10px;
			max-width: 100%;
			max-height: 35%;
		}
		.item_cart {
			max-width: 1200px;
			margin: 10px auto;
			padding-bottom: 10px;
			border-bottom: 2px dotted #ccc;
		}
		.item_cart p {
			font-size: 19px;
			color: black;
		}
		a {
			font-size: 19px;
			color: black;
		}
	</style>
</head>
<body>
	<h2 class="title">Products for Sale</h2>
	<div class="store_container">
		<?php
		$itens = array(['image'=>'Product_Images/caderno.png', 'name'=>"Notebook", 'price'=>24.99],
			['image'=>'Product_Images/caneta.jpeg', 'name'=>"Pen", 'price'=>2.99], 
			['image'=>'Product_Images/lapis.png', 'name'=>"Pencil", 'price'=>1.99], 
			['image'=>'Product_Images/borracha.jpeg', 'name'=>"Rubber", 'price'=>0.50], 
			['image'=>'Product_Images/clips_de_papel.jpeg', 'name'=>"Paper Clip", 'price'=>0.10]);

		foreach ($itens as $key => $value) {
			?>
			<div class="product">
				<?php
				echo "<p>".$value['name']."</p>";
				?>
				<img src="<?php echo $value['image'] ?>"/>
				<?php 
				echo "<p>"."R$ ".number_format($value['price'], 2)."</p>"; 
				?>
				<a href="?add=<?php echo $key ?>">Add to Cart</a>
			</div><!--Produtos da Papelaria-->
			<?php
		}
		?>
	</div><!--Conteúdo da Loja-->
	<?php
	if (isset($_GET['add'])) {
		$idProduct = (int) $_GET['add'];
		if (isset($itens[$idProduct])) {
			if (isset($_SESSION['cart'][$idProduct])) {
				$_SESSION['cart'][$idProduct]['quantity']++;
			} else {
				$_SESSION['cart'][$idProduct] = array('quantity'=>1, 'name'=>$itens[$idProduct]['name'], 'price'=>$itens[$idProduct]['price']);
			}

			echo '<script>alert("The item has been added to the cart.");</script>';
		} else {
			echo '<script>alert("The selected item cannot be added!");</script>';
			//die("The selected item cannot be added!");
		}
	}
	?>
	<h2 class="title">Cart Content:</h2>
	<div class='item_cart'>
		<?php
		foreach ($_SESSION['cart'] as $key => $value) {
			$total += number_format(($value['quantity']*$value['price']), 2);
			if ($value['quantity'] > 0) {
				echo "<p>"."Name of Product: ".$value['name']." | Quantity: ".$value['quantity']." | Price R$".number_format(($value['quantity']*$value['price']), 2)."</p>"."<hr>";
			
		?>
		<div class="item_cart_remove">
			<a href="?remove=<?php if ($value['quantity'] > 0) echo $key ?>">Remove</a>
		</div>
		<?php
			}
		}
		echo "<p>"."Amount: ".number_format($total, 2)."<br>"."</p>";
		?>
		<?php
		if (isset($_GET['remove'])) {
			$idProduct = (int) $_GET['remove'];
			if (isset($_SESSION['cart'][$idProduct])) {
				$_SESSION['cart'][$idProduct]['quantity']--;
				$total -= number_format(($_SESSION['cart'][$idProduct]['quantity']*$_SESSION['cart'][$idProduct]['price']), 2);
			}

			header("Location: index.php");
		}
		?>
	</div><!--Conteúdo do Carrinho-->
</body>
</html>