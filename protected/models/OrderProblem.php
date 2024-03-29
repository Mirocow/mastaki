<?php

/**
 * This is the model class for table "order_problem".
 *
 * The followings are the available columns in table 'order_problem':
 * @property integer $device_problem_id
 * @property integer $fix_order_id
 * @property string $status
 * @property double $discount
 */
class OrderProblem extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_problem';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('device_problem_id, fix_order_id, discount', 'required'),
			array('device_problem_id, fix_order_id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('device_problem_id, fix_order_id, status, discount', 'safe', 'on'=>'search'),
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
            'deviceProblem' => array(self::BELONGS_TO, 'DeviceProblem', 'device_problem_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'device_problem_id' => 'Device Problem',
			'fix_order_id' => 'Fix Order',
			'status' => 'Status',
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

		$criteria->compare('device_problem_id',$this->device_problem_id);
		$criteria->compare('fix_order_id',$this->fix_order_id);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderProblem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
