<?php

/**
 * This is the model class for table "fix_order".
 *
 * The followings are the available columns in table 'fix_order':
 * @property integer $id
 * @property string $created
 * @property double $discount
 * @property string $status
 * @property integer $user_id
 */
class FixOrder extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'fix_order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created, user_id', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
            array('discount', 'numerical'),
			array('status', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, created, status, discount, user_id', 'safe', 'on'=>'search'),
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
            //'deviceProblems' => array(self::MANY_MANY, 'DeviceProblem', 'order_problem(fix_order_id, device_problem_id)'),
            'orderProblems' => array(self::HAS_MANY, 'OrderProblem', 'fix_order_id'),
            'deviceProblems' => array(self::HAS_MANY, 'DeviceProblem', 'device_problem_id', 'through' => 'orderProblems'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'created' => 'Created',
            'discount' => 'Discount',
			'status' => 'Status',
			'user_id' => 'User',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('status',$this->status,true);
        $criteria->compare('discount',$this->discount);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FixOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
