<?php
require 'header.php';

if(!isset($_SESSION['id']) || $_SESSION['uloga'] != "admin")
{
    header("Location: http://localhost:8080/Bsport/login.php");
}


$email = "";
$lozinka= "";
$lozinkaprovera = "";
$ime = "";
$adresa = "";
$brojtelefona = "";

$greske = Array();
$brgresaka = 0;

$potvrda = "";

if(isset($_POST['registruj']))
{
    $link = konekcija();
    
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $lozinka = mysqli_real_escape_string($link, $_POST['password']);
    $lozinkaprovera = mysqli_real_escape_string($link, $_POST['passwordprovera']);
    $ime = mysqli_real_escape_string($link, $_POST['imeprezime']);
    $adresa = mysqli_real_escape_string($link, $_POST['adresa']);
    $brojtelefona = mysqli_real_escape_string($link, $_POST['telefon']);  
    
    
    
    
    if($email == "")
    {
        $greske[$brgresaka] = "Morate da unesete email adresu";
        $brgresaka++;
    }
    if($lozinka == "")
    {
        $greske[$brgresaka] = "Morate da unesete lozinku";
        $brgresaka++;
    }
    if($lozinka != $lozinkaprovera)
    {
        $greske[$brgresaka] = "Unete lozinke se ne poklapaju";
        $brgresaka++;
    }
    if($ime == "")
    {
        $greske[$brgresaka] = "Morate da unesete ime i prezime";
        $brgresaka++;
    }
    if($adresa == "")
    {
        $greske[$brgresaka] = "Morate da unesete adresu";
        $brgresaka++;
    }   
      
    
    if(count($greske) == 0)
    {
        $query_provera = "SELECT count(*) as broj FROM korisnici WHERE email = '$email'";
        $rezultat = mysqli_query($link, $query_provera);
        $red = mysqli_fetch_assoc($rezultat);
        $broj = $red['broj'];
        if($broj)
        {
            $greske[$brgresaka] = "Korisnik sa unetim e-mailom već postoji";
            $brgresaka++;
        }
        else
        {
            $passhash = password_hash($lozinka, PASSWORD_DEFAULT);
            
            $query = "INSERT INTO korisnici(email, password, imeprezime, adresa, brojtelefona, ulogaid) VALUES('$email', '$passhash', '$ime', '$adresa', '$brojtelefona', 1)";
            
            if(!mysqli_query($link, $query))
                die("Greska: " . mysqli_error($link));
            
            $email = $lozinka = $lozinkaprovera = $ime = $adresa = "";
            
            $potvrda = '<div class="alert alert-success" role="alert">Uspešno je registrovan novi admin korisnik.</div>';
            
            
        }
        
            
        
        
        mysqli_close($link);
    }
 
}

?>
        
		<div class="section section-breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1>Registruj novog admina</h1>
					</div>
				</div>
			</div>
		</div>
        
        <div class="section">
	    	<div class="container">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
                                            <?php echo $potvrda; ?>
						<div class="basic-login">
                                                    <form role="form" method="post">
                                                                <?php 
                                                                    if(count($greske))
                                                                    {
                                                                        echo '<label>Greške:</label><ul>';
                                                                        foreach($greske as $greska)
                                                                        {
                                                                            echo '<li>' . $greska . '</li>';
                                                                        }
                                                                        echo '</ul>';
                                                                    }                                                               
                                                                ?>
                                                        
                                                        
								<div class="form-group">
		        				 	<label for="register-email"><i class="icon-user"></i> <b>Email</b></label>
                                                                <input class="form-control" id="register-email" type="email" placeholder="" name="email" value="<?php echo $email; ?>">
								</div>
								<div class="form-group">
		        				 	<label for="register-password"><i class="icon-lock"></i> <b>Lozinka</b></label>
									<input class="form-control" id="register-password" type="password" placeholder="" name="password">                                                                      
								</div>
								<div class="form-group">
		        				 	<label for="register-password2"><i class="icon-lock"></i> <b>Ponovo ukucajte lozinku</b></label>
									<input class="form-control" id="register-password2" type="password" placeholder="" name="passwordprovera">
								</div>
                                                            
                                                                <div class="form-group">
                                                                <label for="imeprezime"><i class="icon-lock"></i> <b>Ime i prezime</b></label>
									<input class="form-control" id="imeprezime" type="text" placeholder="" name="imeprezime" value="<?php echo $ime; ?>">
								</div>
                                                                
                                                                <div class="form-group">
                                                                <label for="adresa"><i class="icon-lock"></i> <b>Adresa</b></label>
									<input class="form-control" id="adresa" type="text" placeholder="" name="adresa" value="<?php echo $adresa; ?>">
								</div>
                                                                <div class="form-group">
                                                                <label for="telefon"><i class="icon-lock"></i> <b>Broj telefona</b></label>
									<input class="form-control" id="telefon" type="text" placeholder="" name="telefon" >
								</div>
                                                            
								<div class="form-group">
									<button type="submit" class="btn pull-right" name="registruj">Registruj</button>
									<div class="clearfix"></div>
								</div>
							</form>
						</div>
					</div>
					
				</div>
			</div>
		</div>


<?php

require 'footer.php';

?>