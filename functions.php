<?php
/**
 * Twenty Nineteen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

/**
 * Twenty Nineteen only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

if ( ! function_exists( 'twentynineteen_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function twentynineteen_setup() {

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1568, 9999 );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'menu-1' => __( 'Primary', 'twentynineteen' ),
				'footer' => __( 'Footer Menu', 'twentynineteen' ),
				'social' => __( 'Social Links Menu', 'twentynineteen' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
				'navigation-widgets',
			)
		);

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 190,
				'width'       => 190,
				'flex-width'  => false,
				'flex-height' => false,
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );

		// Add custom editor font sizes.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => __( 'Small', 'twentynineteen' ),
					'shortName' => __( 'S', 'twentynineteen' ),
					'size'      => 19.5,
					'slug'      => 'small',
				),
				array(
					'name'      => __( 'Normal', 'twentynineteen' ),
					'shortName' => __( 'M', 'twentynineteen' ),
					'size'      => 22,
					'slug'      => 'normal',
				),
				array(
					'name'      => __( 'Large', 'twentynineteen' ),
					'shortName' => __( 'L', 'twentynineteen' ),
					'size'      => 36.5,
					'slug'      => 'large',
				),
				array(
					'name'      => __( 'Huge', 'twentynineteen' ),
					'shortName' => __( 'XL', 'twentynineteen' ),
					'size'      => 49.5,
					'slug'      => 'huge',
				),
			)
		);

		// Editor color palette.
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => 'default' === get_theme_mod( 'primary_color', 'default' ) ? __( 'Blue', 'twentynineteen' ) : null,
					'slug'  => 'primary',
					'color' => twentynineteen_hsl_hex( 'default' === get_theme_mod( 'primary_color' ) ? 199 : get_theme_mod( 'primary_color_hue', 199 ), 100, 33 ),
				),
				array(
					'name'  => 'default' === get_theme_mod( 'primary_color', 'default' ) ? __( 'Dark Blue', 'twentynineteen' ) : null,
					'slug'  => 'secondary',
					'color' => twentynineteen_hsl_hex( 'default' === get_theme_mod( 'primary_color' ) ? 199 : get_theme_mod( 'primary_color_hue', 199 ), 100, 23 ),
				),
				array(
					'name'  => __( 'Dark Gray', 'twentynineteen' ),
					'slug'  => 'dark-gray',
					'color' => '#111',
				),
				array(
					'name'  => __( 'Light Gray', 'twentynineteen' ),
					'slug'  => 'light-gray',
					'color' => '#767676',
				),
				array(
					'name'  => __( 'White', 'twentynineteen' ),
					'slug'  => 'white',
					'color' => '#FFF',
				),
			)
		);

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Add support for custom line height.
		add_theme_support( 'custom-line-height' );
	}
endif;
add_action( 'after_setup_theme', 'twentynineteen_setup' );

if ( ! function_exists( 'wp_get_list_item_separator' ) ) :
	/**
	 * Retrieves the list item separator based on the locale.
	 *
	 * Added for backward compatibility to support pre-6.0.0 WordPress versions.
	 *
	 * @since 6.0.0
	 */
	function wp_get_list_item_separator() {
		/* translators: Used between list items, there is a space after the comma. */
		return __( ', ', 'twentynineteen' );
	}
