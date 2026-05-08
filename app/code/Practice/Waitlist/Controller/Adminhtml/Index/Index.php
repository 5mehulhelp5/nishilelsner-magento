<?php

namespace Practice\Waitlist\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;

class Index extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    protected $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Practice_Waitlist::waitlist_management');
        $resultPage->getConfig()->getTitle()->prepend(__('Waitlist Management'));
        return $resultPage;
    }
}
