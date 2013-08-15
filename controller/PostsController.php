<?php
/**
* 
*/
class PostsController extends Controller{
    
    function index(){
        $perPage = 10;
        $this->loadModel('Post');
        $condition = array(
                'type'   =>'post',
                'online' => 1
            );
        $d['posts'] = $this->Post->find(array(
            'conditions' => $condition,
            'limit'      => ($perPage*($this->request->page-1)).','.$perPage
        ));
        $d['total'] = $this->Post->findCount($condition);
        $d['page'] = ceil($d['total'] / $perPage);
        if (empty($d['posts'])) {
            $this->e404('Post introuvable');
        }
        $this->set($d);
    }

    function view($id,$slug){
        $this->loadModel('Post');
        $d['post'] = $this->Post->findFirst(array(
            'fields'    => 'id,slug,content,name',
            'conditions'    => array(
                'type' =>'post',
                'online' => 1,
                'id'=>$id
            )
        ));
        if (empty($d['post'])) {
            $this->e404('Page introuvable');
        }
        if ($slug != $d['post']->slug) {
            $this->redirect("posts/view/id:$id/slug:".$d['post']->slug,301);
        }
        $this->set($d);
    }

    /**
     * Admin
     */
    function admin_index(){
        $perPage = 10;
        $this->loadModel('Post');
        $condition = array(
                'type'   =>'post'
            );
        $d['posts'] = $this->Post->find(array(
            'fields'     => 'id,name,online',
            'conditions' => $condition,
            'limit'      => ($perPage*($this->request->page-1)).','.$perPage
        ));
        $d['total'] = $this->Post->findCount($condition);
        $d['page'] = ceil($d['total'] / $perPage);
        if (empty($d['posts'])) {
            $this->e404('Post introuvable');
        }
        $this->set($d);
    }

    /**
     * Permet d'editer un article
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    function admin_edit($id = null){
        $this->loadModel('Post');
        if ($id === null) {
            $post = $this->Post->findFirst(array(
                'conditions' => array('online' => -1)
            ));
            if (!empty($post)) {
                $id = $post->id;
            }else{
                $this->Post->save(array(
                   'online' => -1
                ));
                $id = $this->Post->id;
            }
         } 
        $d['id'] = $id;       
        if ($this->request->data) {
            if ($this->Post->validates($this->request->data)) {
                $this->request->data->type = 'post';
                $this->request->data->created = date('Y-m-d H:i:s');

                $this->Post->save($this->request->data);
                $this->Session->setFlash('Le contenu a bien été modifié');
                $id = $this->Post->id;
                $this->redirect('admin/posts/index');
            }else{
                $this->Session->setFlash('Merci de corriger vos informations','error');
            }

        }else {
            $this->request->data = $this->Post->findFirst(array(
                'conditions' => array('id' => $id)
            ));
        }

        $this->set($d);

    }

    /**
     * Permet de supprimer un article
     * @param  [type] $i [description]
     * @return [type]    [description]
     */
    function admin_delete($id){
        $this->loadModel('Post');
        // $this->Post->delete($id);
        $this->Session->setFlash('Le contenu a bien été supprimé');
        $this->redirect('admin/posts/index');
    }

    /**
     * Permet de lister les contenus
     */
    function admin_tinymce(){
        $this->loadModel('Post');
        $this->layout = 'modal';
        $d['posts'] = $this->Post->find();
        $this->set($d);
    }


}
?>
