<div class="navbar navbar-inverse">
	<div class="navbar-inner">
    <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
     
          <!-- Be sure to leave the brand out there if you want it shown -->
          <a class="brand" href="index.php" style="padding-left:100px;">Total Sales Tools <small>backend v1.0</small></a>
          
          <div class="nav-collapse">
			<?php $this->widget('zii.widgets.CMenu',array(
                    'htmlOptions'=>array('class'=>'pull-right nav'),
                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
					'itemCssClass'=>'item-test',
                    'encodeLabel'=>false,
                    'items'=>array(
                        array('label'=>'Dashboard', 'url'=>array('/site/index')),
                        array('label'=>'Setting', 'url'=>array('/master/config'), 'visible'=>Yii::app()->user->checkAccess('admin')),
                        array('label'=>'Master & Formula', 'url'=>array('/master'), 'visible'=>Yii::app()->user->checkAccess('operator')),
                        array('label'=>'กำหนดความสัมพันธ์', 'url'=>array('/manage'), 'visible'=>Yii::app()->user->checkAccess('user')),
                        array('label'=>'รายงาน', 'url'=>array('/report'), 'visible'=>Yii::app()->user->checkAccess('user')),
                        array('label'=>'Data', 'url'=>array('/data'), 'visible'=>Yii::app()->user->checkAccess('operator')),
                        array('label'=>'User', 'url'=>array('/user'), 'visible'=>!Yii::app()->user->isGuest),
                        array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                        array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                    ),
                )); ?>
    	</div>
    </div>
	</div>
</div>

<div class="subnav navbar">
    <div class="navbar-inner">
    	<div class="container">
        
        	<div class="style-switcher pull-left" style="padding-left:80px;">
                <a href="javascript:chooseStyle('none', 60)" checked="checked"><span class="style" style="background-color:#0088CC;"></span></a>
                <a href="javascript:chooseStyle('style2', 60)"><span class="style" style="background-color:#7c5706;"></span></a>
                <a href="javascript:chooseStyle('style3', 60)"><span class="style" style="background-color:#468847;"></span></a>
                <a href="javascript:chooseStyle('style4', 60)"><span class="style" style="background-color:#4e4e4e;"></span></a>
                <a href="javascript:chooseStyle('style5', 60)"><span class="style" style="background-color:#d85515;"></span></a>
                <a href="javascript:chooseStyle('style6', 60)"><span class="style" style="background-color:#a00a69;"></span></a>
                <a href="javascript:chooseStyle('style7', 60)"><span class="style" style="background-color:#a30c22;"></span></a>
          	</div>
            <?php /*
           <form class="navbar-search pull-right" action="">
           	 
           <input type="text" class="search-query span2" placeholder="Search">
           
           </form>
           */ ?>
    	</div><!-- container -->
    </div><!-- navbar-inner -->
</div><!-- subnav -->