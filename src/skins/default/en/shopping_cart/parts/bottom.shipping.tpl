{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Shopping cart shipping estimator
 *
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2011 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 * @since     1.0.0
 *}
<div class="shipping-estimator">
  <widget class="\XLite\View\Form\Cart\Main" name="shopping_form" />
    <widget template="shopping_cart/delivery.tpl">
    <noscript>
      <widget class="\XLite\View\Button\Submit" label="Submit" />
    </noscript>
  <widget name="shopping_form" end />
</div>
