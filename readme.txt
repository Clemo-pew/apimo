=== Apimo Connector ===
Contributors:
Tags: real estate, property management, listings, clients, leads, showings, open houses, reports
Tested up to: 6.7.1
Stable tag: 2.6.3.1
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Are you a real estate agent or broker looking for a way to streamline your business operations? Look no further! Our plugin is here to help.

With Manage Real Estate Business, you can easily:

- List and manage properties for sale or rent
- Schedule and manage showings and open houses

Our plugin integrates seamlessly with your WordPress website and is user-friendly and intuitive. Start streamlining your real estate business today with Manage Real Estate Business!

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Use the plugin by going to the 'Apimo' menu in WordPress.
4. Obtain the token and 4-digit provider ID for API access from the Apimo support team.
5. In General Settings, add your API key: paste the token. In Company ID, paste the provider ID. Validate Key should display 'your keys are valid' (verify with support if this is not the case). Clear all data only if you want to change the agency connected to the site; it will erase all data imported from Apimo.
6. In Settings, add the slug for the individual product (single slug) and for the archive. They must be different. Choose main and secondary colors, primary labels and titles, and secondary price. In Container setting, choose the width of the page.
7. In Layout, choose the display of products (do not check 'Show unavailable services', it is only used for debugging). The number of columns in the product list is: desktop 2, tablet 2, mobile 1 (the site is not optimized for other choices).
8. Choose the search filters. In 'Number of posts per page', choose a multiple of 2. In 'Gallery display type', one of the two must be checked. Enable Meta fields and save.
9. In Apimo > Logs, launch the Run scheduler to retrieve products.
10. Customize the pages: See the site > Customize > add elements to the main menu of the site.
11. Shortcode: In Apimo > Apimo: generate the shortcode. This process will allow you to generate a selection of products or extract all buildings. To filter properties by category, do not select the filter in step 2. You will then choose the other filters and follow the steps of the plugin until the shortcode is generated. You can filter products by tags or manually select the products. In the site > + New > Create a new page, name it, paste the shortcode, and confirm. You can also generate shortcodes that filter by custom_tag (custom attributes).
12. To view all instructions, please see the Installation instructions file [Installation instruction](https://wordpress.org/plugins/).

== Frequently Asked Questions ==
 
= Is it possible to modify the custom post type name? =

The plugin does not allow modification of the post type for properties.

= Is it possible to change the slug of the listing properties and the single property pages? =

Yes, in the admin dashboard for the Apimo plugin, you can edit the slug.

= If I deactivate the plugin, will my properties be gone? =

No, disabling the plugin will not affect your properties. The only way to delete all properties is to uninstall the plugin. Activating the plugin should not overwrite your existing properties.

= How does the plugin handle multilingual properties with WPML activated? =

The plugin supports multilingual properties when WPML is activated. Properties can be imported in multiple languages, including:

- Arabic (ar)
- Bulgarian (bg_BG)
- Catalan (ca_ES)
- Corsican (co)
- Czech (cs_CZ)
- Danish (da_DK)
- German (de_DE, de_CH)
- Greek (el_GR)
- English (en_GB, en_US)
- Spanish (es_CL, es_CR, es_ES, es_PE, es_VE)
- Persian (fa_IR)
- Finnish (fi_FI)
- French (fr_BE, fr_CH, fr_FR)
- Hebrew (he_IL)
- Hungarian (hu_HU)
- Italian (it_IT)
- Japanese (ja_JP)
- Khmer (km_KH)
- Lao (lo_LA)
- Luxembourgish (lb_LU)
- Mongolian (mn_MN)
- Malay (ms_MY)
- Norwegian Bokmål (nb_NO)
- Dutch (nl_BE, nl_NL)
- Polish (pl_PL)
- Portuguese (pt_BR, pt_PT)
- Romanian (ro_RO)
- Russian (ru_RU)
- Slovak (sk_SK)
- Slovenian (sl_SI)
- Serbian (sr_RS)
- Swedish (sv_SE)
- Tamil (ta_IN)
- Thai (th_TH)
- Turkish (tr_TR)
- Ukrainian (uk_UA)
- Chinese (zh_CN)
- and more ...

= Is it possible to create just the search bar for the listing of properties? =

Yes, there is a shortcode to generate just the search bar without including the listing of properties. In the Generate Shortcode popup, at step 6, you have the option to select the type of shortcode you want to create: Apimo or Search shortcode. Use the Search shortcode to generate the search bar only.

= What types of personal data are collected? =

The plugin collects user identification information, such as full name, date of birth, telephone number, and job title, as well as information about the user's private or professional clients/prospects, including surname, first name, company name, postal address, and telephone number. Sensitive data such as racial or ethnic origin, political opinions, religious or philosophical beliefs, and trade union membership is not collected unless required by law.

= How can I customize the appearance of the property listings? =

You can customize the appearance of the property listings by going to the Apimo > Settings section in your WordPress dashboard. Here, you can select the colors, labels, titles, and container width. Additionally, you can choose the number of columns for the product list on different devices.

= Can I schedule automatic updates for the property listings? =

Yes, you can schedule automatic updates for the property listings. Go to Apimo > Logs and use the 'Run scheduler' option to retrieve products at regular intervals.

= How do I handle API errors? =

If you encounter API errors, first ensure that your token and provider ID are correctly entered and valid. If the problem persists, check the Apimo > Logs section for detailed error messages and contact Apimo support if needed.

= Can I filter properties by multiple criteria? =

Yes, you can filter properties by multiple criteria when generating shortcodes. Use the options in the Generate Shortcode popup to apply various filters like category, tags, and custom attributes.

= Is there a way to display properties in different languages? =

Yes, the plugin supports multilingual properties with WPML. You can import and display properties in multiple languages. Ensure WPML is activated and configured on your site.

= How can I add new fields to the property listings? =

To add new fields to the property listings, you can use the custom fields feature in WordPress. However, any additional fields will require custom development to ensure they integrate seamlessly with the Apimo Connector plugin.

= How do I change the order of properties in the listing? =

You can change the order of properties in the listing by modifying the order filter in the shortcode. Go to Apimo > Generate Shortcode, and select the desired order criteria.

= What should I do if my properties are not displaying correctly? =

If your properties are not displaying correctly, check the following:

1. Ensure your API keys are valid.
2. Verify that the shortcode is correctly generated and inserted into the page.
3. Check for conflicts with other plugins or themes.
4. Look at the Apimo > Logs section for any error messages.

= Can I export property data from the plugin? =

Currently, the plugin does not support exporting property data directly. You may need to use other tools or plugins to export data from your WordPress site.

= How do I reset the plugin settings? =

To reset the plugin settings, go to Apimo > General Settings and use the 'Clear all data' option. This will erase all data imported from Apimo and reset the plugin settings.

= Is it possible to import properties from a different platform? =

The plugin is specifically designed to work with the Apimo API. Importing properties from a different platform would require custom development to integrate the other platform's API with the plugin.

= How can I contact support if I have issues with the plugin? =

For support with the plugin, you can contact the Apimo support team through their official website or email. Ensure you have your token and provider ID ready for quicker assistance.

= How do I update the plugin to the latest version? =

To update the plugin to the latest version, go to your WordPress dashboard, navigate to Plugins > Installed Plugins, find the Apimo Connector plugin, and click 'Update Now' if an update is available. Ensure you have a backup of your site before updating to avoid any data loss.


== Screenshots ==

1. Generate Shortcode.
![Generate Shortcode](assets/screenshot-1.gif)

2. Listing Properties display.
![Listing Properties](assets/screenshot-2.png)

3. Single Property display.
![Single Property](assets/screenshot-3.png)

4. The Apimo Dashboard.
![Apimo Dashboard](assets/screenshot-4.png)

5. The Apimo Dashboard Settings.
![Apimo Dashboard Settings](assets/screenshot-5.png)



== Changelog ==

= 2.6.3 =
* Adding a contact form to properties and integrating reCAPTCHA v3.

= 2.6.2 =
* Fix Advanced filter for areas and services.

= 2.6 =
* Add more translations

= 2.5.9.3 =
* Fix translate

= 2.5.9.2 =
* Fix Responsive problem

= 2.5.9.1 =
* Fixed SQL query issue by ensuring the correct table prefix is used.
* Updated currency handling to display prices in the correct currency.

= 2.5.9 =
* Fix Display problem and shortcode filter problem

= 2.5.8.7 =
* Fix translate

= 2.5.8.6 =
* Fix some bugs

= 2.5.8.2 =
* Fix properties images display

= 2.5.8.1 =
* Fix some bugs

= 2.5.8 =
* Fix order By filter in the shortcode

= 1.0 =
* Initial release

== Upgrade Notice ==

= 1.0 =
Initial release.

== Assets ==
![Plugin Logo](assets/Apimologo.png)