endif;

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function twentynineteen_widgets_init() {

	register_sidebar(
		array(
			'name'          => __( 'Footer', 'twentynineteen' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your footer.', 'twentynineteen' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'twentynineteen_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Twenty Nineteen 2.0
 *
 * @param string $link Link to single post/page.
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function twentynineteen_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf(
		'<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Post title. Only visible to screen readers. */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentynineteen' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'twentynineteen_excerpt_more' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width Content width.
 */
function twentynineteen_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'twentynineteen_content_width', 640 );
}
add_action( 'after_setup_theme', 'twentynineteen_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function twentynineteen_scripts() {
	wp_enqueue_style( 'twentynineteen-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );

	wp_style_add_data( 'twentynineteen-style', 'rtl', 'replace' );

	if ( has_nav_menu( 'menu-1' ) ) {
		wp_enqueue_script(
			'twentynineteen-priority-menu',
			get_theme_file_uri( '/js/priority-menu.js' ),
			array(),
			'20200129',
			array(
				'in_footer' => false, // Because involves header.
				'strategy'  => 'defer',
			)
		);
		wp_enqueue_script(
			'twentynineteen-touch-navigation',
			get_theme_file_uri( '/js/touch-keyboard-navigation.js' ),
			array(),
			'20230621',
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);
	}

	wp_enqueue_style( 'twentynineteen-print-style', get_template_directory_uri() . '/print.css', array(), wp_get_theme()->get( 'Version' ), 'print' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'twentynineteen_scripts' );

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @since Twenty Nineteen 1.0
 * @deprecated Twenty Nineteen 2.6 Removed from wp_print_footer_scripts action.
 *
 * @link https://git.io/vWdr2
 */
function twentynineteen_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}

/**
 * Enqueue supplemental block editor styles.
 */
function twentynineteen_editor_customizer_styles() {

	wp_enqueue_style( 'twentynineteen-editor-customizer-styles', get_theme_file_uri( '/style-editor-customizer.css' ), false, '2.1', 'all' );

	if ( 'custom' === get_theme_mod( 'primary_color' ) ) {
		// Include color patterns.
		require_once get_parent_theme_file_path( '/inc/color-patterns.php' );
		wp_add_inline_style( 'twentynineteen-editor-customizer-styles', twentynineteen_custom_colors_css() );
	}
}
add_action( 'enqueue_block_editor_assets', 'twentynineteen_editor_customizer_styles' );

/**
 * Display custom color CSS in customizer and on frontend.
 */
function twentynineteen_colors_css_wrap() {

	// Only include custom colors in customizer or frontend.
	if ( ( ! is_customize_preview() && 'default' === get_theme_mod( 'primary_color', 'default' ) ) || is_admin() ) {
		return;
	}

	require_once get_parent_theme_file_path( '/inc/color-patterns.php' );

	$primary_color = 199;
	if ( 'default' !== get_theme_mod( 'primary_color', 'default' ) ) {
		$primary_color = get_theme_mod( 'primary_color_hue', 199 );
	}
	?>

	<style type="text/css" id="custom-theme-colors" <?php echo is_customize_preview() ? 'data-hue="' . absint( $primary_color ) . '"' : ''; ?>>
		<?php echo twentynineteen_custom_colors_css(); ?>
	</style>
	<?php
}
add_action( 'wp_head', 'twentynineteen_colors_css_wrap' );

/**
 * SVG Icons class.
 */
require get_template_directory() . '/classes/class-twentynineteen-svg-icons.php';

/**
 * Custom Comment Walker template.
 */
require get_template_directory() . '/classes/class-twentynineteen-walker-comment.php';

/**
 * Common theme functions.
 */
require get_template_directory() . '/inc/helper-functions.php';

/**
 * SVG Icons related functions.
 */
require get_template_directory() . '/inc/icon-functions.php';

/**
 * Enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Custom template tags for the theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Block Patterns.
 */
require get_template_directory() . '/inc/block-patterns.php';

function add_wp_head_custom(){ ?>
	<?php //date_default_timezone_set('Asia/Tokyo'); ?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="preload" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/bootstrap.min.css?ver=5.0.2" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<link rel="preload" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/slick.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<link rel="preload" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/slick-theme.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/style.min.css?ver=<?php echo date("ymdHis",filemtime( get_stylesheet_directory()."/assets/css/style.min.css")); ?>" media="all" type="text/css">
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<link rel="canonical" href="<?php echo esc_url( home_url( '/' ) ); ?>">
	<link rel="Shortcut Icon" type="image/x-icon" href="<?php echo home_url(); ?>/favicon.ico" />
<?php }
add_action( 'wp_head', 'add_wp_head_custom',99);

function add_wp_footer_custom(){ ?>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js" defer></script>
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/slick.min.js"></script>
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/script.js" defer></script>
	<script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/common.js?ver=<?php echo date("ymdHis",filemtime( get_stylesheet_directory()."/assets/js/common.js")); ?>"></script>
	<!-- OptanonConsentNoticeStart for kohler.jp-->
	<script type="text/javascript" src=https://cdn.cookielaw.org/consent/9011c1c0-db62-4f4b-8553-f2abe09c124a/OtAutoBlock.js ></script>
	<script src=https://cdn.cookielaw.org/scripttemplates/otSDKStub.js  type="text/javascript" charset="UTF-8" data-domain-script="9011c1c0-db62-4f4b-8553-f2abe09c124a" ></script>
	<script type="text/javascript">
		function OptanonWrapper() { }
	</script>
<?php }
add_action( 'wp_footer', 'add_wp_footer_custom', 99);

// 管理画面での読み込み
function enqueue_post_styles() {
	global $pagenow;
	if ( $pagenow == 'post.php' || $pagenow == 'post-new.php' || $pagenow == 'edit.php' ) {
		$postType = get_post_type();
		if ( $postType == 'products' ) { // 特定のカスタム投稿タイプの場合のみ適用
			wp_enqueue_style( 'custom-admin-style', get_template_directory_uri() . '/assets/css/admin-style-products.css' );
		}
	}
  }
  add_action( 'admin_enqueue_scripts', 'enqueue_post_styles' );
  
  function my_delete_plugin_files() {
	  wp_deregister_style('wp-block-library');
	  wp_deregister_script('wp-polyfill-js');
	  wp_deregister_script('wp-i18n-js');
	  wp_deregister_script('wp-polyfill-inert-js');
	  wp_deregister_script('regenerator-runtime-js');
	  wp_deregister_script('wp-hooks-js');
  }
  add_action( 'wp_enqueue_scripts', 'my_delete_plugin_files' );
  
  function theme_name_scripts() {
	  wp_deregister_script('jquery-core-js');
	  wp_deregister_script('jquery-migrate-js');
	  wp_deregister_script('utils-js');
  }
  add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
  
/*-------------------------------------------*/
/*  common.jsでサイトのURL・テーマURLを使えるようにする
/*-------------------------------------------*/
  $tmp_path_arr = array(
	  'temp_uri' => get_template_directory_uri(),
	  'home_url' => home_url()
  );
//   wp_enqueue_script( 'common', get_template_directory_uri() . '/assets/js/common.js', '', update_date((get_stylesheet_directory()."/assets/js/common.js")), true );
  wp_localize_script( 'common', 'tmp_path', $tmp_path_arr );
  
  // 記事の自動整形を無効化
  remove_filter('the_content', 'wpautop');
  
/*-------------------------------------------*/
/*  パンくずリスト
/*-------------------------------------------*/
  function breadcrumb() {
	  $home = '<li><a href="'.home_url().'" >HOME</a></li>';
	
	  echo '<ul id="breadcrumb" class="d-flex list-unstyled mb-0">';
	if( is_search() ) {
		  // 検索ページの場合
		  echo $home;
		  echo '<li>「'.get_search_query().'」の検索結果</li>';
	  }
	  else if ( is_category() ) {
		  // カテゴリページの場合
		  $cat = get_queried_object();
		  $cat_id = $cat->parent;
		  $cat_list = array();
		  while ($cat_id != 0){
			  $cat = get_category( $cat_id );
			  $cat_link = get_category_link( $cat_id );
			  array_unshift( $cat_list, '<li>'.$cat->name.'</li>' );
			  $cat_id = $cat->parent;
		  }
		  echo $home;
		  foreach($cat_list as $value){
			  echo $value;
		  }
		  the_archive_title('<li>', '</li>');
	  }
	  else if ( is_archive() ) {
	  // 月別アーカイブ・タグページの場合
		  echo $home;
		  if (is_tax()) {
			$post_type = get_post_type(get_the_ID());
			echo '<li>'.esc_html(get_post_type_object(get_post_type())->label).'</li>';
		  }
		  the_archive_title('<li>', '</li>');
	  }
	  else if (is_singular(array('products', 'portfolio'))) {
		$post_type = get_post_type(get_the_ID());
		$post_type_cat = get_post_type(get_the_ID()).'-cat';
		$cat = get_the_terms(get_the_ID(), $post_type_cat);
		if( isset($cat[0]->term_id) ) $cat_id = $cat[0]->term_id;
		$cat_list = array();
		while ($cat_id != 0){
			$cat = get_term( $cat_id );
			$cat_link = get_term_link( $cat_id );
			array_unshift( $cat_list, '<li>'.$cat->name.'</li>' );
			$cat_id = $cat->parent;
		}
		echo $home;
		echo '<li>'.esc_html(get_post_type_object(get_post_type())->label).'</li>';
		foreach($cat_list as $value){
			echo $value;
		}
		the_title('<li>', '</li>');
	  }
	  else if ( is_single() ) {
		  // 投稿ページの場合
		  $cat = get_the_category();
		  if( isset($cat[0]->term_id) ) $cat_id = $cat[0]->term_id;
		  $cat_list = array();
		  while ($cat_id != 0){
			  $cat = get_category( $cat_id );
			  $cat_link = get_category_link( $cat_id );
			  array_unshift( $cat_list, '<li>'.$cat->name.'</li>' );
			  $cat_id = $cat->parent;
		  }
		  echo $home;
		  foreach($cat_list as $value){
			  echo $value;
		  }
		  the_title('<li>', '</li>');
	  }
	  else if( is_page() ) {
		  // 固定ページの場合
		  echo $home;
		  $ancestors_ids = array_reverse(get_post_ancestors( $home ));
		  foreach($ancestors_ids as $ancestors_id){
			  echo '<li>'.get_page($ancestors_id)->post_title.'</a></li>';
		  }
		  the_title('<li>', '</li>');
	  }
	  else if( is_404() ) {
		  // 404ページの場合
		  echo $home;
		  echo '<li>ページが見つかりません</li>';
	  }
	  echo "</ul>";
  }

	// アーカイブの余計なタイトルを削除
	add_filter( 'get_the_archive_title', function ($title) {
		if (is_category()) {
			$title = single_cat_title('',false);
		} elseif (is_tag()) {
			$title = single_tag_title('',false);
		} elseif (is_tax()) {
			$title = single_term_title('',false);
		} elseif (is_post_type_archive() ){
			$title = post_type_archive_title('',false);
		} elseif (is_date()) {
			$title = get_the_time('Y年n月');
		} elseif (is_search()) {
			$title = '検索結果：'.esc_html( get_search_query(false) );
		} elseif (is_404()) {
			$title = '「404」ページが見つかりません';
		} else {

		}
		return $title;
	});
	
  /*-------------------------------------------*/
  /*  ページがなければトップページへリダイレクト
  /*-------------------------------------------*/
  add_action( 'template_redirect', 'is404_redirect_home' );
  function is404_redirect_home() {
	if ( is_404() ) {
	  wp_safe_redirect( home_url( '/' ) );
	  exit();
	}
	if ( is_404() ) {
	  wp_safe_redirect( home_url( '/' ), 301 );
	  exit();
	}
  }
  /*-------------------------------------------*/
  /*  管理画面メニューカスタマイズ
  /*-------------------------------------------*/
  add_action('admin_menu', 'custom_menu_page');
	function custom_menu_page() {
    	add_submenu_page('edit.php?post_type=products', '商品情報一括登録', '商品情報一括登録', 'edit_pages', 'admin-product-data', 'add_custom_menu_page', 2);
	}
	function add_custom_menu_page(){
		require_once ( dirname(__FILE__).'/admin-product-data.php' );
	}

  /*-------------------------------------------*/
  /* 商品検索
  /*-------------------------------------------*/
	function custom_search($search, $wp_query) {
		global $wpdb;
		
		//サーチページ以外だったら終了
		if (!$wp_query->is_search)
		return $search;

		if (!isset($wp_query->query_vars))
		return $search;

		// タグ名・カテゴリ名も検索対象に
		isset($_GET['s']) ? $input_freeword = $_GET['s'] : $input_freeword = '';
		if ( !empty($input_freeword) ) {
			$input_freeword = mb_convert_kana($input_freeword, 'KVs');
			// $input_freeword = mb_strtolower($input_freeword);
			$input_freeword = str_replace('＋','+',$input_freeword);
			$input_freeword = str_replace('＝','=',$input_freeword);
			$input_freeword = str_replace('／','/',$input_freeword);
			$freewords = preg_split('/[\s,]+/', $input_freeword);
			$search = '';
			foreach ( $freewords as $freeword ) {
				if ( !empty($freeword) ) {
					$freeword = $wpdb->esc_like($freeword); // SQLエスケープ

					// 検索条件に以下を追加
					// タイトル・タクソノミー・ターム・カスタムフィールド
					// カスタムフィールド「商品の型・バリエーション」と「色」を組み合わせ
					$search .= " AND (
						lower({$wpdb->posts}.post_title) LIKE '%{$freeword}%'
						OR {$wpdb->posts}.ID IN (
							SELECT distinct r.object_id
							FROM {$wpdb->term_relationships} AS r
							INNER JOIN {$wpdb->term_taxonomy} AS tt ON r.term_taxonomy_id = tt.term_taxonomy_id
							INNER JOIN {$wpdb->terms} AS t ON tt.term_id = t.term_id
							WHERE lower(t.name) LIKE '%{$freeword}%'
							OR lower(t.slug) LIKE '%{$freeword}%'
						)
						OR {$wpdb->posts}.ID IN (
							SELECT distinct post_id
							FROM {$wpdb->postmeta}
							WHERE {$wpdb->postmeta}.meta_key
							NOT IN ('_edit_last', '_edit_lock', '_wp_old_slug', 'classic-editor-remember', 'veu_head_title', 'veu_display_promotion_alert')
							AND lower(meta_value) LIKE '%{$freeword}%'
						)
						OR {$wpdb->posts}.ID IN (
							SELECT distinct pm1.post_id
							FROM {$wpdb->postmeta} AS pm1
							INNER JOIN {$wpdb->postmeta} AS pm2 ON pm1.post_id = pm2.post_id
							WHERE pm1.meta_key = 'model_number' 
							AND pm2.meta_key = 'color_model_number'
							AND lower(CONCAT(pm1.meta_value, '-', pm2.meta_value)) LIKE '%{$freeword}%'
						)
						OR {$wpdb->posts}.ID IN (
							SELECT distinct pm1.post_id
							FROM {$wpdb->postmeta} AS pm1
							WHERE pm1.meta_key = 'model_number'
							AND EXISTS (
								SELECT 1
								FROM {$wpdb->postmeta} AS pm2
								WHERE pm2.post_id = pm1.post_id
								AND pm2.meta_key = 'color_model_number'
								AND lower(CONCAT(pm1.meta_value, '-', pm2.meta_value)) LIKE '%{$freeword}%'
							)
						)
					)";
				}
			}
		}
		return $search;
	}
	add_filter('posts_search','custom_search', 10, 2);

	function custom_get_posts ( $query ) {
		if ($query->is_search() && $query->is_main_query() && !is_admin()) {

			// 検索対象を商品ページのみにする
			$query->set('post_type', 'products');
			
			// カテゴリーの絞り込み
			$cat_query = [];
			if (isset($_GET['type']) && is_array($_GET['type'])) {
				$type = array_map('intval', $_GET['type']); // IDを整数にキャスト
				if (!empty($type)) {
					$cat_query[] = array(
						'taxonomy' => 'products-cat',
						'field' => 'term_id',
						'terms' => $type,
						'operator' => 'IN',
					);
				}
			}
			$query->set('tax_query', $cat_query);
		}
	}
	add_action( 'pre_get_posts', 'custom_get_posts' );

  /*-------------------------------------------*/
  /* コンソールログ処理実行
  /* @param  string $data 表示したいstr
  /*-------------------------------------------*/
	//新たにカラムを追加
	function add_cattag_columns( $columns ) {
		$index = 2; // 列を追加する位置
		return array_merge(
		array_slice($columns, 0, $index),
		array('id' => 'ID'),
		array_slice($columns, $index)
		);
	}
	add_filter('manage_edit-category_columns' , 'add_cattag_columns');
	add_filter('manage_edit-post_tag_columns' , 'add_cattag_columns');
	add_filter('manage_edit-products-cat_columns' , 'add_cattag_columns');

	//新カラムにIDを表示
	function custom_term_columns( $string, $column_name, $cattag_id ) {
		if ('id' === $column_name){
			echo $cattag_id;
		}
	}
	add_action( 'manage_category_custom_column', 'custom_term_columns', 10, 3 );
	add_action( 'manage_post_tag_custom_column', 'custom_term_columns', 10, 3 );
	add_action( 'manage_products-cat_custom_column', 'custom_term_columns', 10, 3 );

	//並び替えを可能にする
	function sort_cattag_columns($columns) {
		$columns['id'] = 'ID';
		return $columns;
	}
	add_filter( 'manage_edit-category_sortable_columns', 'sort_cattag_columns' );
	add_filter( 'manage_edit-post_tag_sortable_columns', 'sort_cattag_columns' );
	add_filter( 'manage_edit-products-cat_sortable_columns', 'sort_cattag_columns' );

	// メディアライブラリにIDカラムを追加
	function media_url_column($columns) {
		$index = 2; // 列を追加する位置
		return array_merge(
			array_slice($columns, 0, $index),
			array('id' => 'ID'),
			array_slice($columns, $index)
		);
	}
	add_filter('manage_upload_columns', 'media_url_column'); // フックを修正

	// メディアライブラリにIDを表示
	function media_url_value($column_name, $id) {
		if ('id' === $column_name) {
			echo $id;
		}
	}
	add_action('manage_upload_custom_column', 'media_url_value', 10, 2); // フックを修正

/*-------------------------------------------*/
/* アップ可能な拡張子を追加
/*-------------------------------------------*/
	function allow_upload_file( $mimes ) {
	$mimes['dxf'] = 'text/plain';
	$mimes['dwg'] = 'image/vnd.dwg';
	return $mimes;
	}
	add_filter( 'upload_mimes', 'allow_upload_file' );

  /*-------------------------------------------*/
  /* コンソールログ処理実行
  /* @param  string $data 表示したいstr
  /*-------------------------------------------*/
	function console_log_2( $data ){
		echo '<script>';
		echo 'console.log('. json_encode( $data ) .')';
		echo '</script>';
	}

/**
 * FAQ カスタム投稿タイプ & タクソノミー
 */
add_action('init', function () {
    register_post_type('faq', [
        'labels' => [
            'name'          => 'よくあるご質問',
            'singular_name' => 'FAQ',
            'add_new_item'  => '新しい質問を追加',
            'edit_item'     => '質問を編集',
        ],
        // フロントのルーティングは無効、管理画面UIは有効
        'public'              => false,          // ← フロント公開はしない
        'show_ui'             => true,           // 管理画面に表示
        'show_in_menu'        => true,
        'show_in_rest'        => true,           // ブロックエディタ/ACF対応
        'exclude_from_search' => true,           // 検索に出さない
        'publicly_queryable'  => false,          // 個別URLを有効化しない
        'has_archive'         => false,          // アーカイブ無し（/faq/ を取らない）
        'rewrite'             => false,          // リライトルール無し（競合回避）
        'supports'            => ['title', 'editor', 'page-attributes'],
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-editor-help',
    ]);

    register_taxonomy('faq_category', 'faq', [
        'label'        => 'FAQカテゴリー',
        'hierarchical' => true,
        'show_ui'      => true,
        'show_in_rest' => true,
        // 固定ページのスラッグと被らないように（任意）
        'rewrite'      => ['slug' => 'faq-category', 'with_front' => false],
        'public'       => false,          // 直接URLは不要
        'publicly_queryable' => false,
    ]);
});

/**
 * ACF ローカル定義（FAQに「表示ページ指定」と「表示カテゴリ指定」フィールドを自動作成）
 * ACF が有効な時のみ実行
 */
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key'                   => 'group_faq_display_pages',
        'title'                 => 'FAQ表示設定',
        'fields'                => [
            [
                'key'           => 'field_faq_display_pages',
                'label'         => '表示する固定ページ',
                'name'          => 'display_pages',
                'type'          => 'relationship', // 固定ページを選択（複数可）
                'post_type'     => ['page'],
                'filters'       => ['search', 'post_type'],
                'return_format' => 'id',          // ★ID返却（重要）
                'multiple'      => 1,
                'instructions'  => 'このFAQを表示したい固定ページを選択してください（複数可）',
            ],
            // 新規追加：カテゴリ（タクソノミー）を選べるフィールド
            // ここでは製品カテゴリ 'products-cat' を対象にする想定です。
            // 他のタクソノミーを対象にしたい場合は 'taxonomy' の値を変更してください。
            [
                'key'           => 'field_faq_display_terms',
                'label'         => '表示するカテゴリ（製品カテゴリ）',
                'name'          => 'display_terms',
                'type'          => 'taxonomy',       // タクソノミー選択フィールド
                'taxonomy'      => 'products-cat',   // ← ここを対象のタクソノミーに変更可
                'field_type'    => 'multi_select',   // 管理画面で複数選択可
                'add_term'      => 0,
                'save_terms'    => 0,
                'load_terms'    => 0,
                'return_format' => 'id',             // term_id を返す（重要）
                'multiple'      => 1,
                'instructions'  => 'このFAQを表示したいカテゴリーページ（製品カテゴリ）を選択してください（複数可）',
            ],
        ],
        'location' => [[
            [
                'param'    => 'post_type',
                'operator' => '==',
                'value'    => 'faq',
            ],
        ]],
        'position'      => 'normal',
        'style'         => 'default',
        'active'        => true,
    ]);
});

