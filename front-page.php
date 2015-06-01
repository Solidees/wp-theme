<?php
if (get_option('show_on_front') == 'posts') {
	get_template_part('index');
} elseif ('page' == get_option('show_on_front')) {
	get_header();
	dazzling_featured_slider();
	dazzling_call_for_action(); ?>

<div id="content" class="site-content container">
	<div id="primary" class="content-area col-sm-12 col-md-12">
		<main id="main" class="site-main" role="main"> <?php while ( have_posts() ) : the_post(); ?> <div class="row">
			<div class="col-md-8" id="splash-container">
				<?php the_post_thumbnail('full', array('class' => 'img-responsive attachment-full')); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'dazzling' ), 'after' => '</div>', ) ); ?>
					</div>
					<?php edit_post_link( __( 'Edit', 'dazzling' ), '<footer class="entry-meta"><i class="fa fa-pencil-square-o"></i><span class="edit-link">', '</span></footer>' ); ?>
				</article>
				<a href="/les-rencontres-solidees/" class="btn btn-primary">Les rencontres Solidées &gt;</a><a href="/sinspirer/" class="btn btn-primary">S'inspirer &gt;</a>
			</div>
			<div class="col-sm-4" id="canvas-container">
				<canvas id="canvas" class="canvas"></canvas>
				<div id="html-canvas" class="canvas hide"></div>
			</div>
		</div> <?php get_sidebar( 'home' ); ?> <?php endwhile; // end of the loop. ?> </main>
	</div>

<?php
	get_footer();
}