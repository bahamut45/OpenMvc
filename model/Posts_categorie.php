<?php
/**
* 
*/
class Posts_categorie extends Model{
        var $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'Vous devez préciser un titre'
        ),
        'sort' => array(
            'rule' => 'notEmpty',
            'message' => 'Vous devez préciser un ordre'
        )
    );
}
?>