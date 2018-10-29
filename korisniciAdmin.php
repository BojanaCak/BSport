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
       
    $query = "DELETE FROM korisnici WHERE id = $id";
    
    mysqli_query($link, $query); 
}

$query = "SELECT k.id as kid, k.imeprezime, k.email, k.adresa, k.brojtelefona, u.naziv as uloga FROM korisnici k JOIN uloge u ON k.ulogaid=u.id";

$rezultat = mysqli_query($link, $query);       

$redovi = mysqli_fetch_all($rezultat, MYSQLI_ASSOC);



?>

		<div class="section section-breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1>Svi Korisnici</h1>
					</div>
				</div>
			</div>
		</div>
        
        <div class="section">
	    	<div class="container">
				<div class="row">
                                    <div class="col-md-10 col-md-offset-1" style="height: 350px;">
                                                <table id="tabelaPodaci" class="display"> 
                                                    <thead> 
                                                        <tr> 
                                                            <th>ID</th> 
                                                            <th>E-Mail </th> 
                                                            <th>Ime i prezime</th> 
                                                            <th>Adresa</th>
                                                            <th>Broj telefona</th>
                                                            <th>Uloga</th>
                                                            <th>Obriši korisnika</th>
                                                            <th>Izmeni korisnika</th>
                                                        </tr> 
                                                    </thead> 
                                                    <tbody> 
                                                        <?php
                                                        foreach ($redovi as $red)
                                                        {
                                                        
                                                        ?>
                                                        <tr> 
                                                            <th scope=row><a href="izmeniKorisnika.php?id=<?php echo $red['kid'] ?>"><?php echo $red['kid'] ?></a></th> 
                                                                <td><?php echo  $red['email'] ?></td> 
                                                                <td><?php echo  $red['imeprezime'] ?></td> 
                                                                <td><?php echo  $red['adresa'] ?></td> 
                                                                <td><?php echo  $red['brojtelefona'] ?></td> 
                                                                <td><?php echo  $red['uloga'] ?></td>
                                                                <td style="text-align: center;"><form method="post"><input type="hidden" value="<?php echo $red['kid'] ?>" name="id"><button type="submit" name="obrisi" class="btn btn-red">OBRIŠI</button></form></td>
                                                                <td style="text-align: center;"><a class="btn btn-green" href="izmeniKorisnika.php?id=<?php echo $red['kid'] ?>">IZMENI</a></td>
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