
	<div id="footer">
		<p><a href="#"><img src="<?php bloginfo('template_url'); ?>/images/favorite.gif" alt="" class="left" style="vertical-align:middle" /></a><br />
        Content &copy; <?php bloginfo('name'); ?>. Proudly powered by <a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.', 'sandbox'); ?>" rel="generator"><?php _e('WordPress', 'sandbox'); ?></a>.  To bookmark this site, press Control+D.  <!--Stats: <?php echo get_num_queries(); ?> queries, <?php timer_stop(1); ?> seconds.--><br />
        <br />
        "Black Hat" theme by <a href="http://www.nickifaulk.com/" rel="designer">Nicki Faulk</a>.  For best results, please view with <a href="http://www.mozilla.com/firefox/">Firefox</a>. &nbsp; [ <?php wp_register('', ' / '); ?> <?php wp_loginout(); ?> ]</p>
	</div><!-- #footer -->

	<div id="theend"></div>
</div><!-- #wrapper .hfeed -->

<?php wp_footer() ?>

</body>
</html>