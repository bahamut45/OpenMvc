<?php 
 
?>
<div class="page-header">
    <h1><?php echo $total; ?> Articles</h1>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>En ligne ?</th>
            <th>Titre</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php foreach ($posts as $k => $v): ?>
                <tr>
                    <td><?php echo $v->id; ?></td>
                    <td><span class="label <?php echo ($v->online == 1) ? 'label-success' : 'label-error'; ?>"><?php echo ($v->online == 1) ? 'En ligne' : 'Hors ligne'; ?></span></td>
                    <td><?php echo $v->name; ?></td>
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
