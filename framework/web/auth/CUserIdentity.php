<?php
/**
 * CUserIdentity class file
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CUserIdentity is a base class for representing identities that are authenticated based on a phone and a password.
 *
 * Derived classes should implement {@link authenticate} with the actual
 * authentication scheme (e.g. checking phone and password against a DB table).
 *
 * By default, CUserIdentity assumes the {@link phone} is a unique identifier
 * and thus use it as the {@link id ID} of the identity.
 *
 * @property string $id The unique identifier for the identity.
 * @property string $name The display name for the identity.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package system.web.auth
 * @since 1.0
 */
class CUserIdentity extends CBaseUserIdentity
{
    /**
     * @var string phone
     */
    public $phone;
    /**
     * @var string password
     */
    public $password;

    /**
     * Constructor.
     * @param string $phone phone
     * @param string $password password
     */
    public function __construct($phone,$password)
    {
        $this->phone=$phone;
        $this->password=$password;
    }

    /**
     * Authenticates a user based on {@link phone} and {@link password}.
     * Derived classes should override this method, or an exception will be thrown.
     * This method is required by {@link IUserIdentity}.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        throw new CException(Yii::t('yii','{class}::authenticate() must be implemented.',array('{class}'=>get_class($this))));
    }

    /**
     * Returns the unique identifier for the identity.
     * The default implementation simply returns {@link phone}.
     * This method is required by {@link IUserIdentity}.
     * @return string the unique identifier for the identity.
     */
    public function getId()
    {
        return $this->phone;
    }

    /**
     * Returns the display name for the identity.
     * The default implementation simply returns {@link phone}.
     * This method is required by {@link IUserIdentity}.
     * @return string the display name for the identity.
     */
    public function getName()
    {
        return $this->phone;
    }
}
