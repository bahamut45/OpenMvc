<?php
/**
* Dispatcher
* Permet de charger le controller en foncton de la requete utilisateur
*/
class Dispatcher{
    
    var $request; //Object Request

    /**
     * Fonction principale du dispatcher
     * Charge le controller en fonction du routing
     */
    function __construct(){
        $this->request = new Request();
        Router::parse($this->request->url,$this->request);
        $controller = $this->loadController();
        $action = $this->request->action;
        if ($this->request->prefix) {
            $action = $this->request->prefix.'_'.$action;
        }
        if (!in_array($action, array_diff(get_class_methods($controller),get_class_methods('Controller')))) {
            $this->error('Le controleur '.$this->request->controller.' n\'a pas de méthode '.$action);
        }
        call_user_func_array(array($controller,$action),$this->request->params);
        $controller->render($action);
    }

    /**
     * Permet de generer une page d'erreur en cas de probleme au niveau du routing (page inexistante)
     * @param  [type] $message [description]
     * @return [type]          [description]
     */
    function error($message){
        $controller = new Controller($this->request);
        $controller->e404($message);
    }

    /**
     * Permet de charger le controller en fonction de la requete utilisateur
     * @return [type] [description]
     */
    function loadController(){
        $name = ucfirst($this->request->controller).'Controller';
        $file = ROOT.DS.'controller'.DS.$name.'.php';
        if (!file_exists($file)) {
            $this->error('Le controller '.$this->request->controller.' n\'existe pas');
        }
        require $file;
        $controller = new $name($this->request);
        return $controller;
    }
}

?>