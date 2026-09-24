=== Single Card Designs for Elementor ===
Contributors: nipunapathirana
Tags: elementor, card, product card, showcase, book
Requires at least: 5.8
Tested up to: 7.1
Requires PHP: 8.0
Stable tag: 1.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds a fully customizable "Single Card" widget to Elementor, with two selectable card templates.

== Description ==

Single Card Designs for Elementor adds one widget for building a standalone product/content showcase card — think a book, tour, or product highlight — with two selectable visual templates and full styling control from the Elementor editor.

Features:

* **Two templates**: Template 1 (Light) shows the image separated above a white content area; Template 2 (Image Overlay) uses the image as a full-bleed background with a dark gradient and white text.
* **Content**: image, any number of tags, an optional rating badge (icon + value), title, an optional highlight badge (e.g. "Top Rated"), description (up to 500 characters, auto-truncated at 120 with a "See More" toggle), an author/brand line, and a button — all editable per card.
* **Enable/disable toggles**: independently show or hide the rating, description, and button.
* **Card height**: an explicit, fully responsive height control (desktop/tablet/mobile).
* **Full style controls**: card background, border-radius, box-shadow, and padding; image height/position/border-radius and overlay gradient color; tag and rating badge colors/typography; title and badge colors/typography (independent defaults per template); description and author colors/typography; button background/text color with separate hover states, typography, border-radius, and padding; and decorative gallery-style dots (color, active color, count).
* Fully mobile responsive throughout.

= Requirements =

* Elementor (free) must be installed and active.

== Installation ==

1. Upload the `single-card-designs-for-elementor` folder to the `/wp-content/plugins/` directory, or install the plugin ZIP through **Plugins → Add New → Upload Plugin** in your WordPress admin.
2. Activate the plugin through the **Plugins** screen in WordPress.
3. Make sure Elementor is installed and active.
4. Edit any page with Elementor, search for **Single Card** in the widget panel, and drag it onto the page.

== Frequently Asked Questions ==

= Does this require Elementor Pro? =

No. It works with the free version of Elementor.

= Can I hide the description or button? =

Yes. Use the **Show Description** and **Show Button** switches in the Content tab.

= What's the difference between the two templates? =

Template 1 (Light) puts the image in its own panel above a plain content area. Template 2 (Image Overlay) uses the image as the card's full background with a dark gradient behind the text. Switch between them with the **Template** control at the top of the Content tab — title, badge, description, and author colors have independent defaults for each template so text stays readable either way.

= How does the description truncation work? =

The Description field accepts up to 500 characters. If the text is longer than 120 characters, the card shows the first 120 characters followed by a "See More" link — clicking it reveals the full text (up to 500 characters) in place, with no page reload, via a lightweight CSS-only toggle (no JavaScript). Text of 120 characters or fewer displays in full with no toggle.

== Changelog ==

= 1.1.0 =
* Removed the manual "Description Character Limit" control. Descriptions are now capped at 500 characters and automatically truncated at 120 characters with a "See More" / "See Less" toggle when longer.

= 1.0.0 =
* Initial release.
