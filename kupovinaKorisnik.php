<?php

require 'header.php';

if(!isset($_SESSION['id']))
{
    header("Location: http://localhost:8080/Bsport/login.php");
}

$link = konekcija();

$id = $_SESSION['id'];

$query = "SELECT por.id as id, DATE_FORMAT(por.vreme,'%d.%m.%Y %T') as vreme, (SELECT SUM(a.cena * s.kolicina) FROM stavka s JOIN artikli a ON s.artikalid=a.id WHERE s.porudzbinaid=por.id) as ukupno FROM porudzbina por WHERE por.korisnikid=$id";

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
                                    <div class="col-md-8 col-md-offset-2">
						<!-- Action Buttons -->
                                                <table class="table table-hover table-bordered" style=" background-color: #FFF;"> 
                                                    <thead> 
                                                        <tr> 
                                                            <th>Broj porudžbine</th> 
                                                            <th>Vreme </th> 
                                                            <th>Ukupan Iznos</th> 
                                                        </tr> 
                                                    </thead> 
                                                    <tbody> 
                                                        <?php
                                                        foreach ($redovi as $red)
                                                        {
                                                        
                                                        ?>
                                                        <tr data-toggle="popover" data-trigger="hover" title="Stavke:"> 
                                                            <th scope=row><?php echo $red['id'] ?></th> 
                                                                <td><?php echo  $red['vreme'] ?></td> 
                                                                <td><?php echo  $red['ukupno'] ?></td> 
                                                            </tr>                                                      
                                                        <?php
                                                        }
                                                        ?>
                                                    </tbody> 
                                                </table>
                                                
					</div>
				</div>
                </div>
        </div>
				






<?php

require 'footer.php';

mysqli_close($link);

?>
