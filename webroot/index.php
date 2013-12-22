<?php
$debut = microtime(true);
define('WEBROOT',dirname(__FILE__)); #Definie le dossier web
define('ROOT',dirname(WEBROOT)); # Definie la racine
define('DS',DIRECTORY_SEPARATOR); # Definie le type de separateur(windows \ ou unix /)
define('CORE',ROOT.DS.'core'); # Definie le core
define('BASE_URL', dirname(dirname($_SERVER['SCRIPT_NAME']))); # Definie l'url de base

require CORE.DS.'Includes.php';
new Dispatcher();

$_SESSION['loadPage'] = (round(microtime(true) - $debut,5)*1000);
?>