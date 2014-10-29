<?php

class OrderController extends Controller
{

    public function actionCreateOrder()
    {
        if(isset($_POST['data']))
        {
            $data = json_decode($_POST['data'], true);
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

                //@todo Отправка SMS с паролем
            }

            $newFixOrder = new FixOrder();
            $newFixOrder->created = Core::now('sql');
            $newFixOrder->status = 'PENDING';
            $newFixOrder->user_id = $user->getPrimaryKey();
            $newFixOrder->save();

            foreach($data['orderedProblems'] as $problem)
            {
                $newOrderProblem = new OrderProblem();
                $newOrderProblem->fix_order_id = $user->getPrimaryKey();
                $newOrderProblem->device_problem_id = $problem;
                $newOrderProblem->save();
            }
            print json_encode(array('result' => 'SUCCESS'));
        }
        else
            print json_encode(array('result' => 'ERROR'));
    }
}