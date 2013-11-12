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
        $d['catTree'] = $this->formatCatTree();
        $d['total'] = $this->Posts_categorie->findCount('parentId <> -1');
        $this->set($d);
    }

    /**
     * Permet d'editer une catégorie
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    function admin_edit($id = null){
        if (is_null($id)) {
            $d['text'] = 'Ajouter une catégorie';
        }else{
            $d['text'] = 'Editer la catégorie';
        }
        // Génère l'arbre de catégorie via le controller Posts_categories
        $d['catTree'] = $this->formatCatTree();
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

    /**
     * Permet de savoir si catégorie parente ou enfante
     * @param  [type]  $id [description]
     * @return boolean     [description]
     */
    public function catHasChild($id){
        $this->loadModel('Posts_categorie');
        $conditions = array(
            'id' => intval($id)
        );
        $res = $this->Posts_categorie->findCount($conditions);
        if (intval($res) > 0) {
            return true;
        }
        return false;
    }

    /**
     * Génére l'arbre de catégorie
     * @param  integer $parent [description]
     * @param  integer $level  [description]
     * @return [type]          [description]
     */
    public function catTree($parent = 0, $level = 0){
        $html = '';
        $this->loadModel('Posts_categorie');
        $cats = $this->Posts_categorie->find(array(
            'fields' =>'id,name,parentId,sort',
            'conditions' => 'parentId = '.intval($parent)
        ));
        foreach ($cats as $cat) {
            $html .= $cat->id . "/" . str_repeat("&mdash;", $level * 1) .'/'. $cat->name . "/".$cat->sort."/".$cat->parentId.",";
            if ($this->catHasChild($cat->id)) {
                $html .= $this->catTree($cat->id,$level+1);
            }
        }
        return $html;
    }

    function formatCatTree(){
        $tree = explode(',', $this->catTree());
        foreach ($tree as $key => $value) {
            if(!empty($value)) {
                $val = explode('/',$value);
                $tr[$key] = array('id' => $val[0],'separator' => $val[1], 'name' => $val[2], 'sort' => $val[3], 'parentId' => $val[4]);
            }
        }
        return $tr;
    }
}
?>
