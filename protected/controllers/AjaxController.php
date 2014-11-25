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
                $manufacturers = array();
                $devices = array();

                foreach(Manufacturer::model()->findAllByAttributes(array('device_type_id' => $data['deviceTypeId']), array('order' => 'pos ASC')) as $manufacturer)
                    $manufacturers[] = array('id' => $manufacturer->getPrimaryKey(), 'name' => $manufacturer->name, 'active' => $manufacturer->active);

                if(count($manufacturers) > 0)
                    foreach(Device::model()->findAllByAttributes(array('type_id' => $data['deviceTypeId'], 'manufacturer_id' => $manufacturers[0]['id']), array('order' => 'pos ASC')) as $device)
                        $devices[] = array('id' => $device->getPrimaryKey(), 'name' => $device->name, 'image' => $device->image, 'active' => $device->active);

                print json_encode(array('action' => 'deviceType', 'manufacturers' => $manufacturers, 'devices' => $devices));
            }
            elseif($data['action'] == 'manufacturer')
            {
                $devices = array();
                foreach(Device::model()->findAllByAttributes(array('type_id' => $data['deviceTypeId'], 'manufacturer_id' => $data['manufacturerId']), array('order' => 'pos ASC')) as $device)
                    $devices[] = array('id' => $device->getPrimaryKey(), 'name' => $device->name, 'image' => $device->image, 'active' => $device->active);

                print json_encode(array('action' => 'manufacturer', 'devices' => $devices));
            }
            elseif($data['action'] == 'servicesDeviceType')
            {
                $problemCategories = array();
                $breakdowns = array();
                $problems = array();

                foreach(ProblemCategory::model()->findAllByAttributes(array('device_type_id' => $data['deviceTypeId']), array('order' => 'pos ASC')) as $problemCategory)
                    $problemCategories[] = array('id' => $problemCategory->getPrimaryKey(), 'name' => $problemCategory->name, 'active' => $problemCategory->active);

                if(count($problemCategories) > 0)
                {
                    foreach(Problem::model()->findAllByAttributes(array('problem_category_id' => $problemCategories[0]['id'], 'type' => 'BREAKDOWN'), array('order' => 'pos ASC')) as $breakdown)
                    {
                        $breakdowns[] = array('id' => $breakdown->getPrimaryKey(), 'name' => $breakdown->name, 'description' => $breakdown->description, 'active' => $breakdown->active);
                    }
                }
                if(count($problemCategories) > 0)
                {
                    foreach(Problem::model()->findAllByAttributes(array('problem_category_id' => $problemCategories[0]['id'], 'type' => 'PROBLEM'), array('order' => 'pos ASC')) as $problem)
                    {
                        $problems[] = array('id' => $problem->getPrimaryKey(), 'name' => $problem->name, 'description' => $problem->description, 'active' => $problem->active);
                    }
                }

                print json_encode(array('action' => 'servicesDeviceType', 'problemCategories' => $problemCategories, 'breakdowns' => $breakdowns, 'problems' => $problems));
            }
            elseif($data['action'] == 'catalogDeviceType')
            {
                $manufacturers = array();
                $devices = array();
                $problemCategories = array();
                $breakdowns = array();
                $problems = array();

                foreach(Manufacturer::model()->findAllByAttributes(array('device_type_id' => $data['deviceTypeId']), array('order' => 'pos ASC')) as $manufacturer)
                    $manufacturers[] = array('id' => $manufacturer->getPrimaryKey(), 'name' => $manufacturer->name, 'active' => $manufacturer->active);

                if(count($manufacturers) > 0)
                    foreach(Device::model()->findAllByAttributes(array('type_id' => $data['deviceTypeId'], 'manufacturer_id' => $manufacturers[0]['id']), array('order' => 'pos ASC')) as $device)
                        $devices[] = array('id' => $device->getPrimaryKey(), 'name' => $device->name, 'image' => $device->image, 'active' => $device->active);

                foreach(ProblemCategory::model()->findAllByAttributes(array('device_type_id' => $data['deviceTypeId']), array('order' => 'pos ASC')) as $problemCategory)
                    $problemCategories[] = array('id' => $problemCategory->getPrimaryKey(), 'name' => $problemCategory->name, 'active' => $problemCategory->active);

                if(count($problemCategories) > 0 && count($devices) > 0)
                {
                    foreach(Problem::model()->findAllByAttributes(array('problem_category_id' => $problemCategories[0]['id'], 'type' => 'BREAKDOWN'), array('order' => 'pos ASC')) as $breakdown)
                    {
                        $data = array('id' => $breakdown->getPrimaryKey(), 'name' => $breakdown->name, 'description' => $breakdown->description, 'active' => $breakdown->active);
                        $deviceBreakdown = DeviceProblem::model()->findByAttributes(array('problem_id' => $breakdown->getPrimaryKey(), 'device_id' => $devices[0]['id']));

                        if($deviceBreakdown !== null)
                            $data['active'] = $deviceBreakdown->active;
                        else
                            $data['active'] = 0;

                        $breakdowns[] = $data;
                    }
                    foreach(Problem::model()->findAllByAttributes(array('problem_category_id' => $problemCategories[0]['id'], 'type' => 'PROBLEM'), array('order' => 'pos ASC')) as $problem)
                    {
                        $data = array('id' => $problem->getPrimaryKey(), 'name' => $problem->name, 'description' => $problem->description, 'active' => $problem->active);
                        $deviceProblem = DeviceProblem::model()->findByAttributes(array('problem_id' => $problem->getPrimaryKey(), 'device_id' => $devices[0]['id']));

                        if($deviceProblem !== null)
                            $data['active'] = $deviceProblem->active;
                        else
                            $data['active'] = 0;

                        $problems[] = $data;
                    }
                }

                print json_encode(array('action' => 'catalogDeviceType', 'devices' => $devices, 'manufacturers' => $manufacturers, 'problemCategories' => $problemCategories, 'breakdowns' => $breakdowns, 'problems' => $problems));
            }
            elseif($data['action'] == 'catalogProblemCategory')
            {
                $breakdowns = array();
                $problems = array();

                foreach(Problem::model()->findAllByAttributes(array('problem_category_id' => $data['problemCategoryId'], 'type' => 'BREAKDOWN'), array('order' => 'pos ASC')) as $breakdown)
                {
                    $element = array('id' => $breakdown->getPrimaryKey(), 'name' => $breakdown->name, 'description' => $breakdown->description, 'active' => $breakdown->active);
                    $deviceBreakdown = DeviceProblem::model()->findByAttributes(array('problem_id' => $breakdown->getPrimaryKey(), 'device_id' => $data['deviceId']));

                    if($deviceBreakdown !== null)
                        $element['active'] = $deviceBreakdown->active;
                    else
                        $element['active'] = 0;

                    $breakdowns[] = $element;
                }
                foreach(Problem::model()->findAllByAttributes(array('problem_category_id' => $data['problemCategoryId'], 'type' => 'PROBLEM'), array('order' => 'pos ASC')) as $problem)
                {
                    $element = array('id' => $problem->getPrimaryKey(), 'name' => $problem->name, 'description' => $problem->description, 'active' => $problem->active);
                    $deviceProblem = DeviceProblem::model()->findByAttributes(array('problem_id' => $problem->getPrimaryKey(), 'device_id' => $data['deviceId']));

                    if($deviceProblem !== null)
                        $element['active'] = $deviceProblem->active;
                    else
                        $element['active'] = 0;

                    $problems[] = $element;
                }

                print json_encode(array('action' => 'problemCategory', 'breakdowns' => $breakdowns, 'problems' => $problems));
            }
            elseif($data['action'] == 'problemCategory')
            {
                $breakdowns = array();
                $problems = array();

                foreach(Problem::model()->findAllByAttributes(array('problem_category_id' => $data['problemCategoryId'], 'type' => 'BREAKDOWN'), array('order' => 'pos ASC')) as $breakdown)
                    $breakdowns[] = array('id' => $breakdown->getPrimaryKey(), 'name' => $breakdown->name, 'description' => $breakdown->description, 'active' => $breakdown->active);

                foreach(Problem::model()->findAllByAttributes(array('problem_category_id' => $data['problemCategoryId'], 'type' => 'PROBLEM'), array('order' => 'pos ASC')) as $problem)
                    $problems[] = array('id' => $problem->getPrimaryKey(), 'name' => $problem->name, 'description' => $problem->description, 'active' => $problem->active);

                print json_encode(array('action' => 'problemCategory', 'breakdowns' => $breakdowns, 'problems' => $problems));
            }
            elseif($data['action'] == 'catalogDevice')
            {
                $problemCategories = array();
                $breakdowns = array();
                $problems = array();

                foreach(ProblemCategory::model()->findAllByAttributes(array('device_type_id' => $data['deviceTypeId']), array('order' => 'pos ASC')) as $problemCategory)
                    $problemCategories[] = array('id' => $problemCategory->getPrimaryKey(), 'name' => $problemCategory->name, 'active' => $problemCategory->active);

                if(count($problemCategories) > 0)
                {
                    foreach(Problem::model()->findAllByAttributes(array('problem_category_id' => $problemCategories[0]['id'], 'type' => 'BREAKDOWN'), array('order' => 'pos ASC')) as $breakdown)
                    {
                        $element = array('id' => $breakdown->getPrimaryKey(), 'name' => $breakdown->name, 'description' => $breakdown->description, 'active' => $breakdown->active);
                        $deviceBreakdown = DeviceProblem::model()->findByAttributes(array('problem_id' => $breakdown->getPrimaryKey(), 'device_id' => $data['deviceId']));

                        if($deviceBreakdown !== null)
                            $element['active'] = $deviceBreakdown->active;
                        else
                            $element['active'] = 0;

                        $breakdowns[] = $element;
                    }
                    foreach(Problem::model()->findAllByAttributes(array('problem_category_id' => $problemCategories[0]['id'], 'type' => 'PROBLEM'), array('order' => 'pos ASC')) as $problem)
                    {
                        $element = array('id' => $problem->getPrimaryKey(), 'name' => $problem->name, 'description' => $problem->description, 'active' => $problem->active);
                        $deviceProblem = DeviceProblem::model()->findByAttributes(array('problem_id' => $problem->getPrimaryKey(), 'device_id' => $data['deviceId']));

                        if($deviceProblem !== null)
                            $element['active'] = $deviceProblem->active;
                        else
                            $element['active'] = 0;

                        $problems[] = $element;
                    }
                }
                print json_encode(array('action' => 'catalogDevice', 'problemCategories' => $problemCategories, 'breakdowns' => $breakdowns, 'problems' => $problems));
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
            if($data['action'] == 'problemCategory')
            {
                $problemCategory = ProblemCategory::model()->findByPk($data['id']);
                $problemCategory->name = $data['value'];

                if(isset($_FILES['ProblemCategory']))
                {
                    if($_FILES['ProblemCategory']['tmp_name']['icon_file'] !== '')
                    {
                        $problemCategory->icon_file=CUploadedFile::getInstance($problemCategory,'icon_file');
                        $problemCategory->icon_file->saveAs('images/icons/'.$problemCategory->icon_file->name);
                        $problemCategory->icon = $problemCategory->icon_file->name;
                    }
                }

                $problemCategory->save();
            }
            if($data['action'] == 'breakdown')
            {
                $breakdown = Problem::model()->findByPk($data['id']);
                $breakdown->name = $data['value'];
                $breakdown->description = $data['description'];

                if(isset($_FILES['Problem']))
                {
                    if($_FILES['Problem']['tmp_name']['image_file'] !== '')
                    {
                        $breakdown->image_file = CUploadedFile::getInstance($breakdown,'image_file');
                        $breakdown->image_file->saveAs('images/images/'.$breakdown->image_file->name);
                        $breakdown->image = $breakdown->image_file->name;
                    }
                }

                $breakdown->save();
            }
            if($data['action'] == 'problem')
            {
                $problem = Problem::model()->findByPk($data['id']);
                $problem->name = $data['value'];
                $problem->description = $data['description'];

                if(isset($_FILES['Problem']))
                {
                    if($_FILES['Problem']['tmp_name']['image_file'] !== '')
                    {
                        $problem->image_file=CUploadedFile::getInstance($problem,'image_file');
                        $problem->image_file->saveAs('images/images/'.$problem->image_file->name);
                        $problem->image = $problem->image_file->name;
                    }
                }

                $problem->save();
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
            elseif($data['action'] == 'device')
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
            elseif($data['action'] == 'problemCategory')
            {
                $problemCategory = new ProblemCategory();
                $problemCategory->name = $data['value'];
                $problemCategory->device_type_id = $data['deviceTypeId'];

                if(isset($_FILES['ProblemCategory']))
                {
                    if($_FILES['ProblemCategory']['tmp_name']['icon_file'] !== '')
                    {
                        $problemCategory->icon_file=CUploadedFile::getInstance($problemCategory,'icon_file');
                        $problemCategory->icon_file->saveAs('images/icons/'.$problemCategory->icon_file->name);
                        $problemCategory->icon = $problemCategory->icon_file->name;
                    }
                }

                if($problemCategory->save())
                    $response['result'] = 'OK';
                else
                    $response['result'] = 'ERROR';

                $response['id'] = $problemCategory->getPrimaryKey();
                $response['name'] = $problemCategory->name;
            }
            elseif($data['action'] == 'breakdown')
            {
                $breakdown = new Problem();
                $breakdown->name = $data['value'];
                $breakdown->description = $data['description'];
                $breakdown->type = 'BREAKDOWN';
                $breakdown->problem_category_id = $data['problemCategoryId'];

                if(isset($_FILES['Problem']))
                {
                    if($_FILES['Problem']['tmp_name']['image_file'] !== '')
                    {
                        $breakdown->image_file=CUploadedFile::getInstance($breakdown,'image_file');
                        $breakdown->image_file->saveAs('images/images/'.$breakdown->image_file->name);
                        $breakdown->image = $breakdown->image_file->name;
                    }
                }

                if($breakdown->save())
                    $response['result'] = 'OK';
                else
                    $response['result'] = 'ERROR';

                $response['id'] = $breakdown->getPrimaryKey();
                $response['name'] = $breakdown->name;
            }
            elseif($data['action'] == 'problem')
            {
                $problem = new Problem();
                $problem->name = $data['value'];
                $problem->description = $data['description'];
                $problem->type = 'PROBLEM';
                $problem->problem_category_id = $data['problemCategoryId'];

                if(isset($_FILES['Problem']))
                {
                    if($_FILES['Problem']['tmp_name']['image_file'] !== '')
                    {
                        $problem->image_file=CUploadedFile::getInstance($problem,'image_file');
                        $problem->image_file->saveAs('images/images/'.$problem->image_file->name);
                        $problem->image = $problem->image_file->name;
                    }
                }

                if($problem->save())
                    $response['result'] = 'OK';
                else
                    $response['result'] = 'ERROR';

                $response['id'] = $problem->getPrimaryKey();
                $response['name'] = $problem->name;
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
            elseif($data['action'] == 'problemCategory')
            {
                $problemCategory = ProblemCategory::model()->findByPk($data['id']);

                if(count($problemCategory->problems) == 0)
                {
                    if($problemCategory->delete())
                        $result = 'OK';
                    else
                        $result = 'ERROR';
                }
                else
                    $result = 'NOT_EMPTY';
            }
            elseif($data['action'] == 'breakdown')
            {
                $breakdown = Problem::model()->findByPk($data['id']);

                if($breakdown->delete())
                    $result = 'OK';
                else
                    $result = 'ERROR';
            }
            elseif($data['action'] == 'problem')
            {
                $problem = Problem::model()->findByPk($data['id']);

                if($problem->delete())
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
            elseif($data['action'] == 'breakdown' || $data['action'] == 'problem')
            {
                $problem = Problem::model()->findByPk($data['id']);
                if($problem !== null)
                {
                    if($problem->image !== null)
                    {
                        $response['src'] = Yii::app()->baseUrl.'/images/images/'.$problem->image;
                        $response['result'] = 'OK';
                    }
                    else
                        $response['result'] = 'NO_IMAGE';
                }
                else
                    $response['result'] = 'ERROR';
            }
            elseif($data['action'] == 'problemCategory')
            {
                $problemCategory = ProblemCategory::model()->findByPk($data['id']);
                if($problemCategory !== null)
                {
                    if($problemCategory->icon !== null)
                    {
                        $response['src'] = Yii::app()->baseUrl.'/images/icons/'.$problemCategory->icon;
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
                    $deviceTypeToReplace = DeviceType::model()->findByAttributes(array(), array('condition' => 'pos < :pos', 'order' => 'pos DESC', 'params' => array(':pos' => $deviceTypeToMove->pos)));
                else
                    $deviceTypeToReplace = DeviceType::model()->findByAttributes(array(), array('condition' => 'pos > :pos', 'order' => 'pos ASC', 'params' => array(':pos' => $deviceTypeToMove->pos)));

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
                    $manufacturerToReplace = Manufacturer::model()->findByAttributes(array('device_type_id' => $data['deviceTypeId']), array('condition' => 'pos < :pos', 'order' => 'pos DESC', 'params' => array(':pos' => $manufacturerToMove->pos)));
                else
                    $manufacturerToReplace = Manufacturer::model()->findByAttributes(array('device_type_id' => $data['deviceTypeId']), array('condition' => 'pos > :pos', 'order' => 'pos ASC', 'params' => array(':pos' => $manufacturerToMove->pos)));

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
                    $deviceToReplace = Device::model()->findByAttributes(array('manufacturer_id' => $data['manufacturerId'], 'type_id' => $data['deviceTypeId']), array('condition' => 'pos < :pos', 'order' => 'pos DESC', 'params' => array(':pos' => $deviceToMove->pos)));
                else
                    $deviceToReplace = Device::model()->findByAttributes(array('manufacturer_id' => $data['manufacturerId'], 'type_id' => $data['deviceTypeId']), array('condition' => 'pos > :pos', 'order' => 'pos ASC', 'params' => array(':pos' => $deviceToMove->pos)));

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
            elseif($data['action'] == 'problemCategory')
            {
                $problemCategoryToMove = ProblemCategory::model()->findByPk($id);

                if($direction == 'up')
                    $problemCategoryToReplace = ProblemCategory::model()->findByAttributes(array('device_type_id' => $data['deviceTypeId']), array('condition' => 'pos < :pos', 'order' => 'pos DESC', 'params' => array(':pos' => $problemCategoryToMove->pos)));
                else
                    $problemCategoryToReplace = ProblemCategory::model()->findByAttributes(array('device_type_id' => $data['deviceTypeId']), array('condition' => 'pos > :pos', 'order' => 'pos ASC', 'params' => array(':pos' => $problemCategoryToMove->pos)));

                if($problemCategoryToReplace !== null)
                {
                    $pos = $problemCategoryToReplace->pos;
                    $problemCategoryToReplace->pos = $problemCategoryToMove->pos;
                    $problemCategoryToMove->pos = $pos;

                    $problemCategoryToMove->save();
                    $problemCategoryToReplace->save();

                    $response['result'] = 'OK';
                }
            }
            elseif($data['action'] == 'breakdown')
            {
                $breakdownToMove = Problem::model()->findByPk($id);

                if($direction == 'up')
                    $breakdownToReplace = Problem::model()->findByAttributes(array('problem_category_id' => $data['problemCategoryId'], 'type' => 'BREAKDOWN'), array('condition' => 'pos < :pos', 'order' => 'pos DESC', 'params' => array(':pos' => $breakdownToMove->pos)));
                else
                    $breakdownToReplace = Problem::model()->findByAttributes(array('problem_category_id' => $data['problemCategoryId'], 'type' => 'BREAKDOWN'), array('condition' => 'pos > :pos', 'order' => 'pos ASC', 'params' => array(':pos' => $breakdownToMove->pos)));

                if($breakdownToReplace !== null)
                {
                    $pos = $breakdownToReplace->pos;
                    $breakdownToReplace->pos = $breakdownToMove->pos;
                    $breakdownToMove->pos = $pos;

                    $breakdownToMove->save();
                    $breakdownToReplace->save();

                    $response['result'] = 'OK';
                }
            }
            elseif($data['action'] == 'problem')
            {
                $problemToMove = Problem::model()->findByPk($id);

                if($direction == 'up')
                    $problemToReplace = Problem::model()->findByAttributes(array('problem_category_id' => $data['problemCategoryId'], 'type' => 'PROBLEM'), array('condition' => 'pos < :pos', 'order' => 'pos DESC', 'params' => array(':pos' => $problemToMove->pos)));
                else
                    $problemToReplace = Problem::model()->findByAttributes(array('problem_category_id' => $data['problemCategoryId'], 'type' => 'PROBLEM'), array('condition' => 'pos > :pos', 'order' => 'pos ASC', 'params' => array(':pos' => $problemToMove->pos)));

                if($problemToReplace !== null)
                {
                    $pos = $problemToReplace->pos;
                    $problemToReplace->pos = $problemToMove->pos;
                    $problemToMove->pos = $pos;

                    $problemToMove->save();
                    $problemToReplace->save();

                    $response['result'] = 'OK';
                }
            }
        }
        print json_encode($response);
    }

    public function actionGetProblemDescription()
    {
        if(isset($_POST['id']))
        {
            print json_encode(array('desc' => Problem::model()->findByPk($_POST['id'])->description));
        }
    }

    public function actionSavePrice()
    {
        if(isset($_POST['data']))
        {
            $data = json_decode($_POST['data'], true);

            $breakdown = DeviceProblem::model()->findByAttributes(array('device_id' => $data['deviceId'], 'problem_id' => $data['problemId']));

            if($breakdown === null)
            {
                $breakdown = new DeviceProblem();
                $breakdown->device_id = $data['deviceId'];
                $breakdown->problem_id = $data['problemId'];
                $breakdown->active = 0;
            }
            $breakdown->price = $data['price'];
            $breakdown->part_price = $data['partPrice'];
            $breakdown->save();

        }
    }

    public function actionGetPrices()
    {
        $response = array();
        if(isset($_POST['data']))
        {
            $data = json_decode($_POST['data'], true);
            if(isset($data['deviceId']) && isset($data['breakdownId']) && isset($data['problemId']))
            {
                $breakdown = DeviceProblem::model()->findByAttributes(array('device_id' => $data['deviceId'], 'problem_id' => $data['breakdownId']));
                $problem = DeviceProblem::model()->findByAttributes(array('device_id' => $data['deviceId'], 'problem_id' => $data['problemId']));

                if($breakdown !== null)
                    $response['breakdown'] = array('price' => $breakdown->price, 'partPrice' => $breakdown->part_price);
                if($problem !== null)
                    $response['problem'] = array('price' => $problem->price, 'partPrice' => $problem->part_price);
            }
        }

        print json_encode($response);
    }



    public function actionToggle()
    {
        if(isset($_POST['action']))
        {
            $data = $_POST;
            if($data['action'] == 'problemCategory')
            {
                $problemCategory = ProblemCategory::model()->findByPk($data['problemCategoryId']);

                if($problemCategory->active == 1) {
                    $problemCategory->active = 0;
                    $deviceProblems = DeviceProblem::model()->findAll(array(
                        'with' => array('device', 'problem' => array(
                            'with' => array('problemCategory'),
                        )),
                        'condition' => 'problemCategory.id = :problemCategoryId',
                        //'condition' => 'device.id = :deviceId AND problemCategory.id = :problemCategoryId',
                        'params' => array(':problemCategoryId' => $data['problemCategoryId']),
                        //'params' => array(':problemCategoryId' => $data['problemCategoryId'], ':deviceId' => $data['deviceId']),
                    ));

                    foreach ($deviceProblems as $deviceProblem)
                    {
                        $deviceProblem->active = 0;
                        $deviceProblem->save();
                    }
                }
                else
                    $problemCategory->active = 1;

                $problemCategory->save();
            }
            if($data['action'] == 'deviceType')
            {
                $deviceType = DeviceType::model()->findByPk($data['deviceTypeId']);
                if($deviceType->active == 1)
                    $deviceType->active = 0;
                else
                    $deviceType->active = 1;

                $deviceType->save();
            }
            if($data['action'] == 'manufacturer')
            {
                $manufacturer = Manufacturer::model()->findByPk($data['manufacturerId']);
                if($manufacturer->active == 1)
                    $manufacturer->active = 0;
                else
                    $manufacturer->active = 1;

                $manufacturer->save();
            }
            if($data['action'] == 'device')
            {
                $device = Device::model()->findByPk($data['deviceId']);
                if($device->active == 1)
                    $device->active = 0;
                else
                    $device->active = 1;

                $device->save();
            }
            if($data['action'] == 'problem')
            {
                $problem = DeviceProblem::model()->findByAttributes(array('device_id' => $data['deviceId'], 'problem_id' => $data['problemId']));
                if($problem->active == 1)
                    $problem->active = 0;
                else
                    $problem->active = 1;

                $problem->save();
            }
        }
    }

    public function actionSaveClient()
    {
        if(isset($_POST['User']) && isset($_POST['clientId']))
        {
            $user = User::model()->findByPk($_POST['clientId']);
            $user->attributes = $_POST['User'];
            $user->save();
        }
    }
    public function actionClientOrders()
    {
        if(isset($_POST['id']))
        {
            $orders = FixOrder::model()->findAllByAttributes(array('user_id' => $_POST['id']));

            $this->renderPartial('/admin/_orders', array('orders' => $orders));
        }
    }
    public function actionClientInfo()
    {
        if(isset($_POST['id']))
        {
            $user = User::model()->findByPk($_POST['id']);

            print json_encode($user->attributes);
        }
    }

    public function actionGetMastak()
    {
        if(isset($_POST['id']))
        {
            $mastak = Mastak::model()->findByPk($_POST['id']);
            if($mastak !== null)
            {
                $response = $mastak->attributes;
                $response['skills'] = $mastak->skillsDetail();
                $response['reviews'] = $this->renderPartial('/admin/_reviews', array('reviews' => MastakReview::model()->findAllByAttributes(array('mastak_id' => $_POST['id']))), true);
                print json_encode($response);
            }
        }
    }

    public function actionGetMastaks()
    {
        if(isset($_POST['search']))
        {
            $response = array();
            $mastaki = Mastak::model()->findAll(array(
                'condition' => "name LIKE '%".$_POST['search']."%' OR phone LIKE '%".$_POST['search']."%'",
            ));

            $this->renderPartial('/admin/_mastaki', array('mastaki' => $mastaki));
        }
    }

    public function actionSetMastakStatus()
    {
        if(isset($_POST['id']) && isset($_POST['status']))
        {
            $mastak = Mastak::model()->findByPk($_POST['id']);

            if($mastak !== null)
            {
                $mastak->status = $_POST['status'];
                $mastak->save();
            }
        }
    }

    public function actionAddMastakReview()
    {
        if(isset($_POST['id']) && isset($_POST['content']))
        {
            $mastakReview = new MastakReview();
            $mastakReview->content = $_POST['content'];
            $mastakReview->mastak_id = $_POST['id'];
            $mastakReview->created = $this->sqlDateTime();
            $mastakReview->save();
            print json_encode(array('date' => $mastakReview->created, 'content' => $_POST['content']));
        }
    }
    public function actionAddOrderComment()
    {
        if(isset($_POST['id']) && isset($_POST['content']))
        {
            $orderComment = new OrderComment();
            $orderComment->content = $_POST['content'];
            $orderComment->fix_order_id = $_POST['id'];
            $orderComment->created = $this->sqlDateTime();
            $orderComment->user_id = intval(Yii::app()->user->getId());
            $orderComment->save();
            print json_encode(array('date' => $orderComment->created, 'content' => $orderComment->content));
        }
    }
}