<?php 
    //debug($posts);
?>
<div class="page-header">
    <h1><?php echo $total; ?> Articles</h1>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>En ligne ?</th>
            <th>Auteur</th>
            <th>Titre</th>
            <th>Catégorie</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php foreach ($posts as $k => $v): ?>
                <tr>
                    <td><?php echo $v->id; ?></td>
                    <td>
                        <span class="label <?php echo ($v->online == 1) ? 'label-success' : 'label-important'; ?>"><?php echo ($v->online == 1) ? 'En ligne' : 'Hors ligne'; ?></span>
                    </td>
                    <td><?php echo $v->UserLogin; ?></td>
                    <td><?php echo $v->name; ?></td>
                    <td>
                        <span class="label <?php echo ($v->cat_id == 0) ? 'label-important' : 'label-success'; ?>"><?php echo ($v->cat_id == 0) ? 'Sans catégorie' : $v->PostCatName; ?></span>
                    </td>
                    <td>
                        <a href="<?php echo Router::url('admin/posts/edit/'.$v->id); ?>">Editer</a>
                        <a onclick="return confirm(Vouvez vous vraiment supprimer ce contenu');" href="<?php echo Router::url('admin/posts/delete/'.$v->id); ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tr>
    </tbody>
</table>

<a href="<?php echo Router::url('admin/posts/edit'); ?>" class="btn btn-primary">Ajouter un article</a>