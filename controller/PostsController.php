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
            'orderDesc'   => 'created',
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
     * Permet de lister les articles 
     */
    function admin_index(){
        $perPage = 10;
        $this->loadModel('Post');
        $condition = array(
                'type'   =>'post'
            );
        $d['posts'] = $this->Post->find(array(
            'fields'     => array('id,name,online,cat_id,created'),
            'conditions' => $condition,
            'joins'      => array(
                array(
                    'table'  => 'posts_categories',
                    'as'     => 'PostCat',
                    'fields' => array(
                        'name' => 'PostCatName',
                        'parentId' => 'PostCatParentId'
                    ),
                    'type'       => 'left',
                    'conditions' => 'Post.cat_id = PostCat.id'
                ),
                array(
                    'table'  => 'users',
                    'as'     => 'User',
                    'fields' => array(
                        'login' => 'UserLogin'
                    ),
                    'type'       => 'left',
                    'conditions' => 'Post.user_id = User.id'
                )
            ),
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
        //lister les tags de l'article        
        $this->loadModel('Tag');
        $condition = array(
            'pt.posts_id' => $id
        );
        $d['articleTags'] = $this->Tag->find(array(
            'fields' => array('name'),
            'conditions' => $condition,
            'joins'      => array(
                array(
                    'table'  => 'posts_tags',
                    'as'     => 'pt',
                    'type'       => 'left',
                    'conditions' => 'pt.tags_id = Tag.id'
                )
            ),
            'orderAsc' => 'name'
        ));
        foreach ($d['articleTags'] as $k => $v) {
            $articleTags[] = $v->name;
        }
        $d['articleTags'] = implode(', ', $articleTags).', ';

        // Liste tous les tags pour autocompletion
        $this->loadModel('Tag');
        $d['tags'] = $this->Tag->find();
        foreach ($d['tags'] as $k => $v) {
            $listTags[$v->id] = $v->name;
        }
        $d['listTags'] = $listTags;

        //Liste les catégorie et sous catégorie pour les articles
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
                
            $dataTags = array_map('trim',explode(',', $this->request->data->tag));
            $dataTags = array_map('strtolower', $dataTags);
            $dataTags = array_unique($dataTags);

            $addTags = array_diff($dataTags, $articleTags);
            if (count($addTags) > 0) {
                foreach ($addTags as $tag) {
                    if (empty($tag)) {
                        continue;
                    }
                    if (!in_array($tag, $listTags)) {
                        $saveTag = array('name' => $tag);
                        $this->loadModel('Tag');
                        $this->Tag->save($saveTag);
                        $lastTag = $this->Tag->req_id;
                    }else {
                        $lastTag = array_search($tag,$listTags);
                    }
                        $save = array('posts_id' => $id, 'tags_id' => $lastTag);
                        $this->loadModel('Posts_tag');
                        $this->Posts_tag->save($save);
                }
            }

            $delTags = array_diff($articleTags, $dataTags);
            if (count($delTags) > 0) {
                foreach ($delTags as $key) {
                    $tag = array_search($key,$listTags);
                    $this->loadModel('Posts_tag');
                    $tagId = $this->Posts_tag->findFirst(array(
                        'conditions' => array('tags_id' => $tag, 'posts_id' => $id)
                    ));
                    $this->Posts_tag->delete($tagId->id);
                }
            }

            if ($this->Post->validates($this->request->data)) {
                $this->request->data->type = 'post';
                unset($this->request->data->tag);
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
     * @param  [type] $id [description]
     * @return [type]    [description]
     */
    function admin_delete($id){
        $this->loadModel('Post');
        $this->Post->delete($id);
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
