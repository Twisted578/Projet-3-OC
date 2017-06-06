<?php session_start();
include '../config.php';
include '../classes/Db.php';
include '../classes/Texte.php';
include '../classes/User.php';
$DB = new DB();
if (!User::isadmin($DB)){
	header('location:../login.php');
	$_SESSION['erreur'] = "Espace réservé aux administrateurs";
	exit();
}



