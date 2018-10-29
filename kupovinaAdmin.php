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
       
    $query = "DELETE FROM porudzbina WHERE id = $id";
    
    mysqli_query($link, $query);  
    
  
}

$query = "SELECT por.id as id, DATE_FORMAT(por.vreme,'%d.%m.%Y %T') as vreme, (SELECT SUM(a.cena * s.kolicina) FROM stavka s JOIN artikli a ON s.artikalid=a.id WHERE s.porudzbinaid=por.id) as ukupno, kor.imeprezime, kor.email, kor.adresa FROM porudzbina por JOIN korisnici kor on por.korisnikid=kor.id";

$rezultat = mysqli_query($link, $query);       

$redovi = mysqli_fetch_all($rezultat, MYSQLI_ASSOC);



?>

		<div class="section section-breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1>Sve Porudžbine</h1>
					</div>
				</div>
			</div>
		</div>
        
        <div class="section">
	    	<div class="container">
				<div class="row">
                    <div class="col-md-10 col-md-offset-1">
						<table id="tabelaPodaci"  class="display"> 
                           <thead> 
                               <tr> 
                                   <th>Broj porudžbine</th> 
                                   <th>Ime i prezime</th> 
                                   <th>E-Mail</th> 
                                   <th>Adresa</th> 
                                   <th>Vreme </th> 
                                   <th>Ukupan Iznos</th> 
                                   <th>Obriši porudžbinu</th>
                                </tr> 
                            </thead> 
                            <tbody> 
                               <?php
                                  foreach ($redovi as $red){
                               ?>
                                <tr data-toggle="popover" data-trigger="hover" title="Stavke:"> 
                                    <th scope=row><?php echo $red['id'] ?></th> 
                                    <td><?php echo  $red['imeprezime'] ?></td> 
                                    <td><?php echo  $red['email'] ?></td> 
                                    <td><?php echo  $red['adresa'] ?></td> 
                                    <td><?php echo  $red['vreme'] ?></td> 
                                    <td><?php echo  $red['ukupno'] ?></td> 
                                    <td style="text-align: center;">
									<form method="post"><input type="hidden" value="<?php echo $red['id'] ?>" name="id">
									<button type="submit" name="obrisi" class="btn btn-red">OBRIŠI</button>
									</form>
									</td>
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
