<?php

/**
 * This is the model class for table "ann_classif".
 *
 * The followings are the available columns in table 'ann_classif':
 * @property integer $ac_id
 * @property integer $ac_ann_id
 * @property integer $ac_classifval_id
 */
class AnnClassif extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnnClassif the static model class
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
		return 'ann_classif';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ac_ann_id, ac_classifval_id', 'required'),
			array('ac_ann_id, ac_classifval_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ac_id, ac_ann_id, ac_classifval_id', 'safe', 'on'=>'search'),
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
            'value'=>array(self::BELONGS_TO, 'ClassifValue','ac_classifval_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ac_id' => 'Ac',
			'ac_ann_id' => 'Ac Ann',
			'ac_classifval_id' => 'Ac Classifval',
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

		$criteria->compare('ac_id',$this->ac_id);
		$criteria->compare('ac_ann_id',$this->ac_ann_id);
		$criteria->compare('ac_classifval_id',$this->ac_classifval_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}