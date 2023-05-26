<?php
header("Content-Type: text/html;charset=utf-8");
include_once ("TControl.php");

/*
function mostrarError ($missatge)
{
	include_once("missatgeCap.html");
	echo "$missatge";
	include_once("missatgePeu.html");
}

*/
function mostrarMissatge ($missatge)
{
	include_once("missatgeCap.html");
	echo "$missatge";
	include_once("missatgePeu.html");
}

//////////////////////////// CODI /////////////////////

if (isset($_POST["opcio"]))
{
	$opcio = $_POST["opcio"];

	switch ($opcio)
	{
		case "Llistat":

			$c = new TControl();
			//agafo id triat
			$idParquing = $_POST["idParquing"];

			$parquing = $c->getParquing($idParquing);
			$adresa = $parquing['adresa'];
			$numBicis = $parquing['numBicis'];
			$maxBicis = $parquing['maxBicis'];

			$perc = 100 * $numBicis / $maxBicis;

			$taulaBicicletesAparcades = $c->taulaBicicletesAparcades($idParquing);

			include_once("dadesParquing.html");
			
			break;

		case "Agafar":
			
			if(!isset($_POST["DNI"]) || !isset($_POST["idParquing"])) mostrarMissatge("S'ha de seleccionar Usuari i Pàrquing!");

			$dni = $_POST["DNI"];
			$idParquing = $_POST["idParquing"];
			$c = new TControl();

			//COmprovo si el parquing té bicis
			$parquing = $c->getParquing($idParquing);

			//Si encara hi ha avions aterrats
			if (intval($parquing['numBicis']) > 0 )
			{
				$c->agafar_bici($dni, $idParquing);
				//feedback correcte
				mostrarMissatge("Has pogut agafar una bici correctament.");
			}
			else
			{
				mostrarMissatge("Algu se t'ha avançat, i ja no queden més bicicletes.");
			}
			
			break;
		
		case "Tornar":

			if(!isset($_POST["DNI"]) || !isset($_POST["idParquing"])) mostrarMissatge("S'ha de seleccionar Usuari i Pàrquing!");

			$dni = $_POST["DNI"];
			$idParquing = $_POST["idParquing"];
			$c = new TControl();

			//Comprovo si el parquing està ple
			$parquing = $c->getParquing($idParquing);

			//Hi ha lloc al parquing
			if (intval($parquing['numBicis']) < intval($parquing['maxBicis']) )
			{
				
				//Comprovo si la bici era d'aquest usuari
				if(true)//if (intval($parquing['numBicis']) < intval($parquing['maxBicis']) )
				{

					$c->tornar_bici($dni, $idParquing);
					mostrarMissatge("Has pogut aparcar la bici correctament.");

				}
				else mostrarMissatge("Aquesta bicicleta no es teva, lladre!");
			}
			else
			{
				mostrarMissatge("Algu se t'ha avançat, i aquest pàrquing ja està ple.");
			}
			
			break;
		
		case "agafar":
			include_once("agafar.html");
			break;

		case "tornar":
			include_once("tornar.html");
			break;
        
        case "llistat_agafades":
            include_once("llistatAgafades.html");
            break;

		case "llistat_parquing":
			include_once("llistatParquing.html");
			break;

		default:
			echo "<br>ERROR: Opció no disponible<br>";

	}
}
?>