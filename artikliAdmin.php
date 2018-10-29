<?php

require 'header.php';

if(!isset($_SESSION['id']) || $_SESSION['uloga'] != "admin")
{
    header("Location: http://localhost:8080/Bsport/login.php");
}

$link = konekcija();



if(isset($_POST['obrisi']))
{
    $id = mysqli_real_escape_string($link, $_POST['id']);
       
    $query = "DELETE FROM artikli WHERE id = $id";
    
    mysqli_query($link, $query);  
    
    unlink("artikli/artikal$id.jpg");
}

$query = "SELECT a.id, a.naziv as nazivp, a.cena, a.kratakopis, a.stanje, k.naziv as nazivk FROM artikli a JOIN kategorija k on a.kategorijaid=k.id";

$rezultat = mysqli_query($link, $query);       

$redovi = mysqli_fetch_all($rezultat, MYSQLI_ASSOC);



?>

		<div class="section section-breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1>Svi Artikli</h1>
					</div>
				</div>
			</div>
		</div>
        
        <div class="section"  >
	    	<div class="container">
				<div class="row">
                                    <div class="col-md-10 col-md-offset-1" >
                                                <table  id="tabelaPodaci" class="display"> 
                                                    <thead> 
                                                        <tr> 
                                                            <th>ID</th> 
                                                            <th>Naziv </th> 
                                                            <th>Kratak opis</th> 
                                                            <th>Kategorija</th>
                                                            <th>Cena</th>
                                                            <th>Stanje</th>
                                                            <th>Obriši artikal</th>
                                                            <th>Izmeni artikal</th>
                                                        </tr> 
                                                    </thead> 
                                                    <tbody> 
                                                        <?php
                                                        foreach ($redovi as $red)
                                                        {
                                                        
                                                        ?>
                                                        <tr> 
                                                            <td><a href="izmeniArtikal.php?ida=<?php echo $red['id'] ?>"><?php echo $red['id'] ?></a></td> 
                                                                <td><?php echo  $red['nazivp'] ?></td> 
                                                                <td><?php echo  $red['kratakopis'] ?></td> 
                                                                <td><?php echo  $red['nazivk'] ?></td> 
                                                                <td><?php echo  $red['cena'] ?></td> 
                                                                <td><?php echo  $red['stanje'] ?></td> 
                                                                <td style="text-align: center;"><form method="post"><input type="hidden" value="<?php echo $red['id'] ?>" name="id"><button type="submit" name="obrisi" class="btn btn-red">OBRIŠI</button></form></td>
                                                                <td style="text-align: center;"><a class="btn btn-green" href="izmeniArtikal.php?ida=<?php echo $red['id'] ?>">IZMENI</a></td>
                                                            </tr>                                                      
                                                        <?php
                                                        }
                                                        ?>
                                                    </tbody> 
                                                </table>
                                                <div id="popover_content_wrapper" style="display: none">
                                                    <div>This is your div content</div>
                                                </div>
					</div>
				</div>
                </div>
        </div>
				






<?php

require 'footer.php';

mysqli_close($link);

?>