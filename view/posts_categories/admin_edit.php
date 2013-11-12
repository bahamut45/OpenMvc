<div class="page-header">
    <h1><?php echo $text; ?></h1>
</div>
<?php 
    echo $this->Form->create(null,array(
    'class' => 'form-horizontal',
    'inputDefaults' => array(
        'format'  => array('div', 'before', 'label', 'between', 'input', 'disError', 'after', 'endDiv'),
        'div'     => 'control-group',
        'label'   => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'after'   => '</div>',
        'error'   => array('class' => 'error','attributes' => array('wrap' => 'span', 'class' => 'help-inline'))        
    )
    )); 
?>
    <?php echo $this->Form->inputForm('id', array('type' => 'hidden')); ?>
    <?php echo $this->Form->inputForm('name',array(
        'label' => array('text' => 'Titre :')        
    )); ?>
    <?php echo $this->Form->inputForm('parentId',array(
        'type' => 'select',
        'label' => array('text' => 'Catégorie Parente:'),
        'attributes' => $catTree
    )); ?>
    <?php echo $this->Form->inputForm('sort',array(
        'label' => array('text' => 'Ordre :'),
        'class' => 'input-mini',
    )); ?>
    <?php echo $this->Form->inputForm('content',array(
        'type' => 'textarea',
        'label' => array('text' => 'Description :'),
        'class' => 'wysiwyg',
        'rows' => 5
    )); ?>

<?php 
    echo $this->Form->end(array(
        'input' => array(
            'class' => 'btn btn-primary',
            'value' => 'Envoyer'
        ),
        'reset' => array(
            'class' => 'btn btn-danger',
            'style' => 'margin-left:5px',
            'value' => 'Effacer'
        ),
        'cancel' => array(
            'class' => 'btn btn-info',
            'style' => 'margin-left:5px',
            'url'   => 'cockpit/posts_categories',
            'value' => 'Annuler'
        ),
        'div' => 'form-actions'
    ));
?>

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

