{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * ____file_title____
 *
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2011 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 * @since     1.0.0
 *}
{if:order.isSelected(#status#,#Q#)}Queued{end:}
{if:order.isSelected(#status#,#P#)}Processed{end:}
{if:order.isSelected(#status#,#I#)}Incomplete{end:}
{if:order.isSelected(#status#,#F#)}Failed{end:}
{if:order.isSelected(#status#,#D#)}Declined{end:}
{if:order.isSelected(#status#,#C#)}Complete{end:}