/**
 * FAQ 取得用ヘルパー
 * - $args['page_id'] があれば ACF「display_pages」にそのページIDが含まれるFAQを抽出
 * - $args['term_id'] があれば ACF「display_terms」にその term_id が含まれるFAQを抽出
 * - $args['group_by_category'] true でカテゴリごとに配列をグループ化
 *
 * NOTE:
 * - display_pages は relationship (IDs) serialized なので "LIKE" 検索で '"123"' を使う
 * - display_terms は taxonomy フィールドで return_format => 'id' のため serialized array に term_id が含まれるため同様に '"123"' LIKE で検索できます
 */
function get_faq_items($args = []) {
    $defaults = [
        'page_id'           => 0,       // 指定があればページ紐づけで絞り込み
        'term_id'           => 0,       // 指定があればカテゴリ（ターム）紐づけで絞り込み
        'posts_per_page'    => -1,
        'order'             => 'ASC',
        'orderby'           => 'menu_order title',
        'category__in'      => [],      // 指定カテゴリで絞り込み（faq_category）
        'group_by_category' => false,
    ];
    $args = wp_parse_args($args, $defaults);

    $query_args = [
        'post_type'      => 'faq',
        'posts_per_page' => $args['posts_per_page'],
        'order'          => $args['order'],
        'orderby'        => $args['orderby'],
        'tax_query'      => [],
        'meta_query'     => [],
        'no_found_rows'  => true,
    ];

    // ページ指定（ACF relationship は serialized IDs なので "LIKE" 検索）
    if (!empty($args['page_id'])) {
        $page_id = (int) $args['page_id'];
        $query_args['meta_query'][] = [
            'key'     => 'display_pages',
            'value'   => '"' . $page_id . '"',
            'compare' => 'LIKE',
        ];
    }

    // ターム指定（ACF taxonomy フィールドは serialized array で保存されるので同じく LIKE 検索）
    if (!empty($args['term_id'])) {
        $term_id = (int) $args['term_id'];
        $query_args['meta_query'][] = [
            'key'     => 'display_terms',
            'value'   => '"' . $term_id . '"',
            'compare' => 'LIKE',
        ];
    }

    // 複数の meta_query がある場合は OR（どちらかにマッチすれば表示）
    if (count($query_args['meta_query']) > 1) {
        $query_args['meta_query']['relation'] = 'OR';
    }

    // カテゴリで絞る（任意）
    if (!empty($args['category__in'])) {
        $query_args['tax_query'][] = [
            'taxonomy' => 'faq_category',
            'field'    => 'term_id',
            'terms'    => array_map('intval', (array)$args['category__in']),
        ];
    }

    $q = new WP_Query($query_args);

    if (!$args['group_by_category']) return $q;

    // カテゴリごとにグルーピングして返す
    $grouped = [];
    if ($q->have_posts()) {
        while ($q->have_posts()) {
            $q->the_post();
            $terms = get_the_terms(get_the_ID(), 'faq_category') ?: [];
            if (!$terms) {
                $grouped[0]['term'] = null;
                $grouped[0]['posts'][] = get_post();
            } else {
                foreach ($terms as $t) {
                    $tid = $t->term_id;
                    if (!isset($grouped[$tid])) {
                        $grouped[$tid] = ['term' => $t, 'posts' => []];
                    }
                    $grouped[$tid]['posts'][] = get_post();
                }
            }
        }
        wp_reset_postdata();
    }
    return $grouped;
}

