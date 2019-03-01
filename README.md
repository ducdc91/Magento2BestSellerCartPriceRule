# Best seller position as Condition and Action in Cart Price Rule - Magento 2
---

This is a sample Magento 2 module allow admin can add Best seller position as Condition and Action in Cart Price Rule.

[![License: GPL v3](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

## Main Features

* Add "Best Seller Top" in Condition of cart price rule
* Add "Best Seller Top" in Action of cart price rule
* Use `sales_bestsellers_aggregated_daily` table to check item in cart is best seller or not.

## Configure and Manage

* No configuration


## Installation without Composer

* Download the files from github: [Direct download link](https://github.com/ducdc91/Magento2BestSellerCartPriceRule/tarball/master)
* Extract archive and copy all directories to app/code/Shopstack/BestSellerCartRule
* Go to project home directory and execute these commands

```bash
php bin/magento setup:upgrade
php bin/magento di:compile
php bin/magento setup:static-content:deploy
```

## Licence

[Open Software License (OSL 3.0)](http://opensource.org/licenses/osl-3.0.php)