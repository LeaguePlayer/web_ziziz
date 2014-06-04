<a id="message-<?=$data->id?>" class="message-row <?=($data->viewed==0) ? 'noviewed' : 'viewed'?>" href="<?=$this->createUrl('messages/view', array('id'=>$data->id))?>">

    <div class="hor_loader"></div>
    <div class="message-info">
        <?php $sender = ($data->from == 0) ? "Администрация сайта" : $data->sender->user_login ?>
        <span class="message-sender"><?php echo CHtml::encode($sender.": "); ?></span>
        
    	<span class="message-subject"><?php echo CHtml::encode($data->subject); ?></span>
        
        <div class="message-text"><?php echo CHtml::encode(strip_tags($data->text)); ?></div>
        
   	    <span class="message-date"><?php echo CHtml::encode(Functions::when_it_was($data->send_date)); ?></span>
    </div>
    
    <form class="message-actions" method="POST" action="<?=$this->createUrl('messages/index', array('id'=>$data->id))?>">
    
        <?php if ($data->viewed==0): ?>
            <input type="button" value="Прочитано" class="default-button" rel="<?=$data->id?>" />
        <?php endif; ?>
        
        <input type="button" value="Удалить" class="default-button" rel="<?=$data->id?>" />
        
    </form>
    
</a>