/**
 * 表示ショートコード
 * [faq_list] … 現在の固定ページに紐づいたFAQを一括表示（トップや事業詳細で使う）
 * [faq_all]  … 全FAQをカテゴリ分けなしで表示（トップ用など）
 * [faq_archive_like] … カテゴリごとにまとめて表示（一覧ページ用）
 *
 * 変更点：
 * - カテゴリページ（products-cat のアーカイブ）で表示する場合、自動的に現在のタームIDを検出してそのタームに紐づくFAQを抽出します。
 * - shortcode の属性に 'term_id' を渡すことも可能です。
 */

/* [faq_list] */
add_shortcode('faq_list', function ($atts) {
    // 自動判定: タクソノミーアーカイブ(products-cat)なら term_id を取得して渡す
    $current_term_id = 0;
    if (function_exists('is_tax') && is_tax('products-cat')) {
        $queried = get_queried_object();
        if ($queried && isset($queried->term_id)) {
            $current_term_id = (int) $queried->term_id;
        }
    }

    $atts = shortcode_atts([
        'page_id'        => get_the_ID(),
        'term_id'        => $current_term_id,
        'posts_per_page' => -1,
        'accordion'      => '1',
        'more_link'      => '0',
        'archive_url'    => '/faq/',
        'more_label'     => '一覧へ',
    ], $atts, 'faq_list');

    // page_id と term_id の両方を渡すと OR 条件で検索されます（get_faq_items の実装により）
    $q = get_faq_items([
        'page_id'           => (int) $atts['page_id'],
        'term_id'           => (int) $atts['term_id'],
        'posts_per_page'    => (int) $atts['posts_per_page'],
        'group_by_category' => false,
    ]);

    ob_start();
    if ($q->have_posts()) {
        // 先にカテゴリ収集
        $cat_terms = [];
        while ($q->have_posts()) { $q->the_post();
            $terms = get_the_terms(get_the_ID(), 'faq_category') ?: [];
            foreach ($terms as $t) { $cat_terms[$t->slug] = $t; }
        }
        wp_reset_postdata();

        echo '<div class="faq-list" data-accordion="'.esc_attr($atts['accordion']).'">';
        while ($q->have_posts()) { $q->the_post(); ?>
            <div class="faq-item">
                <div class="faq-item__question acor-menu mb-0"><?php echo esc_html(get_the_title()); ?></div>
                <div class="faq-item__answer acor-menu-child w-100 px-3 pb-3 pt-1">
                    <div class="d-flex bg-white px-2 py-2 faq-content__answer__txt"><?php the_content(); ?></div>
                </div>
            </div>
        <?php }
        echo '</div>';
        wp_reset_postdata();

        // 「一覧へ」リンク（該当カテゴリへジャンプ）
        if ($atts['more_link'] === '1' && !empty($cat_terms)) {
            echo '<div class="faq-more-links" style="margin-top:16px;">';
            foreach ($cat_terms as $t) {
                $href = trailingslashit($atts['archive_url']).'#faq-cat-'.rawurlencode($t->slug);
                echo '<a class="btn btn-outline-primary me-2" href="'.esc_url($href).'">'.esc_html($t->name).'の'.esc_html($atts['more_label']).'</a>';
            }
            echo '</div>';
        }
    }
    return ob_get_clean();
});

