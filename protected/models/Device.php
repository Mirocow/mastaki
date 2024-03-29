<?php

/**
 * This is the model class for table "device".
 *
 * The followings are the available columns in table 'device':
 * @property integer $id
 * @property string $name
 * @property integer $manufacturer_id
 * @property integer $type_id
 * @property integer $active
 * @property string $image
 */
class Device extends CActiveRecord
{
    public $image_file;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'device';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, manufacturer_id, type_id', 'required'),
			array('manufacturer_id, type_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
            array('image_file', 'file', 'types'=>'jpg, jpeg, gif, png', 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, manufacturer_id, type_id, image, image_file, active', 'safe', 'on'=>'search'),
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
            'manufacturer'=>array(self::BELONGS_TO, 'Manufacturer', 'manufacturer_id'),
            'type'=>array(self::BELONGS_TO, 'DeviceType', 'type_id'),
            'deviceProblems'=>array(self::HAS_MANY, 'DeviceProblem', 'device_id'),
            'maxPos' => array(self::STAT, 'Device', 'id', 'select'=> 'MAX(pos)', 'defaultValue' => 1),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'manufacturer_id' => 'Manufacturer',
			'type_id' => 'Device Type',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('manufacturer_id',$this->manufacturer_id);
		$criteria->compare('type_id',$this->type_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Device the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function nextPos()
    {
        $criteria = new CDbCriteria;
        $criteria->select = new CDbExpression('MAX(pos) as maxPos');
        $cmd = self::model()->getCommandBuilder()->createFindCommand(self::model()->tableName(), $criteria);
        $max = $cmd->query()->read();

        return $max['maxPos'] + 1;
    }

    protected function beforeSave()
    {

        if($this->isNewRecord)
        {
            $this->pos = $this->nextPos();
        }
        parent::beforeSave();
        return true;
    }
}
