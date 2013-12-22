<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo isset($title_for_layout) ? $title_for_layout : 'Administration'; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="http://getbootstrap.com/2.3.2/assets/css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo Router::webroot('css/bootstrap-datetimepicker/datetimepicker.css'); ?>">
        <link rel="stylesheet" href="<?php echo Router::webroot('css/autocomplete/jquery.autocomplete.css'); ?>">
        <style type="text/css">
            body { padding-top: 60px; padding-bottom: 40px; }
        </style>
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
                    <a class="brand" href="<?php echo Router::url('admin/posts/index'); ?>">Administration</a>
                    <div class="nav-collapse">
                        <ul class="nav">
                            <li class="dropdown <?php echo isActive(Router::url('cockpit/posts'),'active',false); ?>">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Gestion des articles <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo Router::url('admin/posts/index'); ?>">Liste des articles</a></li>
                                    <li><a href="<?php echo Router::url('admin/posts/edit'); ?>">Ajouter un article</a></li>
                                    <li class="divider"></li>
                                    <li><a href="<?php echo Router::url('admin/posts_categories/index'); ?>">Liste des catégories</a></li>
                                    <li><a href="<?php echo Router::url('admin/posts_categories/edit'); ?>">Ajouter une catégorie</a></li>
                                </ul>
                            </li>
                            <li class="<?php echo isActive(Router::url('admin/pages'),'active',false); ?>"><a href="<?php echo Router::url('admin/pages/index'); ?>">Pages</a></li>
                        </ul>
                        <div class="btn-group pull-right">
                            <button class="btn btn-primary">
                                <i class="icon-user icon-white"></i> <?php echo $this->Session->user('login') ?>
                            </button>
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo Router::url(); ?>">
                                        <i class="icon-home"></i> Site
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="<?php echo Router::url('users/logout'); ?>">
                                        <i class="icon-off"></i> Se déconnecter
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <?php echo $this->Session->flash(); ?>
            <?php echo $content_for_layout; ?>
              <hr>
            <footer>
                <p>&copy; Company 2012</p>
            </footer>
        </div><!--/.fluid-container-->

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
    </body>
</html>