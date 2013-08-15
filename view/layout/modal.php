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
        <div class="container-fluid">
            <?php echo $this->Session->flash(); ?>
            <?php echo $content_for_layout; ?>
        </div>
    </body>
</html>