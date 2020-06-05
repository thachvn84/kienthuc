<?php
/**
 * Plugin Name: Page feature post widget
 */
add_action( 'widgets_init', 'subhomepage_top_load_widgets' );
function subhomepage_top_load_widgets() {
	register_widget( 'subhomepage_top_widget' );
}
class subhomepage_top_widget extends WP_Widget {
	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'subhomepage_top_widget', 'description' => __('A widget that displays a list of posts from a category of your choice.', 'mvp-text') );
		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'subhomepage_top_widget' );
		/* Create the widget. */
		parent::__construct( 'subhomepage_top_widget', __('Trada5p: Customize feature post for sub page', 'mvp-text'), $widget_ops, $control_ops );
    }
    
	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
		/* Our variables from the widget settings. */
		global $post;
		$title = apply_filters('widget_title', $instance['title'] );
		$categories = $instance['categories'];
        $tags = $instance['tags'];
		/* Before widget (defined by themes). */
		echo $before_widget;
		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
		?>
			<?php $mvp_feat_posts = get_option('mvp_feat_posts'); if ($mvp_feat_posts == "true") { ?>
                <?php $mvp_feat_layout = get_option('mvp_feat_layout'); if( $mvp_feat_layout == "Featured 1" ) { ?>
                    <div id="home-feat-wrap" class="left relative">
                        <?php global $do_not_duplicate; global $post; $recent = new WP_Query(array( 'cat' => $categories, 'tag' => $tags, 'posts_per_page' => '1'  )); while($recent->have_posts()) : $recent->the_post(); $do_not_duplicate[] = $post->ID; if (isset($do_not_duplicate)) { ?>
                            <div class="home-feat-main left relative">
                                <a href="<?php the_permalink(); ?>" rel="bookmark">
                                <div id="home-feat-img" class="left relative">
                                    <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
                                        <?php the_post_thumbnail('mvp-post-thumb', array( 'class' => 'unlazy reg-img' )); ?>
                                        <?php the_post_thumbnail('mvp-medium-thumb', array( 'class' => 'unlazy mob-img' )); ?>
                                    <?php } ?>
                                </div><!--home-feat-img-->
                                <div id="home-feat-text">
                                    <?php if(get_post_meta($post->ID, "mvp_featured_headline", true)): ?>
                                        <h2><?php echo esc_html(get_post_meta($post->ID, "mvp_featured_headline", true)); ?></h2>
                                        <p><?php the_title(); ?></p>
                                    <?php else: ?>
                                        <h2 class="stand-title"><?php the_title(); ?></h2>
                                    <?php endif; ?>
                                </div><!--home-feat-text-->
                                <?php $post_views = get_post_meta($post->ID, "post_views_count", true); if ( $post_views >= 1) { ?>
                                <div class="feat-info-wrap">
                                    <div class="feat-info-views">
                                        <i class="fa fa-eye fa-2"></i> <span class="feat-info-text"><?php mvp_post_views(); ?></span>
                                    </div><!--feat-info-views-->
                                    <?php $disqus_id = get_option('mvp_disqus_id'); if ( ! $disqus_id ) { if (get_comments_number()==0) { } else { ?>
                                        <div class="feat-info-comm">
                                            <i class="fa fa-comment"></i> <span class="feat-info-text"><?php comments_number( '0', '1', '%' ); ?></span>
                                        </div><!--feat-info-comm-->
                                    <?php } } ?>
                                </div><!--feat-info-wrap-->
                                <?php } ?>
                                <?php if ( has_post_format( 'video' )) { ?>
                                    <div class="feat-vid-but">
                                        <i class="fa fa-play fa-3"></i>
                                    </div><!--feat-vid-but-->
                                <?php } ?>
                                </a>
                            </div><!--home-feat-main-->
                        <?php } endwhile; wp_reset_postdata(); ?>
                        <div class="feat-title-wrap">
                            <h3 class="home-feat-title"><?php echo esc_html(get_option('mvp_feat_head')); ?></h3>
                        </div><!--feat-title-wrap-->
                    </div><!--home-feat-wrap-->
                    <?php } ?>
                <?php } ?>
		<?php
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['categories'] = strip_tags( $new_instance['categories'] );
        $instance['tags'] = strip_tags( $new_instance['tags'] );
		return $instance;
	}
	function form( $instance ) {
		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Title', 'tags' => '', 'showcat' => 'on', 'number' => 5 );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
		</p>
		<!-- Category -->
		<p>
			<label for="<?php echo $this->get_field_id('categories'); ?>">Select category:</label>
			<select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>All Categories</option>
				<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($categories as $category) {  ?>
				<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>
        <!-- Tag -->
		<p>
			<label for="<?php echo $this->get_field_id( 'tags' ); ?>">Tag Name:</label>
			<input id="<?php echo $this->get_field_id( 'tags' ); ?>" name="<?php echo $this->get_field_name( 'tags' ); ?>" value="<?php echo $instance['tags']; ?>" style="width:90%;" />
		</p>
	<?php
	}
}
?>