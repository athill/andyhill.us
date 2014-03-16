This file last modified: 03/31/12.
Theme Name: darkbasic
Theme URI: http://demo.lunaz.com
Description: Simple blue, dark gray and black theme with 1 sidebar, a fluid layout, and no artsy stuff. This theme supports widgets and header images.
Author: luna
Author URI: http://www.lunaz.com
Version: 1.4
License: GNU General Public License v2.0
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: blue,black,silver,dark,two-columns,right-sidebar,sticky-post,custom-header

Notes:

-This is my first theme and I'm late to the CMS party. :) Please bring issues to my attention as I'm still learning.
-Print styles included in style.css.
-I'm not exactly sure what the point of post_thumbnails is, but it's supported.
-There's room for facebook & tweet buttons in footer.php using id: div#likeme.
-Tried to validate as much as possible for XHTML 1.0 Strict.

Issues

-Comment_form() does not validate because of attribute 'aria-required'. Hope it becomes standard...
-Large images that use the max-width & height rules look cruddy in IE.
-Links that are in .post p a will not have the gray hover background most other links have. Unaligned uncaptioned linked images in the same class will have a gray background on hover. Getting rid of margins/padding/borders will still leave a ~3px gray hover. The only other solution I got working was to set display: block;, which isn't what I wanted. This is commented in the style.css.
-No translations done, I don't understand enough of the documentation to do it, and know no other languages. Text domain issues in single.php, page.php, index.php.