{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Country selector
 *
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2011 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 * @since     1.0.0
 *}
<select name="{field}" onchange="{onchange}" id="{fieldId}">
   <option value="">Select one..</option>
   <option FOREACH="getCountries(),v" value="{v.code:r}" selected="{v.code=country}">{v.country:h}</option>
</select>
