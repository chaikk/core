{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product element
 *
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2011 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version   GIT: $Id$
 * @link      http://www.litecommerce.com/
 * @since     3.0.0
 * @ListChild (list="product.modify.list", weight="120")
 *}
<tr>
  <td valign="top">{t(#Brief Description#)}</td>
  <td valign="top">
    <textarea name="{getNamePostedData(#brief_description#)}" cols="45" rows="6">{product.brief_description:h}</textarea>
  </td>
</tr>