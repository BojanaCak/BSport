<?php
require 'konekcija.php';

class Artikal
{
    public $id;
    public $cena;
    public $naziv;
    public $kolicina;
    
    public function __construct($id, $kolicina, $naziv, $cena) {
        $this->id = $id;
        $this->kolicina = $kolicina;
        $this->cena = $cena;
        $this->naziv = $naziv;
    }
    
    public function proveriStanje()
    {
        $link = konekcija();
        
        $query = "SELECT stanje FROM artikli WHERE id={$this->id}";
        
        $rezultat = mysqli_query($link, $query);
        
        $red = mysqli_fetch_assoc($rezultat);
        
        if($red['stanje'] < $this->kolicina)
        {
            $this->kolicina = $red['stanje'];
            return "Artikla {$this->naziv} nažalost nema dovoljno na stanju";
        }
        else
        {
            return "";
        }
        
        mysqli_close($link);
    }
    
}


class Korpa
{
    public $artikli;
    public $broj;
    
    function __construct() {
        $this->artikli = Array();
        $this->broj = 0;
    }
    
    public function azurirajKorpu($artikal)
    {
        foreach($this->artikli as $jedan)
        {
            if($jedan->id == $artikal->id)
            {
                $jedan->kolicina += $artikal->kolicina;
                return;
            }
        }
        
        $this->artikli[$this->broj] = $artikal;
        $this->broj++;
        
    }
    
    public function ukupno()
    {
        $ukupno = 0.0;
        
        foreach($this->artikli as $jedan)
        {
            $ukupno += $jedan->cena * $jedan->kolicina;
        }
        
        return $ukupno;
    }
    
}

class Kategorija
{
    public $id;
    public $naziv;
    
    public function __construct($id, $naziv) {
        $this->id = $id;
        $this->naziv = $naziv;
    }
}