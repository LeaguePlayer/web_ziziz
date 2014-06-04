<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
    
    <?php Yii::app()->clientScript->registerCoreScript('jquery');?>  
    <?php Yii::app()->clientScript->registerCoreScript('jquery.ui');?>
    
    
    <title><?php echo $this->pageTitle; ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/css/form.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/css/ziziz/megastyle.css?v=2" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/css/ziziz/news.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/css/ziziz/announce_form.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/js/fancybox/source/jquery.fancybox.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/js/fancybox/helpers/jquery.fancybox-buttons.css" />

    <?php $cs=Yii::app()->getClientScript(); ?>
    <?php $cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.tools.min.js', CClientScript::POS_HEAD); ?>
    <?php $cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/fancybox/source/jquery.fancybox.js', CClientScript::POS_HEAD); ?>
    <?php $cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/fancybox/helpers/jquery.fancybox-buttons.js', CClientScript::POS_HEAD); ?>
    <?php $cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/main.js', CClientScript::POS_HEAD); ?>
    <?php $cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/select.js', CClientScript::POS_HEAD); ?>
	<?php $cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/btn_add_ann.js', CClientScript::POS_HEAD); ?>
    <?php $cs->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.upload.js', CClientScript::POS_HEAD); ?>
	
</head>

<body>

<div style="overflow: hidden; min-height: 100%;">
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter19527787 = new Ya.Metrika({id:19527787,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });




    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";




    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/19527787" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<div id="header">

<?
    $session = Yii::app()->session;
    $session->open();
    $city_translit = Functions::translit($session['cur_city']);
    $session->close();
?>

	<div class="header_menu">
        <?php
        if (Yii::app()->user->isGuest){
            $this->widget('zii.widgets.CMenu',array(
    			'items'=>array(
                    array('label'=>'Главная', 'url'=>'/'),
    				array('label'=>'Объявления', 'url'=>array('/announcements/index', 'gorod'=>$city_translit)),
                    array('label'=>'Авто Объявления', 'url'=>array('/auto/index', 'gorod'=>$city_translit)),
    			),
    		));
        }
        else {
            $this->widget('zii.widgets.CMenu',array(
    			'items'=>array(
                    array('label'=>'Главная', 'url'=>'/'),
    				array('label'=>'Объявления', 'url'=>array('/announcements/index', 'gorod'=>$city_translit)),
                    array('label'=>'Авто Объявления', 'url'=>array('/auto/index', 'gorod'=>$city_translit)),
                    array('label'=>'Личный кабинет', 'url'=>array('users/view', 'id'=>Yii::app()->user->id)),
    			),
    		));
        }
        
        ?>
    </div>
    
    <? if (Yii::app()->user->checkAccess('moderator')): ?>
    <div class="header_menu">
        <?
        $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
                array('label'=>'Категории', 'url'=>array('/category/index')),
                array('label'=>'Классификаторы', 'url'=>array('/classifier/index')),
                array('label'=>'Модификации', 'url'=>array('/modification/index')),
                array('label'=>'Модерация', 'url'=>array('site/moderation')),
                array('label'=>'Слайдер', 'url'=>array('sliderPhoto/manage')),
			),
		));
        ?>
    </div>
    <? endif; ?>
    
    <div id="header_logo">
    	<a href="/"><img src="/images/logo.jpg" width="115" height="44" alt="logo" /></a>
        <span class="text_logo">найдем запчасти для<br /> <strong style="color: #2987C5; font-size: 14px;">любого</strong> автомобиля</span>
    </div>
    <div id="panel">
        <div id="panel-left"></div>
        <div id="panel-right"></div>
        <div id="panel-content">
        
            <div id="city_form">
            
            	<?php
					$session = Yii::app()->session;
					$session->open();

//$session->remove('cur_city_id');
//$session->remove('cur_city'); die();

					if (isset($session['cur_city_id']) && isset($session['cur_city']))
					{
						$cur_city_id = $session['cur_city_id'];
						$cur_city = $session['cur_city'];
					}
					else
					{
						$cur_city_id = Yii::app()->params['def_city_id'];
						$cur_city = Yii::app()->params['def_city_name'];
					}
				?>
                <span class="selected_city">Выбранный город: <?= $cur_city; ?></span>
                <span class="select">
                    <span class="left"> 
                        <span class="button"> 
                            <span class="center">Выберите город</span>
                        </span> 
                    </span>
                    
                    <?php echo Chtml::dropDownList(
						'Citys',
						'city_name',
						CHtml::listData(Citys::model()->findAll(array(
							'order'=>'city_name')),
							'city_id',
							'city_name'),
						array(
							'id'=>'idSelect',
                            'options'=>array(
                                $cur_city_id => array(
                                    'selected'=>true,
                                ),
                            ),
						));
					?>
                </span>
            </div>
            
            <?php if(Yii::app()->user->isGuest): ?>
				<?php $this->widget('application.components.LoginWidget', array(
	                       'visible'=>Yii::app()->user->isGuest)); ?>
	       <?php else: ?>
            
                <div id="auth_form">
                
                    <div class="user_info">
                        <span class="text-login">Вы вошли, как</span><span class="user-login"><?php echo Yii::app()->user->name; ?></span>
                        <a class="logout" href="<?php echo Yii::app()->createUrl('users/logout'); ?>">Выйти</a>
                    </div>
                    <div class="user_panel">
						<div class="my_announces">
                            <?php echo CHtml::link("Мои объявления", $this->createUrl('users/view', array('id'=>Yii::app()->user->id, '#'=>'annlist'))) ?>
						</div>
						<div class="my_profile">
							<?php echo CHtml::link("Личный кабинет", $this->createUrl('users/view', array('id'=>Yii::app()->user->id))) ?>
						</div>
						<div class="my_messages">
                            <?php
                                $messCount = Messages::model()->with(array(
                                    'recipient' => array(
                                        'select'=>false
                                    ),
                                ))->count('t.to=:u_id AND t.viewed=0', array(':u_id'=>Yii::app()->user->id));
                            ?>
							<a href="<?=$this->createUrl('messages/index')?>"><?=($messCount==0) ? 'Нет новых писем' : $messCount.' новых письма'?></a><div class="messages_count"><span><?=$messCount?></span></div>
						</div>
					</div>
                    
                </div>
                
            <?php endif; ?>
            
   			<div class="clear"></div>
      	
		  </div>
        
    <!--
        	 -->
    </div>
</div>
<div class="clear"></div>


<div id="content">
	<div class="content">
        
        <?php $this->widget('application.components.CBreadcrumbsExt', array(
            'links'=>$this->breadcrumbs,
        )); ?>
        
    	<?php echo $content; ?>
    
	</div>
</div>

</div>

<div id="footer">
	<div class="content">
    </div>
</div>

</body>
</html>

<?php /*
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Объявления', 'url'=>array('/announcements/index')),
				array('label'=>'Категории', 'url'=>array('/category/index')),
                array('label'=>'Классификаторы', 'url'=>array('/classifier/index')),
                array('label'=>'Пользователи', 'url'=>array('/users/index')),
                array('label'=>'Авто Объявления', 'url'=>array('/auto/index')),
                array('label'=>'Марки', 'url'=>array('/brend/index')),
                array('label'=>'Модификации', 'url'=>array('/modification/index')),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->




</body>
</html>
*/?>