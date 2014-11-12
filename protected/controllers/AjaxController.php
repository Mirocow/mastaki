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
    public function actionAddElement()
    {
        $response = array();

        if(isset($_POST['action']))
        {
            $data = $_POST;
            if($data['action'] == 'deviceType')
            {
                $deviceType = new DeviceType();
                $deviceType->name = $data['value'];

                if(isset($_FILES['DeviceType']))
                {
                    if($_FILES['DeviceType']['tmp_name']['icon_file'] !== '')
                    {
                        $deviceType->icon_file=CUploadedFile::getInstance($deviceType,'icon_file');
                        $deviceType->icon_file->saveAs('images/icons/'.$deviceType->icon_file->name);
                        $deviceType->icon = $deviceType->icon_file->name;
                    }
                }

                if($deviceType->save())
                    $response['result'] = 'OK';
                else
                    $response['result'] = 'ERROR';

                $response['id'] = $deviceType->getPrimaryKey();
                $response['name'] = $deviceType->name;
            }
            if($data['action'] == 'manufacturer')
            {
                $manufacturer = new Manufacturer();
                $manufacturer->name = $data['value'];
                $manufacturer->device_type_id = $data['deviceTypeId'];

                if($manufacturer->save())
                    $response['result'] = 'OK';
                else
                    $response['result'] = 'ERROR';

                $response['id'] = $manufacturer->getPrimaryKey();
                $response['name'] = $manufacturer->name;
            }
            if($data['action'] == 'device')
            {
                $device = new Device();
                $device->name = $data['value'];
                $device->type_id = $data['deviceTypeId'];
                $device->manufacturer_id = $data['manufacturerId'];

                if($device->save())
                    $response['result'] = 'OK';
                else
                    $response['result'] = 'ERROR';

                $response['id'] = $device->getPrimaryKey();
                $response['name'] = $device->name;
            }
        }

        print json_encode($response);
    }
    public function actionDeleteElement()
    {
        $result = '';

        if(isset($_POST['data']))
        {
            $data = json_decode($_POST['data'], true);

            if($data['action'] == 'deviceType')
            {
                $deviceType = DeviceType::model()->findByPk($data['id']);

                if(count($deviceType->manufacturers) == 0)
                {
                    if($deviceType->delete())
                        $result = 'OK';
                    else
                        $result = 'ERROR';
                }
                else
                    $result = 'NOT_EMPTY';
            }
            elseif($data['action'] == 'manufacturer')
            {
                $manufacturer = Manufacturer::model()->findByPk($data['id']);

                if(count($manufacturer->devices) == 0)
                {
                    if($manufacturer->delete())
                        $result = 'OK';
                    else
                        $result = 'ERROR';
                }
                else
                    $result = 'NOT_EMPTY';
            }
            elseif($data['action'] == 'device')
            {
                $device = Device::model()->findByPk($data['id']);

                if($device->delete())
                    $result = 'OK';
                else
                    $result = 'ERROR';
            }
        }
        else
            $result = 'ERROR';

        print json_encode(array('result' => $result));
    }
}