{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product details information block
 *
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2011 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 * @since     1.0.0
 *
 * @ListChild (list="product.details.page", weight="40")
 *}

<div class="tabs">
  <ul class="tabs primary">
    <li class="active"><a href="#description" class="active">{t(#Description#)}</a></li>
    <!--li><a href="#taf">{t(#Tell a friend#)}</a></li>
    <li><a href="#cr">{t(#Customer reviews#)}</a></li>
    <li><a href="#rp">{t(#Related products#)}</a></li-->
  </ul>
</div>

{displayViewListContent(#product.details.page.tabs#)}
