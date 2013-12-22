<?php
$style_for_layout = '<style type="text/css">
body {
    background-color: #f5f5f5;
}

.form-signin {
    max-width: 300px;
    padding: 19px 29px 29px;
    margin: 0 auto 20px;
    background-color: #fff;
    border: 1px solid #e5e5e5;
    -webkit-border-radius: 5px;
       -moz-border-radius: 5px;
            border-radius: 5px;
    -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
       -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
            box-shadow: 0 1px 2px rgba(0,0,0,.05);
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
    margin-bottom: 10px;
}
.form-signin input[type="text"],
.form-signin input[type="password"] {
    font-size: 16px;
    height: auto;
    margin-bottom: 15px;
    padding: 7px 9px;
}
</style>';
?>   
<?php 
    echo $this->Form->create(null,array(
    'class' => 'form-signin',
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
<h2 class="form-signin-heading">Zone réservée</h2>
    <?php echo $this->Form->inputForm('login',array(
        'label' => array('text' => 'Identifiant :')        
    )); ?>
    <?php echo $this->Form->inputForm('password',array(
        'type' => 'password',
        'label' => array('text' => 'Mot de passe :')        
    )); ?>
<?php 
    echo $this->Form->end(array(
        'input' => array(
            'class' => 'btn btn-primary',
            'value' => 'Se connecter'
        ),
        'cancel' => array(
            'class' => 'btn btn-info',
            'style' => 'margin-left:5px',
            'url'   => '',
            'value' => 'Annuler'
        ),
        'div' => 'form-actions'
    ));
?>
