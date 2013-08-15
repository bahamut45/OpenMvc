<div class="page-header">
    <h1>Editer un article</h1>
</div>

<form class="form-horizontal" action="<?php echo Router::url('admin/posts/edit/'.$id); ?>" method="post">
    <?php echo $this->Form->input('name','Titre'); ?>
    <?php echo $this->Form->input('slug','Url'); ?>
    <?php echo $this->Form->input('id','hidden'); ?>
    <?php echo $this->Form->input('content','Contenu',array(
        'type' => 'textarea',
        'class' => 'input-xxlarge wysiwyg',
        'rows' => 5
    )); ?>
    <?php echo $this->Form->input('online','En ligne',array(
        'type' => 'checkbox'
    )); ?>
    <div class="form-actions">
        <input type="submit" class="btn btn-primary" name="" value="Envoyer">
    </div>
</form>
<script src="http://code.jquery.com/jquery.min.js"></script>
<script src="<?php echo Router::webroot('js/tinymce/tinymce.min.js'); ?>"></script>
<script type="text/javascript">
    tinyMCE.baseURL ='<?php echo Router::webroot('js/tinymce'); ?>';
    tinymce.init({
        selector: "textarea.wysiwyg",
        theme: "modern",
        language : 'fr_FR',
        plugins: [
            "advlist autoresize autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            // "emoticons template paste textcolor moxiemanager"
            "emoticons template paste textcolor "
        ],
        toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        toolbar2: "print preview media | forecolor backcolor emoticons",
        image_advtab: true,
        templates: [
            {title: 'Test template 1', content: 'Test 1'},
            {title: 'Test template 2', content: 'Test 2'}
        ],
        convert_urls: false,
        file_browser_callback: fileBrowser
    });
    function fileBrowser(field_name, url, type, win){
        if(type=='file'){
          var explorer = '<?php echo Router::url('admin/posts/tinymce'); ?>';
        }else{
          var explorer = '<?php echo Router::url('admin/medias/index/'.$id); ?>';
        }

        tinyMCE.activeEditor.windowManager.open({
            file : explorer,
            title : 'Gallerie',
            width : 850,
            height : 425,
            resizable : 'yes',
        },{
            window : win,
            input : field_name
        });
        window.inputSrc = field_name
        return false;
    }
</script>

