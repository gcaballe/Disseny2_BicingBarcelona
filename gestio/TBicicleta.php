<?php
//Classe de MODEL encarregada de la gestió de la taula BICICLETA de la base de dades
include_once ("TAccesbd.php");
class TBicicleta
{
    private $idBicicleta;
    private $kilometres;
    private $DNICiutada;
    private $parquing;

    function __construct($v_idBicicleta, $v_kilometres, $v_DNICiutada, $v_parquing,
                         $servidor, $usuari, $paraula_pas, $nom_bd)
    {
        $this->idBicicleta = $v_idBicicleta;
        $this->kilometres = $v_kilometres;
        $this->DNICiutada = $v_DNICiutada;
        $this->parquing = $v_parquing;
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

    public function llistaBicicletesAparcades()
    {
        $res = $this->llistaBicicletes("select id, kilometres, DNICiutada, idParquing from bicicleta where idParquing is not null");
        return $res;
    }

    public function llistaBicicletes($SQL)
    {
        $res = false;

        if ($this->abd->consulta_SQL($SQL))
        {   
            $fila = $this->abd->consulta_fila();
            if ($fila == null)
            {
                $res = "<br><h2>No hi han bicicletes disponibles!</h2><br>";
            }
            else
            {
                $res = "<select  name='idBicicleta'> ";
                while ($fila != null)
                {
                    $id = $this->abd->consulta_dada('idBicicleta');
                    $kilometres = $this->abd->consulta_dada('kilometres'); 
                    $DNICiutada = $this->abd->consulta_dada('DNICiutada');
                    
                    $res = $res . "<option value='" . $id . "'>";
                    $res = $res . "$id - $kilometres - $DNICiutada </option>";
                    $fila = $this->abd->consulta_fila();
                }
                $res = $res . "</select>";
            }
            $this->abd->tancar_consulta();
        }
        return $res;
    }
    
    public function taulaBicicletesAparcades($idParquing){
        $res = false;
        $sql = "select b.id, b.kilometres, b.DNICiutada, c.nom from bicicleta b LEFT JOIN ciutada c ON (c.DNI = b.DNICiutada) where idParquing = $idParquing";
        if ($this->abd->consulta_SQL($sql))
        {   
            $fila = $this->abd->consulta_fila();
            $res =  "<table border=1>
                        <thead bgcolor='lightgray'>
                            <td><b>ID bicicleta:</b></td>
                            <td><b>Kilòmetres</b></td>
                        </thead>";
            while ($fila != null)
            {
                $p1 = $this->abd->consulta_dada('id');
                $p2 = $this->abd->consulta_dada('kilometres');
                   
                $res = $res . "<tr>";
                $res = $res . "<td>$p1</td>";
                $res = $res . "<td>$p2</td>";
                $res = $res . "</tr>";
                $fila = $this->abd->consulta_fila();
            }
            $res = $res . "</table>";
            $this->abd->tancar_consulta();
        }
        else
        {
            $res = "<h2>No s'ha pogut realitzar el llistat de bicicletes agafades.</h2>";
        }
        return $res; 
    }

    public function llistaBicicletesAgafades()
    {
        $res = false;
        if ($this->abd->consulta_SQL("select b.id, b.kilometres, b.DNICiutada, c.nom from bicicleta b LEFT JOIN ciutada c ON (c.DNI = b.DNICiutada) where DNICiutada is not null"))
        {   
            $fila = $this->abd->consulta_fila();
            $res =  "<table border=1>
                        <thead bgcolor='lightgray'>
                            <td><b>ID bicicleta:</b></td>
                            <td><b>Kilòmetres</b></td>
                            <td><b>DNI Ciutadà</b></td>
                            <td><b>Nom Ciutadà</b></td>
                        </thead>";
            while ($fila != null)
            {
                $p1 = $this->abd->consulta_dada('id');
                $p2 = $this->abd->consulta_dada('kilometres');
                $p3 = $this->abd->consulta_dada('DNICiutada');
                $p4 = $this->abd->consulta_dada('nom');
   
                $res = $res . "<tr>";
                $res = $res . "<td>$p1</td>";
                $res = $res . "<td>$p2</td>";
                $res = $res . "<td>$p3</td>";
                $res = $res . "<td>$p4</td>";
                $res = $res . "</tr>";
                $fila = $this->abd->consulta_fila();
            }
            $res = $res . "</table>";
            $this->abd->tancar_consulta();
        }
        else
        {
            $res = "<h2>No s'ha pogut realitzar el llistat de bicicletes agafades.</h2>";
        }
        return $res; 
    }


    private function escriuCapsalera ($nom, $ciutat, $npistes)
    {
        $res = "<h1>Dades aeroport</h1>";
        $res = $res . "<h2>L'aeroport de $nom situat a $ciutat te $npistes pistes d'aterratge</h2><br>";
        return $res;
    }

   
}