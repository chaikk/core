{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order info
 *  
 * @author    Creative Development LLC <info@cdev.ru> 
 * @copyright Copyright (c) 2010 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version   SVN: $Id$
 * @link      http://www.litecommerce.com/
 * @since     3.0.0
 *}
<div class="order-title">
  Order #{order.order_id}, {time_format(order.date)}
  <div class="status-{order.status}">
    <widget template="common/order_status.tpl" />
  </div>
</div>

<div class="order-buttons">
  <a href="{buildUrl(#invoice#,##,_ARRAY_(#order_id#^order.order_id,#printable#^#1#))}" class="printable first"><img src="images/spacer.gif" alt="" /><span>Print invoice</span></a>
  |
  <a href="{buildUrl(#order_list#)}" class="last">Back to order list</a>
</div>

<hr class="tiny" />

<widget template="common/invoice.tpl" />

<div IF="order.notes" class="customer-note">
  <strong>Customer note:</strong>
  <div>{order.notes}</div>
</div>