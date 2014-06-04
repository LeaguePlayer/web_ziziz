
<?php if ($model->user_id == Yii::app()->user->id)
    Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl.'/js/profile.js', CClientScript::POS_HEAD);
?>

<?php
$this->pageTitle = "ZIZIZ | Профиль пользователя ".$model->user_login;

$this->breadcrumbs = array(
	'Пользователь '.$model->user_login,
);

//$this->menu=array(
//	array('label'=>'Список', 'url'=>array('index')),
//	array('label'=>'Создать', 'url'=>array('create')),
//	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->user_id)),
//	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'Are you sure you want to delete this item?')),
//	//array('label'=>'Manage Users', 'url'=>array('admin')),
//);
?>

<div id="profile">
	<div class="top">
    	<span style="width: 500px;" class="text_title_profile"><?=($model->user_type==Users::USERTYPE_PHYS_PERSON) ? 'Страница пользователя' : 'Профиль юридического лица лица'?></span>
        <?php if($model->user_id == Yii::app()->user->id): ?>
            <a class="profile_link" href="<?php echo $this->createUrl('users/update', array('id'=>$model->user_id)) ?>">Редактировать профиль</a>
            <a  style="margin-right: 5px;" class="profile_link" href="<?php echo $this->createUrl('users/updatePass', array('id'=>Yii::app()->user->id)) ?>">Изменить пароль</a>
        <?php endif; ?>
    </div>
    <div class="bottom">
    	<div class="left" style="position: relative;">
            <div class="hor_loader"></div>
            <?php if (is_file($_SERVER['DOCUMENT_ROOT'] . '/uploads/avatars/' . $model->avatar)): ?>
                <?php echo CHtml::image('/uploads/avatars/' . $model->avatar, '', array('id'=>'avatar_image', 'width'=>177, 'height'=>215)); ?>
            <?php else: ?>
        	   <img id="avatar_image" src="/images/sto_no_foto.jpg" width="177" height="215" />
            <?php endif; ?>
            
               
            <?php if($model->user_id == Yii::app()->user->id): ?>
                <a id="avatar" style="margin-top: 5px;" class="profile_link" href="#">Аватар</a>
            <?php endif; ?>
        </div>
        
        <div class="right">
            <?php if($model->user_type==Users::USERTYPE_JUR_PERSON): ?>
            <div class="row">
            	<div class="text_title_row">Представитель фирмы:</div>
                <div class="desc_row"><?=$model->user_fio?></div>
            </div>
            <?php elseif (!empty($model->user_fio)): ?>
            <div class="row">
            	<div class="text_title_row">Имя и фамилия:</div>
                <div class="desc_row"><?=$model->user_fio?></div>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($model->user_city_id)): ?>
            <div class="row">
            	<div class="text_title_row">Город:</div>
                <div class="desc_row"><?=$model->city->city_name?></div>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($model->user_phone)): ?>
            <div class="row">
            	<div class="text_title_row">Телефон:</div>
                <div class="desc_row"><?=$model->user_phone?></div>
            </div>
            <?php endif; ?>
            
            <div class="row">
            	<div class="text_title_row">e-mail адрес:</div>
                <div class="desc_row"><?=$model->user_email?></div>
            </div>
            
            <?php if($model->user_type==Users::USERTYPE_JUR_PERSON): ?>
            <div class="row">
            	<div class="text_title_row">Название фирмы:</div>
                <div class="desc_row"><?=$model->company[0]->company_name?></div>
            </div>
            
            <div class="row">
            	<div class="text_title_row">Адрес:</div>
                <div class="desc_row"><?=Citys::model()->findByPk($model->user_city_id)->city_name.', '.$model->company[0]->company_address?></div>
            </div>
            <?php endif; ?>

            <div class="clear"></div>
        </div>
        
        <?php if (Yii::app()->user->id == $model->user_id): ?>
        <div id="actions" style="float: right; margin-top: 22px;">
            <span style="color: #358BBE; float: left; font-family: 'Trebuchet MS',sans-serif;font-size: 11px;font-weight: bold;margin: 16px 13px 0 0;">
                Продать
            </span>
            <a style="border-bottom-right-radius: 0;border-top-right-radius: 0;display: block;float: left;width: 110px;" class="default-button" href="<?=$this->createUrl('auto/create') ?>">Автомобиль</a>
            <?php if ($model->user_type == Users::USERTYPE_JUR_PERSON): ?>
            <a style="border-radius: 0 0 0 0;display: block;float: left;width: 110px" class="default-button" href="<?=$this->createUrl('actions/create') ?>">Акция</a>
            <?php endif; ?>
            <a style="border-bottom-left-radius: 0;border-top-left-radius: 0;display: block;float: left;width: 110px;" class="default-button" href="<?=$this->createUrl('announcements/create') ?>">Запчасть</a>
        </div>
        <?php endif; ?>
        
        <div id="annlist" class="announcements_list">
            <?php $this->renderPartial('_announce_list_in_profile', array(
                'model' => $model,
            )) ?>
        </div>
    </div>
    <div class="clear"></div>
</div>
