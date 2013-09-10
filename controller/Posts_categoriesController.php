<?php
/**
* 
*/
class Posts_categoriesController extends Controller{

    /**
     * Liste des catégories 
     */
    function admin_index(){
        $this->loadModel('Posts_categorie');
        $d['categories'] = $this->Posts_categorie->find(array(
            'conditions' => 'parentId <> -1'
        ));
        $d['total'] = $this->Posts_categorie->findCount('parentId <> -1');
        $this->set($d);
    }

    /**
     * Permet d'editer une catégorie
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    function admin_edit($id = null){
        $this->loadModel('Posts_categorie');
        $d['cat'] = $this->Posts_categorie->find(array(
            'fields' =>'id,name,parentId',
            'conditions' => 'parentId = 0',
            'orderAsc' => 'parentId'
        ));
        $d['subcat'] = $this->Posts_categorie->find(array(
            'fields' =>'id,name,parentId',
            'conditions' => 'parentId != 0 AND parentId != -1',
            'orderAsc' => 'parentId'
        ));
        if ($id === null) {
            $categories = $this->Posts_categorie->findFirst(array(
                'conditions' => array('parentId' => -1)
            ));
            if (!empty($categories)) {
                $id = $categories->id;
            }else{
                $this->Posts_categorie->save(array(
                   'parentId' => -1
                ));
                $id = $this->Posts_categorie->id;
            }
         } 
        $d['id'] = $id;       
        if ($this->request->data) {
            debug($this->request->data);
            if ($this->Posts_categorie->validates($this->request->data)) {
                $this->Posts_categorie->save($this->request->data);                
                $this->Session->setFlash('Le contenu a bien été modifié');
                $id = $this->Posts_categorie->id;
                $this->redirect('admin/posts_categories/index');
            }else{
                $this->Session->setFlash('Merci de corriger vos informations','error');
            }
        }else {
            $this->request->data = $this->Posts_categorie->findFirst(array(
                'conditions' => array('id' => $id)
            ));
        }
        $this->set($d);
    }
}
?>
