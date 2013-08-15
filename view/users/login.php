<div class="page-header">
    <h1>Zone réservé</h1>
    <form class="form-horizontal" action="<?php echo Router::url('users/login'); ?>" method="post">
        <?php echo $this->Form->input('login','Identifiant'); ?>
        <?php echo $this->Form->input('password','Mot de Passe', array('type' => 'password')); ?>
        <div class="form-actions">
            <input type="submit" class="btn btn-primary" value="Se connecter">
        </div>
    </form>

</div>