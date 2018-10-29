<?php

function konekcija()
{
        
    $link = mysqli_connect("localhost","root","","bsport");
    
    if(!$link){
        die("Greska u konekciji sa bazom podataka: ".mysqli_connect_error());
    }
    
    return $link;
    
    
    
}

