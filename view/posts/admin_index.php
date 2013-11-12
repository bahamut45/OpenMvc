<?php 
    //debug($posts);
?>
<div class="page-header">
    <h1><?php echo $total; ?> Articles </h1>
</div>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Etat</th>
            <th>Auteur</th>
            <th>Créé le</th>
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
                        <span class="label <?php echo ($v->online == 1) ? 'label-success' : 'label-important'; ?>"><?php echo ($v->online == 1) ? 'Publié' : 'Brouillon'; ?></span>
                    </td>
                    <td><?php echo $v->UserLogin; ?></td>
                    <td><?php echo $v->created; ?></td>
                    <td><?php echo $v->name; ?></td>
                    <td>
                        <span class="label <?php echo ($v->cat_id == 0) ? 'label-important' : 'label-success'; ?>"><?php echo ($v->cat_id == 0) ? 'Sans catégorie' : $v->PostCatName; ?></span>
                    </td>
                    <td>
                        <a class="btn btn-small" href="<?php echo Router::url('admin/posts/edit/'.$v->id); ?>"><i class="icon-pencil"></i> Editer</a>
                        <a class="btn btn-small btn-danger" onclick="return confirm(Vouvez vous vraiment supprimer ce contenu');" href="<?php echo Router::url('admin/posts/delete/'.$v->id); ?>"><i class="icon-trash icon-white"></i> Supprimer</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tr>
    </tbody>
</table>

<a href="<?php echo Router::url('admin/posts/edit'); ?>" class="btn btn-primary">Ajouter un article</a>