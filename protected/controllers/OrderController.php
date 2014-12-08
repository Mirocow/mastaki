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
                    $sms = new SMS();
                    $result = $sms->send('7'.str_replace(')','',str_replace(' ','',str_replace('-','',str_replace('(','',$data['phone'])))), 'Ваш пароль в сервис-центре Mastaki.pro '.$user->open_pass.' . Мы рады приветствовать вас, '.$data['name'].'!');

                    $userPhone = $user->phone;
                    $userPassword = $user->open_pass;

                }

                $newFixOrder = new FixOrder();
                $newFixOrder->created = Core::now('sql', 'datetime');
                $newFixOrder->status = 'PENDING';
                $newFixOrder->user_id = $user->getPrimaryKey();
                $newFixOrder->to = $data['date'];
                $newFixOrder->save();

                $first = true;
                foreach($data['orderedProblems'] as $problem)
                {
                    $newOrderProblem = new OrderProblem();
                    $newOrderProblem->fix_order_id = $newFixOrder->getPrimaryKey();
                    $newOrderProblem->device_problem_id = $problem;
                    $newOrderProblem->save();
                    if($first)
                    {
                        $deviceProblem = DeviceProblem::model()->findByPk($problem);
                        if($deviceProblem)
                        {
                            $sms = new SMS();
                            $result = $sms->send('7'.str_replace(')','',str_replace(' ','',str_replace('-','',str_replace('(','',$data['phone'])))), $data['name'].'Ваш заказ на ремонт '.$deviceProblem->device->name.' получен. Ваш личный мастер свяжется с вами. № '.$newFixOrder->getPrimaryKey());
                        }
                    }
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
        {
            $condition = "(t.id = '".$_POST['filter']."' OR user.name LIKE '%".$_POST['filter']."%')";
            if($_POST['status'] !== 'ALL')
                $condition .= " AND t.status = '".$_POST['status']."'";
        }

        $orders = FixOrder::model()->findAll(array(
            'condition' => $condition,
            'with' => array('user'),
        ));
        $this->renderPartial('/admin/_ordersExt', array('orders' => $orders));
    }
    public function actionAjaxGetOrder()
    {
        $id = $_POST['id'];
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

        $response['comments'] = $this->renderPartial('/admin/_reviews', array('reviews' => OrderComment::model()->findAllByAttributes(array('fix_order_id' => $id))), true);
        $response['output']   = $this->renderPartial('_order', array('data' => $order), true);
        $response['problems'] = CHtml::listData(DeviceProblem::model()->findAllByAttributes(array('device_id' => FixOrder::model()->findByPk($id)->getDevice())), 'id', 'problem.name');
        print json_encode($response);
    }

    public function actionAjaxSaveOrder()
    {
        if(isset($_POST['data']))
        {
            $data = json_decode($_POST['data']);
            $order = FixOrder::model()->findByPk($data->orderId);

            if($data->mastakId != 0)
                $order->mastak_id = $data->mastakId;
            else
                $order->mastak_id = null;
            $oldStatus = $order->status;
            if($oldStatus !== $data->orderStatus)
            {
                $orderStatuses = Core::orderStatuses();
                $sms = new SMS();
                $result = $sms->send('7'.str_replace(')','',str_replace(' ','',str_replace('-','',str_replace('(','',$order->user->phone)))), $order->user->name.', статус Вашего заказа на ремонт '.$order->deviceProblems[0]->device->name.' изменился на '.$orderStatuses[$data->orderStatus]);
            }
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

    public function actionDeleteOrderProblem()
    {
        if(isset($_POST['orderProblemId']))
        {
            $response = array();

            $orderProblem = OrderProblem::model()->findByPk($_POST['orderProblemId']);
            if($orderProblem !== null)
            {
                $orderId = $orderProblem->fix_order_id;
                $orderProblem->delete();

                $order = FixOrder::model()->findByPk($orderId);
                if($order !== null)
                {
                    $response['totalPrice'] = $order->getTotalPrice();
                    $response['totalDiscount'] = $order->getTotalDiscount();
                    $response['orderId'] = $order->getPrimaryKey();

                    print json_encode($response);
                }
            }
        }
    }
}