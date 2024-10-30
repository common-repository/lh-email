=== LH Email ===
Contributors: shawfactor
Donate link: http://lhero.org/plugins/lh-email/
Tags: email, emails, newsletter, newsletters, posts, smtp, template
Requires at least: 3.0
Tested up to: 4.9
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

LH Email enables you send html emails based on your posts, directly from your WordPress dashboard.

== Description ==

This plugin allows you to send html formatted email message directly from your WordPress dashboard. These emails are based on the posts you create within WordPress. Optionally you can add content at the top and bottom.

These emails are formatted based on a template you can modify both by adding widgets and by editing the template in your theme or child theme.

== Installation ==

Install using WordPress:

1. Log in and go to *Plugins* and click on *Add New*.
2. Search for *LH Email* and hit the *Install Now* link in the results. WordPress will install it.
3. From the Plugin Management page in WordPress, activate the *LH Email* plugin.
4. Transfer the lh-email-post-template.php to you theme or child theme folder
5. Go to *Tools* -> *LH Email* in the WordPress menu and start sending emails

Install manually:

1. Download the plugin zip file and unzip it.
2. Upload the plugin contents into your WordPress installation*s plugin directory on the server. The plugins .php files, readme.txt and subfolders should be installed in the *wp-content/plugins/lh-email/* directory.
3. From the Plugin Management page in WordPress, activate the *LH Email* plugin.
4. Transfer the lh-email-post-template.php to you theme or child theme folder
5. Go to *Tools* -> *LH Email* in the WordPress menu and start sending emails

= Why is my email being sent to spam? =
WordPress by default send its email from the servers mail functionality. This probably won't match you domain so the emails end up in spam. I suggest you install a WordPress smtp plugin or use an email provider like Mandrill.

== Changelog ==



= 1.0 =
* Initial release

= 1.10 - March 28, 2016 =
* Better email handling

= 1.11 - January 23, 2018 =
* Send individual emails

= 1.12 - February 20, 2018 =
* Singleton pattern