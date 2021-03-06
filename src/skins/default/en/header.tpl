{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Page head
 *
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2011 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 * @since     1.0.0
 *}

<head profile="http://www.w3.org/1999/xhtml/vocab">
  <title>{getTitle()}</title>

  <meta http-equiv="Content-Type" content="text/html; charset={getCharset():h}" />
  <meta http-equiv="Content-Style-Type" content="text/css" />
  <meta http-equiv="Content-Script-Type" content="text/javascript" />
  <meta name="Generator" content="Litecommerce 3 (http://litecommerce.com)" />
  <meta IF="getMetaDescription()" name="description" content="{getMetaDescription():r}" />
  <meta IF="getKeywords()" name="keywords" content="{getKeywords():r}" />

  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

  <link FOREACH="getCSSResources(),file" href="{file.url}" rel="stylesheet" type="text/css" media="{file.media}" />

  <script type="text/javascript">
var xliteConfig = {
  script:   '{getScript():h}',
  language: '{currentLanguage.getCode()}'
};
  </script>
  <script FOREACH="getJSResources(),file" type="text/javascript" src="{file.url}"></script>

  {displayViewListContent(#head#)}
</head>
