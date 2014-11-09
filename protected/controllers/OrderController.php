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

            $response['position'] = count($order->orderProblems) + 1;
            $response['name'] = $deviceProblem->problem->name;
            $response['device'] = Device::model()->findByPk($order->getDevice())->name;
            $response['price'] = $deviceProblem->getTotalPrice();
            $response['discount'] = $orderProblem->discount;
            $response['status'] = Html::getProblemStatus($orderProblem->status);
            print json_encode($response);
        }
    }
}