/* [faq_all] */
add_shortcode('faq_all', function ($atts) {
    // 自動判定: タクソノミーアーカイブ(products-cat)なら term_id を取得して渡す
    $current_term_id = 0;
    if (function_exists('is_tax') && is_tax('products-cat')) {
        $queried = get_queried_object();
        if ($queried && isset($queried->term_id)) {
            $current_term_id = (int) $queried->term_id;
        }
    }

    $atts = shortcode_atts([
        'posts_per_page' => -1,
        'term_id'        => $current_term_id,
        'accordion'      => '1',
        'more_link'      => '0',
        'archive_url'    => '/faq/',
        'more_label'     => '一覧へ',
    ], $atts, 'faq_all');

    $q = get_faq_items([
        'page_id'           => 0,
        'term_id'           => (int) $atts['term_id'],
        'posts_per_page'    => (int) $atts['posts_per_page'],
        'group_by_category' => false,
    ]);

    ob_start();
    if ($q->have_posts()) {

        // 表示中FAQが属するカテゴリを収集（ユニーク）
        $cat_terms = [];
        while ($q->have_posts()) { $q->the_post();
            $terms = get_the_terms(get_the_ID(), 'faq_category') ?: [];
            foreach ($terms as $t) { $cat_terms[$t->slug] = $t; }
        }
        wp_reset_postdata();

        echo '<div class="faq-list" data-accordion="'.esc_attr($atts['accordion']).'">';
        while ($q->have_posts()) { $q->the_post(); ?>
            <div class="faq-item">
                <div class="faq-item__question acor-menu mb-0"><?php echo esc_html(get_the_title()); ?></div>
                <div class="faq-item__answer acor-menu-child w-100 px-3 pb-3 pt-1">
                    <div class="d-flex bg-white px-2 py-2 faq-content__answer__txt"><?php the_content(); ?></div>
                </div>
            </div>
        <?php }
        echo '</div>';
        wp_reset_postdata();

        // カテゴリ別の「一覧へ」リンク（任意）
        if ($atts['more_link'] === '1' && !empty($cat_terms)) {
            echo '<div class="faq-more-links" style="margin-top:16px;">';
            foreach ($cat_terms as $t) {
                $href = trailingslashit($atts['archive_url']).'#faq-cat-'.rawurlencode($t->slug);
                echo '<a class="btn btn-outline-primary me-2" href="'.esc_url($href).'">'.esc_html($t->name).'の'.esc_html($atts['more_label']).'</a>';
            }
            echo '</div>';
        }
    }
    return ob_get_clean();
});

