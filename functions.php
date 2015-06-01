<?php
define('SOLIDEES_THEME_VERSION', 0.1);

/**
 * Enqueue scripts and styles.
 */
function solidees_scripts()
{
	wp_enqueue_style('solidees-style', get_stylesheet_directory_uri() . '/assets/css/front.css');
	// Javascript footer
	if (is_home() || is_front_page()) {
		wp_enqueue_style('solidees-cloudtags', get_stylesheet_directory_uri() . '/assets/css/cloudtags.css');
		wp_enqueue_style('solidees-cloudtags-font', '//fonts.googleapis.com/css?family=Finger+Paint');
		wp_enqueue_script('worldcloud2', get_stylesheet_directory_uri() . '/assets/js/wordcloud2.js', array('jquery'), SOLIDEES_THEME_VERSION, true);
		wp_enqueue_script('solidees-homejs', get_stylesheet_directory_uri() . '/assets/js/home.js', array('worldcloud2'), SOLIDEES_THEME_VERSION, true);
	}
}
add_action('wp_enqueue_scripts', 'solidees_scripts', 15);

/**
 * Register all taxonomies
 */
function solidees_inspiration_taxonomies()
{
	// Mots clés
	register_taxonomy('solidees_inspiration_tag', null,
			array(
				'label' => __('Mots clés', 'solidees'),
				'hierarchical' => false,
				'labels' => array('name' => __('Mots clés', 'solidees'), 'singular_name' => __('Mot clé', 'solidees')),
				'rewrite' => array('slug' => __('mots-cles', 'solidees'))));
	
	// Thématiques
	register_taxonomy('solidees_inspiration_category', null,
			array(
				'label' => __('Thématiques', 'solidees'),
				'hierarchical' => true,
				'labels' => array(
					'name' => __('Thématiques', 'solidees'),
					'singular_name' => __('Thématique', 'solidees'),
					'add_new_item' => __("Ajouter une nouvelle thématique", 'solidees')),
				'rewrite' => array('slug' => __('thematique', 'solidees'))));
	
	// Stage
	register_taxonomy('solidees_inspiration_stage', null,
			array(
				'label' => __("Maturités", 'solidees'),
				'labels' => array(
					'name' => __("Maturités", 'solidees'),
					'singular_name' => __("Maturité", 'solidees'),
					'choose_from_most_used' => __("Choisir parmi les types d'action les plus courantes", 'solidees'),
					'add_new_item' => __("Ajouter un nouveau stade de maturité", 'solidees')),
				'rewrite' => array('slug' => __('maturite', 'solidees'))));
}
add_action('init', 'solidees_inspiration_taxonomies');

/**
 * La base d'idées
 */
function solidees_inspiration_posttype()
{
	register_post_type('solidees_inspiration',
			array(
				'labels' => array('name' => __('Inspirations', 'solidees'), 'singular_name' => __('Inspiration', 'solidees')),
				'rewrite' => array('slug' => __('idees-inspirantes', 'solidees')),
				'public' => true,
				'has_archive' => true,
				'hierarchical' => false,
				'taxonomies' => array('solidees_inspiration_category', 'solidees_inspiration_tag', 'solidees_inspiration_stage'),
				'menu_position' => 7));
	add_post_type_support('solidees_inspiration', array('author', 'thumbnail', 'excerpt', 'comments', 'revisions'));
}
add_action('init', 'solidees_inspiration_posttype');

if (! function_exists('solidees_inspiration_paging_nav')) :

	/**
	 * Display navigation to next/previous set of posts when applicable.
	 *
	 * @return void
	 *
	 */
	function solidees_inspiration_paging_nav()
	{
		// Don't print empty markup if there's only one page.
		if ($GLOBALS['wp_query']->max_num_pages < 2) {
			return;
		}
		?>
<nav class="navigation paging-navigation" role="navigation">
	<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'solidees' ); ?></h1>
	<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-next"> <?php next_posts_link( __( '<i class="fa fa-chevron-right"></i> Page suivante', 'solidees' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-previous"><?php previous_posts_link( __( 'Newer posts <i class="fa fa-chevron-left"></i> Page précédente', 'solidees' ) ); ?> </div>
			<?php endif; ?>

		</div>
	<!-- .nav-links -->
</nav>
<!-- .navigation -->
<?php
	}

endif;

/*
 * --------------------------
 * LIBRAIRIES
 * --------------------------
 */
require_once('inc/email-secured.php');
