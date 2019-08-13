<?php
class Pragmatic_PayoneRestrictProducts_Model_Observer
{

    /**
     * Validate if certain products are not allowed in this payment method
     *
     * @param Varien_Event_Observer $observer
     */
    public function isPaymentMethodAvailable(Varien_Event_Observer $observer)
    {
        $event = $observer->getEvent();
        if (Mage::getStoreConfigFlag('payoneext_restrict/general/active') && $event->getResult()->isAvailable === true) {
            $_restricted_methods = explode(',', Mage::getStoreConfig('payoneext_restrict/general/methods'));
            $_quote_method = $event->getMethodInstance();
            if (in_array($_quote_method->getCode(), $_restricted_methods)) {
                $_event_quote =  $event->getQuote();
                $_quote = (!is_null($_event_quote)) ? $_event_quote :  Mage::getSingleton('checkout/cart')->getQuote();
                $_restricted_items = explode(',', Mage::getStoreConfig('payoneext_restrict/general/skipskus'));
                foreach ($_quote->getAllItems() as $item)
                {
                    $_sku = $item->getSku();
                    if (in_array($_sku, $_restricted_items)) {
                        $event->getResult()->isAvailable = false;
                        break;
                    }
                }
            }
        }
    }

}
