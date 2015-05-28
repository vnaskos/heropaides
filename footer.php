
		<aside id="sidebar" class="grid-30 push-5 mobile-grid-100">
			<?php get_sidebar(); ?>
		</aside>
		
		<div id="before-footer" class="grid-100"></div>
	</div>
	<footer id="footer" class="grid-container">
		<?php if(get_option(SHORT_NAME . 'footer-widgets') != "true"): ?>
			<div class="footer-widget">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer-Widgets") ) { ?>
					<p>Now add some widgets!</p>
				<?php } ?>
			</div>
			<div class="clear"></div>
		<?php endif; ?>
		<div class="footer-copyright">
			<p><?php echo get_option(SHORT_NAME . 'footer-text'); ?> | Designed and Developed by: <span><a href="http://nask00s.tk">nask00s</a></span> under GPL v2 License</p>
		</div>
	</footer>
	
	<?php wp_footer(); ?>
</body>
</html>
