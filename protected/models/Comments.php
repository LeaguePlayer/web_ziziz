<?php

/**
 * This is the model class for table "questions".
 *
 * The followings are the available columns in table 'questions':
 * @property integer $id
 * @property integer $from_user_id
 * @property string $date_public
 * @property string $text
 * @property string $branch_id
 */
class Comments extends CActiveRecord
{
    const TYPE_QUESTION = 1;
    const TYPE_ANSWER = 2;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Questions the static model class
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
		return 'comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('text', 'required'),
			array('text', 'length', 'max'=>1024),
            //array('date_public', 'date'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('text', 'safe', 'on'=>'search'),
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
            'branch' => array(self::BELONGS_TO, 'CommentBranch', 'branch_id'),
            //'announcement' => array(self::BELONGS_TO, 'Announcements', 'branch.ann_id'),
            'author' => array(self::BELONGS_TO, 'Users', 'from_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'from_user_id' => 'From User',
			'date_public' => 'Date Public',
			'text' => 'Text',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('from_user_id',$this->from_user_id);
		$criteria->compare('date_public',$this->date_public,true);
		$criteria->compare('text',$this->text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    protected function beforeSave() {
        if (parent::beforeSave()){
            if (Yii::app()->user->isGuest)
                $this->from_user_id = 0;
            else
                $this->from_user_id = Yii::app()->user->id;
            
            $this->date_public = date('Y-m-d H:i:s', time());
            return true;
        }
    }
}