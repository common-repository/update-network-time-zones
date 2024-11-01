=== Plugin Name ===
Contributors: oiler
Donate link: http://donorschoose.org/
Tags: network, multisite, wpmu
Requires at least: 2.8
Tested up to: 3.2.1
Stable tag: 1.0

Automatically change the time zone for all of the blogs on your multisite network. Not for single installations. WPMU / Multisite / Network only. 

== Description ==

Update at once all of the Settings -> General -> Time Zone options of your WordPress network.

This plugin was written specifically for a network that has been around for many years and was set up before WordPress 2.8 fixed the daylight savings time issue. Back then, setting the local time for your blog depended on UTC offsets only, so daylight savings folks were off by an hour for half a year. Then WordPress introduced time zones by city and the problem was solved. But we had all our blogs still with the UTC offset in use. So rather than update them individually, this plugin was written to run once and then move on. Recommended use: upload to your mu-plugins folder, run it once and then delete.

== Installation ==

This is intended to be a 'use once and delete' plugin. 
Install in either your regular plugins folder or in the mu-plugins.

1. Upload 'update-timezones.php' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Visit YOURDOMAIN/wp-admin/network/settings.php?page=timezone to run it
4. Delete it when you're done

== Frequently Asked Questions ==

= How many time zones does it support =

Right now I only wrote it to update any of the four continental United States time zones. But it's easy to add more. Just stick them in the select options form area in the same format as the four that are already there.

== Screenshots ==

1. Network Admin page that you'll use to run plugin

== Changelog ==

= 1.0 =
* Initial version

