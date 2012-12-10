<?php

// This file is part of the Carrington Text Theme for WordPress
// http://carringtontheme.com
//
// Copyright (c) 2008-2009 Crowd Favorite, Ltd. All rights reserved.
// http://crowdfavorite.com
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
// **********************************************************************

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }
if (CFCT_DEBUG) { cfct_banner(__FILE__); }

?>
<div id="post-<?php the_ID(); ?>">
	<div class="title"><h1 class="entry-title full-title"><a href="<?php the_permalink() ?>" title="Permanent link to <?php the_title_attribute() ?>" rel="bookmark" rev="post-<?php the_ID(); ?>"><?php the_title() ?></a></h1>
	<span class="date full-date"><?php the_date(); ?></span></div>
<?php

the_excerpt();

?>
	<div class="meta"><?php the_time('M j, Y'); ?> &mdash; 

<?php

comments_popup_link(__('No comments', 'carrington-text'), __('1 comment', 'carrington-text'), __('% comments', 'carrington-text'));

?>
	</div>
</div><!-- .excerpt -->