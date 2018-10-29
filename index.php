<?php

require 'header.php';
				
$greska = "";

$link = konekcija();

$query = "SELECT id, naziv, cena, kratakopis FROM artikli WHERE stanje > 0 ";

if(isset($_GET['katid']))
{
    $id = mysqli_real_escape_string($link, $_GET['katid']);
    $query .= "AND kategorijaid = $id ";
}



$rezultat = mysqli_query($link, $query);

if(mysqli_num_rows($rezultat) == 0)
{
    $greska .= "Nema proizvoda";
}
else
{
    $redovi = mysqli_fetch_all($rezultat, MYSQLI_ASSOC);
}


?>
<!--SLIDER-->	
	<div class="container" id="slider">
		<br>
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				<li data-target="#myCarousel" data-slide-to="1"></li>
				<li data-target="#myCarousel" data-slide-to="2"></li>
			</ol>

    <!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">

			<div class="item active">
				<img src="img/img1.jpg" alt="Adidas" width="100%" height="300">
			</div>

			<div class="item">
				<img src="img/img2.jpg" alt="Nike" width="100%" height="300">
			</div>
    
			<div class="item">
				<img src="img/img3.jpg" alt="Converse" width="100%" height="300">
			</div>
 
		</div>

    <!-- Left and right controls -->
		<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
		</div>
	</div>

<!--Items-->
	<div class="section section-breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
				  <h1 class="text-center"><mark>Shop</mark></h1>
				</div>
			</div>
		</div>
	</div>
        
    <div class="section">
	   	<div class="container">
			<div class="row">
              <?php 
                                    
                if($greska != ""){
                   echo " <div class='alert alert-info col-sm-8 col-sm-offset-2' role='alert'><strong>$greska</strong></div> ";
                }
                else{
                    foreach ($redovi as $red) { 
                        ?>
							<div class="col-sm-4">
							<!-- Product -->
							<div class="shop-item">
							<!-- Product Image -->
							<div class="image">
                             <a href="detalji_artikla.php?id=<?php echo $red['id']; ?>"><img style="width:344px; height: 206px;" src="artikli/<?php echo "s{$red['id']}.jpg"; ?>" alt="<?php echo $red['naziv']; ?>"></a>
							</div>
							<!-- Product Title -->
							<div class="title">
								<h3><a href="detalji_artikla.html"><?php echo $red['naziv']; ?></a></h3>
							</div>							
							<!-- Product Price-->
							<div class="list-price text-danger">Regularna cena: <s><?php echo $red['cena']+200.00; ?></s></div>
							<div class="price">Nasa cena:
								<?php echo $red['cena']; ?>
							</div>
							<!-- Product Description-->
							<div class="description">
								<p><?php echo $red['kratakopis']; ?></p>
							</div>
							<!-- Add to Cart Button -->
							<div class="actions">
								<button type="button" class="btn btn-sm btn-basic" data-toggle="modal" data-target="#details-1"><a href="detalji_artikla.php?id=<?php echo $red['id']; ?>" > Detalji</a></button>
								
							</div>
						</div>
						<!-- End Product -->
					</div>
                                    <?php } } ?>      
				</div>
			</div>
	    </div>
	
	
	
	
<?php

	require 'footer.php';

?>