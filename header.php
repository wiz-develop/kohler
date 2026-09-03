<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */
$setting_page = get_page_by_path('setting');
$setting_page_id = $setting_page->ID;
$site_logo = CFS()->get('site_logo', $setting_page_id);
$company_name = CFS()->get('company_name', $setting_page_id);
$description = CFS()->get('description', $setting_page_id);
$keywords = CFS()->get('keywords', $setting_page_id);

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-PMSJFX7V');</script>
	<!-- End Google Tag Manager -->
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta charset="utf-8">
	<meta name="description" content="<?php echo $description; ?>">
    <meta name="keywords" content="<?php echo $keywords; ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="Expires" content="0">
	<meta name="theme-color" content="#4A3A3A">
	<meta name="theme-color" media="(prefers-color-scheme: light)" content="#C78F8F">
	<meta name="theme-color" media="(prefers-color-scheme: dark)" content="#4A3A3A">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PMSJFX7V"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php wp_body_open(); ?>
<div id="page" class="site-content overflow-visible">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentynineteen' ); ?></a>

		<header id="masthead" class="site-header py-0 position-sticky top-0">
			<div class="bg-white">
				<div class="d-lg-flex align-items-center justify-content-between pl-5">
					<div class="company-logo pe-lg-3 mx-auto mx-lg-0">
						<?php
							if (is_front_page()) {
								$tag = 'h1';
							} else {
								$tag = 'p';
							}
						?>
						<a href="<?php echo get_home_url(); ?>">
							<<?php echo $tag; ?> class="logo_img">
								<img src="<?php echo $site_logo ?>" alt="<?php echo $company_name ?>">
							</<?php echo $tag; ?>>
						</a>
					</div>
					<div class="site-header__menu d-none d-lg-block p-0">
						<nav class="menu-list">
							<?php get_template_part( 'template-parts/header/site', 'branding', ['parts' => 'header'] ); ?>
						</nav>
					</div>
				</div>
			</div>
		</header><!-- #masthead -->

	<div id="content" class="site-content">
		<?php if (!is_front_page()) : ?>
			<div class="breadcrumb mb-0">
                <div class="content container px-0">
					<?php breadcrumb(); ?>
                </div>
            </div>
		<?php endif; ?>
		<main>
