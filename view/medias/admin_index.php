
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Image</th>
            <th>Titre</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php foreach ($images as $k => $v): ?>
                <tr>
                    <td><img src="<?php echo Router::webroot('img/'.$v->file); ?>" alt="<?php echo $v->name; ?>"></td>
                    <td><?php echo $v->name; ?></td>
                    <td>
                        <a onclick="return confirm(Vouvez vous vraiment supprimer cette image');" href="<?php echo Router::url('admin/medias/delete/'.$v->id); ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tr>
    </tbody>
</table>

<div class="page-header">
    <h1>Ajouter une image</h1>
</div>

<form id="test" class="form-horizontal" action="<?php echo Router::url('admin/medias/index/'.$post_id); ?>" method="post" enctype="multipart/form-data">
    <?php echo $this->Form->input('file','Image',array('type' => 'file')); ?>
    <?php echo $this->Form->input('name','Titre'); ?>
    <div class="form-actions">
        <input type="submit" class="btn btn-primary" name="" value="Envoyer">
    </div>
</form>
<script src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
var parentWin = (!window.frameElement && window.dialogArguments) || opener || parent || top;
$(function() {
    $('img').click(function(e){
        e.preventDefault();
        imgSrc = $(this).attr('src');
        imgAlt = $(this).attr('alt');
        divInput = $("input#"+parentWin.inputSrc,parent.document).parent().attr('id');
        divInputSplit = divInput.split("_");
        divTitle = "mce_"+(parseInt(divInputSplit[1],10) +1);
        $("input#"+parentWin.inputSrc,parent.document).val(imgSrc);
        $("input#"+divTitle,parent.document).val(imgAlt);
        $(".mce-close",parent.document).last().trigger("click");
    });
});
</script>
