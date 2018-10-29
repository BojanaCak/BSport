<?php

require 'header.php';

if(!isset($_SESSION['id']) || $_SESSION['uloga'] != "admin")
{
    header("Location: http://localhost:8080/Bsport/login.php");
}

$greske = Array();

$link = konekcija();

$query = "SELECT id, naziv FROM kategorija";

$rezultat = mysqli_query($link, $query);       

$kategorije = mysqli_fetch_all($rezultat, MYSQLI_ASSOC);

$naziv = $kratakopis = $cena = $stanje = $opis = "";

if(isset($_POST['sacuvaj']))
{
    $naziv = mysqli_real_escape_string($link, $_POST['naziv']);
    $kratakopis = mysqli_real_escape_string($link, $_POST['kopis']);
    $kategorijaid = mysqli_real_escape_string($link, $_POST['kategorija']);
    $cena = mysqli_real_escape_string($link, $_POST['cena']);
    $stanje = mysqli_real_escape_string($link, $_POST['stanje']);
    $opis = mysqli_real_escape_string($link, $_POST['opis']);
    
    $file_ext = strtolower(end(explode('.', $_FILES['slika']['name'])));
    $extensions = array("jpeg", "jpg", "png");
    
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
    
    if (empty($_FILES['slika']['name'])) 
    {
        $greske[] = "Morate da izberete sliku novog artikla";
    }
    
    
    if (count($greske) == 0) {
        
        $query = "INSERT INTO artikli(naziv, cena, kratakopis, opis, stanje, kategorijaid)  VALUES('$naziv', $cena, '$kratakopis', '$opis', $stanje, $kategorijaid)";

        if (!mysqli_query($link, $query)) {
            die("Greska: " . mysqli_error($link));
        }
        
        $id = mysqli_insert_id($link);
        
        $target_file = "artikli/artikal$id.jpg";

        $file_tmp = $_FILES['slika']['tmp_name'];
        
        
        move_uploaded_file($file_tmp, $target_file);
        
        header("Location: http://localhost:8080/Bsport/artikliAdmin.php");
    }
}




?>
		<div class="section section-breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1>Unesi Novi Artikal</h1>
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
		        				 	<label for="Naziv" class="col-sm-3 control-label"><b>Naziv</b></label>
		        				 	<div class="col-sm-9">
                                                                    <input class="form-control" id="Naziv" type="text" placeholder="" name="naziv" value="<?php echo $naziv; ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="kratakopis" class="col-sm-3 control-label"><b>Kratak opis</b></label>
									<div class="col-sm-9">
										<input class="form-control" id="kratakopis" type="text" placeholder="" name="kopis" value="<?php echo $kratakopis; ?>">
									</div>
								</div>
                                                    
                                                    
								<div class="form-group">
									<label for="contact-message" class="col-sm-3 control-label"><b>Izaberite kategoriju</b></label>
									<div class="col-sm-9">
										<select class="form-control" id="prependedInput" name="kategorija">
											<?php
                                                                                        foreach ($kategorije as $kategorija)
                                                                                        {
                                                                                            echo "<option value='{$kategorija['id']}'>{$kategorija['naziv']}</option>";                                                                                           
                                                                                        }
                                                                                        ?>
										</select>
									</div>
								</div>
                                                                
                                                                <div class="form-group">
									<label for="cena" class="col-sm-3 control-label"><b>Cena</b></label>
									<div class="col-sm-9">
										<input class="form-control" id="cena" type="text" placeholder="" name="cena" value="<?php echo $cena; ?>">
									</div>
								</div>
                                                    
                                                                <div class="form-group">
									<label for="stanje" class="col-sm-3 control-label"><b>Stanje</b></label>
									<div class="col-sm-9">
										<input class="form-control" id="stanje" type="text" placeholder="" name="stanje" value="<?php echo $stanje; ?>">
									</div>
								</div>
                                                    
								<div class="form-group">
									<label for="opis" class="col-sm-3 control-label"><b>Opis</b></label>
									<div class="col-sm-9">
										<textarea class="form-control" rows="5" id="opis" name="opis"><?php echo $opis; ?></textarea>
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
