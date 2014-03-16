<ul class="ul-wrapper">
<?php if ( dynamic_sidebar(1) ) : else : ?>

<li>
<h2>Archives</h2>
<ul class="li_archives">
<?php wp_get_archives('type=monthly'); ?>
</ul>
</li>

<li>
<h2>Meta</h2>
<ul class="li_reg">
<li><?php wp_register(); ?></li>
</ul>
</li>

<li>
<ul class="li_loginout">
<li><?php wp_loginout(); ?></li>
</ul>
</li>

<?php endif; ?>
</ul>