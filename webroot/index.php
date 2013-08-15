<?php
$debut = microtime(true);
define('WEBROOT',dirname(__FILE__)); #Definie le dossier web
define('ROOT',dirname(WEBROOT)); # Definie la racine
define('DS',DIRECTORY_SEPARATOR); # Definie le type de separateur(windows \ ou unix /)
define('CORE',ROOT.DS.'core'); # Definie le core
define('BASE_URL', dirname(dirname($_SERVER['SCRIPT_NAME']))); # Definie l'url de base

require CORE.DS.'Includes.php';
new Dispatcher();

?>
<div style="position:fixed;bottom:0;left:0;right:0;background:#900;color:#FFF;line-height:30px;height:30px;padding-left:10px">
<?php echo 'Page générée en '.(round(microtime(true) - $debut,5)*1000).' ms'; ?>    
</div>