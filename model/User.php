<?php 
/**
 *          
 */
 class User extends Model{
    var $validate = array(
        'login' => array(
            'rule' => 'notEmpty',
            'message' => 'Vous devez préciser un identifiant'
        ),
        'password' => array(
            'rule' => 'notEmpty',
            'message' => 'Vous devez préciser un mot de passe'
        )
    );
 } 
?>