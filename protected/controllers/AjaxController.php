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
                $manufacturers = CHtml::listData(Manufacturer::model()->findAllByAttributes(array('device_type_id' => $data['deviceTypeId']), array('order' => 'pos ASC')), 'id', 'name');

                reset($manufacturers);

                $devices = array();
                foreach(Device::model()->findAllByAttributes(array('type_id' => $data['deviceTypeId'], 'manufacturer_id' => key($manufacturers)), array('order' => 'pos ASC')) as $device)
                    $devices[] = array('id' => $device->getPrimaryKey(), 'name' => $device->name, 'image' => $device->image);

                print json_encode(array('action' => 'deviceType', 'manufacturers' => $manufacturers, 'devices' => $devices));
            }
            elseif($data['action'] == 'manufacturer')
            {
                $devices = array();
                foreach(Device::model()->findAllByAttributes(array('type_id' => $data['deviceTypeId'], 'manufacturer_id' => $data['manufacturerId']), array('order' => 'pos ASC')) as $device)
                    $devices[] = array('id' => $device->getPrimaryKey(), 'name' => $device->name, 'image' => $device->image);

                print json_encode(array('action' => 'manufacturer', 'devices' => $devices));
            }
        }
    }

    public function actionSaveElement()
    {
        $data = $_POST;
        if(isset($data['action']))
        {
            if($data['action'] == 'deviceType')
            {
                $deviceType = DeviceType::model()->findByPk($data['id']);
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

                if(isset($_FILES['Device']))
                {
                    if($_FILES['Device']['tmp_name']['image_file'] !== '')
                    {
                        $device->image_file=CUploadedFile::getInstance($device,'image_file');
                        $device->image_file->saveAs('images/images/'.$device->image_file->name);
                        $device->image = $device->image_file->name;
                    }
                }

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

                if(isset($_FILES['Device']))
                {
                    if($_FILES['Device']['tmp_name']['image_file'] !== '')
                    {
                        $device->image_file=CUploadedFile::getInstance($device,'image_file');
                        $device->image_file->saveAs('images/images/'.$device->image_file->name);
                        $device->image = $device->image_file->name;
                    }
                }

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

    public function actionGetImage()
    {
        $response = array();
        if(isset($_POST['data']))
        {
            $data = json_decode($_POST['data'],true);

            if($data['action'] == 'deviceType')
            {
                $deviceType = DeviceType::model()->findByPk($data['id']);
                if($deviceType !== null)
                {
                    if($deviceType->icon !== null)
                    {
                        $response['src'] = Yii::app()->baseUrl.'/images/icons/'.$deviceType->icon;
                        $response['result'] = 'OK';
                    }
                    else
                        $response['result'] = 'NO_IMAGE';
                }
                else
                    $response['result'] = 'ERROR';
            }
            elseif($data['action'] == 'device')
            {
                $device = Device::model()->findByPk($data['id']);
                if($device !== null)
                {
                    if($device->image !== null)
                    {
                        $response['src'] = Yii::app()->baseUrl.'/images/images/'.$device->image;
                        $response['result'] = 'OK';
                    }
                    else
                        $response['result'] = 'NO_IMAGE';
                }
                else
                    $response['result'] = 'ERROR';
            }
            else
                $response['result'] = 'ERROR';
        }
        print json_encode($response);
    }

    public function actionSortElement()
    {
        $response = array('result' => 'ERROR');
        if(isset($_POST['data']))
        {
            $data = json_decode($_POST['data'], true);
            $id = $data['id'];
            $direction = $data['direction'];
            if($data['action'] == 'deviceType')
            {
                $deviceTypeToMove = DeviceType::model()->findByPk($id);

                if($direction == 'up')
                    $deviceTypeToReplace = DeviceType::model()->findByAttributes(array('pos' => $deviceTypeToMove->pos - 1));
                else
                    $deviceTypeToReplace = DeviceType::model()->findByAttributes(array('pos' => $deviceTypeToMove->pos + 1));

                if($deviceTypeToReplace !== null)
                {
                    $pos = $deviceTypeToReplace->pos;
                    $deviceTypeToReplace->pos = $deviceTypeToMove->pos;
                    $deviceTypeToMove->pos = $pos;

                    $deviceTypeToMove->save();
                    $deviceTypeToReplace->save();

                    $response['result'] = 'OK';
                }
            }
            elseif($data['action'] == 'manufacturer')
            {
                $manufacturerToMove = Manufacturer::model()->findByPk($id);

                if($direction == 'up')
                    $manufacturerToReplace = Manufacturer::model()->findByAttributes(array('device_type_id' => $data['deviceTypeId'], 'pos' => $manufacturerToMove->pos - 1));
                else
                    $manufacturerToReplace = Manufacturer::model()->findByAttributes(array('device_type_id' => $data['deviceTypeId'], 'pos' => $manufacturerToMove->pos + 1));

                if($manufacturerToReplace !== null)
                {
                    $pos = $manufacturerToReplace->pos;
                    $manufacturerToReplace->pos = $manufacturerToMove->pos;
                    $manufacturerToMove->pos = $pos;

                    $manufacturerToMove->save();
                    $manufacturerToReplace->save();

                    $response['result'] = 'OK';
                }
            }
            elseif($data['action'] == 'device')
            {
                $deviceToMove = Device::model()->findByPk($id);

                if($direction == 'up')
                    $deviceToReplace = Device::model()->findByAttributes(array('manufacturer_id' => $data['manufacturerId'], 'type_id' => $data['deviceTypeId'], 'pos' => $deviceToMove->pos - 1));
                else
                    $deviceToReplace = Device::model()->findByAttributes(array('manufacturer_id' => $data['manufacturerId'], 'type_id' => $data['deviceTypeId'], 'pos' => $deviceToMove->pos + 1));

                if($deviceToReplace !== null)
                {
                    $pos = $deviceToReplace->pos;
                    $deviceToReplace->pos = $deviceToMove->pos;
                    $deviceToMove->pos = $pos;

                    $deviceToMove->save();
                    $deviceToReplace->save();

                    $response['result'] = 'OK';
                }
            }
        }
        print json_encode($response);
    }
}