<?php

require 'header.php';

if(!isset($_SESSION['id']) || $_SESSION['uloga'] != "admin")
{
    header("Location: http://localhost:8080/Bsport/login.php");
}

$greske = Array();

$link = konekcija();

$id = mysqli_real_escape_string($link, $_GET['ida']);

$query = "SELECT id, naziv, cena, kratakopis, stanje, kategorijaid, opis FROM artikli WHERE id = $id";

$rezultat = mysqli_query($link, $query);       

$artikal = mysqli_fetch_assoc($rezultat);

$query = "SELECT id, naziv FROM kategorija";

$rezultat = mysqli_query($link, $query);       

$kategorije = mysqli_fetch_all($rezultat, MYSQLI_ASSOC);

if(isset($_POST['sacuvaj']))
{
    $id = mysqli_real_escape_string($link, $_POST['id']);
    $naziv = mysqli_real_escape_string($link, $_POST['naziv']);
    $kratakopis = mysqli_real_escape_string($link, $_POST['kopis']);
    $kategorijaid = mysqli_real_escape_string($link, $_POST['kategorija']);
    $cena = mysqli_real_escape_string($link, $_POST['cena']);
    $stanje = mysqli_real_escape_string($link, $_POST['stanje']);
    $opis = mysqli_real_escape_string($link, $_POST['opis']);
    
    
    if($naziv == "")
    {
        $greske[] = "Morate da unesete naziv";
        
    }
    if($kratakopis == "")
    {
        $greske[] = "Morate da unesete kratak opis artikla";
        
    }
    if($cena == "")
    {
        $greske[] = "Morate da unesete cenu artikla";
        
    }
    if($stanje == "")
    {
        $greske[] = "Morate da unesete stanje artikla";
        
    }   
    if($opis == "")
    {
        $greske[] = "Morate da unesete opis artikla";
        
    }   
    if (count($greske) == 0) {
        
        $query = "UPDATE artikli SET naziv = '$naziv', kratakopis = '$kratakopis', kategorijaid = $kategorijaid, cena = $cena, stanje = $stanje, opis = '$opis' WHERE id = $id";

        if (!mysqli_query($link, $query)) {
            die("Greska: " . mysqli_error($link));
        }

        if (isset($_FILES['slika'])) {
            $target_file = "artikli/artikal$id.jpg";

            $file_tmp = $_FILES['slika']['tmp_name'];
            $file_ext = strtolower(end(explode('.', $_FILES['slika']['name'])));

            $extensions = array("jpeg", "jpg", "png");

            if (in_array($file_ext, $extensions)) {
                unlink($target_file);
                move_uploaded_file($file_tmp, $target_file);
            }
        }




        header("Location: http://localhost:8080/Bsport/artikliAdmin.php");
    }
}




?>
		<div class="section section-breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1>Izmeni Artikal</h1>
					</div>
				</div>
			</div>
		</div>
        
        <div class="section">
	    	<div class="container">
	        	<div class="row">
	        		<div class="col-sm-7 col-sm-offset-3 shop-item">
                                    <div class="image"><img style="margin-top: 10px;" src="<?php echo "artikli/s" . $artikal['id'] . ".jpg"; ?>"></div>
                                </div>
                                                          
                        </div>
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
		        				 	<label for="Naziv" class="col-sm-3 control-label"><b>Naziv</b></label>
		        				 	<div class="col-sm-9">
                                                                    <input class="form-control" id="Naziv" type="text" placeholder="" name="naziv" value="<?php echo $artikal['naziv']; ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="kratakopis" class="col-sm-3 control-label"><b>Kratak opis</b></label>
									<div class="col-sm-9">
										<input class="form-control" id="kratakopis" type="text" placeholder="" name="kopis" value="<?php echo $artikal['kratakopis']; ?>">
									</div>
								</div>
                                                    
                                                    
								<div class="form-group">
									<label for="contact-message" class="col-sm-3 control-label"><b>Izaberite kategoriju</b></label>
									<div class="col-sm-9">
										<select class="form-control" id="prependedInput" name="kategorija">
											<?php
                                                                                        foreach ($kategorije as $kategorija)
                                                                                        {
                                                                                            if($kategorija['id'] == $artikal['kategorijaid'])
                                                                                            {
                                                                                                echo "<option value='{$kategorija['id']}' selected>{$kategorija['naziv']}</option>";
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                echo "<option value='{$kategorija['id']}'>{$kategorija['naziv']}</option>";
                                                                                            }
                                                                                        }
                                                                                        
                                                                                        
                                                                                        ?>
										</select>
									</div>
								</div>
                                                                
                                                                <div class="form-group">
									<label for="cena" class="col-sm-3 control-label"><b>Cena</b></label>
									<div class="col-sm-9">
										<input class="form-control" id="cena" type="text" placeholder="" name="cena" value="<?php echo $artikal['cena']; ?>">
									</div>
								</div>
                                                    
                                                                <div class="form-group">
									<label for="stanje" class="col-sm-3 control-label"><b>Stanje</b></label>
									<div class="col-sm-9">
										<input class="form-control" id="stanje" type="text" placeholder="" name="stanje" value="<?php echo $artikal['stanje']; ?>">
									</div>
								</div>
                                                    
								<div class="form-group">
									<label for="opis" class="col-sm-3 control-label"><b>Opis</b></label>
									<div class="col-sm-9">
										<textarea class="form-control" rows="5" id="opis" name="opis"><?php echo $artikal['opis']; ?></textarea>
									</div>
								</div>
                                                
                                                                <div class="form-group">
                                                                    <label for="Slika" class="col-sm-3 control-label"><b>Slika</b></label>
                                                                    <div class="col-sm-9">
                                                                        <input type="file" name="slika">
                                                                    </div>
                                                                </div>
								<div class="form-group">
									<div class="col-sm-12">
										<button type="submit" class="btn pull-right" name="sacuvaj">Sačuvaj</button>
									</div>
								</div>
                                                    <input type="hidden" value="<?php echo $artikal['id']; ?>" name="id">
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
