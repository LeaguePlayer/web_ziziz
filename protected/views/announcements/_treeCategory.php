
<ul>
    <?php foreach ($category->childs as $child): ?>
        <li>
            <div class="<?=Category::model()->compareCategory($child, $cur_category) ? "activ" : "unactive-item"?>">
                <?php echo CHtml::link($child->cat_name, $this->createUrl('announcements/index', array('cat_id'=>$child->cat_id)), array(
					'rel'=>$child->cat_id,
				)); ?>
            
                <?php if ($child->inArray($way)): ?>
                
                    <span class="count"><?php echo $child->announcementsCount; ?></span>
                    </div>
                    
                    <?php $this->renderPartial('_treeCategory', array(
                        'category'=>$child,
                        'cur_category'=>$cur_category,
                        'way'=>$way,
                    )); ?>
                    
                <?php else: ?>
                
                    <span class="count"><?php echo $child->getAllAnnouncCount(); ?></span>
                    </div>
                    
                <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>