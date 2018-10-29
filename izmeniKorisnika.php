<?php

require 'header.php';

if(!isset($_SESSION['id']) || $_SESSION['uloga'] != "admin")
{
    header("Location: http://localhost:8080/Bsport/login.php");
}

$greske = Array();

$link = konekcija();

$id = mysqli_real_escape_string($link, $_GET['id']);

$query = "SELECT id, email, imeprezime, adresa, brojtelefona, ulogaid FROM korisnici WHERE id = $id";

$rezultat = mysqli_query($link, $query);       

$korisnik = mysqli_fetch_assoc($rezultat);

$query = "SELECT id, naziv FROM uloge";

$rezultat = mysqli_query($link, $query);       

$uloge = mysqli_fetch_all($rezultat, MYSQLI_ASSOC);

if(isset($_POST['sacuvaj']))
{
    $id = mysqli_real_escape_string($link, $_POST['id']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $imeprezime = mysqli_real_escape_string($link, $_POST['imeprezime']);
    $adresa = mysqli_real_escape_string($link, $_POST['adresa']);
    $ulogaid = mysqli_real_escape_string($link, $_POST['uloga']);
    $brojtelefona = mysqli_real_escape_string($link, $_POST['telefon']);
    
    if($email == "")
    {
        $greske[] = "Morate da unesete email";
        
    }
    if($imeprezime == "")
    {
        $greske[] = "Morate da unesete ime i prezime";
        
    }
    if($adresa == "")
    {
        $greske[] = "Morate da unesete adresu";
        
    }
    if($brojtelefona == "")
    {
        $greske[] = "Morate da unesete broj telefona";
        
    }
   
    if (count($greske) == 0) {
        
        $query = "UPDATE korisnici SET email = '$email', imeprezime = '$imeprezime', adresa = '$adresa', brojtelefona = '$brojtelefona', ulogaid = $ulogaid WHERE id = $id";

        if (!mysqli_query($link, $query)) {
            die("Greska: " . mysqli_error($link));
        }

        header("Location: http://localhost:8080/Bsport/korisniciAdmin.php");
    }
}




?>
		<div class="section section-breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1>Izmeni Korisnika</h1>
					</div>
				</div>
			</div>
		</div>
        
        <div class="section">
	    	<div class="container">
	        	
                            <div class="row">
	        		<div class="col-sm-8 col-sm-offset-2">
	        			                                        
	        			<div class="contact-form-wrapper">
                                                
                                            <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                                    <?php 
                                                                    if(count($greske))
                                                                    {
                                                                        echo '<div class="form-group alert alert-warning" style="margin-left:50px;"><label>Greške:</label><ul>';
                                                                        foreach($greske as $greska)
                                                                        {
                                                                            echo '<li>' . $greska . '</li>';
                                                                        }
                                                                        echo '</ul>';
                                                                        echo '<label>Prethodne vrednosti su ponovo popunjene</label></div>';
                                                                    }                                                               
                                                                ?>
		        				 <div class="form-group">
		        				 	<label for="email" class="col-sm-3 control-label"><b>E-Mail</b></label>
		        				 	<div class="col-sm-9">
                                                                    <input class="form-control" id="email" type="email" placeholder="" name="email" value="<?php echo $korisnik['email']; ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="imeprezime" class="col-sm-3 control-label"><b>Ime i prezime</b></label>
									<div class="col-sm-9">
										<input class="form-control" id="imeprezime" type="text" placeholder="" name="imeprezime" value="<?php echo $korisnik['imeprezime']; ?>">
									</div>
								</div>
                                                        <div class="form-group">
									<label for="adresa" class="col-sm-3 control-label"><b>Adresa</b></label>
									<div class="col-sm-9">
										<input class="form-control" id="adresa" type="text" placeholder="" name="adresa" value="<?php echo $korisnik['adresa']; ?>">
									</div>
								</div>
                                                        <div class="form-group">
									<label for="telefon" class="col-sm-3 control-label"><b>Broj telefona</b></label>
									<div class="col-sm-9">
										<input class="form-control" id="telefon" type="text" placeholder="" name="telefon" value="<?php echo $korisnik['brojtelefona']; ?>">
									</div>
								</div>
                                                    
                                                    
								<div class="form-group">
									<label for="contact-message" class="col-sm-3 control-label"><b>Izaberite ulogu</b></label>
									<div class="col-sm-9">
										<select class="form-control" id="prependedInput" name="uloga">
											<?php
                                                                                        foreach ($uloge as $uloga)
                                                                                        {
                                                                                            if($uloga['id'] == $korisnik['ulogaid'])
                                                                                            {
                                                                                                echo "<option value='{$uloga['id']}' selected>{$uloga['naziv']}</option>";
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                echo "<option value='{$uloga['id']}'>{$uloga['naziv']}</option>";
                                                                                            }
                                                                                        }
                                                                                        
                                                                                        
                                                                                        ?>
										</select>
									</div>
								</div>
                                                                
                                                               
								<div class="form-group">
									<div class="col-sm-12">
										<button type="submit" class="btn pull-right" name="sacuvaj">Sačuvaj</button>
									</div>
								</div>
                                                    <input type="hidden" value="<?php echo $korisnik['id']; ?>" name="id">
		        			</form>
		        		</div>
	        		</div>
	        	</div>
	    	</div>
	    </div>
				






<?php

require 'footer.php';

mysqli_close($link);

?>
