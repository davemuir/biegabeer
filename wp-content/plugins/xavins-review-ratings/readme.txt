=== Xavin's Review Ratings ===
Contributors: XavinNydek
Donate link: http://www.jonathanspence.com/software/wordpress-plugins/xavins-review-ratings/
Tags: page, pages, post, formatting, shortcode, rating, ratings
Requires at least: 2.5.1
Tested up to: 2.7
Stable tag: 1.3

Adds a shortcode tag [xrr rating=4/5] that displays a rating in one of several formats. Intended for
sites doing reviews.

== Description ==

This plugin adds a shortcode tag that will display a rating in one of several formats. Here is a 
feature breakdown:

* Input ratings as a fraction (4/5) or a percentage (80%).
* Use any amount of stars from 2 to 100.
* Set the minimal star fraction allowed, whole, half or quarter.
* Split multiple ratings in one post/page into groups, and have a separate overall rating
calculated for each.
* Display the rating as image stars, text stars, a percentage, a fraction, or any combination.
* Multiple star image sets included, others can be easily added.
* Fully templatized output, use whatever tags you want.
* Optionally group ratings in a table or other structure.
* Settings page for global settings and tag defaults.

The only required parameter is rating, the rest are optional. Here is a basic example.
`[xrr rating=4/5]`

This will convert the 60% into a fraction and display it as text stars:
`[xrr rating=60% display_as=textstars]`

This will display 10 stars from the tiny_star image set and label the rating 'Movie Rating:':
`[xrr rating=7.25/10 imageset=tiny_star label="Movie Rating:"]`

Check the Tag Options section for complete options.

The global settings on the settings page are documented there.

= 1.3.1 = 
* Fixed a harmless error message that could sometimes appear on the settings page.
* Added the ability to always show the decimal place on a fraction.

= 1.3 =
This is mainly an update to the admin side, although I added a few more imagesets.

* Plugin now searches for locations of imagesets in the plugin directory and in the uploads/xavins-review-ratings directory.
* Image extension is also auto-detected now.
* Removed the Image Path setting since it is now redunant.
* Removed the Image Extension setting since it is now redundant.
* Templatized the `<img>` tag, all html is now templatized
* Added documentation of the settings page for the templates.
* Added reset to defaults button.
* Detected imagesets now appear on the settings page.
* Added three new imagesets.

== Installation ==

1. Upload the `xavins-review-ratings` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place `[xrr rating=4/5]` in your pages. Check the 
[plugin homepage](http://www.jonathanspence.com/software/wordpress-plugins/xavins-review-ratings/) 
for complete documentation and inline examples.

== Frequently Asked Questions ==

= How do I add custom image sets? =
Upload a directory containing the five star images in png, jpg, or gif format into your wp-content/uploads/xavins-review-ratings
directory. If you put the correct files in the right place, the plugin will detect it and show them on the settings screen. You
can look in the plugin directory to find the correct file names. The imageset directory name can be whatever you want, as long as
it doesn't conflict with another imageset. You also only need the star images you plan on using, if you are only going to be 
showing whole or blank stars, you only need those two images.

== Screenshots ==

1. Some example ratings.
2. The Image Sets that come with the plugin.

== Tag Options ==
Each of these can have their defaults changed on the settings page, or be changed in each tag. You can mix and match 
display styles and options in the same post/page.

**rating**

The `rating` attribute is required in every xrr tag unless there is an `overall` attribute. Both fractions and percentages are valid inputs.
Any fraction is acceptable, the rating is converted to an intermediate format and then to the specified output format. Unless explicitly
overridden with the `max_stars` attribute, the plugin assumes you want to use the denominator of the fraction as the number of 
stars, so 4/5 would display 5 stars, and 3/10 would display ten stars. 

**max_stars**

The `max_stars` attribute sets the maximum number of stars the rating will be displayed with. You can set it implicitly by using `rating`
with a fraction, or explicitly with the `max_stars` attribute.

For exaple, the following tag will display as seven stars even though the fraction used is out of 5:
`[xrr rating=4/5 max_stars=7]`

**display_as**

The `display_as` attribute determines for the rating will be displayed. The four basic outputs are 'stars', 'percentage',
'fraction', and 'textstars', and they are pretty self explanatory. The basic outputs can also be combined with an underscore
to display two or more at once, for example this tag will display the fraction and then the image stars:
`[xrr rating= 4.5/5 display_as=fraction_stars]`
 
**label**

The `label` attribute sets the label in front of the rating display. Make sure to surround the value with quotes if it contains a space.

**group**

The `group` attribute sets what named group the rating is in. By default all ratings are in an xrr group. The only use for the group
currently is for `overall` calculations. Note: This is entirely independent of the `[xrrgroup]` tag.
 
**overall**

The `overall` attribute has one valid value, 'true'. If set it will ignore any `rating` attribute in the tag and instead calculate 
the average of all the ratings on the post/page that have the same `group`.

**imageset**

The `imageset` attribute determines what set of star images to use. The imagesets are auto-detected, either in the plugin directory
for the imagesets that come with the plugin, or in the wp-content/uploads/xavins-review-ratings/ directory for imagesets you add.
All usable imagesets are detected and displayed on the settings page.

**fraction_separator**

The `fraction_separator` attribute determines the separator between the numerator and denominator when displaying ratings as a 
fraction. By default it is '/', although another common option would be ' of '.

**max_fraction**

The `max_fraction` attribute sets how far stars can be broken up, there are three valid values, none=1 half=2 quarter=4. If you set it
to 1, all ratings will be calculated out of whole stars, and if you set it to 4 they will be calculated to quarter stars, etc. 

**always_show_decimal**

The 'always_show_decimal' attribute determines whether a decimal should always be shown when displaying a fraction. For
example, `3/5` would render as `3.0/5.0`. Possible values are 'true' and 'false'.

== The [xrrgroup] Tag ==
The `[xrrgroup][/xrrgroup]` tag has no options and is used to activate group rendering in the `[xrr]` tags it surrounds.
By default it renders all the contained `[xrr]` tags in a table, but this can be changed by modifying the templates on
the settings screen. Here is an example:

`[xrrgroup][xrr rating=4/5 label="DVD:"][xrr rating=3/5 label="Movie:"][/xrrgroup]`

There are some things to keep in mind. Don't put line breaks inside the `[xrrgroup]` tags, since Wordpress doesn't properly recognize
being inside a shortcode tag, and will insert `<p>` tags that will make your HTML invalid. Also, the `[xrrgroup]` tag is entirely independent
of the `group` attribute in the `[xrr]` tag.

== Full Changelog == 
= 1.3.1 = 
* Fixed a harmless error message that could sometimes appear on the settings page.
* Added the ability to always show the decimal place on a fraction.

= 1.3 =
This is mainly an update to the admin side, although I added a few more imagesets.

* Plugin now searches for locations of imagesets in the plugin directory and in the uploads/xavins-review-ratings directory.
* Image extension is also auto-detected now.
* Removed the Image Path setting since it is now redunant.
* Removed the Image Extension setting since it is now redundant.
* Templatized the `<img>` tag, all html is now templatized
* Added documentation of the settings page for the templates.
* Added reset to defaults button.
* Detected imagesets now appear on the settings page.
* Added three new imagesets.

= 1.2 =
* First Public Release
