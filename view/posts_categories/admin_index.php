<?php //debug($catTree); ?>

<div class="page-header">
    <h1><?php echo $total; ?> Catégories</h1>
</div>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Ordre</th>
            <th>Titre</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php foreach ($catTree as $k => $v): ?>
                <tr>
                    <td><?php echo $v['id']; ?></td>
                    <td><?php echo $v['sort']; ?></td>
                    <td><?php echo ($v['parentId'] == 0) ? $v['name'] : '<span class="text-info">|'.$v['separator'].'</span> ' . $v['name']; ?></td>
                    <td>
                        <a class="btn btn-small" href="<?php echo Router::url('admin/posts_categories/edit/'.$v['id']); ?>"><i class="icon-pencil"></i> Editer</a>
                        <a class="btn btn-small btn-danger" onclick="return confirm(Vouvez vous vraiment supprimer ce contenu');" href="<?php echo Router::url('admin/posts_categories/delete/'.$v['id']); ?>"><i class="icon-trash icon-white"></i> Supprimer</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tr>
    </tbody>
</table>

<a href="<?php echo Router::url('admin/posts_categories/edit'); ?>" class="btn btn-primary">Ajouter une Catégorie</a>