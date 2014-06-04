<?php

/**
 * This is the model class for table "classifier".
 *
 * The followings are the available columns in table 'classifier':
 * @property integer $classif_id
 * @property string $classif_name
 */
class Classifier extends CActiveRecord
{

    protected function beforeDelete(){
        
        $command = Yii::app()->db->createCommand();
        $command->delete('cat_classif', 'cc_classif_id=:id', array(':id'=>$this->classif_id));
        $command->delete('classif_value', 'cv_classif_id=:id', array(':id'=>$this->classif_id));
        
        return parent::beforeDelete();
    }
    
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Classifier the static model class
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
		return 'classifier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('classif_name', 'required'),
			array('classif_name', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('classif_id, classif_name', 'safe', 'on'=>'search'),
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
            'cats'=>array(self::MANY_MANY, 'Category', 'cat_classif(cc_classif_id, cc_cat_id)'),
            'values'=>array(self::HAS_MANY, 'ClassifValue', 'cv_classif_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'classif_id' => 'Classif',
			'classif_name' => 'Классификатор',
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

		$criteria->compare('classif_id',$this->classif_id);
		$criteria->compare('classif_name',$this->classif_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}