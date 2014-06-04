<?php

/**
 * This is the model class for table "cat_classif".
 *
 * The followings are the available columns in table 'cat_classif':
 * @property integer $cc_id
 * @property integer $cc_cat_id
 * @property integer $cc_classif_id
 */
class CatClassif extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatClassif the static model class
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
		return 'cat_classif';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cc_cat_id, cc_classif_id', 'required'),
			array('cc_cat_id, cc_classif_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cc_id, cc_cat_id, cc_classif_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cc_id' => 'Cc',
			'cc_cat_id' => 'Cc Cat',
			'cc_classif_id' => 'Cc Classif',
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

		$criteria->compare('cc_id',$this->cc_id);
		$criteria->compare('cc_cat_id',$this->cc_cat_id);
		$criteria->compare('cc_classif_id',$this->cc_classif_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}