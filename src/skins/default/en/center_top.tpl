{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Center-top region
 *
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2010 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version   SVN: $Id$
 * @link      http://www.litecommerce.com/
 * @since     3.0.0
 *}
<!-- [catalog] {{{ -->
<widget class="XLite_View_Category" />
<widget class="XLite_View_Product" />
<!-- [/catalog] }}} -->

<!-- [main] {{{ -->
<widget target="main" mode="accessDenied" template="access_denied.tpl">
<widget module="GreetVisitor" target="main" mode="" template="modules/GreetVisitor/greet_visitor.tpl" visible="{greetVisitor&!page}">
<widget class="XLite_View_Welcome" name="welcome" />
<widget target="main" template="pages.tpl">
<!-- [/main] }}} -->

<!-- [help] {{{ -->
<widget target="help" mode="terms_conditions" template="common/dialog.tpl" body="terms_conditions.tpl" head="Terms & Conditions">
<widget target="help" mode="privacy_statement" template="common/dialog.tpl" body="privacy_statement.tpl" head="Privacy statement">
<widget target="recover_password" mode="" template="common/dialog.tpl" head="Forgot password?" body="recover_password.tpl">
<widget target="recover_password" mode="recoverMessage" template="common/dialog.tpl" head="Recover password" body="recover_message.tpl">
<widget target="help" mode="contactus" template="common/dialog.tpl" body="contactus.tpl" head="Contact us">
<widget target="help" mode="contactusMessage" template="common/dialog.tpl" body="contactus_message.tpl" head="Message is sent">
<!-- [/help] }}} -->

<!-- [shopping_cart] {{{ -->
<widget class="XLite_View_Cart" />
<!-- [/shopping_cart] }}} -->

<!-- [profile] {{{ -->
<widget target="profile" mode="login" template="common/dialog.tpl" head="Authentication" body="authentication.tpl">
<widget target="profile" mode="account" template="common/dialog.tpl" head="Your account" body="account.tpl">
<widget target="login" template="common/dialog.tpl" body="authentication.tpl" head="Authentication">
<widget target="profile" mode="register" class="XLite_View_RegisterForm" head="New customer" name="registerForm" IF="!showAV" />
<widget target="profile" mode="success" template="common/dialog.tpl" head="Registration complete" body="register_success.tpl">

{* It's only the test *}
<widget target="profile" mode="modify" class="XLite_View_Model_Profile_Modify" IF="!showAV" />
{*<widget target="profile" mode="modify" class="XLite_View_RegisterForm" head="Modify profile" name="profileForm" IF="!showAV" />*}


<widget target="profile" mode="delete" template="common/dialog.tpl" head="Delete profile - Confirmation" body="delete_profile.tpl">
<!-- [/profile] }}} -->

<!-- [checkout] {{{ -->
<widget class="XLite_View_Checkout" />

<widget target="checkoutSuccess" template="checkout/success.tpl" />
<widget module="GoogleCheckout" template="common/dialog.tpl" body="modules/GoogleCheckout/google_checkout_dialog.tpl" head="Google Checkout payment module" visible="{target=#googlecheckout#&!valid}" />
<!-- [/checkout] }}} -->

<!-- [order] {{{ -->
<widget class="XLite_View_OrderSearch" />
<widget class="XLite_View_Order" />
<widget class="XLite_View_Invoice" />
<!-- [/order] }}} -->

<!-- [modules] {{{ -->
<widget module="GiftCertificates" class="XLite_Module_GiftCertificates_View_AddGiftCertificate" />
<widget module="GiftCertificates" class="XLite_Module_GiftCertificates_View_Ecards" />
<widget module="GiftCertificates" class="XLite_Module_GiftCertificates_View_CheckGiftCertificate" />
<widget module="GiftCertificates" target="gift_certificate_info" template="common/dialog.tpl" body="modules/GiftCertificates/gift_certificate_info.tpl" head="Gift certificate">
<widget module="AdvancedSearch" class="XLite_Module_AdvancedSearch_View_AdvancedSearchCenter" />
<widget module="WishList" target="wishlist,product" mode="MessageSent" template="common/dialog.tpl" body="modules/WishList/message.tpl" head="Message has been sent">
<widget module="WishList" target="wishlist" head="Wish List" template="common/dialog.tpl" body="modules/WishList/wishlist.tpl">
<widget module="ProductAdviser" template="modules/ProductAdviser/center_top.tpl" />
<!-- [/modules] }}} -->

<!-- [search] {{{ -->
<widget class="XLite_View_SearchResult" />
<!-- [/search] }}} -->