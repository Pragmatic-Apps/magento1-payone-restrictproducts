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

                // check deviating addresses
                if (Mage::getStoreConfigFlag('payoneext_restrict/general/checkaddress')) {
                    $oBillingAddress = $_quote->getBillingAddress()->getData();
                    $oShippingAddress = $_quote->getShippingAddress()->getData();
                    $addressDiff = array_diff([
                        'firstname' => $oBillingAddress['firstname'],
                        'lastname' => $oBillingAddress['firstname'],
                        'company' => $oBillingAddress['company'],
                        'street' => $oBillingAddress['street'],
                        'postcode' => $oBillingAddress['postcode'],
                        'city' => $oBillingAddress['city'],
                        'country_id' => $oBillingAddress['country_id']
                    ], [
                        'firstname' => $oShippingAddress['firstname'],
                        'lastname' => $oShippingAddress['firstname'],
                        'company' => $oShippingAddress['company'],
                        'street' => $oShippingAddress['street'],
                        'postcode' => $oShippingAddress['postcode'],
                        'city' => $oShippingAddress['city'],
                        'country_id' => $oShippingAddress['country_id']
                    ]);
                    if ($addressDiff) {
                        $event->getResult()->isAvailable = false;
                        return;
                    }
                }

                // check items
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
