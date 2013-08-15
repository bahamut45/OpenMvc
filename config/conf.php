<?php 
/**
*  Permet de recuperer la configuration mysql
*/
class Conf{

    static $debug = 1;
    
    static $databases = array(
        'default' => array(
            'host'      => 'localhost',
            'database'  => 'OpenMvc',
            'login'     => 'root',
            'password'  => 'admin'
        )
    );
}

Router::prefix('cockpit','admin');
Router::connect('','posts/index');
Router::connect('cockpit','cockpit/posts/index');
Router::connect('blog/:slug-:id','posts/view/id:([0-9]+)/slug:([a-z0-9\-]+)');
Router::connect('blog/*','posts/*');
?>