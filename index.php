<?php

require 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader);

echo $twig->render('index.html', array(
		'var' => 'fui'));