<?php
session_start();
require './klase.php';

$link = konekcija();

$query = "SELECT id, naziv FROM kategorija";

$rezultat = mysqli_query($link, $query);

$redovi = mysqli_fetch_all($rezultat, MYSQLI_ASSOC);


?>
<!DOCTYPE html>
<html>
<head>
	<title>BSport</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta name="viewport" content="width=device-width, inital-scale=1,user-scalable=no">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
	</script>
	<script src="js/bootstrap.min.js"></script>
</head>
<body> <nav class="navbar navbar-default navbar-fixed-top">
	    <div class="mainmenu-wrapper">
	        <div class="container">
	        	<div class="menuextras">
					<div class="extras">
						<ul>
							<?php 
                                 if(isset($_SESSION['id'])){
                                    $korpa = unserialize($_SESSION['korpa']);
                                        if($_SESSION['uloga']=="admin"){
                                          echo "<li><i class='glyphicon glyphicon-plus icon-white'></i> <a href='dodajArtikal.php'><b>Novi artikal</b></a></li>";
                                          echo "<li><i class='glyphicon glyphicon-folder-open icon-white'></i> <a href='artikliAdmin.php'><b>Svi artikli</b></a></li>";
										  echo "<li><i class='glyphicon glyphicon-list-alt icon-white'></i> <a href='kupovinaAdmin.php'><b>Sve porudžbine</b></a></li>";
                                          echo "<li><i class='glyphicon glyphicon-user icon-white'></i> <a href='adminRegister.php'><b>Registruj novog admina</b></a></li>";
                                          echo "<li><i class='glyphicon glyphicon-globe icon-white'></i> <a href='korisniciAdmin.php'><b>Svi korisnici</b></a></li>";
                                        }
                                        else{
                                          echo "<div class='log'><li class='shopping-cart-items'><i class='glyphicon glyphicon-shopping-cart icon-white'></i> <a href='shopping_cart.php'><b>{$korpa->broj} Artikal(la)</b></a></li></div>";
                                          echo "<div class='log'><li><a href='kupovinaKorisnik.php'><b>Moja korpa</b></a></li></div>";
                                        }
                                          echo "<div class='log'><li class='text-right'><a href='logout.php'>Odjavi se</a></li></div>";
										}
										else{
                                           echo "<div class='log'><li><a href='login.php'>Prijava</a></li><li><a href='Registracija.php'>Registracija</a></li></div>";
                                                            }
                                                
                                                
                            ?>	
			        		
			        	</ul>
					</div>
		        </div>
	
	
	<div class="container"> 
		<a href="index.php" class="navbar-brand">BSport</a>
		<ul class="nav navbar-nav">
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Kategorije<span class="caret"></span></a>
			
			 <ul class="dropdown-menu" role="menu">
				
			  <?php 
                foreach($redovi as $red){
					echo " <li><a href='dropdown.php?katid={$red['id']}'>{$red['naziv']}</a></li> ";
                 }
              ?></ul>
			</li>
			<li><a href="kontakt.php">Kontakt</a></li>
		</ul>
	
	</div>
	</nav>