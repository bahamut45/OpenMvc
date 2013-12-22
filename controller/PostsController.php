<?php
/**
* 
*/
class PostsController extends Controller{
    
    function index(){
        $perPage = 10;
        $this->loadModel('Post');
        $posts = $this->Post->find(array(
            'fields'     => array('id,name,content,slug'),
            'functions'  => array('DATE_FORMAT( Post.created,  "%W %d %M %Y" ) AS created', 'GROUP_CONCAT( Tags.name SEPARATOR  ", ") AS Tag'),
            'conditions' => array('type' =>'post','online' => 1),
            'joins'      => array(
                array(
                    'table'  => 'posts_categories',
                    'as'     => 'PostCat',
                    'fields' => array(
                        'name' => 'PostCatName',
                        'slug' => 'PostCatSlug',
                    ),
                    'type'       => 'left',
                    'conditions' => 'PostCat.id = Post.cat_id'
                ),
                array(
                    'table'  => 'posts_tags',
                    'as'     => 'PostTags',
                    'type'       => 'left',
                    'conditions' => 'Post.id = PostTags.posts_id'
                ),
                array(
                    'table'  => 'tags',
                    'as'     => 'Tags',
                    'type'       => 'left',
                    'conditions' => 'PostTags.tags_id = Tags.id'
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
            'group'     => 'Post.id, Post.name',
            'orderDesc' => 'Post.created',
            'limit'     => ($perPage*($this->request->page-1)).','.$perPage
        ));

        // Permet de trouver le readmore
        foreach ($posts as $k => $v) {
            if (($more_pos = strpos($v->content, "<hr id=\"openmvc-readmore\" style=\"border: red dashed 1px;\" />")) !== false){
                $v->content = substr($v->content, 0, $more_pos);
                $url = Router::url("posts/view/id:{$v->id}/slug:{$v->slug}");
                $v->content .= '<div class="clearfix"><a class="btn" href="'.$url.'">Lire la suite &rarr;</a></div>';
            }
        }

        $d['posts'] = $posts;

        $d['total'] = $this->Post->findCount(array(
                'type' =>'post',
                'online' => 1
            )
        );
        $d['page'] = ceil($d['total'] / $perPage);
        if (empty($d['posts'])) {
            $this->e404('Post introuvable');
        }

        // Génère l'arbre de catégorie via le controller Posts_categories
        $d['catTree'] = $this->request('Posts_categories','formatCatTree');

        // Génère la liste des archives
        $d['dateTree'] = $this->Post->find(array(
            'fields'     => false,
            'functions'  => array('YEAR(created) AS YEAR', 'MONTHNAME(created) AS MONTH','COUNT(*) AS TOTAL'),
            'conditions' => array('type' =>'post','online' => 1),
            'group'      => 'YEAR,MONTH',
            'orderDesc'  => 'MONTH( created )'
        ));

        $this->set($d);
    }

    //Permet d'afficher les articles qui correspondent à la catégorie.
    function category($category){
        $this->loadModel('Posts_categorie');
        $cat = $this->Posts_categorie->findFirst(array(
            'conditions'=>array('slug'=>$category)
        ));
        if(empty($cat)){
            $this->e404('Page introuvable');
        }
        $perPage = 10;
        $this->loadModel('Post');
        $posts = $this->Post->find(array(
            'fields'     => array('id,name,content,slug'),
            'functions'  => array('DATE_FORMAT( Post.created,  "%W %d %M %Y" ) AS created', 'GROUP_CONCAT( Tags.name SEPARATOR  ", ") AS Tag'),
            'conditions' => array('type' =>'post','online' => 1,'cat_id' => $cat->id),
            'joins'      => array(
                array(
                    'table'  => 'posts_categories',
                    'as'     => 'PostCat',
                    'fields' => array(
                        'name' => 'PostCatName',
                        'slug' => 'PostCatSlug',
                    ),
                    'type'       => 'left',
                    'conditions' => 'PostCat.id = Post.cat_id'
                ),
                array(
                    'table'  => 'posts_tags',
                    'as'     => 'PostTags',
                    'type'       => 'left',
                    'conditions' => 'Post.id = PostTags.posts_id'
                ),
                array(
                    'table'  => 'tags',
                    'as'     => 'Tags',
                    'type'       => 'left',
                    'conditions' => 'PostTags.tags_id = Tags.id'
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
            'group'     => 'Post.id, Post.name',
            'orderDesc' => 'Post.created',
            'limit'     => ($perPage*($this->request->page-1)).','.$perPage
        ));

        // Permet de trouver le readmore
        foreach ($posts as $k => $v) {
            if (($more_pos = strpos($v->content, "<hr id=\"openmvc-readmore\" style=\"border: red dashed 1px;\" />")) !== false){
                $v->content = substr($v->content, 0, $more_pos);
                $url = Router::url("posts/view/id:{$v->id}/slug:{$v->slug}");
                $v->content .= '<div class="clearfix"><a class="btn" href="'.$url.'">Lire la suite &rarr;</a></div>';
            }
        }

        $d['posts'] = $posts;

        $d['total'] = $this->Post->findCount(array(
                'type' =>'post',
                'online' => 1
            )
        );
        $d['page'] = ceil($d['total'] / $perPage);

         // Génère l'arbre de catégorie via le controller Posts_categories
        $d['catTree'] = $this->request('Posts_categories','formatCatTree');

        // Génère la liste des archives
        $d['dateTree'] = $this->Post->find(array(
            'fields'     => false,
            'functions'  => array('YEAR(created) AS YEAR', 'MONTHNAME(created) AS MONTH','COUNT(*) AS TOTAL'),
            'conditions' => array('type' =>'post','online' => 1),
            'group'      => 'YEAR,MONTH',
            'orderDesc'  => 'MONTH( created )'
        ));
        $this->set($d);
    }

    function view($id,$slug){
        $this->loadModel('Post');
        $post = $this->Post->findFirst(array(
            'fields'    => 'id,slug,content,name',
            'conditions'    => array(
                'type' =>'post',
                'online' => 1,
                'id'=>$id
            )
        ));

        //Supprime le hr du readmore pour la visualisation de l'article
        if (($more_pos = strpos($post->content, "<hr id=\"openmvc-readmore\" style=\"border: red dashed 1px;\" />")) !== false){
            $post->content = str_replace("<hr id=\"openmvc-readmore\" style=\"border: red dashed 1px;\" />", "", $post->content);
        }
        $d['post'] = $post;
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
        if (is_null($id)) {
            $d['text'] = 'Ajouter un article';
        }else{
            $d['text'] = 'Editer l\'article';
        }
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
        if (!empty($d['articleTags'])) {
            foreach ($d['articleTags'] as $k => $v) {
                $articleTags[] = $v->name;
            }
            $d['articleTags'] = implode(', ', $articleTags).', ';
        }else{
            $d['articleTags'] = '';
        }

        // Liste tous les tags pour autocompletion
        $this->loadModel('Tag');
        $d['tags'] = $this->Tag->find();
        foreach ($d['tags'] as $k => $v) {
            $listTags[$v->id] = $v->name;
        }
        $d['listTags'] = $listTags;

        // Génère l'arbre de catégorie via le controller Posts_categories
        $d['catTree'] = $this->request('Posts_categories','formatCatTree');

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
