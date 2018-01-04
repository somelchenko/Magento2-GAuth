<?php

namespace SO\Gauthenticator\Observer;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\Plugin\AuthenticationException as PluginAuthenticationException;
use Otp\Otp;
use ParagonIE\ConstantTime\Encoding;

/**
 * Class SecretCodeCheck
 * @package SO\Gauthenticator\Observer
 */
class SecretCodeCheck implements ObserverInterface
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

    /**
     * SecretCodeCheck constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function __construct(
        RequestInterface $request
    )
    {
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
            $key = $this->_request->getParam('otp');
            $otp = new Otp();
            $secret = $user->getGoogleSecret();

            $checkResult = $otp->checkTotp(Encoding::base32Decode($secret), $key);
            if (!$checkResult) {
                throw new PluginAuthenticationException(__('Google Authenticator OTP is Incorrect.'));
            }
        }

        return $this;
    }
}
