=== Card Carousel for Elementor ===
Contributors: nipunapathirana
Tags: elementor, carousel, slider, cards, swiper
Requires at least: 5.8
Tested up to: 7.1
Requires PHP: 8.0
Stable tag: 1.7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds a Swiper-powered "Card Carousel" widget to Elementor, with a manual card builder or a dynamic post/taxonomy source.

== Description ==

Card Carousel for Elementor adds a single, flexible widget to the Elementor editor: a carousel of media cards, styled either as a classic image-and-text card ("Media & Text") or a full-bleed photo card with an overlay gradient ("Image Overlay").

Features:

* Two card styles: Media & Text and Image Overlay.
* Two content sources:
  * Manual — build cards by hand with a repeater (image, title, subtitle, description, badges, link).
  * Posts (Dynamic) — pull cards automatically from any public post type on the site, optionally filtered by any taxonomy term(s) or a hand-picked list of posts.
  * Optional per-card category label, with a toggle to show or hide it.
* Configurable description character limit with clean, word-boundary truncation.
* Full carousel controls: slides per view (responsive), spacing, loop, autoplay, pause on hover, transition speed, arrows and/or dot navigation.
* Full Elementor style controls for card background, border radius, shadows, padding, typography, colors, and navigation arrow/dot styling.
* Built entirely on Elementor's own Swiper.js integration — no extra libraries loaded.

= Requirements =

* Elementor (free) must be installed and active.

== Installation ==

1. Upload the `card-carousel-for-elementor` folder to the `/wp-content/plugins/` directory, or install the plugin ZIP through **Plugins → Add New → Upload Plugin** in your WordPress admin.
2. Activate the plugin through the **Plugins** screen in WordPress.
3. Make sure Elementor is installed and active.
4. Edit any page with Elementor, search for **Card Carousel** in the widget panel, and drag it onto the page.

== Frequently Asked Questions ==

= Does this require Elementor Pro? =

No. It works with the free version of Elementor.

= Can I use my own posts/custom post types instead of manual cards? =

Yes. Set **Card Source** to **Posts (Dynamic)** in the widget's Cards section, then choose a post type and, optionally, one or more taxonomy terms to filter by.

= Can I hide the category label on dynamic cards? =

Yes. When using the **Posts (Dynamic)** source, turn off the **Show Category** switch in the Posts Source settings.

== Changelog ==

= 1.7.4 =
* Maintenance release: added Plugin URI / Author URI, and moved the WordPress.org listing-icon source files into the plugin folder (excluded from the packaged ZIP).

= 1.7.3 =
* Updated the plugin icon used for the WordPress.org listing (prepared as properly sized icon-128x128.png / icon-256x256.png assets).

= 1.7.2 =
* Cached the dynamic Posts source's category/taxonomy query in a transient (15 minutes) to resolve the Plugin Check "possible slow query" warning on tax_query.

= 1.7.1 =
* Fixed the plugin slug to match the WordPress.org listing: main file, folder, and text domain are now card-carousel-for-elementor.
* Updated "Tested up to" to 7.1.

= 1.7.0 =
* Raised the minimum required PHP version to 8.0, with an admin notice (instead of a fatal error) on unsupported hosting.
* Renamed the plugin internally — files, classes, constants, hooks, and CSS classes.

= 1.6.1 =
* Fixed image cropping (object-fit/object-position) to prevent stretching regardless of the selected image size.
* Fixed a plugin asset registration mismatch that could prevent the widget's stylesheet from loading.

= 1.6.0 =
* Added a "Show Category" toggle for the dynamic Posts source.

= 1.5.0 =
* Added a description character limit control.
* Added the button/link text element to the Media & Text card style.

= 1.4.0 =
* Generalized the dynamic data source to support any public post type and any taxonomy.

= 1.3.0 =
* Added a dynamic Posts data source alongside the manual card repeater.

= 1.2.0 =
* Fixed navigation arrow clipping by restructuring the carousel markup.

= 1.1.1 =
* Fixed navigation arrow positioning.

= 1.1.0 =
* Added the Image Overlay card style.
* Fixed spacing between carousel cards.

= 1.0.0 =
* Initial release.

== Upgrade Notice ==

= 1.7.3 =
Updated plugin listing icon.
