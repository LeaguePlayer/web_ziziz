<?php

/**
 * This is the model class for table "gallery".
 *
 * The followings are the available columns in table 'gallery':
 * @property integer $gal_id
 * @property string $gal_name
 */
class Gallery extends CActiveRecord
{
    protected function afterDelete(){
        //удаляем файлы и данные из базы
        foreach($this->all as $ph){
            $mini = str_replace('original_','thumbs/mini_',$ph->ph_url);
            $big = str_replace('original_','thumbs/big_',$ph->ph_url);
            if (file_exists($_SERVER['DOCUMENT_ROOT'].$ph->ph_url))
                unlink($_SERVER['DOCUMENT_ROOT'].$ph->ph_url); //Удаляем оригинал
            if (file_exists($_SERVER['DOCUMENT_ROOT'].$mini))
                unlink($_SERVER['DOCUMENT_ROOT'].$mini); //Удаляем маленькую
            if (file_exists($_SERVER['DOCUMENT_ROOT'].$big))
                unlink($_SERVER['DOCUMENT_ROOT'].$big); //Удаляем большую
            $ph->delete();
        }
        return parent::afterDelete();
    }
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Gallery the static model class
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
		return 'gallery';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gal_name', 'required'),
			array('gal_name', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('gal_id, gal_name', 'safe', 'on'=>'search'),
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
            'anns'=>array(self::HAS_MANY, 'Announcements', 'ann_gallery_id'),
            'original'=>array(self::HAS_MANY, 'Photo', 'ph_gal_id', 'condition'=>"ph_type = 'original'"),
            'big'=>array(self::HAS_MANY, 'Photo', 'ph_gal_id', 'condition'=>"ph_type = 'big'"),
            'mini'=>array(self::HAS_MANY, 'Photo', 'ph_gal_id', 'condition'=>"ph_type = 'mini'"),
            'all'=>array(self::HAS_MANY, 'Photo', 'ph_gal_id'),
            'photoCount' => array(self::STAT, 'Photo', 'ph_gal_id',
                'select' => 'COUNT(*)'
            ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'gal_id' => 'Gal',
			'gal_name' => 'Название галереи',
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

		$criteria->compare('gal_id',$this->gal_id);
		$criteria->compare('gal_name',$this->gal_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}