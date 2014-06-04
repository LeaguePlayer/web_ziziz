<div class="text_title_news_ads_actions">
	Объявления<?php echo (count($posts) == 0) ? "" : CHtml::link('посмотреть все', $this->createUrl('announcements/index', array('gorod'=>$city->translit))); ?>
</div>

<?php if (count($posts) == 0): ?>
    <div class="default-text">В вашем городе пока нет объявлений. Хотите стать <?php echo CHtml::link(' первым', $this->createUrl('announcements/create')) ?>?</div>
<?php endif; ?>

<?php if(get_class($posts[0])=='Announcements'): ?>
    <div class="ads">
		<h3>
			<?php echo $posts[0]->ann_name; ?>
		</h3>
		<div class="date"><?= Functions::when_it_was($posts[0]->ann_public_date) ?></div>
		<a href="<?= $this->createUrl("announcements/view", array('id'=>$posts[0]->ann_id, 'gorod'=>$city->translit)); ?>"></a>
    </div>
<?php elseif(get_class($posts[0])=='Auto'): ?>
	<div class="ads">
		<h3>
			<?php echo $posts[0]->automodel->modelbrend->b_name.' '
                .$posts[0]->automodel->m_name.', '
                .$posts[0]->auto_year.' года, пробег '
                .Functions::priceFormat($posts[0]->auto_run).' км, цена '
                .Functions::priceFormat($posts[0]->auto_price).' р.';
            ?>
        </h3>
        <div class="date"><?= Functions::when_it_was($posts[0]->auto_public_date) ?></div>
        <a href="<?= $this->createUrl("auto/view", array('id'=>$posts[0]->auto_id, 'gorod'=>$city->translit)); ?>"></a>
    </div>
<?php endif ?>



<?php if(get_class($posts[1])=='Announcements'): ?>
    <div class="ads">
		<h3>
			<?php echo $posts[1]->ann_name; ?>
		</h3>
		<div class="date"><?= Functions::when_it_was($posts[1]->ann_public_date) ?></div>
		<a href="<?= $this->createUrl("announcements/view", array('id'=>$posts[1]->ann_id, 'gorod'=>$city->translit)); ?>"></a>
    </div>
<?php elseif(get_class($posts[1])=='Auto'): ?>
	<div class="ads">
		<h3>
			<?php echo $posts[1]->automodel->modelbrend->b_name.' '
                .$posts[1]->automodel->m_name.', '
                .$posts[1]->auto_year.' года, пробег '
                .Functions::priceFormat($posts[1]->auto_run).' км, цена '
                .Functions::priceFormat($posts[1]->auto_price).' р.';
            ?>
		</h3>
		<div class="date"><?= Functions::when_it_was($posts[1]->auto_public_date) ?></div>
		<a href="<?= $this->createUrl("auto/view", array('id'=>$posts[1]->auto_id, 'gorod'=>$city->translit)); ?>"></a>
    </div>
<?php endif ?>



<?php if(get_class($posts[2])=='Announcements'): ?>
    <div class="ads">
		<h3>
			<?php echo $posts[2]->ann_name; ?>
		</h3>
		<div class="date"><?= Functions::when_it_was($posts[2]->ann_public_date) ?></div>
		<a href="<?= $this->createUrl("announcements/view", array('id'=>$posts[2]->ann_id, 'gorod'=>$city->translit)); ?>"></a>
    </div>
<?php elseif(get_class($posts[2])=='Auto'): ?>
	<div class="ads">
		<h3>
			<?php echo $posts[2]->automodel->modelbrend->b_name.' '
                .$posts[2]->automodel->m_name.', '
                .$posts[2]->auto_year.' года, пробег '
                .Functions::priceFormat($posts[2]->auto_run).' км, цена '
                .Functions::priceFormat($posts[2]->auto_price).' р.';
            ?>
		</h3>
		<div class="date"><?= Functions::when_it_was($posts[2]->auto_public_date) ?></div>
		<a href="<?= $this->createUrl("auto/view", array('id'=>$posts[2]->auto_id, 'gorod'=>$city->translit)); ?>"></a>
    </div>
<?php endif ?>



<?php if(get_class($posts[3])=='Announcements'): ?>
    <div class="ads">
		<h3>
			<?php echo $posts[3]->ann_name; ?>
		</h3>
		<div class="date"><?= Functions::when_it_was($posts[3]->ann_public_date) ?></div>
		<a href="<?= $this->createUrl("announcements/view", array('id'=>$posts[3]->ann_id, 'gorod'=>$city->translit)); ?>"></a>
    </div>
<?php elseif(get_class($posts[3])=='Auto'): ?>
	<div class="ads">
		<h3>
			<?php echo $posts[3]->automodel->modelbrend->b_name.' '
                .$posts[3]->automodel->m_name.', '
                .$posts[3]->auto_year.' года, пробег '
                .Functions::priceFormat($posts[3]->auto_run).' км, цена '
                .Functions::priceFormat($posts[3]->auto_price).' р.';
            ?>
        </h3>
		<div class="date"><?= Functions::when_it_was($posts[3]->auto_public_date) ?></div>
		<a href="<?= $this->createUrl("auto/view", array('id'=>$posts[3]->auto_id , 'gorod'=>$city->translit)); ?>"></a>
    </div>
<?php endif ?>



<?php if(get_class($posts[4])=='Announcements'): ?>
    <div class="ads">
		<h3>
			<?php echo $posts[4]->ann_name; ?>
		</h3>
		<div class="date"><?= Functions::when_it_was($posts[4]->ann_public_date) ?></div>
		<a href="<?= $this->createUrl("announcements/view", array('id'=>$posts[4]->ann_id, 'gorod'=>$city->translit)); ?>">
    </div>
<?php elseif(get_class($posts[4])=='Auto'): ?>
	<div class="ads">
		<h3>
			<?php echo $posts[4]->automodel->modelbrend->b_name.' '
                .$posts[4]->automodel->m_name.', '
                .$posts[4]->auto_year.' года, пробег '
                .Functions::priceFormat($posts[4]->auto_run).' км, цена '
                .Functions::priceFormat($posts[4]->auto_price).' р.';
            ?>
		</h3>
		<div class="date"><?= Functions::when_it_was($posts[4]->auto_public_date) ?></div>
		<a href="<?= $this->createUrl("auto/view", array('id'=>$posts[4]->auto_id, 'gorod'=>$city->translit)); ?>"></a>
    </div>
<?php endif ?>

