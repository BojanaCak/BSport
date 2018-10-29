<?php

require 'header.php';

$greske = Array();
$broj = 0;

if(!isset($_SESSION['id']))
{
    header("Location: http://localhost:8080/Bsport/login.php");
}

$korpa = unserialize($_SESSION['korpa']);

$artikli_u_korpi = $korpa->artikli;


if(isset($_POST['obrisi']))
{
    $id = $_POST['id'];
    $key=-1;
    for( $i=0; $i<$korpa->broj; $i++ )
    {
        if($artikli_u_korpi[$i]->id == $id)
        {
            $key = $i;
            break;
        }
    }
       
    array_splice($artikli_u_korpi, $key, 1); 
    $korpa->artikli = $artikli_u_korpi;
    $korpa->broj--;
    
    $_SESSION['korpa'] = serialize($korpa);
    
    header("Location: http://localhost:8080/Bsport/shopping-cart.php");
}

if(isset($_POST['osvezi']))
{
    $id = $_POST['id'];
    $kolicina = $_POST['kolicina'];
    
    if($kolicina == "" || $kolicina < 1 || !preg_match('/^[1-9]\d$/', $kolicina))
    {
        header("Location: http://localhost:8080/Bsport/shopping-cart.php");
    }
    else{
        $key=-1;
        for( $i=0; $i<$korpa->broj; $i++ )
        {
            if($artikli_u_korpi[$i]->id == $id)
            {
                $key = $i;
                break;
            }
        }

        $artikli_u_korpi[$key]->kolicina = $kolicina;


        $korpa->artikli = $artikli_u_korpi;

        $_SESSION['korpa'] = serialize($korpa);

        header("Location: http://localhost:8080/Bsport/shopping-cart.php");
    }
}

if(isset($_POST['potvrdi']))
{
    if(count($artikli_u_korpi) == 0)
    {
        $greske[$broj] = "Korpa Vam je prazna";
        $broj++;
    }
    
    
    foreach ($artikli_u_korpi as $jedan)
    {
        $greska = $jedan->proveriStanje();
        if($greska != "")
        {
            $greske[$broj] = $greska;
            $broj++;
        }      
    }
    
  
    if($broj == 0)
    {
        $link = konekcija();

        $query = "INSERT INTO porudzbina(korisnikid) VALUES({$_SESSION['id']})";
        mysqli_query($link, $query);

        $poslednji = mysqli_insert_id($link);

        $query = "";

        foreach ($artikli_u_korpi as $jedan)
        {
            $query .= "INSERT INTO stavka(porudzbinaid, artikalid, kolicina) VALUES({$poslednji}, {$jedan->id}, {$jedan->kolicina});";
            $query .= "UPDATE artikli SET stanje = stanje - {$jedan->kolicina} WHERE id = {$jedan->id};";
        }

        mysqli_multi_query($link, $query);

        $korpa = new Korpa();


        $_SESSION['korpa'] = serialize($korpa);

        mysqli_close($link);
        
        header("Location:http://localhost:8080/Bsport/kupovinaKorisnik.php");
    }
    else 
    {
        $korpa->artikli = $artikli_u_korpi;
        $_SESSION['korpa'] = serialize($korpa);
    }
}

?>
        
		<div class="section section-breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1>Korpa</h1>
					</div>
				</div>
			</div>
		</div>
        
        <div class="section">
	    	<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<!-- Action Buttons -->
						<div class="pull-right">							
                            <form method="post">
                             <button type="submit"  class="btn" name="potvrdi"><i class="glyphicon glyphicon-shopping-cart icon-white"></i> POTVRDI</button>
                            </form>
						</div>
					</div>
				</div>
                 
    			<?php
                   if($broj){
					echo '<div class="row" style="margin-top:15px;"><div class="col-md-8 col-md-offset-2">';
                    echo ' <div class="alert alert-danger" role="alert"> ';
                    echo "<label>Upozorenje</label><ul>";
                    
					foreach ($greske as $greska){
                      echo "<li>$greska</li>";
                    }
                    echo "</ul>";
                    echo "Dostupne količine su postavljene, ukoliko vam odgovaraju potvrdite kupovinu.";
                    echo '</div>';
                    echo '</div></div>';
                   } 
                ?>
                    
                    
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<!-- Shopping Cart Items -->
						<table class="shopping-cart">
							<!-- Shopping Cart Item -->
                          <?php 
                            if(count($artikli_u_korpi)== 0){
                              echo '<tr><td><h1>Korpa je prazna</h1></td></tr>';
                            }
							else{
                               foreach($artikli_u_korpi as $jedan){
                          ?>
                                                        
                          <tr>
                            <!-- Shopping Cart Item Image -->
                             <td class="image"><a href="detalji_artikla.php?id=<?php echo $jedan->id ?>"><img src="artikli/<?php echo "s{$jedan->id}.jpg"; ?>"></a></td>
                            
							<!-- Shopping Cart Item Description & Features -->
                              <td> <div class="cart-item-title"><a href="detalji_artikla.php?id=<?php echo $jedan->id ?>"><h3><?php echo $jedan->naziv ?></h3></a></div>
                                                                            
                            <form method="post">       
                               </td>
                            <!-- Shopping Cart Item Quantity -->
                               <td class="quantity">
                                 <input class="form-control input-sm input-micro" type="text" value="<?php echo $jedan->kolicina ?>" name="kolicina">
                               </td>
                            <!-- Shopping Cart Item Price -->
                                <td class="price"><?php echo $jedan->cena ?></td>
                            <!-- Shopping Cart Item Actions -->
                                <td class="actions">
                                    <button type="submit"  class="btn btn-xs btn-grey" name="osvezi"><i class="glyphicon glyphicon-pencil"></i></button>
                                    <button type="submit"  class="btn btn-xs btn-grey" name="obrisi"><i class="glyphicon glyphicon-trash"></i></button>
                                    <input type="hidden" value="<?php echo $jedan->id ?>" name="id">
                                </td>
                            </form>
                           </tr>
                            <?php 
                                  } }
                            ?>
                            														
						</table>
					</div>
				</div>
				<div class="row">
					
					

	    
<?php

require 'footer.php';

?>