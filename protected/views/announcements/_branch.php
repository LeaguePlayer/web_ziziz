<li>
    <?php $hasChild = ($category->childsCount>0) ? true : false ?>
    <?php
	$activ = ($cur_category!==null && $category->cat_id==$cur_category->cat_id) ? true : false;
	?>	
	
    <div class="item <?=($hasChild) ? 'resolvable' : ''?> <?=($activ) ? 'activ' : 'unactiv'?>" rel="<?=$category->cat_id?>">
        <a href="#" rel="<?=$category->cat_id?>"><span class="name <?=($root)?'root':'child'?>"><?=$category->cat_name?></span></a>
        <?php
			$count = Announcements::model()->with(array(
				'user'=>array(
					'select'=>'user_city_id',
				)
			))->count(
				'ann_status='.Announcements::STATUS_PUBLISHED
				.' AND user.user_city_id='.$city_id
				.' AND ann_category='.$category->cat_id
			);
		?>
		<span class="count"><?=$count;?></span>
    </div>
    <?php if ($hasChild) echo CHtml::openTag('div', array('class'=>'unexpand')) ?>
        <?php foreach ($category->childs as $child): ?>
            <ul>
                <?php $this->renderPartial('_branch', array(
					'category'=>$child,
					'city_id'=>$city_id,
				)); ?>
            </ul>
        <?php endforeach; ?>
    <?php if ($hasChild) echo CHtml::closeTag('div') ?>
</li>