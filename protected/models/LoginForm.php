<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
    public $phone;
    public $password;

    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that login and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // login and password are required
            array('phone', 'required', 'message' => 'Введите телефон'),
            array('password', 'required', 'message' => 'Введите пароль'),
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels($labelName = null)
    {
        $labels = array(
            'phone' => 'Телефон',
            'password' => 'Пароль',
        );
        if(!$labelName)
            return $labels;
        else
            return $labels[$labelName];
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute,$params)
    {
        if(!$this->hasErrors())
        {
            $this->_identity = new UserIdentity($this->phone,$this->password);
            if(!$this->_identity->authenticate())
                $this->addError('password','Неверный телефон или пароль');
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login()
    {
        if($this->_identity===null)
        {
            $this->_identity=new UserIdentity($this->phone,$this->password);
            $this->_identity->authenticate();
        }
        if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
        {
            //@todo тута мы непосредственно фигачим куки
            //$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
            $duration = 0;
            Yii::app()->user->login($this->_identity,$duration);
            return true;
        }
        else
            return false;
    }
}