/* [faq_archive_like] （カテゴリごとにまとめて表示） */
add_shortcode('faq_archive_like', function ($atts) {
    $atts = shortcode_atts([
        'accordion' => '1',
    ], $atts, 'faq_archive_like');

    $terms = get_terms(['taxonomy' => 'faq_category', 'hide_empty' => true]);
    ob_start();
    if (!is_wp_error($terms) && $terms) {
        foreach ($terms as $term) {
            $q = new WP_Query([
                'post_type' => 'faq',
                'posts_per_page' => -1,
                'tax_query' => [[
                    'taxonomy' => 'faq_category',
                    'field'    => 'term_id',
                    'terms'    => $term->term_id,
                ]],
                'no_found_rows' => true,
            ]);
            if ($q->have_posts()) {
                echo '<section class="faq-category" id="faq-cat-'.esc_attr($term->slug).'">';
                echo '<h2 class="faq-category__title">'.esc_html($term->name).'</h2>';
                echo '<div class="faq-list" data-accordion="'.esc_attr($atts['accordion']).'">';
                while ($q->have_posts()) {
                    $q->the_post();
                    ?>
                    <div class="faq-item">
						<div class="faq-item__question acor-menu mb-0">
							<?php echo esc_html(get_the_title()); ?>
						</div>
						<div class="faq-item__answer acor-menu-child w-100 px-3 pb-3 pt-1">
							<div class="d-flex bg-white px-2 py-2 faq-content__answer__txt">
								<?php the_content(); ?>
							</div>
						</div>
					</div>
                    <?php
                }
                echo '</div></section>';
                wp_reset_postdata();
            }
        }
    }
    return ob_get_clean();
});

