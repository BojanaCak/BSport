<?php

require 'header.php';

if(!isset($_GET['id']) || $_GET['id'] == ""){
    header("Location: http://localhost:8080/Bsport/index.php");
}

$greske = "";

$link = konekcija();

$id = mysqli_real_escape_string($link, $_GET['id']);


$query = "SELECT id, naziv, cena, kratakopis, stanje, opis FROM artikli WHERE id = $id";
$rezultat = mysqli_query($link, $query);
$red = mysqli_fetch_assoc($rezultat);

if(isset($_POST['dodaj']))
{
    $id = $_POST['id'];
    $kolicina = mysqli_real_escape_string($link, $_POST['kolicina']);
    
    if($kolicina == "" || $kolicina < 1 || !preg_match('/^[1-9]\d?$/', $kolicina))
    {
        $greske .= "Unesite ispravnu količinu";
    }
    
    
    if($greske == "")
    {
        if(isset($_SESSION['id']))
        {
            $korpa = unserialize($_SESSION['korpa']);
            $korpa->azurirajKorpu(new Artikal($id, $kolicina, $red['naziv'], $red['cena']));
            $_SESSION['korpa'] = serialize($korpa);
            header("Location: http://localhost:8080/Bsport/shopping_cart.php");
        }
        else{
            header("Location: http://localhost:8080/Bsport/login.php");
        }
    }
}




?>

		<div class="section section-breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1>Detalji proizvoda</h1>
					</div>
				</div>
			</div>
		</div>
        
        <div class="section">
	    	<div class="container">
	    		<div class="row">
	       			<div class="col-sm-6">
	    				<div class="product-image-large">
	    					<img src="artikli/<?php echo "s{$red['id']}.jpg"; ?>" alt="<?php echo $red['naziv']; ?>">
	    				</div>
	    				
	    			</div>
	    			<div class="col-sm-4 product-details">
	    				<h4><?php echo $red['naziv']; ?></h4>
	    				<div class="price">
							<?php echo $red['cena']; ?>
						</div>
						<h5>Kratak opis</h5>
	    				<p>
	    					<?php echo $red['kratakopis']; ?>
	    				</p>
						<table class="shop-item-selections">
                           <form method="post">						
							
							<tr>
								<td><b>Količina:</b></td>
								<td>
									<input type="text" class="form-control input-sm input-micro" value="1" name="kolicina" >
                                                                        
								</td>
							</tr>
							<!-- Add to Cart Button -->
							<tr>
								<td>&nbsp;</td>
								<td>
                                    <input  class="btn btn" type="submit" name="dodaj" value="Dodaj u korpu">
								</td>
							</tr>
                                <?php 
                                    if($greske != "") {
                                      echo "<tr><td colspan='2' style='padding-top:10px;'><span class='alert alert-danger'> $greske </span></td></tr>";
                                    } 
                                ?>
                                    <input type="hidden" value="<?php echo $red['id']; ?>" name="id">
                                    <input type="hidden" value="<?php echo $red['stanje']; ?>" name="stanje">
                            </form>	
						</table>
	    			</div>
	    			
	    			<div class="col-sm-10">
	    				<div class="tabbable">
	    					
							<ul class="nav nav-tabs product-details-nav">
								<li class="active"><a href="#tab1" data-toggle="tab">Opis</a></li>
							</ul>
							
							<div class="tab-content product-detail-info">
								<div class="tab-pane active" id="tab1">
									<h4>Detaljniji opis</h4>
									<?php echo $red['opis']; ?>
								</div>
								
							</div>
						</div>
	    			</div>
	    		</div>
			</div>
		</div>

	    
<?php



require 'footer.php';


mysqli_close($link);
?>