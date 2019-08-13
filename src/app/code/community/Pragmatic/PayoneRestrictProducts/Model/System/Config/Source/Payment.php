<?php

class Pragmatic_PayoneRestrictProducts_Model_System_Config_Source_Payment
{

    public function toOptionArray()
    {
        $methods = [];
        foreach (Mage::getSingleton('payment/config')->getAllMethods() as $paymentCode=>$paymentModel) {
            if (strpos($paymentCode, 'payone') > -1) {
                $paymentTitle = Mage::getStoreConfig('payment/'.$paymentCode.'/title');
                $methods[$paymentCode] = array(
                    'label'   => $paymentTitle,
                    'value' => $paymentCode,
                );
            }
        }
        return $methods;
    }

}