<?php

/**
 * This is the model class for table "announcements".
 *
 * The followings are the available columns in table 'announcements':
 * @property integer $ann_id
 * @property integer $ann_category
 * @property string $ann_name
 * @property integer $ann_status
 * @property integer $ann_user_id
 * @property string $ann_actual_date
 * @property integer $ann_gallery_id
 * @property integer $ann_state
 * @property string $ann_public_date
 * @property string $ann_desc
 */
class Announcements extends CActiveRecord
{    
	const STATUS_MODERATED 		= 1; // на модерации
	const STATUS_PUBLISHED 		= 2; // опубликовано
	const STATUS_BLOCKED 		= 3; // заблокировано
	const STATUS_REMOVED 		= 4; // удалено
	
	const STATE_UNKNOWN 		= 1; // не указано
	const STATE_NEW 			= 2; // новое
	const STATE_USED 			= 3; // б/у
	
	const DATE_INTERVAL_ONE_WEEK = 1;
	const DATE_INTERVAL_TWO_WEEKS = 2;
	const DATE_INTERVAL_ONE_MONTH = 3;
    
    
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Announcements the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'announcements';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ann_category, ann_name, ann_state, ann_price', 'required'),
			array('ann_category, ann_status, ann_user_id, ann_state, model_id', 'numerical', 'integerOnly'=>true),
            array('ann_price', 'numerical', 'integerOnly'=>true, 'message'=>'Цена должна быть целым числом.'),
			array('ann_name', 'length', 'max'=>100),
            array('ann_desc', 'length', 'max'=>2000),
            //array('ann_actual_date, ann_public_date', 'date', 'format'=>'yyyy-MM-dd HH:mm:ss', 'allowEmpty'=>false),
            //array('','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false,'on'=>'update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ann_category, ann_name, ann_status, ann_user_id, ann_actual_date, ann_state, ann_public_date, ann_desc', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'cat'=>array(self::BELONGS_TO, 'Category', 'ann_category'),
            'user'=>array(self::BELONGS_TO, 'Users', 'ann_user_id'),
            'values'=>array(self::MANY_MANY, 'ClassifValue', 'ann_classif(ac_ann_id, ac_classifval_id)'),
            'gall'=>array(self::BELONGS_TO, 'Gallery', 'ann_gallery_id'),
            'state'=>array(self::BELONGS_TO, 'Lookup', 'ann_state'),
            'commentBranchs'=>array(self::HAS_MANY, 'CommentBranch', 'ann_id'),
            'automodel'=>array(self::BELONGS_TO, 'Carmodel', 'model_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ann_id' => 'Ann',
			'ann_category' => 'Категория',
			'ann_name' => 'Наименование',
			'ann_status' => 'Статус',
			'ann_user_id' => 'Пользователь',
			'ann_actual_date' => 'Актуальная дата',
			'ann_gallery_id' => 'Галерея',
			'ann_state' => 'Состояние',
			'ann_public_date' => 'Дата публикации',
			'ann_desc' => 'Описание',
            'ann_price' => 'Цена'
		);
	}
    
    protected function afterDelete()
	{
        $command = Yii::app()->db->createCommand()->delete('ann_classif',
            'ac_ann_id=:ann_id',
            array(
                ':ann_id'=>$this->ann_id,
            )
        );
        
        Gallery::model()->find('gal_id=:id', array(':id'=>$this->gall->gal_id))->delete();
        foreach (CommentBranch::model()->findAll('ann_id=:ann_id', array(':ann_id'=>$this->ann_id)) as $branch)
            $branch->delete();
        return parent::afterDelete();
    }
    
    public function instanceGallery()
	{
        $no_gallery == false;
        if (!$this->isNewRecord)
        {
            $gallery = Gallery::model()->findByPk($this->ann_gallery_id);
            if ($gallery === null)
                $no_gallery = true;
        }
        if ($no_gallery || $this->isNewRecord)
        {
            $gallery = new Gallery;
            $gallery->gal_name = md5(time().rand(1,100));
            if (!$gallery->save())
                throw new CHttpException(403, 'Ошибка при создании галереи');
        }
        $this->ann_gallery_id = $gallery->gal_id;
    }
    
    protected function beforeSave()
    {
    	if (parent::beforeSave())
        {
            $this->last_update = date('Y-m-d H:i:s');
            if ($this->isNewRecord)
        	{
            	if (Yii::app()->user->checkAccess('user'))
            	{
            	   $this->ann_status = self::STATUS_MODERATED;
            	}
    	        $today = time();
           		$this->ann_public_date = date('Y-m-d H:i:s', $today);
            	$this->ann_actual_date = date('Y-m-d H:i:s', ($today + (3600 * 24 * 14))); // 14 дней
    		}
            $this->instanceGallery();
            return true;
        }
		return false;
	}
    
    protected function afterSave()
    {
        parent::afterSave();
        if (!$this->isNewRecord)
        {         
            $command = Yii::app()->db->createCommand()->delete('ann_classif',
                'ac_ann_id=:ann_id',
                array(
                    ':ann_id'=>$this->ann_id,
                )
            );
        }
        if(isset($_POST['ClassifValues']) and is_array($_POST['ClassifValues']))
        {
            foreach($_POST['ClassifValues'] as $val_id)
            {
                $ac = new AnnClassif;
                $ac->ac_ann_id = $this->ann_id;
                $ac->ac_classifval_id = $val_id;
                $ac->save();
            }
        }
        
        try
        {
            $dir = '/uploads/photo/';
            $dirthumb = '/uploads/photo/thumbs/';
            
            $photos = CUploadedFile::getInstancesByName('ph_url');
    
            foreach($photos as $k => $ph)
    		{
                $sourcePath = pathinfo($ph->getName());
                $filename = md5(md5($sourcePath['basename']).time()).'.'.$sourcePath['extension'];
                
                if(!is_dir($_SERVER['DOCUMENT_ROOT'].$dir))
    			{
                    mkdir($_SERVER['DOCUMENT_ROOT'].$dir);
                }
                if(!is_dir($_SERVER['DOCUMENT_ROOT'].$dirthumb))
    			{
                    mkdir($_SERVER['DOCUMENT_ROOT'].$dirthumb);
                }
                //сохраняем изображение
                $file = $_SERVER['DOCUMENT_ROOT'].$dir.'original_'.$filename;
                $ph->saveAs($file);
                
                //Ресайзим
                Yii::import("ext.EPhpThumb.EPhpThumb");
                $thumb = new EPhpThumb();
                $thumb->init();
                $thumb->create($file)->adaptiveResize(800,800)->save($_SERVER['DOCUMENT_ROOT'].$dir.'original_'.$filename);
                $thumb->create($file)->adaptiveResize(322,190)->save($_SERVER['DOCUMENT_ROOT'].$dirthumb.'big_'.$filename);
                $thumb->create($file)->adaptiveResize(140,83)->save($_SERVER['DOCUMENT_ROOT'].$dirthumb.'mini_'.$filename);
                   				
                $photo = new Photo;
                $photo->ph_url = $dir.'original_'.$filename;
                $photo->ph_type = 'original';
                $photo->ph_gal_id = $this->gall->gal_id;
    			$photo->save();
            }
            return true;
        }
        catch (exception $e)
        {
            return true;
        }
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ann_id',$this->ann_id);
		$criteria->compare('ann_category',$this->ann_category);
		$criteria->compare('ann_name',$this->ann_name,true);
		$criteria->compare('ann_status',$this->ann_status);
		$criteria->compare('ann_user_id',$this->ann_user_id);
		$criteria->compare('ann_actual_date',$this->ann_actual_date,true);
		$criteria->compare('ann_gallery_id',$this->ann_gallery_id);
		$criteria->compare('ann_state',$this->ann_state);
		$criteria->compare('ann_public_date',$this->ann_public_date,true);
		$criteria->compare('ann_desc',$this->ann_desc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function cordTypes()
    {
        return array(
            'Amtel-Vredestein',
            'BFGoodrich',
            'Bridgestone',
            'Continental AG',
            'Cooper Tire & Rubber Company',
            'Dunlop Rubber',
            'Englebert',
            'Federal Corporation',
            'Firestone',
            'Fulda Reifen',
            'Goodyear Tire and Rubber Company',
            'Hankook Tire',
            'Maxxis',
            'Michelin',
            'Nokian Tyres',
            'Pirelli',
            'Sumitomo Rubber Industries',
            'Toyo Tire & Rubber',
            'Yokohama Rubber Company',
            'Белшина',
            'Днепрошина',
            'Нижнекамскшина',
            'Росава',
            'Сибур — Русские шины',
            'Ярославский шинный завод',
        );
    }
}