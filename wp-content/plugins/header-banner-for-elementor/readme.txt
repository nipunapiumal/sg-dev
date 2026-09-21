=== Header Banner for Elementor ===
Contributors: nipunapathirana
Tags: elementor, header, banner, hero, page title
Requires at least: 5.8
Tested up to: 7.1
Requires PHP: 8.0
Stable tag: 1.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds a fully customizable "Header Banner" widget to Elementor — a page-header/hero section with a static or dynamic title.

== Description ==

Header Banner for Elementor adds a single widget for building page-header/hero banners: a background image (or color) with a title on top, fully styleable from the Elementor editor.

Features:

* **Title source**: static text you type yourself, or dynamic — automatically pulls the current page/post title, the site title, or the site tagline, so the same banner works across many pages.
* **Background**: any image from the Media Library, with image size/position controls, plus an adjustable color overlay for text readability.
* **Title styling**: color, full typography controls (font family, size, weight, line-height, letter-spacing — all responsive), alignment, and max-width.
* **Layout controls**: min-height, padding, margin, and border-radius — all independently responsive per breakpoint (desktop/tablet/mobile) — plus a box-shadow control.
* Fully mobile responsive throughout.

= Requirements =

* Elementor (free) must be installed and active.

== Installation ==

1. Upload the `header-banner-for-elementor` folder to the `/wp-content/plugins/` directory, or install the plugin ZIP through **Plugins → Add New → Upload Plugin** in your WordPress admin.
2. Activate the plugin through the **Plugins** screen in WordPress.
3. Make sure Elementor is installed and active.
4. Edit any page with Elementor, search for **Header Banner** in the widget panel, and drag it onto the page.

== Frequently Asked Questions ==

= Does this require Elementor Pro? =

No. It works with the free version of Elementor.

= What does "Dynamic" title do? =

Set **Title Source** to **Dynamic** and pick **Current Page / Post Title** to have the banner automatically show the title of whichever page it's placed on (useful inside a template applied to many pages), or pick **Site Title**/**Site Tagline** to pull those instead.

= Can the background use the page's featured image instead of a fixed image? =

Yes. Set **Background Image Source** (Style tab → Background) to **Featured Image**, and the banner will automatically use whichever page/post it's placed on's featured image — handy inside a single template applied across many pages. If that page has no featured image, no background image is shown. Switch back to **Media Library** at any time to pick a fixed image instead.

== Changelog ==

= 1.1.0 =
* Added a "Background Image Source" option: choose between the Media Library (pick any image) or the page/post's Featured Image (automatically follows whichever page the banner is placed on). Both share the same Image Size control.

= 1.0.0 =
* Initial release.