add_action('admin_post_export_media_csv', 'export_media_csv');

function export_media_csv() {
    if (!current_user_can('manage_options')) {
        wp_die('権限がありません。');
    }

    $today     = current_time('Y-m-d');
	$yesterday = date('Y-m-d', strtotime($today . ' -1 day'));

	$args = [
		'post_type'      => 'attachment',
		'post_status'    => 'inherit',
		'posts_per_page' => -1,
		'orderby'        => 'ID',
		'order'          => 'ASC',
		'date_query'     => [
			[
				'after'     => $yesterday . ' 00:00:00',
				'before'    => $today . ' 23:59:59',
				'inclusive' => true,
				'column'    => 'post_date',
			],
		],
	];

    $attachments = get_posts($args);

    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename=media-list.csv');

    $output = fopen('php://output', 'w');

    // Excel文字化け対策
    fwrite($output, "\xEF\xBB\xBF");

    // CSV見出し
    fputcsv($output, ['ファイル名', 'ID', 'URL']);

    foreach ($attachments as $attachment) {
        $id = $attachment->ID;

        $file_path = get_attached_file($id);
        $filename  = $file_path ? basename($file_path) : '';
        $url       = wp_get_attachment_url($id);

        fputcsv($output, [
            $filename,
            $id,
            $url,
        ]);
    }

    fclose($output);
    exit;
}

/**
 * ショールームページの初期表示文言と管理画面の編集項目。
 *
 * 未保存の項目は会社案内 2026 の掲載内容を初期値として表示する。
 */
