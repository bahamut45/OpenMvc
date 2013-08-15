<?php
/**
* 
*/
class PagesController extends Controller{
    
    function view($id){
        $this->loadModel('Post');
        $d['page'] = $this->Post->findFirst(array(
            'conditions'    => array(
                'type' =>'page',
                'online' => 1,
                'id'=>$id
            )
        ));
        if (empty($d['page'])) {
            $this->e404('Page introuvable');
        }
        $this->set($d);
    }

    /**
     * Permet de recuperer les pages pour le menu
     * @param  string $value [description]
     * @return [type]        [description]
     */
    function getMenu($value=''){
        $this->loadModel('Post');        
        return $this->Post->find(array(
            'conditions' => array('online' => 1,'type' =>'page')
        ));
    }
}
?>
