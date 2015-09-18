<?php
require 'vendor/autoload.php';
include_once 'dbconfig.php';
include_once 'controller/Proprietario.php';
include_once 'controller/Animal.php';

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader, array( 'debug' => true ));
$twig->addExtension(new Twig_Extension_Debug());
$db = connect("us-cdbr-iron-east-02.cleardb.net", "heroku_37cb58925e40f47","b84259f8a37b3c","498b47c3");
$proprietarioController = new ProprietarioController($twig,$db);
$animalController = new animalController($twig,$db);

if (isset($_GET['action']) && !empty($_GET['action']) &&
	isset($_GET['controller']) && !empty($_GET['controller'])) {
    if ($_GET['controller'] == 'proprietario')
    {
    	if (($_GET['action'] == 'edit' || $_GET['action'] == 'delete') && isset($_GET['id']) && !empty($_GET['id']))
			$proprietarioController->{$_GET['action']}($_GET['id']);
		else if ($_GET['action'] == 'update')
			$proprietarioController->update($_GET['id'], $_POST['name'],$_POST['email'],$_POST['phone'],$_POST['adr']);
		else if ($_GET['action'] == 'create')
			$proprietarioController->create($_POST['name'],$_POST['email'],$_POST['phone'],$_POST['adr']);
		else
    		$proprietarioController->{$_GET['action']}();
    }
    else if ($_GET['controller'] == 'animal')
    {
    	if (($_GET['action'] == 'edit' || $_GET['action'] == 'delete') && isset($_GET['id']) && !empty($_GET['id']))
			$animalController->{$_GET['action']}($_GET['id']);
		else if ($_GET['action'] == 'update')
			$animalController->update($_GET['id'], $_POST['name'],$_POST['species'],$_POST['birth'],$_POST['notes'],$_POST['owner']);
		else if ($_GET['action'] == 'create')
			$animalController->create($_POST['name'],$_POST['species'],$_POST['birth'],$_POST['notes'],$_POST['owner']);
		else
    		$animalController->{$_GET['action']}();
    }
}
else
	echo $twig->render('index.html', array(
			'var' => 'teste'));