<?php
namespace Practice\Waitlist\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

class Delete extends Action
{
    /**
     * @var \Practice\Waitlist\Model\WaitlistFactory
     */
    protected $waitlistFactory;
    
    /**
     * Dependency Initilization
     *
     * @param Context $context
     * @param \Practice\Waitlist\Model\WaitlistFactory $waitlistFactory
     */
    public function __construct(
        Context $context,
        \Practice\Waitlist\Model\WaitlistFactory $waitlistFactory
    ) {
        $this->waitlistFactory = $waitlistFactory;
        parent::__construct($context);
    }

    /**
     * Provides content
     *
     * @return Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        try {
            $waitlistModel = $this->waitlistFactory->create();
            $waitlistModel->load($id);
            $waitlistModel->delete();
            $this->messageManager->addSuccessMessage(__('You deleted the waitlist.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Check Autherization
     *
     * @return boolean
     */
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Practice_Waitlist::delete');
    }
}