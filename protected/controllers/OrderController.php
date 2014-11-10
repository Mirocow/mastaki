<?php

class OrderController extends Controller
{

    public function actionCreateOrder()
    {
        $errorName = 0;
        $errorPhone = 0;
        $userPhone = null;
        $userPassword = null;
        if(isset($_POST['data']))
        {
            $data = json_decode($_POST['data'], true);
            if ($data['name'] !== '' && $data['phone'] !== '')
            {
                $user = User::model()->findByAttributes(array('phone' => $data['phone']));
                if($user === null)
                {
                    $user = new User();
                    $user->phone = $data['phone'];
                    $user->name = $data['name'];
                    $user->open_pass = Core::generatePassword();
                    $user->role = 'USER';
                    $user->password = md5($user->open_pass);
                    $user->save();

                    //@todo Отправка SMS с паролем, пока вместо этого вывод на экран

                    $userPhone = $user->phone;
                    $userPassword = $user->open_pass;

                }

                $newFixOrder = new FixOrder();
                $newFixOrder->created = Core::now('sql');
                $newFixOrder->status = 'PENDING';
                $newFixOrder->user_id = $user->getPrimaryKey();
                $newFixOrder->save();

                foreach($data['orderedProblems'] as $problem)
                {
                    $newOrderProblem = new OrderProblem();
                    $newOrderProblem->fix_order_id = $newFixOrder->getPrimaryKey();
                    $newOrderProblem->device_problem_id = $problem;
                    $newOrderProblem->save();
                }
                print json_encode(array('result' => 'SUCCESS', 'userPhone' => $userPhone, 'userPassword' => $userPassword));
            }
            else
            {
                if($data['name'] =='')
                    $errorName = 1;
                if($data['phone'] == '')
                    $errorPhone = 1;

                print json_encode(array('result' => 'ERROR', 'errorName' => $errorName, 'errorPhone' => $errorPhone));
            }
        }
        else
            print json_encode(array('result' => 'ERROR'));
    }

    public function actionAjaxGetOrders()
    {
        $response = array();
        $condition = '';
        if(isset($_POST['filter']))
            $condition = "t.id = '".$_POST['filter']."' OR user.name LIKE '%".$_POST['filter']."%'";

        $orders = FixOrder::model()->findAll(array(
            'condition' => $condition,
            'with' => array('user'),
        ));

        foreach($orders as $order)
            $response[] = array('id' => $order->id, 'name' => $order->user->name, 'status' => $order->status);

        print json_encode($response);
    }
    public function actionAjaxGetOrder($id)
    {
        $response = array();
        $order = FixOrder::model()->find(array(
            'condition' => 't.id = :id',
            'params' => array(':id' => $id),
            'with' => array(
                'orderProblems' => array(
                    'with' => array(
                        'deviceProblem' => array(
                            'with' => array('device', 'problem'),
                        )
                    ),
                ),
                'user',
            ),
        ));

        $response['output'] = $this->renderPartial('_order', array('data' => $order), true);
        $response['problems'] = CHtml::listData(DeviceProblem::model()->findAllByAttributes(array('device_id' => FixOrder::model()->findByPk($id)->getDevice())), 'id', 'problem.name');
        print json_encode($response);
    }

    public function actionAjaxSaveOrder()
    {
        if(isset($_POST['data']))
        {
            $data = json_decode($_POST['data']);
            $order = FixOrder::model()->findByPk($data->orderId);
            $order->status = $data->orderStatus;
            $order->save();

            $totalPrice = 0;
            $orderProblems = OrderProblem::model()->with('deviceProblem')->findAllByAttributes(array('fix_order_id' => $order->getPrimaryKey()));
            foreach($orderProblems as $orderProblem)
                $totalPrice += $orderProblem->deviceProblem->price;

            foreach($data->problemStatuses as $problemStatus)
            {
                $dbProblemStatus = OrderProblem::model()->findByPk($problemStatus->id);
                $dbProblemStatus->status = $problemStatus->status;
                $dbProblemStatus->discount = $problemStatus->discount;
                $dbProblemStatus->save();
            }
            $newPrice = $order->getTotalPrice();
            $newDiscount = $order->getTotalDiscount();
            print json_encode(array('result' => 'SUCCESS', 'orderId' => $order->getPrimaryKey(), 'newPrice' => $newPrice, 'newDiscount' => $newDiscount));
        }
        else
            print json_encode(array('result' => 'ERROR'));

    }

    public function actionAjaxAddProblemToOrder()
    {
        $response = array();
        if(isset($_POST['data']))
        {
            $data = json_decode($_POST['data']);

            $order = FixOrder::model()->findByPk($data->orderId);
            $deviceProblem = DeviceProblem::model()->findByPk($data->problemId);
            $orderProblem = new OrderProblem();
            $orderProblem->device_problem_id = $deviceProblem->getPrimaryKey();
            $orderProblem->fix_order_id = $order->getPrimaryKey();
            $orderProblem->save();

            $response['problemId'] = $orderProblem->getPrimaryKey();
            $response['position'] = count($order->orderProblems);
            $response['name'] = $deviceProblem->problem->name;
            $response['device'] = Device::model()->findByPk($order->getDevice())->name;
            $response['price'] = $deviceProblem->getTotalPrice();
            $response['discount'] = '<div class="input-group input-group-sm">
                <input type="text" class="form-control discount" size="2" value="'.$orderProblem->discount.'"/>
                <span class="input-group-addon">%</span>
            </div>';
            $response['status'] = CHtml::dropDownList('problemStatus', $orderProblem->status, Core::problemStatuses(), array('class' => 'form-control input-sm problem-status-select','order-problem-id' => $orderProblem->getPrimaryKey()));
            print json_encode($response);
        }
    }
}