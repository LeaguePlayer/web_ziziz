<?php $this->pageTitle=Yii::app()->name. " - Автомобильный портал"; ?>

<?php $slides = SliderPhoto::model()->findAll(); ?>
<?php if (count($slides)>0): ?>
<div id="slider">
	<div style="margin:0 auto; width: 907px; height:298px; position: relative;">
		<a class="prev browse left sl_but_lf"></a>
		<div class="page">
 			<div class="navi">
                <a class="active"></a>
                <?php for($i = 0; $i < count($slides)-1; $i++): ?>
                    <a></a>
                <?php endfor; ?>
 			</div>
			<div class="scrollable" id="scrollable">                 
  				<div class="items">
                    <?php foreach($slides as $slide): ?>
                        <div>
                            <a href="<?=($slide->status==1) ? $this->createUrl('announcements/index', array('gorod'=>$city->translit)) : $this->createUrl('auto/index', array('gorod'=>$city->translit))?>">
                            <?php echo CHtml::image($slide->url, '', array(
                                'width'=>907,
                                'height'=>275,
                            )) ?>
                            </a>
        				</div>
                    <?php endforeach; ?>
  				</div>                
			</div>
			<a class="next browse right sl_but_rh"></a>
		</div>                 
	</div>
</div>
<?php endif; ?>

<div id="services">
	<div class="top">
   	  <div class="search">
        	<img src="/images/search_det.png" alt="search_det" width="132" height="90" />
            <div class="search_text">
            	<span class="text_search_title">Опубликовать запрос</span>
                <span class="text_search">на поиск запчастей</span>
          </div>
      </div>
      <div class="search">
        	<img src="/images/search_services.png" alt="search_services" width="108" height="90" />
            <div class="search_text">
            	<span class="text_search_title">Опубликовать запрос</span>
                <span class="text_search">на оказание услуги</span>
          </div>
      </div>
      <div class="search">
      		<img src="/images/search_komp.png" alt="search_komp" width="132" height="90" />
            <div class="search_text">
            	<span class="text_search_title">Найти компанию</span>
                <span class="text_search">по специализации</span>
          </div>
      </div>
  </div>
  <div class="bottom">
    	<div id="search_det" class="order">
        	<div class="order_button">
            	<a class="ajaxfancybox" href="<?php echo $this->createUrl('proposal/create', array('type'=>Proposal::TYPE_SEARCH_SPAREPART)) ?>"><span style="font-size:18px; font-weight:bold">Подать заявку</span><br />на запчасть</a>
            </div>
            <div class="text_order">
            	<span style="color:#ffd304">ziziz</span> предлагает вам оставить заявку на интересующую Вас запчасть и получить самое выгодное предложение, как по цене, так и по срокам поставки. Работайте на прямую с поставщиками, без посредников!
            </div>
        </div>
      <div id="search_services" class="order" style="display:none;">
       	  <div class="order_button">
           	  <a class="ajaxfancybox" href="<?php echo $this->createUrl('proposal/create', array('type'=>Proposal::TYPE_SEARCH_SERVICES)) ?>"><span style="font-size:18px; font-weight:bold">Подать заявку</span><br />на оказание услуги</a>
          </div>
          <div class="text_order">
           	  <span style="color:#ffd304">ziziz</span> предлагает вам оставить заявку на интересующую Вас услугу и получить самое выгодное предложение, как по цене, так и по срокам!
          </div>
      </div>
      <div id="search_komp" class="order" style="display:none;">
       	  <div class="order_button">
            	<a href="<?php echo $this->createUrl('site/fullmap') ?>"><span style="font-size:18px; font-weight:bold">Подать заявку</span><br />поиск компании</a>
            </div>
            <div class="text_order">
            	<span style="color:#ffd304">ziziz</span> предлагает вам оставить заявку на поиск интересующей Вас компании и получить самое выгодное предложение, как по цене, так и по срокам поиска!
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>

<div id="news_ads_actions">


    <div id="news_block">
    	<?php echo $this->renderPartial('_newsblock', array('news'=>$news)); ?>
    </div>
    
    <div id="ads_block">
        <?php echo $this->renderPartial('_adsblock', array(
			'posts'=>$posts,
            'city'=>$city,
		)); ?>
    </div>
    <!--
    <div id="actions_block">
        <?php //echo $this->renderPartial('_actblock', array('actions'=>$actions)); ?>
    </div>
    -->
    
    <div class="clear"></div>
    
</div>

<?php
$session = Yii::app()->session;
$session->open();
?>
<?php if(!empty($session['cur_city_id'])): ?>
<div id="objects_in_map">
    <?php echo $this->renderPartial('_map'); ?>
</div>
<?php endif; ?>
<?php $session->close(); ?>