<?php
	/* Template Name: Homepage */
?>
<?php get_header(); ?>
<div id="home-main-wrap" class="left relative">
	<div class="home-wrap-out1">
		<div class="home-wrap-in1">
			<div id="home-left-wrap" class=" left relative">
				<div class="home-wrap-out2">
					<div id="tab-col2" class="home-mid-col relative tab-col-cont theiaStickySidebar">
						<?php if ( is_active_sidebar( 'homepage-left-widget' ) ) { ?>
							<?php dynamic_sidebar( 'homepage-left-widget' ); ?>
						<?php } ?>
					</div><!--home-left-col-->
					<div class="home-wrap-in2">
						<div id="tab-col1" class="home-left-col relative tab-col-cont">
							<div id="home-mid-wrap" class="left relative">
								<?php if(get_option('mvp_home_layout') == 'Widgets' || get_option('mvp_home_layout') == 'Widgets and Blog') { ?>
									<?php global $paged; $paged = (get_query_var('page')) ? get_query_var('page') : 1; if ( $paged < 2 ) : ?>
										<?php if ( is_active_sidebar( 'homepage-widget' ) ) { ?>
											<?php dynamic_sidebar( 'homepage-widget' ); ?>
										<?php } ?>
									<?php endif; ?>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>		
			</div><!--home-left-wrap-->
		</div><!--home-wrap-in1-->
		<div id="arch-right-col" class="relative">
			<?php if ( is_active_sidebar( 'homepage-right-widget' ) ) { ?>
				<?php dynamic_sidebar( 'homepage-right-widget' ); ?>
			<?php } ?>
		</div><!--home-right-col-->
	</div><!--home-wrap-out1-->
</div><!--home-main-wrap-->
<?php get_footer(); ?>