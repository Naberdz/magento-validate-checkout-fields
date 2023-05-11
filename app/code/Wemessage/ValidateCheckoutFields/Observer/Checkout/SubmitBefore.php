<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Wemessage\ValidateCheckoutFields\Observer\Checkout;

class SubmitBefore implements \Magento\Framework\Event\ObserverInterface
{

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        $order = $observer->getEvent()->getOrder();

        $billingAddress = $order->getBillingAddress();
        $shippingAddress = $order->getShippingAddress();

        foreach($billingAddress->getData() as $key => $value){
            if($value) $billingAddress->setData($key, trim(preg_replace('~{{(.*)}}~s', '', $value)));
        }

        foreach($shippingAddress->getData() as $key => $value){
            if($value) $shippingAddress->setData($key, trim(preg_replace('~{{(.*)}}~s', '', $value)));
        }

        $order->setCustomerLastname(trim(preg_replace('~{{(.*)}}~s', '',  $order->getCustomerLastname())));
        $order->setCustomerFirstname(trim(preg_replace('~{{(.*)}}~s', '', $order->getCustomerFirstname())));

        return $this;
    }
}

