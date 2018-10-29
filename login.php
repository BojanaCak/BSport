<?php

require 'header.php';

if(isset($_SESSION['id']))
{
    header("Location: http://localhost:8080/Bsport/index.php");
}


$email = "";
$lozinka= "";

$greske = Array();
$brgresaka = 0;


if(isset($_POST['prijava']))
{
    $link = konekcija();
    
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $lozinka = mysqli_real_escape_string($link, $_POST['password']);
    
    if($email == "")
    {
        $greske[$brgresaka] = "Morate uneti email adresu";
        $brgresaka++;
    }
    if($lozinka == "")
    {
        $greske[$brgresaka] = "Morate uneti lozinku";
        $brgresaka++;
    }
    
    if(count($greske) == 0)
    {      
        
        $query_provera = "SELECT id, email, password, ulogaid FROM korisnici WHERE email = '$email'";
        $rezultat = mysqli_query($link, $query_provera);
          
        if(mysqli_num_rows($rezultat) == 0)
        {
            $greske[$brgresaka] = "Neispravno uneti podaci";
            $brgresaka++;
        }
        else
        {
            $red = mysqli_fetch_assoc($rezultat);     
            
            $id = $red['id']; $passhash = $red['password'];
			$ulogaid = $red['ulogaid'];
            
            if(password_verify($lozinka, $passhash))
            {
                $query = "SELECT naziv FROM uloge WHERE id = $ulogaid";
                $rezultat = mysqli_query($link, $query);
                $red = mysqli_fetch_assoc($rezultat);
                $uloga = $red['naziv'];
                
                $_SESSION['id'] = $id;
                $_SESSION['uloga'] = $uloga;                
                $_SESSION['korpa'] = serialize(new Korpa());
                
                header("Location: http://localhost:8080/Bsport/index.php");
            }
            else
            {
                $greske[$brgresaka] = "Neispravno uneti podaci";
                $brgresaka++;
            }     
        }
        
        
    }
    
    
    
    
    mysqli_close($link);
}

?>

		<div class="section section-breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1>Prijava</h1>
					</div>
				</div>
			</div>
		</div>
        
        <div class="section">
	    	<div class="container">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						<div class="basic-login">
                           <form role="form" role="form" method="post">
                              <?php 
                                if(count($greske)){
                                    echo '<p>Greške:</p><ul>';
                                    foreach($greske as $greska){
                                        echo '<li>' . $greska . '</li>';
                                    }
                                    echo '</ul>';
                                }                                                               
                              ?>
								<div class="form-group">
		        				 	<label for="login-email"><i class="icon-user"></i> <b>Email</b></label>
									<input class="form-control" id="login-email" type="text" placeholder="Vaš E-mail" name="email" value="<?php echo $email; ?>">
								</div>
								<div class="form-group">
		        				 	<label for="login-password"><i class="icon-lock"></i> <b>Lozinka</b></label>
									<input class="form-control" id="login-password" type="password" placeholder="Vaša Lozinka" name="password" value="<?php echo $lozinka; ?>">
								</div>
								<div class="form-group">
									
									<button type="submit" class="btn pull-right" name="prijava">Prijava</button>
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