function kohler_showroom_field_definitions() {
    return [
        'lead_title' => [
            'section' => '導入文',
            'label'   => '見出し',
            'type'    => 'text',
            'default' => '国内ショールームのご案内',
        ],
        'lead_text' => [
            'section' => '導入文',
            'label'   => '説明文',
            'type'    => 'textarea',
            'rows'    => 3,
            'default' => '実物を見て、触れて、使って。国内2拠点（大阪ショールームは改装中）でKOHLERの製品をご体験いただけます。',
        ],
        'tokyo_name' => [
            'section' => '東京ショールーム',
            'label'   => '名称',
            'type'    => 'textarea',
            'rows'    => 2,
            'default' => "KOHLER TOKYO\nSHOWROOM",
        ],
        'tokyo_details' => [
            'section' => '東京ショールーム',
            'label'   => '所在地・営業情報',
            'type'    => 'textarea',
            'rows'    => 3,
            'default' => "東京都港区高輪2-21-38 大野高輪ビル1F\n定休日：日・祝日・年末年始",
        ],
        'tokyo_link_text' => [
            'section' => '東京ショールーム',
            'label'   => 'リンク文言',
            'type'    => 'text',
            'default' => '予約制につきこちらからご予約お願い致します。',
        ],
        'tokyo_link_url' => [
            'section' => '東京ショールーム',
            'label'   => 'リンクURL',
            'type'    => 'url',
            'default' => 'https://jpkohler.com/contact/showroom',
        ],
        'aoyama_name' => [
            'section' => '南青山ショールーム',
            'label'   => '名称',
            'type'    => 'textarea',
            'rows'    => 2,
            'default' => "KOIZUMI with KOHLER\nMINAMI-AOYAMA SHOWROOM",
        ],
        'aoyama_details' => [
            'section' => '南青山ショールーム',
            'label'   => '所在地・営業情報',
            'type'    => 'textarea',
            'rows'    => 4,
            'default' => "東京都港区南青山4-24-1 FAVEUR MINAMIAOYAMA 1F\nTEL 03-6451-1473／10:00〜16:00（完全予約制）\n休館日：土・日・祝日　※東京メトロ表参道駅より徒歩7分",
        ],
        'aoyama_link_text' => [
            'section' => '南青山ショールーム',
            'label'   => 'リンク文言',
            'type'    => 'text',
            'default' => '詳しくはこちらをご覧ください。',
        ],
        'aoyama_link_url' => [
            'section' => '南青山ショールーム',
            'label'   => 'リンクURL',
            'type'    => 'url',
            'default' => 'https://www.koizumi-pb.jp/kohler-concept/',
        ],
        'osaka_status' => [
            'section' => '大阪ショールーム',
            'label'   => 'ステータス',
            'type'    => 'text',
            'default' => '【改装中】',
        ],
        'osaka_name' => [
            'section' => '大阪ショールーム',
            'label'   => '名称',
            'type'    => 'text',
            'default' => 'KOHLER OSAKA SHOWROOM',
        ],
        'osaka_details' => [
            'section' => '大阪ショールーム',
            'label'   => '所在地・営業情報',
            'type'    => 'textarea',
            'rows'    => 5,
            'default' => "大阪市住之江区南港北2-1-10 ATCビル ITM棟9F\nTEL 06-6615-5432\n現在は改装中のためご見学いただけません。\n2027年中の改装完了を予定しています。",
        ],
        'features_title' => [
            'section' => 'ショールームでできること',
            'label'   => '見出し',
            'type'    => 'text',
            'default' => 'ショールームでできること',
        ],
        'features_items' => [
            'section'     => 'ショールームでできること',
            'label'       => '内容（1行につき1項目）',
            'type'        => 'textarea',
            'rows'        => 5,
            'description' => '改行ごとに箇条書きとして表示されます。',
            'default'     => "シャワーや水栓は実際に通水して、使い心地をご確認いただけます。\n陶器・水栓金具のカラーサンプルを取り揃え、仕上げの検討にもご活用いただけます。\nお客さまや設計事務所をご案内いただく場としてもご利用いただけます。",
        ],
    ];
}

function kohler_showroom_get_value($post_id, $field_name) {
    $definitions = kohler_showroom_field_definitions();

    if (!isset($definitions[$field_name])) {
        return '';
    }

    $meta_key = '_kohler_showroom_' . $field_name;
    if (metadata_exists('post', $post_id, $meta_key)) {
        return (string) get_post_meta($post_id, $meta_key, true);
    }

    return $definitions[$field_name]['default'];
}

function kohler_add_showroom_meta_box($post) {
    if (!$post || 'showroom' !== $post->post_name) {
        return;
    }

    add_meta_box(
        'kohler-showroom-content',
        'ショールーム掲載内容',
        'kohler_render_showroom_meta_box',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes_page', 'kohler_add_showroom_meta_box');

function kohler_render_showroom_meta_box($post) {
    $definitions = kohler_showroom_field_definitions();
    $current_section = '';

    wp_nonce_field('kohler_save_showroom_fields', 'kohler_showroom_nonce');
    echo '<p>ショールームページに表示する文字とリンク先を編集できます。未保存の項目には会社案内の文言が表示されます。</p>';

    foreach ($definitions as $field_name => $definition) {
        if ($current_section !== $definition['section']) {
            if ('' !== $current_section) {
                echo '</tbody></table>';
            }
            $current_section = $definition['section'];
            echo '<h3 style="margin-top:24px;">' . esc_html($current_section) . '</h3>';
            echo '<table class="form-table" role="presentation"><tbody>';
        }

        $input_id = 'kohler_showroom_' . $field_name;
        $value = kohler_showroom_get_value($post->ID, $field_name);
        echo '<tr><th scope="row"><label for="' . esc_attr($input_id) . '">' . esc_html($definition['label']) . '</label></th><td>';

        if ('textarea' === $definition['type']) {
            $rows = isset($definition['rows']) ? (int) $definition['rows'] : 3;
            echo '<textarea class="large-text" rows="' . esc_attr($rows) . '" id="' . esc_attr($input_id) . '" name="kohler_showroom[' . esc_attr($field_name) . ']">' . esc_textarea($value) . '</textarea>';
        } else {
            echo '<input class="large-text" type="' . esc_attr($definition['type']) . '" id="' . esc_attr($input_id) . '" name="kohler_showroom[' . esc_attr($field_name) . ']" value="' . esc_attr($value) . '">';
        }

        if (!empty($definition['description'])) {
            echo '<p class="description">' . esc_html($definition['description']) . '</p>';
        }
        echo '</td></tr>';
    }

    if ('' !== $current_section) {
        echo '</tbody></table>';
    }
}

function kohler_save_showroom_fields($post_id) {
    if (
        !isset($_POST['kohler_showroom_nonce']) ||
        !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['kohler_showroom_nonce'])), 'kohler_save_showroom_fields') ||
        (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) ||
        wp_is_post_revision($post_id) ||
        !current_user_can('edit_post', $post_id) ||
        'page' !== get_post_type($post_id)
    ) {
        return;
    }

    $submitted = isset($_POST['kohler_showroom']) && is_array($_POST['kohler_showroom'])
        ? wp_unslash($_POST['kohler_showroom'])
        : [];

    foreach (kohler_showroom_field_definitions() as $field_name => $definition) {
        if (!array_key_exists($field_name, $submitted)) {
            continue;
        }

        $value = 'url' === $definition['type']
            ? esc_url_raw($submitted[$field_name])
            : ('textarea' === $definition['type'] ? sanitize_textarea_field($submitted[$field_name]) : sanitize_text_field($submitted[$field_name]));

        update_post_meta($post_id, '_kohler_showroom_' . $field_name, $value);
    }
}
add_action('save_post_page', 'kohler_save_showroom_fields');
