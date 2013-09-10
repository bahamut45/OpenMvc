<?php //debug($categorie); ?>

<div class="page-header">
    <h1><?php echo $total; ?> Catégories</h1>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Ordre</th>
            <th>Type</th>
            <th>Titre</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php foreach ($categories as $k => $v): ?>
                <tr>
                    <td><?php echo $v->id; ?></td>
                    <td><?php echo $v->sort ?></td>
                    <td>
                        <span class="label <?php echo ($v->parentId == 0) ? 'label-info' : 'label-success'; ?>"><?php echo ($v->parentId == 0) ? 'Catégorie principale' : 'Sous catégorie'; ?></span>
                    </td>
                    <td><?php echo $v->name; ?></td>
                    <td>
                        <a href="<?php echo Router::url('admin/posts_categories/edit/'.$v->id); ?>">Editer</a>
                        <a onclick="return confirm(Vouvez vous vraiment supprimer ce contenu');" href="<?php echo Router::url('admin/posts_categories/delete/'.$v->id); ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tr>
    </tbody>
</table>

<a href="<?php echo Router::url('admin/posts_categories/edit'); ?>" class="btn btn-primary">Ajouter une Catégorie</a>