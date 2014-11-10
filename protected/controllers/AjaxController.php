<?php
class AjaxController extends Controller
{
    public function actionGetDevices()
    {
        if(isset($_POST['data']))
        {
            $data = json_decode($_POST['data'], true);
            if($data['action'] == 'deviceType')
            {
                $manufacturers = CHtml::listData(Manufacturer::model()->findAllByAttributes(array('device_type_id' => $data['deviceTypeId'])), 'id', 'name');

                reset($manufacturers);

                $devices = CHtml::listData(Device::model()->findAllByAttributes(array('type_id' => $data['deviceTypeId'], 'manufacturer_id' => key($manufacturers))), 'id', 'name');

                print json_encode(array('action' => 'deviceType', 'manufacturers' => $manufacturers, 'devices' => $devices));
            }
            elseif($data['action'] == 'manufacturer')
            {
                $devices = CHtml::listData(Device::model()->findAllByAttributes(array('type_id' => $data['deviceTypeId'], 'manufacturer_id' => $data['manufacturerId'])), 'id', 'name');
                print json_encode(array('action' => 'manufacturer', 'devices' => $devices));
            }
        }
    }

    public function actionSaveElement()
    {
        if(isset($_POST['data']))
        {
            $data = json_decode($_POST['data'], true);
            if($data['action'] == 'deviceType')
            {
                $deviceType = DeviceType::model()->findByPk($data['id']);
                $deviceType->name = $data['value'];
                $deviceType->save();
            }
            if($data['action'] == 'manufacturer')
            {
                $manufacturer = Manufacturer::model()->findByPk($data['id']);
                $manufacturer->name = $data['value'];
                $manufacturer->save();
            }
            if($data['action'] == 'device')
            {
                $device = Device::model()->findByPk($data['id']);
                $device->name = $data['value'];
                $device->save();
            }
        }
    }
}