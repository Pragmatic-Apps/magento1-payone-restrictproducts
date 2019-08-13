# Magento (v1): Payone Disable Methods for certain Products
This extension extends the [Payone Payment extension](https://github.com/PAYONE-GmbH/magento-1) with the possibility to automatically disable certain payment methods if particular products are in the shopping cart.
This feature is necessary to comply with the requirements of some payment provides (e.g. when you are not allowed to sell certain products, like coupons, via specific payment methods, like installment)
The extension listens to the *payment_method_is_active* event and checks if the method is restricted and if there is a certain SKU in the cart.

## Installation

### Modman
You can easily clone this repo with modman. Learn more in the modman wiki at https://github.com/colinmollenhour/modman/wiki/Tutorial

```
$ modman clone https://github.com/trendmarke-gmbh/magento1-payone-restrictproducts
```

### Manual installation
Alternatively you can download the repo and transfer the content of the src directory into your Magento root directory. After the installation clear the cache and that's it.

## Configuration
You find the configuration as a new section in the Payone tab. You can set:
* ** Enable product restriction:** Activate the restriction check at all
* **  Payment methods to check:** Multiselect of the payment methods that should be restricted
* **  Disallowed SKUs:** A comma-seperated list of SKUs that should be restricted

## Customization
Feel free to edit and change the extensions as you wish. 

## Notes and Credits
- This extension was tested with Magento 1.9.x but it should also work with older versions (probably till 1.4.x).