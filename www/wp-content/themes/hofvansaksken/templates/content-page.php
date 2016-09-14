<?php if($_SESSION['ontvanger']): ?>		
	<input type="hidden" id="hddn_ontvanger" value="<?php echo $_SESSION['ontvanger']  ;?>">
<?php endif; ?>
<?php if($_SESSION['voornaam']): ?>		
	<input type="hidden" id="hddn_voornaam" value="<?php echo $_SESSION['voornaam']  ;?>">
<?php endif; ?>

<?php the_content(); ?>
<?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
