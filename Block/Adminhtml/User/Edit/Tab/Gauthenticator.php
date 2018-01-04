<?php

namespace SO\Gauthenticator\Block\Adminhtml\User\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Config\Model\Config\Source\Yesno;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use PHPGangsta_GoogleAuthenticator as GoogleAuth;

/**
 * Class Gauthenticator
 * @package SO\Gauthenticator\Block\Adminhtml\User\Edit\Tab
 */
class Gauthenticator extends Generic implements TabInterface
{

    /**
     * @var Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Config\Model\Config\Source\Yesno
     */
    protected $_yesno;

    /**
     * @var \PHPGangsta_GoogleAuthenticator
     */
    protected $_ga;

    /**
     * Gauthenticator constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Config\Model\Config\Source\Yesno $yesno
     * @param \PHPGangsta_GoogleAuthenticator $ga
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Yesno $yesno,
        GoogleAuth $ga,
        array $data = []
    )
    {
        $this->_coreRegistry = $registry;
        $this->_yesno = $yesno;
        $this->_ga = $ga;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Check is readonly block
     *
     * @return boolean
     */
    public function isReadonly()
    {
        return false;
    }

    /**
     * Retrieve product
     *
     * @return \Magento\Catalog\Model\Product
     */
    public function getProduct()
    {
        return $this->_coreRegistry->registry('current_product');
    }

    /**
     * Get tab label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Google Authenticator');
    }

    /**
     * Get tab title
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Google Authenticator');
    }

    /**
     * Check if tab can be displayed
     *
     * @return boolean
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Check if tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Exception
     */
    protected function _prepareForm()
    {
        /** @var $model \Magento\User\Model\User */
        $model = $this->_coreRegistry->registry('permissions_user');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('user_');

        $baseFieldset = $form->addFieldset('ga_fieldset', ['legend' => __('Google Authenticator ')]);
        $yesnoSource = $this->_yesno->toOptionArray();

        if ($model->getEnableGauth()) {
            $qrHtml = '<span style="color:green; font-size: 16px">' . __('For scan new QR code disable and re enable google Authenticator') . '</span>';
        } else {
            $secret = $this->_ga->createSecret();

            $domain = $this->_request->getUri()->getHost();
            $qrCodeUrl = $this->_ga->getQRCodeGoogleUrl($domain . ' Admin Page', $secret);

            $qrHtml = '<span style="color:red; font-size: 20px">' . __('Scan QR code before enable authorization and closing the page!!') . '</span> <br><img src="' . $qrCodeUrl . '" />';

            $model->setGoogleSecret($secret);
            $baseFieldset->addField('google_secret', 'hidden', ['name' => 'google_secret']);
        }

        $baseFieldset->addField(
            'enable_gauth',
            'select',
            [
                'name'   => 'enable_gauth',
                'label'  => __('Enable'),
                'title'  => __('Enable'),
                'values' => $yesnoSource,
                'note'   => $qrHtml
            ]
        );

        $data = $model->getData();
        $form->setValues($data);

        $this->setForm($form);

        return parent::_prepareForm();
    }
}