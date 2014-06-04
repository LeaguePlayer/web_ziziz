<?php

/**
 * This is the model class for table "photo".
 *
 * The followings are the available columns in table 'photo':
 * @property integer $ph_id
 * @property integer $ph_gal_id
 * @property string $ph_url
 * @property string $ph_type
 * @property string $ph_main
 */
class Photo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Photo the static model class
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
		return 'photo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ph_gal_id, ph_url', 'required'),
			array('ph_gal_id, ph_main', 'numerical', 'integerOnly'=>true),
			array('ph_url', 'length', 'max'=>200),
			array('ph_type', 'length', 'max'=>10),
            array('ph_url', 'file', 'types'=>'jpeg,jpg,gif,png', 'maxSize'=>1024*1024*5, 'allowEmpty'=>true,'tooLarge' => 'Максимальный размер файла 5 MB'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ph_id, ph_gal_id, ph_url, ph_type, ph_main', 'safe', 'on'=>'search'),
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
            'gallery'=>array(self::BELONGS_TO, 'Gallery', 'ph_gal_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ph_id' => 'Ph',
			'ph_gal_id' => 'Ph Gal',
			'ph_url' => 'Фото',
			'ph_type' => 'Ph Type',
			'ph_main' => 'Ph Main',
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

		$criteria->compare('ph_id',$this->ph_id);
		$criteria->compare('ph_gal_id',$this->ph_gal_id);
		$criteria->compare('ph_url',$this->ph_url,true);
		$criteria->compare('ph_type',$this->ph_type,true);
		$criteria->compare('ph_main',$this->ph_main,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}