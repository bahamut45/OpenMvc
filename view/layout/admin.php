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
                            <li><a href="<?php echo Router::url('admin/posts/index'); ?>">Articles</a></li>
                            <li><a href="<?php echo Router::url('admin/pages/index'); ?>">Pages</a></li>
                            <li><a href="<?php echo Router::url(''); ?>">Site</a></li>
                            <li><a href="<?php echo Router::url('users/logout'); ?>">Deconnexion</a></li>
                        </ul>
                        <p class="navbar-text pull-right">Logged in as <a href="#"><?php echo $this->Session->user('login'); ?></a></p>
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