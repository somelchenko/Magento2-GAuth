<?php

namespace SO\Gauthenticator\Observer;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\Plugin\AuthenticationException as PluginAuthenticationException;
use PHPGangsta_GoogleAuthenticator as GoogleAuth;

/**
 * Class SecretCodeCheck
 * @package SO\Gauthenticator\Observer
 */
class SecretCodeCheck implements ObserverInterface
{

    /**
     * @var \PHPGangsta_GoogleAuthenticator
     */
    protected $_ga;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

    /**
     * SecretCodeCheck constructor.
     * @param \PHPGangsta_GoogleAuthenticator $ga
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function __construct(
        GoogleAuth $ga,
        RequestInterface $request
    )
    {
        $this->_ga = $ga;
        $this->_request = $request;
    }

    /**
     * Check secret code
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     * @throws PluginAuthenticationException
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /**
         * @var $user \Magento\User\Model\User
         */
        $user = $observer->getUser();
        $userName = $observer->getUsername();

        $adminUser = $user->loadByUsername($userName);

        if ($adminUser->getEnableGauth() && $adminUser->getId()) {
            $code = $this->_request->getParam('otp');
            $checkResult = $this->_ga->verifyCode($user->getGoogleSecret(), $code, 2);
            if (!$checkResult) {
                throw new PluginAuthenticationException(__('Google Authenticator OTP is Incorrect.'));
            }
        }

        return $this;
    }
}
