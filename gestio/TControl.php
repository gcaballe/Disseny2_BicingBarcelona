<?php
header("Content-Type: text/html;charset=utf-8");

//Classe de CONTROLADOR
include_once ("TBicicleta.php");
include_once ("TCiutada.php");
include_once ("TParquing.php");


class TControl
{
	private $servidor;
	private $usuari;
	private $paraula_pas;
	private $nom_bd;
	function __construct()
	{
		$this->servidor = "fdb1030.awardspace.net";
		$this->usuari = "4288574_gcaballe";
		$this->paraula_pas = "gcaballe1995";
		$this->nom_bd = "4288574_gcaballe";
	}

	/* Funcions de Bicicleta */
	public function taulaBicicletesAparcades($idParquing){
		$tbici = new TBicicleta ("","","","",
							$this->servidor, $this->usuari, $this->paraula_pas, $this->nom_bd);
		$res = $tbici->taulaBicicletesAparcades($idParquing);
		return $res;
	}

	public function llistaBicicletesAgafades()
	{
		$tbici = new TBicicleta ("","","","",
							$this->servidor, $this->usuari, $this->paraula_pas, $this->nom_bd);
		$res = $tbici->llistaBicicletesAgafades();
		return $res;
	}

	public function llistaBicicletesAparcades()
	{
		$tbici = new TBicicleta ("","","","",
							$this->servidor, $this->usuari, $this->paraula_pas, $this->nom_bd);
		$res = $tbici->llistaBicicletesAparcades();
		return $res;
	}


	/* Funcions de Ciutada */
	public function llistaCiutadansSenseBicicleta()
	{
		$tciu = new TCiutada ("","","","", $this->servidor, $this->usuari, $this->paraula_pas, $this->nom_bd);
		$res = $tciu->llistaCiutadansSenseBicicleta();
		return $res;
	}
	
	public function llistaCiutadansAmbBicicleta()
	{
		$tciu = new TCiutada ("","","","", $this->servidor, $this->usuari, $this->paraula_pas, $this->nom_bd);
		$res = $tciu->llistaCiutadansAmbBicicleta();
		return $res;
	}


	/* Funcions de Pàrquing */
	public function llistaParquingsDisponibles()
	{
		$tparq = new TParquing ("","","","", $this->servidor, $this->usuari, $this->paraula_pas, $this->nom_bd);
		$res = $tparq->llistaParquingsDisponibles();
		return $res;
	}
	
	public function llistaParquingsAmbBicis()
	{
		$tparq = new TParquing ("","","","", $this->servidor, $this->usuari, $this->paraula_pas, $this->nom_bd);
		$res = $tparq->llistaParquingsAmbBicis();
		return $res;
	}

	public function getParquing($idParquing)
	{
		$tparq = new TParquing ("","","","", $this->servidor, $this->usuari, $this->paraula_pas, $this->nom_bd);
		$res = $tparq->getParquing($idParquing);
		return $res;
	}

	
	/*
	Funcions de UPDATE
	*/
	
	/*
	Agafa una bici d'un parquing en concret. La primera avaliable.
	*/
	public function agafar_bici($dni, $idParquing)
	{
		$res = 0;
		$tparq = new TParquing ($idParquing,"","","", $this->servidor, $this->usuari, $this->paraula_pas, $this->nom_bd);
		$res = $tparq->agafar_bici($dni);
		return $res;
	}

	/*
	Torna una bici a un parquing en concret.
	*/
	public function tornar_bici($dni, $idParquing)
	{
		$res = 0;
		$tparq = new TParquing ($idParquing,"","","", $this->servidor, $this->usuari, $this->paraula_pas, $this->nom_bd);
		$res = $tparq->tornar_bici($dni);
		return $res;
	}

}