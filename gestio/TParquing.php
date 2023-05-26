<?php
//Classe de MODEL encarregada de la gestió de la taula BICICLETA de la base de dades
include_once ("TAccesbd.php");
class TParquing
{
    private $idParquing;
    private $adresa;
    private $maxBicis;
    private $numBicis;

    function __construct($v_idParquing, $v_adresa, $v_maxBicis, $v_numBicis,
                         $servidor, $usuari, $paraula_pas, $nom_bd)
    {
        $this->idParquing = $v_idParquing;
        $this->adresa = $v_adresa;
        $this->maxBicis = $v_maxBicis;
        $this->numBicis = $v_numBicis;
        $var_abd = new TAccesbd($servidor,$usuari,$paraula_pas,$nom_bd);
        $this->abd = $var_abd;
        $this->abd->connectar_BD();
    }

    function __destruct()
    {
        if (isset($this->abd))
        {
        unset($this->abd);
        }
    }

    /*
    public function totalAterrats()
	{
		$res = 0;
        $sql = "select count(*) as quants from avio where aeroport is not null";
	
        if ($this->abd->consulta_SQL($sql) )
        {
			
            if ($this->abd->consulta_fila())
            {
                $res = ($this->abd->consulta_dada('quants'));
            }
        }
        return $res;
	}

	public function totalVolant()
	{
        $res = 0;
		$sql = "select count(*) as quants from avio where aeroport is null";
		if ($this->abd->consulta_SQL($sql) )
        {
            if ($this->abd->consulta_fila())
            {
                $res = ($this->abd->consulta_dada('quants'));
            }
        }
        return $res;
	}*/

    public function getParquing($idParquing){
        $sql = "select id, adresa, numBicis, maxBicis from parquing WHERE id = $idParquing";
        
        if ($this->abd->consulta_SQL($sql))
        {   
            $fila = $this->abd->consulta_fila();
            if ($fila == null)
            {
                $res = "<br><h2>Aquest pàrquing no existeix!</h2><br>";
            }
            else
            {
                $res = array();
                $res['id'] = $this->abd->consulta_dada('id');
                $res['adresa'] = $this->abd->consulta_dada('adresa'); 
                $res['numBicis'] = $this->abd->consulta_dada('numBicis');
                $res['maxBicis'] = $this->abd->consulta_dada('maxBicis');
                
            }
            $this->abd->tancar_consulta();
        }
        return $res;
    }

    public function llistaParquingsDisponibles()
    {
        $res = $this->llistaParquings("select id, adresa, numBicis, maxBicis from parquing where numBicis < maxBicis");
        return $res;
    }
    
    public function llistaParquingsAmbBicis()
    {
        $res = $this->llistaParquings("select id, adresa, numBicis, maxBicis from parquing where numBicis > 0");
        return $res;
    }

    public function llistaParquings($SQL)
    {
        $res = false;

        if ($this->abd->consulta_SQL($SQL))
        {   
            $fila = $this->abd->consulta_fila();
            if ($fila == null)
            {
                $res = "<br><h2>Tots els pàrquings estàn ocupats!</h2><br>";
            }
            else
            {
                $res = "<select  name='idParquing'> ";
                while ($fila != null)
                {
                    $id = $this->abd->consulta_dada('id');
                    $adresa = $this->abd->consulta_dada('adresa'); 
                    $numBicis = $this->abd->consulta_dada('numBicis');
                    $maxBicis = $this->abd->consulta_dada('maxBicis');
                    
                    $res = $res . "<option value='" . $id . "'>";
                    $res = $res . "ID: $id - $adresa - $numBicis de $maxBicis bicicletes</option>";
                    $fila = $this->abd->consulta_fila();
                }
                $res = $res . "</select>";
            }
            $this->abd->tancar_consulta();
        }
        return $res;
    }


    /* Retorna un objecte TBicicleta, i redueix le número de bicis del pàrquing.
      Aquí he afegit jo, que agafi la bici amb menys kilometratge sempre que pugui.
    */
    public function agafar_bici ($dni)
	{
        $idParquing = $this->idParquing;
        $sql = "select id from bicicleta where idParquing = $idParquing order by kilometres asc";
        if ($this->abd->consulta_SQL($sql))
        {
            $fila = $this->abd->consulta_fila();
            $idBicicleta = $this->abd->consulta_dada('id');
            
        }

        //Canvio places parking parquing
		$res = false;
        $sql = "update parquing set numBicis = numBicis - 1 where id = $idParquing";
        if ($this->abd->consulta_SQL($sql))
        {
            $res = true;      
        }

        //Canvio dni i parquing de la bicicleta
		$res = false;
        $sql = "update bicicleta set DNICiutada = '$dni', idParquing = null WHERE id = $idBicicleta";
        if ($this->abd->consulta_SQL($sql))
        {
            $res = true;      
        }
    
	}

    /* Retorna un objecte TBicicleta, i redueix le número de bicis del pàrquing.
      Aquí he afegit jo, que agafi la bici amb menys kilometratge sempre que pugui.
    */
    public function tornar_bici ($dni)
	{
        $idParquing = $this->idParquing;
        /*
        NO FA FALTA en aquest cas
        $sql = "select id from bicicleta where DNICiutada = $dni";
        if ($this->abd->consulta_SQL($sql))
        {
            $fila = $this->abd->consulta_fila();
            $idBicicleta = $this->abd->consulta_dada('id');
            
        }*/

        //Canvio places parking parquing
		$res = false;
        $sql = "update parquing set numBicis = numBicis + 1 where id = $idParquing";
        if ($this->abd->consulta_SQL($sql))
        {
            $res = true;      
        }

        
        //Canvio dni i parquing de la bicicleta
		$res = false;
        $sql = "update bicicleta set DNICiutada = null, idParquing = $idParquing WHERE DNICiutada = '$dni'";
        if ($this->abd->consulta_SQL($sql))
        {
            $res = true;      
        }
    
	}

}