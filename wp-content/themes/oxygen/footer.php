<?php
/**
 *	Oxygen WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

	global $theme_version;
?>
		
		<?php if( ! defined("NO_HEADER_MENU")): ?>
		</div>
		<?php endif; ?>

		<?php if( ! defined("NO_FOOTER_MENU")): ?>

			<?php get_template_part('tpls/footer-main'); ?>

		<?php endif; ?>

	</div>

	<?php wp_footer(); ?>
	
	<!-- <?php echo 'ET: ', microtime( true ) - STIME, 's ', $theme_version, ( is_child_theme() ? 'ch' : '' ); ?> -->

</body>
</html>