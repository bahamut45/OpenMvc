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
 * Permet de determiner si un array est associatif
 * @param  [type]  $var [description]
 * @return boolean      [description]
 */
function is_assoc($var){
    return is_array($var) && array_diff_key($var,array_keys(array_keys($var)));
}

?>