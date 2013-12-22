<?php
 //debug(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo isset($title_for_layout) ? $title_for_layout : 'Mon site'; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="http://getbootstrap.com/2.3.2/assets/css/bootstrap.css" rel="stylesheet">
        <style type="text/css">
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>
        <?php if (isset($style_for_layout)): ?>
            <?php echo $style_for_layout; ?>
        <?php endif ?>
        <link href="http://getbootstrap.com/2.3.2/assets/css/bootstrap-responsive.css" rel="stylesheet">

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Le fav and touch icons -->
        <link rel="shortcut icon" href="http://getbootstrap.com/2.3.2/assets/ico/favicon.png">
        <link rel="apple-touch-icon" href="http://getbootstrap.com/2.3.2/assets/ico/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="http://getbootstrap.com/2.3.2/assets/ico/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="http://getbootstrap.com/2.3.2/assets/ico/apple-touch-icon-114x114.png">
    </head>
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="#">OpenMvc</a>
                    <div class="nav-collapse">
                        <ul class="nav">
                            <?php $pagesMenu = $this->request('Pages','getMenu'); ?>
                            <?php foreach ($pagesMenu as $p): ?>
                                <li class="<?php echo isActive(Router::url('pages/view/'.$p->id),'active'); ?>"><a href="<?php echo Router::url('pages/view/'.$p->id); ?>"><?php echo $p->name; ?></a></li>
                            <?php endforeach ?>
                            <li class="<?php echo isActive(Router::url(''),'active'); echo isActive(Router::url('posts'),'active',false); ?>"><a href="<?php echo Router::url(''); ?>">Actualité</a></li>
                        </ul>
                        <?php if ($this->Session->isLogged()): ?>
                            <div class="btn-group pull-right">
                                <button class="btn btn-primary">
                                    <i class="icon-user icon-white"></i> <?php echo $this->Session->user('login') ?>
                                </button>
                                <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo Router::url("users/edit/id:{$this->Session->user('id')}"); ?>">
                                            <i class="icon-pencil"></i> Editer
                                        </a>
                                    </li>
                                    <?php if($this->Session->user('role') == 'admin'): ?>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="<?php echo Router::url('cockpit'); ?>">
                                                <i class="icon-cog"></i> Administration
                                            </a>
                                        </li>
                                    <?php endif ?>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo Router::url('users/logout'); ?>">
                                            <i class="icon-off"></i> Se déconnecter
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        <?php else: ?>
                        <?php
                            echo $this->Form->create('users/login',array('class' => 'navbar-form pull-right'));
                            echo $this->Form->inputForm('login',array('placeholder' => 'Identifiant','class' => 'span2'));
                            echo $this->Form->inputForm('password',array('type' => 'password','placeholder' => 'Mot de passe','class' => 'span2','style' => 'margin-left:5px',));
                            echo $this->Form->end(array('input' => array('class' => 'btn btn-primary','value' => 'Envoyer','style' => 'margin-left:5px')));
                        ?>                  
                        <?php endif ?>                        
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <?php echo $this->Session->flash(); ?>
            <?php echo $content_for_layout; ?>
        </div><!--/.fluid-container-->
        <div class="navbar navbar-inverse navbar-fixed-bottom">
            <div class="navbar-inner">
                <div class="container-fluid">                    
                    <ul class="nav">
                        <li><a>OpenMvc &copy; <?php echo date('Y'); ?></a></li>
                        <li><a><?php echo 'Page générée en '.loadPage().' ms '; ?></a></li>
                        <li><a><?php echo 'Avec '.nbQueries().' requêtes SQL'; ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="http://code.jquery.com/jquery.min.js"></script>
        <script type="text/javascript">
            jQuery(document).ready(function($){
                $('.alert').delay(3000).fadeOut(500);
            });
        </script>
        <script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-transition.js"></script>
        <script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-alert.js"></script>
        <script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-modal.js"></script>
        <script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-dropdown.js"></script>
        <script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-scrollspy.js"></script>
        <script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-tab.js"></script>
        <script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-tooltip.js"></script>
        <script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-popover.js"></script>
        <script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-button.js"></script>
        <script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-collapse.js"></script>
        <script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-carousel.js"></script>
        <script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-typeahead.js"></script>
        <script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-affix.js"></script>
    </body>
</html>