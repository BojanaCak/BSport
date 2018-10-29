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
		<div class="section section-breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1>Spisak trenutnih proizvoda</h1>
					</div>
				</div>
			</div>
		</div>
        
        <div class="section">
	    	<div class="container">
				<div class="row">
                                    <?php 
                                    
                                    if($greska != "")
                                    {
                                        echo " <div class='alert alert-info col-sm-8 col-sm-offset-2' role='alert'><strong>$greska</strong></div> ";
                                    }
                                    else
                                    {
                                    
                                    foreach ($redovi as $red) { 
                                        
                                        
                                        ?>
                                        
                                        <div class="col-sm-4">
						
						<div class="shop-item">
							<div class="image">
                                                            <a href="detalji_artikla.php?id=<?php echo $red['id']; ?>"><img style="width:344px; height: 206px;" src="artikli/<?php echo "s{$red['id']}.jpg"; ?>" alt="<?php echo $red['naziv']; ?>"></a>
							</div>
							<!-- Product Title -->
							<div class="title">
								<h3><a href="detalji_artikla.php"><?php echo $red['naziv']; ?></a></h3>
							</div>							
							<!-- Product Price-->
							<div class="price">
								<?php echo $red['cena']; ?>
							</div>
							<!-- Product Description-->
							<div class="description">
								<p><?php echo $red['kratakopis']; ?></p>
							</div>
							<!-- Add to Cart Button -->
							<div class="actions">
								<a href="detalji_artikla.php?id=<?php echo $red['id']; ?>" class="btn"><i class="icon-shopping-cart icon-white"></i> Dodaj u korpu</a>
							</div>
						</div>
					</div>
                                    <?php } } ?>      
				</div>
			</div>
	    </div>

	    

	    
<?php
mysqli_close($link);


require 'footer.php';

?>