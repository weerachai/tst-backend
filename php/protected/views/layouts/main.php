<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

<style>
.myNavbar .navbar-inner {
background-image:none;
background-color:yellow; 
}
</style>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-39494685-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
		<?php $this->widget('bootstrap.widgets.TbNavbar', array(
        'htmlOptions'=>array('class'=>'myNavbar'),
    		'type'=>null, // null or 'inverse'
    		'brand'=>CHtml::encode(Yii::app()->name),
    		'brandUrl'=>array('/site/index'),
    		'collapse'=>true, // requires bootstrap-responsive.css
    		'items'=>array(
        		array(
            		'class'=>'bootstrap.widgets.TbMenu',
            		'items'=>array(
						array('label'=>'Home', 'url'=>array('/site/index')),
						array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
						array('label'=>'Contact', 'url'=>array('/site/contact')),
						array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
						array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
					),
        		),        		array(
            		'class'=>'bootstrap.widgets.TbMenu',
            		'htmlOptions'=>array('class'=>'pull-right'),
            		'items'=>array(
                		array('label'=>'Link', 'url'=>'#'),
                		'---',
                		array('label'=>'Dropdown', 'url'=>'#', 'items'=>array(
                    		array('label'=>'Action', 'url'=>'#'),
                    		array('label'=>'Another action', 'url'=>'#'),
                    		array('label'=>'Something else here', 'url'=>'#'),
                    		'---',
                    		array('label'=>'Separated link', 'url'=>'#'),
                		)),
            		),
        		),
    		),
		)); ?>
<div class="container" id="page">
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by LOXBIT PUBLIC COMPANY LIMITED PLC.<br/>
		All Rights Reserved.<br/>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
