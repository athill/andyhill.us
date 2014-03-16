<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {
	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = 'Teal';
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	
	$magpro_slider_start = array("false" => __("No", 'Teal' ),"true" => __("Yes", 'Teal' ));
	$homecat_array = array("hori" => __("Horizontal Layout", 'Teal' ),"verti" => __("Vertical Layout", 'Teal' ));
	
	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = __("Select a page:", 'Teal' );
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri(). '/admin/images/';
		
	$options = array();
		
		
							
	$options[] = array( "name" => "country1",
						"type" => "innertabopen");	

		$options[] = array( "name" => __("Select a Skin", 'Teal' ),
							"type" => "groupcontaineropen");	

				$options[] = array( "name" => __("Select a Skin", 'Teal' ),
										"desc" => __("Images for skins.", 'Teal' ),
										"id" => "skin_style",
										"type" => "images",
										"std" => "darky",
										"options" => array(
											'teal' => $imagepath . 'Teal.png',
											'azurite' => $imagepath . 'azurite.png',
											'oren' => $imagepath . 'oren.png',
											'bred' => $imagepath . 'bred.png',
											'gren' => $imagepath . 'gren.png',
											'rubia' => $imagepath . 'rubia.png',
											'aqua' => $imagepath . 'aqua.png',
											'bgre' => $imagepath . 'bgre.png',
											'blby' => $imagepath . 'blby.png',
											'blbr' => $imagepath . 'blbr.png',
											'brow' => $imagepath . 'brow.png',
											'yrst' => $imagepath . 'yrst.png',
											'grun' => $imagepath . 'grun.png',
											'kafe' => $imagepath . 'kafe.png',
											'darky' => $imagepath . 'darky.png',)
										);						

										
		$options[] = array( "type" => "groupcontainerclose");



		$options[] = array( "name" => __("Logo Settings", 'Teal' ),
							"type" => "groupcontaineropen");	

				$options[] = array( "name" => __("Upload Logo", 'Teal' ),
									"desc" => __("Upload your logo here. max width 450px, It will replace the blog title and description.", 'Teal' ),
									"id" => "header_logo",
									"type" => "proupgrade");	
									
				$options[] = array( "name" => __("Upload FavIcon", 'Teal' ),
									"desc" => __("Upload your favicon here.", 'Teal' ),
									"id" => "favicon",
									"type" => "proupgrade");														

										
		$options[] = array( "type" => "groupcontainerclose");	
		

		$options[] = array( "name" => __("Adsense Settings", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Google Adsense ID", 'Teal' ),
										"desc" => __("Enter your full adsense id. Ex : pub-1234567890", 'Teal' ),
										"id" => "google_adsense_id",
										"std" => "",
										"type" => "proupgrade");		
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Single Page Settings", 'Teal' ),
							"type" => "groupcontaineropen");	
							
					$options[] = array( "name" => __("Show Featured Image?", 'Teal' ),
										"desc" => __("Select yes if you want to show featured image as header.", 'Teal' ),
										"id" => "show_featured_image_single",
										"std" => "false",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Ratings?", 'Teal' ),
										"desc" => __("Select yes if you want to show ratings under post title.", 'Teal' ),
										"id" => "show_rat_on_single",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);										
										
					$options[] = array( "name" => __("Show Posted by and Date?", 'Teal' ),
										"desc" => __("Select yes if you want to show Posted by and Date under post title.", 'Teal' ),
										"id" => "show_pd_on_single",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);											
										
					$options[] = array( "name" => __("Show Categories and Tags?", 'Teal' ),
										"desc" => __("Select yes if you want to show categories under post title.", 'Teal' ),
										"id" => "show_cats_on_single",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
										
					$options[] = array( "name" => __("Show Social Share Buttons?", 'Teal' ),
										"desc" => __("Select yes if you want to show social buttons under post title.", 'Teal' ),
										"id" => "show_socialbuts_on_single",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);																	

					$options[] = array( "name" => __("Show Author Bio", 'Teal' ),
										"desc" => __("Select yes if you want to show Author Bio Box on single post page.", 'Teal' ),
										"id" => "show_author_bio",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show RSS Box", 'Teal' ),
										"desc" => __("Select yes if you want to show RSS box on single post page.", 'Teal' ),
										"id" => "show_rss_box",
										"std" => "true",
										"type" => "select",
										"options" => $magpro_slider_start);		
										
					$options[] = array( "name" => __("Show Social Box", 'Teal' ),
										"desc" => __("Select yes if you want to show social box on single post page.", 'Teal' ),
										"id" => "show_social_box",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Next/Previous Box", 'Teal' ),
										"desc" => __("Select yes if you want to show Next/Previous box on single post page.", 'Teal' ),
										"id" => "show_np_box",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Related Posts Box", 'Teal' ),
										"desc" => __("Select yes if you want to show Next/Previous box on single post page.", 'Teal' ),
										"id" => "show_related_box",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);																																								
										
		$options[] = array( "type" => "groupcontainerclose");						
		
		
		
	$options[] = array( "type" => "innertabclose");	


	$options[] = array( "name" => "country2",
						"type" => "innertabopen");	
						
		$options[] = array( "name" => __("Social Settings", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Twitter", 'Teal' ),
										"desc" => __("Enter your twitter id", 'Teal' ),
										"id" => "twitter_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Redditt", 'Teal' ),
										"desc" => __("Enter your reddit url", 'Teal' ),
										"id" => "redit_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Delicious", 'Teal' ),
										"desc" => __("Enter your delicious url", 'Teal' ),
										"id" => "delicious_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Technorati", 'Teal' ),
										"desc" => __("Enter your technorati url", 'Teal' ),
										"id" => "technorati_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Facebook", 'Teal' ),
										"desc" => __("Enter your facebook url", 'Teal' ),
										"id" => "facebook_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Stumble", 'Teal' ),
										"desc" => __("Enter your stumbleupon url", 'Teal' ),
										"id" => "stumble_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Youtube", 'Teal' ),
										"desc" => __("Enter your youtube url", 'Teal' ),
										"id" => "youtube_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Flickr", 'Teal' ),
										"desc" => __("Enter your flickr url", 'Teal' ),
										"id" => "flickr_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("LinkedIn", 'Teal' ),
										"desc" => __("Enter your linkedin url", 'Teal' ),
										"id" => "linkedin_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Google", 'Teal' ),
										"desc" => __("Enter your google url", 'Teal' ),
										"id" => "google_id",
										"std" => "",
										"type" => "text");

							
		$options[] = array( "type" => "groupcontainerclose");											
														
	$options[] = array( "type" => "innertabclose");
	
	
	$options[] = array( "name" => "country3",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("Custom Header", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show custom Header?", 'Teal' ),
										"desc" => __("Selecting yes will show custom header instead of slider", 'Teal' ),
										"id" => "custom_header_home",
										"std" => "false",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);
										
		$options[] = array( "type" => "groupcontainerclose");						
						
		$options[] = array( "name" => __("Slider Settings", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Select Category", 'Teal' ),
										"desc" => __("Posts from this category will be shown in the slider.", 'Teal' ),
										"id" => "magpro_slidercat",
										"std" => "true",
										"type" => "select",
										"options" => $options_categories);
					
					$options[] = array( "name" => __("Show slider on homepage", 'Teal' ),
										"desc" => __("Select yes if you want to show slider on homepage.", 'Teal' ),
										"id" => "show_magpro_slider_home",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);
										
					$options[] = array( "name" => __("Show slider on Single post page", 'Teal' ),
										"desc" => __("Select yes if you want to show slider on Single post page.", 'Teal' ),
										"id" => "show_magpro_slider_single",
										"std" => "false",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show slider on Pages", 'Teal' ),
										"desc" => __("Select yes if you want to show slider on Pages.", 'Teal' ),
										"id" => "show_magpro_slider_page",
										"std" => "false",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show slider on Category Pages", 'Teal' ),
										"desc" => __("Select yes if you want to show slider on Category Pages.", 'Teal' ),
										"id" => "show_magpro_slider_archive",
										"std" => "false",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);																														
					
					$options[] = array( "name" => __("Auto Start?", 'Teal' ),
										"desc" => __("Select yes if you want the slider to start scrolling automaticaly on page load. Only applies to Accordian and Botique sliders.", 'Teal' ),
										"id" => "magpro_slider_auto",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);
										
					$options[] = array( "name" => __("How many slides?", 'Teal' ),
										"desc" => __("Enter a number. Ex: 5 or 7", 'Teal' ),
										"id" => "magpro_slidernumposts",
										"std" => "5",
										"class" => "mini",
										"type" => "text");										

					$options[] = array( "name" => __("Pause Duration", 'Teal' ),
										"desc" => __("Time between slide changes. 1000 is 1 Second", 'Teal' ),
										"id" => "magpro_slider_time",
										"std" => "7000",
										"type" => "proupgrade");

										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Sliders Available in PRO Version", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Upgrade now for these Sliders", 'Teal' ),
										"desc" => __("Available in PRO", 'Teal' ),
										"id" => "magpro_slider_upgrade",
										"std" => "anything",
										"type" => "proimages",
										"options" => array(
											'nivo' => $imagepath . 'nivo.png',
											'camera' => $imagepath . 'camera.png',
											'piecemaker' => $imagepath . 'piecemaker.png',
											'accordian' => $imagepath . 'accordian.png',
											'boutique' => $imagepath . 'boutique.png',	
											'boutiquetwo' => $imagepath . 'boutiquevid.png',	
											'caroufredsel' => $imagepath . 'ken.png',
											'sliderkit' => $imagepath . 'ruby.png',	
											'wilto' => $imagepath . 'wilto.png',																							
											'wiltovideo' => $imagepath . 'wiltovid.png')
										);				

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");	
	
								

	$options[] = array( "name" => "country4",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("Layout Settings", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Select a homepage layout", 'Teal' ),
										"desc" => __("Images for layout.", 'Teal' ),
										"id" => "homepage_layout",
										"std" => "mag",
										"type" => "images",
										"options" => array(
											'mag' => $imagepath . 'mag.png',
											'standard' => $imagepath . 'standard.png')
										);					

										
		$options[] = array( "type" => "groupcontainerclose");		
		
		$options[] = array( "name" => __("Layouts Available in PRO", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Upgrade now for these layouts.", 'Teal' ),
										"desc" => __("UpGrade Now.", 'Teal' ),
										"id" => "homepage_layout_upgrade",
										"std" => "",
										"type" => "proimages",
										"options" => array(
											'magpro' => $imagepath . 'magpro.png',
											'magvideo' => $imagepath . 'magvid.png',											
											'maglite' => $imagepath . 'maglite.png',
											'mag' => $imagepath . 'mag.png',
											'magthree' => $imagepath . 'magthree.png',
											'magfour' => $imagepath . 'magfour.png',
											'magfive' => $imagepath . 'magfive.png',
											'magsix' => $imagepath . 'magsix.png',
											'magseven' => $imagepath . 'magseven.png',
											'mageight' => $imagepath . 'mageight.png',
											'standard' => $imagepath . 'standard.png')
										);					

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");		
	
	$options[] = array( "name" => "country6",
						"type" => "innertabopen");

		$options[] = array( "name" => __("MagPro Settings", 'Teal' ),
							"type" => "tabheading");

	
		
		$options[] = array( "name" => __("Recent Posts", 'Teal' ),
							"type" => "groupcontaineropen");	


					$options[] = array( "name" => __("How Many Recent Posts?", 'Teal' ),
										"desc" => __("Enter a number like 7 or 10", 'Teal' ),
										"id" => "magpro_recent_posts_num",
										"std" => "10",
										"type" => "proupgrade");
										
		$options[] = array( "type" => "groupcontainerclose");			
		
		$options[] = array( "name" => __("Video Settings", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Videos", 'Teal' ),
										"desc" => __("Select yes if you want to show videos.", 'Teal' ),
										"id" => "magpro_show_videos",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);

					$options[] = array( "name" => __("Select a Category", 'Teal' ),
										"desc" => __("For posts in this category, You need to create a custom field called video and enter the url to video in its value field", 'Teal' ),
										"id" => "magpro_show_videos_cat",
										"type" => "proupgrade",
										"options" => $options_categories);


					$options[] = array( "name" => __("How many Videos", 'Teal' ),
										"desc" => __("How many Videos would you like to show.", 'Teal' ),
										"id" => "magpro_show_videos_num",
										"std" => "3",
										"type" => "proupgrade");
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Top Rated/Most Popular", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Top Rated/Most popular box ?", 'Teal' ),
										"desc" => __("Select yes or no", 'Teal' ),
										"id" => "magpro_show_mostbox",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);


					$options[] = array( "name" => __("How many Posts", 'Teal' ),
										"desc" => __("How many posts would you like to show.", 'Teal' ),
										"id" => "magpro_show_mostboxnum",
										"std" => "10",
										"type" => "proupgrade");
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Gallery", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Gallery?", 'Teal' ),
										"desc" => __("Select yes or no", 'Teal' ),
										"id" => "magpro_show_gallery",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);

					$options[] = array( "name" => __("Which Gallery?", 'Teal' ),
										"desc" => __("Enter the gallery ID", 'Teal' ),
										"id" => "magpro_galid",
										"std" => "",
										"type" => "proupgrade");


					$options[] = array( "name" => __("How many Images?", 'Teal' ),
										"desc" => __("Enter the number of images you would like to show", 'Teal' ),
										"id" => "magpro_galnum",
										"std" => "10",
										"type" => "proupgrade");
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Category Boxes", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Category Boxes", 'Teal' ),
										"desc" => __("Select yes or no", 'Teal' ),
										"id" => "magpro_show_catbox",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);

					$options[] = array( "name" => __("Which Layout", 'Teal' ),
										"desc" => __("Select horizontal or vertical", 'Teal' ),
										"id" => "magpro_show_catbox_which",
										"std" => "hori",
										"type" => "proupgrade",
										"options" => $homecat_array);


					$options[] = array( "name" => __("Which Categories?", 'Teal' ),
										"desc" => __("Enter the category ID's seperated by comma. Ex : 1, 7, 20", 'Teal' ),
										"id" => "magpro_catbox_id",
										"std" => "",
										"type" => "proupgrade");
										
					$options[] = array( "name" => __("How many posts per box?", 'Teal' ),
										"desc" => __("Enter a number. Ex : 1, 7, 20", 'Teal' ),
										"id" => "magpro_catbox_num",
										"std" => "7",
										"type" => "proupgrade");										
										
		$options[] = array( "type" => "groupcontainerclose");						
		
									
						
	$options[] = array( "type" => "innertabclose");		


	$options[] = array( "name" => "country12",
						"type" => "innertabopen");
		
		$options[] = array( "name" => __("Video Mag Settings", 'Teal' ),
							"type" => "tabheading");
		
						
	
		
		$options[] = array( "name" => __("Recent Tab Settings", 'Teal' ),
							"type" => "groupcontaineropen");	
										
					$options[] = array( "name" => __("Show Recent Videos Tab?", 'Teal' ),
										"desc" => __("Select yes if you want to show Recent Videos tab in the homepage", 'Teal' ),
										"id" => "video_mag_recent",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	

					$options[] = array( "name" => __("How many posts?", 'Teal' ),
										"desc" => __("Enter a number. Ex : 1, 7, 20", 'Teal' ),
										"id" => "video_mag_recent_num",
										"std" => "7",
										"type" => "proupgrade");

					$options[] = array( "name" => __("Select the Layout Type", 'Teal' ),
										"desc" => __("Images for layout.", 'Teal' ),
										"id" => "video_mag_recent_layout",
										"std" => "vidrecentone",
										"type" => "proupgrade",
										"options" => array(
											'vidrecentone' => $imagepath . 'vidone.png',
											'vidrecenttwo' => $imagepath . 'vidtwo.png',
											'vidrecentthree' => $imagepath . 'vidthree.png',
											'vidrecentfour' => $imagepath . 'vidfour.png')
										);																								
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Top Rated Settings", 'Teal' ),
							"type" => "groupcontaineropen");	
										
					$options[] = array( "name" => __("Show Top Rated Videos Tab?", 'Teal' ),
										"desc" => __("Select yes if you want to show Top Rated Videos tab in the homepage", 'Teal' ),
										"id" => "video_mag_toprated",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	

					$options[] = array( "name" => __("How many posts?", 'Teal' ),
										"desc" => __("Enter a number. Ex : 1, 7, 20", 'Teal' ),
										"id" => "video_mag_toprated_num",
										"std" => "7",
										"type" => "proupgrade");

					$options[] = array( "name" => __("Select the Layout Type", 'Teal' ),
										"desc" => __("Images for layout.", 'Teal' ),
										"id" => "video_mag_toprated_layout",
										"std" => "vidtopratedone",
										"type" => "proupgrade",
										"options" => array(
											'vidtopratedone' => $imagepath . 'vidone.png',
											'vidtopratedtwo' => $imagepath . 'vidtwo.png',
											'vidtopratedthree' => $imagepath . 'vidthree.png',
											'vidtopratedfour' => $imagepath . 'vidfour.png')
										);																								
										
		$options[] = array( "type" => "groupcontainerclose");		
		
		$options[] = array( "name" => __("Most Popular Settings", 'Teal' ),
							"type" => "groupcontaineropen");	
										
					$options[] = array( "name" => __("Show Top Rated Videos Tab?", 'Teal' ),
										"desc" => __("Select yes if you want to show Top Rated Videos tab in the homepage", 'Teal' ),
										"id" => "video_mag_most",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	

					$options[] = array( "name" => __("How many posts?", 'Teal' ),
										"desc" => __("Enter a number. Ex : 1, 7, 20", 'Teal' ),
										"id" => "video_mag_most_num",
										"std" => "7",
										"type" => "proupgrade");

					$options[] = array( "name" => __("Select the Layout Type", 'Teal' ),
										"desc" => __("Images for layout.", 'Teal' ),
										"id" => "video_mag_most_layout",
										"std" => "vidmostone",
										"type" => "proupgrade",
										"options" => array(
											'vidmostone' => $imagepath . 'vidone.png',
											'vidmosttwo' => $imagepath . 'vidtwo.png',
											'vidmostthree' => $imagepath . 'vidthree.png',
											'vidmostfour' => $imagepath . 'vidfour.png')
										);																							
										
		$options[] = array( "type" => "groupcontainerclose");			
		
		$options[] = array( "name" => __("Favourite Tab Settings", 'Teal' ),
							"type" => "groupcontaineropen");	
										
					$options[] = array( "name" => __("Show Favourite Videos Tab?", 'Teal' ),
										"desc" => __("Select yes if you want to show Favourite Videos tab in the homepage", 'Teal' ),
										"id" => "video_mag_fav",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Select Category", 'Teal' ),
										"desc" => __("Posts from this category will be shown in the Favourites tab.", 'Teal' ),
										"id" => "video_mag_fav_cat",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $options_categories);

					$options[] = array( "name" => __("How many posts?", 'Teal' ),
										"desc" => __("Enter a number. Ex : 1, 7, 20", 'Teal' ),
										"id" => "video_mag_fav_num",
										"std" => "7",
										"type" => "proupgrade");

					$options[] = array( "name" => __("Select the Layout Type", 'Teal' ),
										"desc" => __("Images for layout.", 'Teal' ),
										"id" => "video_mag_fav_layout",
										"std" => "vidfavone",
										"type" => "proupgrade",
										"options" => array(
											'vidfavone' => $imagepath . 'vidone.png',
											'vidfavtwo' => $imagepath . 'vidtwo.png',
											'vidfavthree' => $imagepath . 'vidthree.png',
											'vidfavfour' => $imagepath . 'vidfour.png')
										);																					
										
		$options[] = array( "type" => "groupcontainerclose");		
									
		$options[] = array( "name" => __("Category Boxes", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Category Boxes", 'Teal' ),
										"desc" => __("Select yes or no", 'Teal' ),
										"id" => "video_mag_show_catbox",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);

					$options[] = array( "name" => __("Which Categories?", 'Teal' ),
										"desc" => __("Enter the category ID's seperated by comma. Ex : 1, 7, 20", 'Teal' ),
										"id" => "video_mag_catbox_id",
										"std" => "",
										"type" => "proupgrade");
										
					$options[] = array( "name" => __("How many posts per box?", 'Teal' ),
										"desc" => __("Enter a number. Ex : 1, 7, 20", 'Teal' ),
										"id" => "video_mag_catbox_num",
										"std" => "2",
										"type" => "proupgrade");										
										
		$options[] = array( "type" => "groupcontainerclose");		

						
	$options[] = array( "type" => "innertabclose");	

	
	$options[] = array( "name" => "country7",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("Mag Settings", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'Teal' ),
										"desc" => __("Select yes if you want to show ratings", 'Teal' ),
										"id" => "show_ratings_mag",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Thumbnail?", 'Teal' ),
										"desc" => __("Select yes if you want to show thumbnail in the post", 'Teal' ),
										"id" => "show_postthumbnail_mag",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);														

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");	
	
	$options[] = array( "name" => "country8",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("MagLite Settings", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'Teal' ),
										"desc" => __("Select yes if you want to show ratings", 'Teal' ),
										"id" => "show_ratings_maglite",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Thumbnail?", 'Teal' ),
										"desc" => __("Select yes if you want to show thumbnail in the post", 'Teal' ),
										"id" => "show_postthumbnail_maglite",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);														

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");	
	
	
	
	
	
	$options[] = array( "name" => "country13",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("MagThree Settings", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'Teal' ),
										"desc" => __("Select yes if you want to show ratings", 'Teal' ),
										"id" => "show_ratings_magthree",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Thumbnail?", 'Teal' ),
										"desc" => __("Select yes if you want to show thumbnail in the post", 'Teal' ),
										"id" => "show_postthumbnail_magthree",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);														

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");	
	
	$options[] = array( "name" => "country14",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("MagFour Settings", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'Teal' ),
										"desc" => __("Select yes if you want to show ratings", 'Teal' ),
										"id" => "show_ratings_magfour",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Thumbnail?", 'Teal' ),
										"desc" => __("Select yes if you want to show thumbnail in the post", 'Teal' ),
										"id" => "show_postthumbnail_magfour",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);														

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");		
	
	$options[] = array( "name" => "country15",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("MagFive Settings", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'Teal' ),
										"desc" => __("Select yes if you want to show ratings", 'Teal' ),
										"id" => "show_ratings_magfive",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Thumbnail?", 'Teal' ),
										"desc" => __("Select yes if you want to show thumbnail in the post", 'Teal' ),
										"id" => "show_postthumbnail_magfive",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);														

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");	
	
	$options[] = array( "name" => "country16",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("MagSix Settings", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'Teal' ),
										"desc" => __("Select yes if you want to show ratings", 'Teal' ),
										"id" => "show_ratings_magsix",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Thumbnail?", 'Teal' ),
										"desc" => __("Select yes if you want to show thumbnail in the post", 'Teal' ),
										"id" => "show_postthumbnail_magsix",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);														

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");
	
	$options[] = array( "name" => "country17",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("MagSeven Settings", 'Teal' ),
							"type" => "tabheading");
		
		
		$options[] = array( "name" => __("Recent Posts Settings", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'Teal' ),
										"desc" => __("Select yes if you want to show ratings", 'Teal' ),
										"id" => "show_ratings_magseven",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Thumbnail?", 'Teal' ),
										"desc" => __("Select yes if you want to show thumbnail in the post", 'Teal' ),
										"id" => "show_postthumbnail_magseven",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);																			

										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Category Box Settings", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'Teal' ),
										"desc" => __("Select yes if you want to show ratings", 'Teal' ),
										"id" => "show_ratings_magseven_cat",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Which categories in left sidebar?", 'Teal' ),
										"desc" => __("Enter the category ID's seperated by comma. Ex : 1, 7, 20", 'Teal' ),
										"id" => "magseven_catbox_id",
										"std" => "",
										"type" => "proupgrade");	
										
					$options[] = array( "name" => __("How many Posts per Category?", 'Teal' ),
										"desc" => __("Enter the number of posts per category you would like to show", 'Teal' ),
										"id" => "magseven_catbox_num",
										"std" => "7",
										"type" => "proupgrade");																											

										
		$options[] = array( "type" => "groupcontainerclose");									
						
	$options[] = array( "type" => "innertabclose");	
	
	$options[] = array( "name" => "country18",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("MagEight Settings", 'Teal' ),
							"type" => "tabheading");
		
		
		$options[] = array( "name" => __("Recent Posts Settings", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'Teal' ),
										"desc" => __("Select yes if you want to show ratings", 'Teal' ),
										"id" => "show_ratings_mageight",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Thumbnail?", 'Teal' ),
										"desc" => __("Select yes if you want to show thumbnail in the post", 'Teal' ),
										"id" => "show_postthumbnail_mageight",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);																			

										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Category Box Settings", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'Teal' ),
										"desc" => __("Select yes if you want to show ratings", 'Teal' ),
										"id" => "show_ratings_mageight_cat",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Which categories in left sidebar?", 'Teal' ),
										"desc" => __("Enter the category ID's seperated by comma. Ex : 1, 7, 20", 'Teal' ),
										"id" => "mageight_catbox_id",
										"std" => "",
										"type" => "proupgrade");	
										
					$options[] = array( "name" => __("How many Posts per Category?", 'Teal' ),
										"desc" => __("Enter the number of posts per category you would like to show", 'Teal' ),
										"id" => "mageight_catbox_num",
										"std" => "7",
										"type" => "proupgrade");																											

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");			
	
	
	
	
	
	$options[] = array( "name" => "country9",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("Standard Blog Settings", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'Teal' ),
										"desc" => __("Select yes if you want to show ratings", 'Teal' ),
										"id" => "show_ratings_standard",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);		
										
					$options[] = array( "name" => __("Show Categories/Tags?", 'Teal' ),
										"desc" => __("Select yes if you want to show categories and tags in posts", 'Teal' ),
										"id" => "show_ctags_standard",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);														

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");	
	
	$options[] = array( "name" => "country5",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("Sidebar Settings", 'Teal' ),
							"type" => "tabheading");
			
		
		$options[] = array( "name" => __("Sidebar Ad Settings", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show 300x250 ads in sidebar?", 'Teal' ),
										"desc" => __("Select yes if you want to show 300x250 ads in sidebar. If you select yes, go to widgets page and drag/drop the ads", 'Teal' ),
										"id" => "show_sidebar_ads",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);		
										
					$options[] = array( "name" => __("Show 125x125 ads in sidebar?", 'Teal' ),
										"desc" => __("Select yes if you want to show 125x125 ads in sidebar. If you select yes, go to widgets page and drag/drop the ads", 'Teal' ),
										"id" => "show_sidebar_ads_onetwofive",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);											
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Feedburner Settings", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show feedburner?", 'Teal' ),
										"desc" => __("Select yes if you want to show feedburner in sidebar.", 'Teal' ),
										"id" => "show_feedburner",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);
										
					$options[] = array( "name" => __("Feedburner Id", 'Teal' ),
										"desc" => __("Enter your feedburner id", 'Teal' ),
										"id" => "feedburner_id",
										"std" => "",
										"type" => "proupgrade");																												
																				
		$options[] = array( "type" => "groupcontainerclose");
		
		$options[] = array( "name" => __("Social Settings", 'Teal' ),
							"type" => "groupcontaineropen");	

										
					$options[] = array( "name" => __("Show Twitter Updates?", 'Teal' ),
										"desc" => __("Select yes if you want to show feedburner in sidebar.", 'Teal' ),
										"id" => "show_twitter_updates",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);																												
																				
		$options[] = array( "type" => "groupcontainerclose");		
		
		$options[] = array( "name" => __("Video Settings", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Videos in sidebar?", 'Teal' ),
										"desc" => __("Select yes if you want to show videos in sidebar.", 'Teal' ),
										"id" => "sidebar_show_videos",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);

					$options[] = array( "name" => __("Select a Category", 'Teal' ),
										"desc" => __("For posts in this category, You need to create a custom field called video and enter the url to video in its value field", 'Teal' ),
										"id" => "sidebar_show_videos_cat",
										"type" => "proupgrade",
										"options" => $options_categories);


					$options[] = array( "name" => __("How many Videos", 'Teal' ),
										"desc" => __("How many Videos would you like to show.", 'Teal' ),
										"id" => "sidebar_show_videos_num",
										"std" => "3",
										"type" => "proupgrade");
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Top Rated/Most Popular", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Top Rated/Most popular box in sidebar?", 'Teal' ),
										"desc" => __("Select yes or no", 'Teal' ),
										"id" => "sidebar_show_mostbox",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);

					$options[] = array( "name" => __("Select the Layout Type", 'Teal' ),
										"desc" => __("Images for layout.", 'Teal' ),
										"id" => "tabboxsidebarlayout",
										"std" => "tabbigthumb",
										"type" => "proupgrade",
										"options" => array(
											'tabbigthumb' => $imagepath . 'vidone.png',
											'tabsmallthumb' => $imagepath . 'vidfour.png')
										);	

					$options[] = array( "name" => __("How many posts", 'Teal' ),
										"desc" => __("How many posts would you like to show.", 'Teal' ),
										"id" => "sidebar_show_mostboxnum",
										"std" => "10",
										"type" => "proupgrade");
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Polls", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Polls?", 'Teal' ),
										"desc" => __("Select yes or no", 'Teal' ),
										"id" => "sidebar_show_poll",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);


					$options[] = array( "name" => __("Which Poll?", 'Teal' ),
										"desc" => __("Enter the poll ID", 'Teal' ),
										"id" => "sidebar_show_poll_id",
										"std" => "",
										"type" => "proupgrade");
										
		$options[] = array( "type" => "groupcontainerclose");												
						
	$options[] = array( "type" => "innertabclose");		
	
	$options[] = array( "name" => "country10",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("AD Settings", 'Teal' ),
							"type" => "tabheading");		
		
		$options[] = array( "name" => __("Header Ad Settings", 'Teal' ),
							"type" => "groupcontaineropen");	

					
					$options[] = array( "name" => __("Show Adsense?", 'Teal' ),
										"desc" => __("If yes, adsense will be show else enter html adcode below", 'Teal' ),
										"id" => "show_header_adsense",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);		
										
					$options[] = array( "name" => __("Header Ad code", 'Teal' ),
										"desc" => __("Enter the html ad code", 'Teal' ),
										"id" => "header_ad_code",
										"type" => "proupgrade");														

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");	
	
	$options[] = array( "name" => "country11",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("Footer Settings", 'Teal' ),
							"type" => "tabheading");		
		
		$options[] = array( "name" => __("Footer Widgets", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show footer widgets on homepage?", 'Teal' ),
										"desc" => __("Select yes if you want to show footer widgets on homepage.", 'Teal' ),
										"id" => "show_footer_widgets_home",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);
										
					$options[] = array( "name" => __("Show footer widgets on single post pages?", 'Teal' ),
										"desc" => __("Select yes if you want to show footer widgets on single post pages.", 'Teal' ),
										"id" => "show_footer_widgets_single",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show footer widgets on pages?", 'Teal' ),
										"desc" => __("Select yes if you want to show footer widgets on pages.", 'Teal' ),
										"id" => "show_footer_widgets_page",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);		
										
					$options[] = array( "name" => __("Show footer widgets on category pages?", 'Teal' ),
										"desc" => __("Select yes if you want to show footer widgets on category pages.", 'Teal' ),
										"id" => "show_footer_widgets_archive",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);																													
																				
		$options[] = array( "type" => "groupcontainerclose");
		
		$options[] = array( "name" => __("Footer Logo", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show footer logo?", 'Teal' ),
										"desc" => __("Select yes if you want to show logo in footer.", 'Teal' ),
										"id" => "show_footer_logo",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);

				$options[] = array( "name" => __("Upload Logo", 'Teal' ),
									"desc" => __("Upload your logo here. Max width 250px", 'Teal' ),
									"id" => "footer_logo",
									"type" => "proupgrade");						

										
		$options[] = array( "type" => "groupcontainerclose");
		
		$options[] = array( "name" => __("Search Box", 'Teal' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show search box in footer?", 'Teal' ),
										"desc" => __("Select yes if you want to show search box in footer.", 'Teal' ),
										"id" => "show_footer_search",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);						

										
		$options[] = array( "type" => "groupcontainerclose");												
						
	$options[] = array( "type" => "innertabclose");			
							
						

							
		
	return $options;
}