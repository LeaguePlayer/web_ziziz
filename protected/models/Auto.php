<?php

/**
 * This is the model class for table "auto".
 *
 * The followings are the available columns in table 'auto':
 * @property integer $auto_id
 * @property string $auto_title
 * @property integer $auto_user
 * @property integer $auto_run
 * @property integer $auto_year
 * @property string $auto_desc
 * @property string $auto_public_date
 * @property string $auto_actual_date
 * @property integer $auto_status
 * @property integer $auto_price
 * @property integer $auto_model_id
 * @property integer $auto_gal_id
 */
class Auto extends CActiveRecord
{
    const STATUS_MODERATED 		= 1; // на модерации
	const STATUS_PUBLISHED 		= 2; // опубликовано
	const STATUS_BLOCKED 		= 3; // заблокировано
	const STATUS_REMOVED 		= 4; // удалено
	
	const DATE_INTERVAL_ONE_WEEK = 1;
	const DATE_INTERVAL_TWO_WEEKS = 2;
	const DATE_INTERVAL_ONE_MONTH = 3;
    
    public $user_city_id;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Auto the static model class
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
		return 'auto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('auto_run, auto_price, auto_year, auto_model_id', 'required'),
			array('auto_model_id, auto_run, auto_year, auto_price, auto_carcass, auto_fuel, auto_control, auto_box, auto_drive, auto_modification_id', 'numerical', 'integerOnly'=>true),
			array('auto_vol', 'numerical'),
			array('auto_desc', 'length', 'max'=>2000),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('auto_id, auto_user, auto_run, auto_year, auto_desc, auto_public_date, auto_actual_date, auto_status, auto_price, auto_model_id, auto_gal_id', 'safe', 'on'=>'search'),
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
            'gall'=>array(self::BELONGS_TO, 'Gallery', 'auto_gal_id'),
            'automodel'=>array(self::BELONGS_TO, 'Carmodel', 'auto_model_id'),
            'user'=>array(self::BELONGS_TO, 'Users', 'auto_user'),
            'modification'=>array(self::BELONGS_TO, 'Modification', 'auto_modification_id'),
            'commentBranchs'=>array(self::HAS_MANY, 'CommentBranchAuto', 'auto_id'),
            //'comments'=>array(self::HAS_MANY, 'Autocomments', 'ann_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'auto_id' => 'Auto',
			'auto_title' => 'Название',
			'auto_user' => 'Пользователь',
			'auto_run' => 'Пробег',
			'auto_year' => 'Год',
			'auto_desc' => 'Описание',
			'auto_public_date' => 'Auto Public Date',
			'auto_actual_date' => 'Auto Actual Date',
			'auto_status' => 'Статус объявления',
			'auto_price' => 'Цена',
			'auto_model_id' => 'Модель',
			'auto_gal_id' => 'Галерея',
		);
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

		$criteria->compare('auto_id',$this->auto_id);
		$criteria->compare('auto_title',$this->auto_title,true);
		$criteria->compare('auto_user',$this->auto_user);
		$criteria->compare('auto_run',$this->auto_run);
		$criteria->compare('auto_year',$this->auto_year);
		$criteria->compare('auto_desc',$this->auto_desc,true);
		$criteria->compare('auto_public_date',$this->auto_public_date,true);
		$criteria->compare('auto_actual_date',$this->auto_actual_date,true);
		$criteria->compare('auto_status',$this->auto_status);
		$criteria->compare('auto_price',$this->auto_price);
		$criteria->compare('auto_model_id',$this->auto_model_id);
		$criteria->compare('auto_gal_id',$this->auto_gal_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function instanceGallery()
	{
        $no_gallery == false;
        if (!$this->isNewRecord)
        {
            $gallery = Gallery::model()->findByPk($this->auto_gal_id);
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
        $this->auto_gal_id = $gallery->gal_id;
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
            	   $this->auto_status = self::STATUS_MODERATED;
            	}
    	        $today = time();
           		$this->auto_public_date = date('Y-m-d H:i:s', $today);
            	$this->auto_actual_date = date('Y-m-d H:i:s', ($today + (3600 * 24 * 14))); // 14 дней
    		}
            $this->instanceGallery();
            return true;
        }
		return false;
	}
    
    protected function afterSave()
    {
        try
        {
            parent::afterSave();
            
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
}