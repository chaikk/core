{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Invoice tax total
 *
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2010 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version   SVN: $Id$
 * @link      http://www.litecommerce.com/
 * @since     3.0.0
 * @ListChild (list="invoice.totals", weight="30")
 *}
<td>Tax cost:</td>
<td class="total">{price_format(order,#tax_cost#):h}</td>