<?php 
/**
 * Permet de debuguer une variable
 * @param  [type] $var [description]
 * @return [type]      [description]
 */
function debug($var = null){  
    if($var === null){
        echo '<pre>';
        print_r($GLOBALS);
        echo '</pre>';
    }else{
        if(Conf::$debug >0){
            $debug = debug_backtrace();
            echo '<p>&nbsp;</p><p><a href="#" onclick="$(this).parent().next(\'ol\').slideToggle(); return false;"><strong>'.$debug[0]['file'].' </strong> l.'.$debug[0]['line'].'</a></p>';
            echo '<ol style="display:none;">';
            foreach($debug as $k => $v){ if($k>0){
                echo '<li><strong>'.$v['file'].' </strong> l.'.$v['line'].'</a></li>';
            }}
            echo '</ol>';
            echo '<pre>';
            print_r($var);
            echo '</pre>';
        }       
    }
}

/**
 * Permet de compter le nombre de requete pour afficher une page
 * @return [int] [nombre de requetes]
 */
function nbQueries(){
    $count = count(explode('|',$_SESSION['CountSql'],-1)); //le -1 permet de supprimer le pipe supplémentaire vide
    unset($_SESSION['CountSql']); // une fois que l'on a lu et affecté la variable on la detruit
    return $count;
}

/**
 * Permet d'afficher le temps de chargement d'une page
 * @return [type] [description]
 */
function loadPage(){
    return $_SESSION['loadPage'];
}

/**
 * Permet de determiner si un array est associatif
 * @param  [type]  $var [description]
 * @return boolean      [description]
 */
function isAssoc($var){
    return is_array($var) && array_diff_key($var,array_keys(array_keys($var)));
}

/**
 * Permet de determiner si l'url correspond à l'url visité
 * @param  [type]  $url   [description]
 * @param  [type]  $class [description]
 * @return boolean        [description]
 */
function isActive($url,$class, $exact = true){
    $html = '';
    if ($exact === true) {
        if ($_SERVER['REQUEST_URI'] == $url) {
            $html = $class;
        }
    }else {
        $url = '/'.str_replace('/', '\/', $url).'/';
        if (preg_match($url, $_SERVER['REQUEST_URI'])) {
            $html = $class;
        }
    }
    return $html;
}
?>