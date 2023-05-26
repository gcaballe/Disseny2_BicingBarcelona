<?php
//Classe de MODEL encarregada de la gestió de la taula BICICLETA de la base de dades
include_once ("TAccesbd.php");
class TCiutada
{
    private $DNI;
    private $pass;
    private $nom;
    private $telefon;

    function __construct($v_DNI, $v_pass, $v_nom, $v_telefon,
                         $servidor, $usuari, $paraula_pas, $nom_bd)
    {
        $this->DNI = $v_DNI;
        $this->pass = $v_pass;
        $this->nom = $v_nom;
        $this->telefon = $v_telefon;
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

    public function llistaCiutadansSenseBicicleta()
    {
        $res = $this->llistCiutadans("SELECT c.DNI, c.nom, c.telefon FROM ciutada c left join bicicleta b on (b.DNICiutada = c.DNI) where b.id is null");
        return $res;
    }
   
    public function llistaCiutadansAmbBicicleta()
    {
        $res = $this->llistCiutadans("SELECT c.DNI, c.nom, c.telefon FROM ciutada c left join bicicleta b on (b.DNICiutada = c.DNI) where b.id is not null");
        return $res;
    }

    public function llistCiutadans($SQL)
    {
        $res = false;

        if ($this->abd->consulta_SQL($SQL))
        {   
            $fila = $this->abd->consulta_fila();
            if ($fila == null)
            {
                $res = "No hi ha cap ciutadà per aquesta opció.";
            }
            else
            {
                $res = "<select name='DNI'> ";
                while ($fila != null)
                {
                    $id = $this->abd->consulta_dada('DNI');
                    $nom = $this->abd->consulta_dada('nom'); 
                    $telefon = $this->abd->consulta_dada('telefon');
                    
                    $res = $res . "<option value='" . $id . "'>";
                    $res = $res . "$id - $nom - Tlf: $telefon </option>";
                    $fila = $this->abd->consulta_fila();
                }
                $res = $res . "</select>";
            }
            $this->abd->tancar_consulta();
        }
        return $res;
    }


    /*
    public function enlairar ()
	{
        
		$res = false;
        $sql = "update avio set aeroport = null where idAvio = '$this->idAvio'";
        if ($this->abd->consulta_SQL($sql))
        {
            $res = true;      
        }
    
        return $res;
	}

	function aterrar ()
	{
        $res = false;
        $sql = "update avio set aeroport = '$this->aeroport' where idAvio = '$this->idAvio'";
        if ($this->abd->consulta_SQL($sql))
        {
            $res = true;       
        }
        return $res;
	}

    public function llistatVolant()
    {
        $res = false;
        if ($this->abd->consulta_SQL("select * from avio where aeroport is null"))
        {   
            $fila = $this->abd->consulta_fila();
            $res =  "<table border=1><tr bgcolor='lightgray'>
                        <th>idAvio</th><th>Tipus</th><th>nPass</th>
                    </tr> ";
            while ($fila != null)
            {
                $idAvio = $this->abd->consulta_dada('idAvio');
                $tipus = $this->abd->consulta_dada('tipus');
                $nPass = $this->abd->consulta_dada('nPass');
   
                $res = $res . "<tr>";
                $res = $res . "<td>$idAvio</td>";
                $res = $res . "<td>$tipus</td>";
                $res = $res . "<td align='right'>$nPass</td>";
                $res = $res . "</tr>";
                $fila = $this->abd->consulta_fila();
            }
            $res = $res . "</table>";
            $this->abd->tancar_consulta();
        }
        else
        {
            $res = "<h2>No s'ha pogut realitzar el llistat d'avions volant.</h2>";
        }
        return $res; 
    }*/


    private function escriuCapsalera ($nom, $ciutat, $npistes)
    {
        $res = "<h1>Dades aeroport</h1>";
        $res = $res . "<h2>L'aeroport de $nom situat a $ciutat te $npistes pistes d'aterratge</h2><br>";
        return $res;
    }

    /*


    public function llistatAvionsAeroport ()
	{
        
		$res = false;
        $sql = "select nom, ciutat, nPistes from aeroport where nom = '$this->aeroport'";

        if ($this->abd->consulta_SQL($sql))
        {
            $fila = $this->abd->consulta_fila();
            $nom = $this->abd->consulta_dada('nom');
            $ciutat = $this->abd->consulta_dada('ciutat');
            $npistes = $this->abd->consulta_dada('nPistes');
            $res = $this->escriuCapsalera ($nom, $ciutat, $npistes);
            $sql = "select idAvio, tipus, npass from avio where aeroport = '$this->aeroport'";
            if ($this->abd->consulta_SQL($sql))
            {   
                $fila = $this->abd->consulta_fila();
                $res = $res . "<table border=1><tr bgcolor='lightblue'><th>ID Avió</th><th>Tipus</th><th>Núm. Passatgers</th></tr> ";
                while ($fila != null)
                {
                    $idAvio = $this->abd->consulta_dada('idAvio');
                    $tipus = $this->abd->consulta_dada('tipus');
                    $npass = $this->abd->consulta_dada('npass');
                    
                    $res = $res . "<tr>";
                    $res = $res . "<td align='center'> $idAvio </td>";
                    $res = $res . "<td align='center'> $tipus </td>";
                    $res = $res . "<td align='center'> $npass </td>";
                    $res = $res ."</tr>";
                             
                    $fila = $this->abd->consulta_fila();
                }
                $res = $res . "</table><br>";
                $this->abd->tancar_consulta();
            }
        }
        return $res;
	}

    */

}