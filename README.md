Magento Prerender Extension
===========================

This extension enable Google Chrome Prerender functionnality on your Magento 
site. This functionality allow you to prerender another page after viewed page
is loaded. You can then for example load next page of a category while firt page
is being viewed by customer.

## Features
There are 2 modes for calculating prerender links: Guessing mode and Based on 
Logs mode.

In Guessing Mode:

 * you can set prerender links for CMS page
 * Prerender links for category pages will be the next page.

In Based Log Mode, prerender link will be the most often next page viewed.

## Installation
1. Install extension through Magento downloader or with pear. Extension can be 
found on [Magento Prerender page][1].
2. Refresh Cache
3. You can set which mode you want to use for calculating prerender links in
BO System > Configuration > System > Prerender Options

## Compatibility
This extension is compatible with:

 * Magento CE 1.5 and 1.6
 * Magento PE 1.10 and 1.11
 * Magento EE 1.10 and 1.11

## Locales
Extension available in:

 * English
 * French

## Tests
For using selenimum tests, disable "Add secret key to urls" option in BO (System > Configuration > Admin > Security)

## Bug Reports
If you find a bug, [you can create a ticket][2].

## More information
Check [Magento Prerender page][1] for more details.

You can find details about prerender links in [Google Chrome Labs][3]

## Licence
Magento Prerender Extension is licensed under AFL 3.0 license.

[1]: http://www.magentocommerce.com/magento-connect/laurent35240/extension/7921/prerender
[2]: https://github.com/laurent35240/Magento-Prerender/issues
[3]: http://code.google.com/chrome/whitepapers/prerender.html