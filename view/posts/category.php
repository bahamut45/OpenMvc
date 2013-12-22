<?php 
?>
<!-- <div class="page-header">
    <h1>Mon blog</h1>
</div> -->
<div class="row-fluid">
    <div class="span3">
        <div class="well well-small sidebar-nav">
            <ul class="nav nav-list">
                <li class="nav-header">Catégorie</li>
                <?php foreach ($catTree as $k => $v): ?>
                    <?php if (!is_null($v['parentId'])): ?>
                        <li class="<?php echo isActive(Router::url("blog/category/{$v['slug']}"),'active'); ?>"><a href="<?php echo Router::url("blog/category/{$v['slug']}"); ?>"><?php echo $v['separator'] .' '. $v['name']; ?></a></li>
                    <?php else: ?>
                        <li class="<?php echo isActive(Router::url("blog/category/{$v['slug']}"),'active'); ?>"><a href="<?php echo Router::url("blog/category/{$v['slug']}"); ?>"><?php echo $v['name']; ?></a></li>    
                    <?php endif ?>                    
                <?php endforeach ?>
            </ul>
        </div><!--/.well -->
        <div class="well well-small sidebar-nav">
            <ul class="nav nav-list">
                <li class="nav-header">Archives</li>
                <?php foreach ($dateTree as $k => $v): ?>
                    <li><a href="<?php echo Router::url("blog/date/{$v->YEAR}/{$v->MONTH}"); ?>"><?php echo ucfirst($v->MONTH).' '. $v->YEAR.' ('.$v->TOTAL.')'; ?></a></li>                
                <?php endforeach ?>
            </ul>
        </div>
    </div>
    <div class="span6">
        <div class="row-fluid">
            <?php foreach ($posts as $k => $v): ?>
                <div class="well well-small">
                    <h2><?php echo $v->name; ?></h2>
                    <div class="pull-right">
                        <span class="btn btn-mini"><i class="icon-calendar"></i> <?php echo $v->created; ?></span>
                        <?php if (!empty($v->PostCatName)): ?>
                            <a class="btn btn-mini" href="<?php echo Router::url("blog/category/{$v->PostCatSlug}"); ?>"><i class="icon-book"></i> <?php echo $v->PostCatName; ?></a>
                        <?php endif ?>
                        <?php 
                            if (!empty($v->Tag)) {
                                echo '<div class="btn-group">';
                                $tags = (explode(',',$v->Tag)); 
                                foreach ($tags as $key) {
                                    $key = trim($key);
                                    $url = Router::url("tags/name:{$key}");
                                    echo '<a class="btn btn-mini" href="'. $url .'"><i class="icon-tag"></i> '.$key.'</a>';
                                }
                                echo '</div>';
                            }                        
                        ?>
                        <?php if (!empty($v->UserLogin)): ?>
                            <a class="btn btn-mini" href="<?php echo Router::url("users/view/name:{$v->UserLogin}"); ?>"><i class="icon-user"></i> <?php echo $v->UserLogin; ?></a>
                        <?php endif ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="caption">
                        <?php echo $v->content; ?> 
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <div class="span3">
        <div class="well well-small sidebar-nav">
            <ul class="nav nav-list">
                <li class="nav-header">Sidebar</li>
                <li class="active"><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
                <li class="nav-header">Sidebar</li>
                <li><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
                <li class="nav-header">Sidebar</li>
                <li><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
            </ul>
        </div><!--/.well -->
    </div>
</div>
<div class="pagination">
    <ul>
        <?php for ($i=1; $i <= $page ; $i++): ?> 
            <li <?php if ($i==$this->request->page) echo 'class="active"'; ?>><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php endfor; ?>
    </ul>
</div>