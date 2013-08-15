<ul>
	<?php foreach ($posts as $k => $v): ?>
		<li><a href="<?php echo Router::url($v->type.'s/view/id:'.$v->id.'/slug:'.$v->slug); ?>" alt="<?php echo ucfirst($v->type); ?> : <?php echo $v->name; ?>"><?php echo ucfirst($v->type); ?> : <?php echo $v->name; ?></a>
	<?php endforeach ?>
</ul>

<script src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
var parentWin = (!window.frameElement && window.dialogArguments) || opener || parent || top;
$(function() {
    $('a').click(function(e){
        e.preventDefault();
        aHref = $(this).attr('href');
        aAlt = $(this).attr('alt');
        divInput = $("input#"+parentWin.inputSrc,parent.document).parent().attr('id');
        divInputSplit = divInput.split("_");
        divTitle = "mce_"+(parseInt(divInputSplit[1],10) +1);
        $("input#"+parentWin.inputSrc,parent.document).val(aHref);
        $("input#"+divTitle,parent.document).val(aAlt);
        $(".mce-close",parent.document).last().trigger("click");
    });
});
</script>