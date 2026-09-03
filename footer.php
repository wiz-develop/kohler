<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

$setting_page = get_page_by_path('setting');
$setting_page_id = $setting_page->ID;
$company_name = CFS()->get('company_name', $setting_page_id);
$site_logo = CFS()->get('site_logo', $setting_page_id);
$footer_logo = CFS()->get('footer_logo', $setting_page_id);

?>
		</main>
	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="site-footer__item main mb-4 pt-4 row justify-content-between align-items-center">
				<div class="footer-logo pe-0">
					<img src="<?php echo $footer_logo; ?>" alt="<?php echo $company_name; ?>">
				</div>
				<div class="sns-list d-flex ps-0">
					<?php
						foreach( CFS()->get('sns_list', $setting_page_id) as $sns_list ) :
					?>
					<div class="sns-list__item col-3 px-1">
						<a href="<?php echo $sns_list['sns_url']; ?>" target="_blank">
							<div class="footer-link__name">
								<img src="<?php echo $sns_list['sns_icon']; ?>" alt="<?php echo $sns_list['sns_name']; ?>">
							</div>
						</a>
					</div>
					<?php
						endforeach;
					?>
				</div>
			</div>
			<div class="site-footer__item sub pb-2 row px-0">
				<?php
					foreach( CFS()->get('footer_menu_list', $setting_page_id) as $footer_menu_list ) :
						$footer_menu_blank = $footer_menu_list['footer_menu_blank'];
				?>
				<div class="footer-link col-12 col-lg-4">
					<a href="<?php echo $footer_menu_list['footer_menu_url']; ?>" <?php if ($footer_menu_blank === 1) echo 'target="_blank"'; ?>>
						<div class="footer-link__name">
							<p class="nav_menu-tit footer mb-0"><img class="link-arrow footer-link pe-2" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/common/link-arrow.png"><?php echo $footer_menu_list['footer_menu_name']; ?></p>
						</div>
					</a>
				</div>
				<?php
					endforeach;
				?>
			</div>
			<?php get_template_part( 'template-parts/nav/nav', 'menu' ); ?>
			<div class="bg-body-dark text-white pb-3">
				<div class="container px-0">
					<?php get_template_part('template-parts/footer/footer-menu'); ?>
					<p class="copylight fs-7 mt-4 mb-0 text-center">&copy; Kohler Co. All Rights Reserved</p>
				</div>
			</div>
		</div>
	</footer><!-- #colophon -->

	<div class="footer_hamburger bg-body-dark d-lg-none position-fixed top-0 container-fluid">
		<div class="row align-items-center">
			<button id="js-sitemap_trigger" class="hamburger-btn sitemap-btn col py-1">
				<svg class="hamburger-btn__img d-block ps-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 37 30">
					<g transform="translate(3663 -4780)">
						<rect width="37" height="30" transform="translate(-3663 4780)" fill="none"/>
						<g transform="translate(0 1)">
						<rect width="25" height="3" rx="1.5" transform="translate(-3657 4784)"/>
						<rect width="25" height="3" rx="1.5" transform="translate(-3657 4793)"/>
						<rect width="25" height="3" rx="1.5" transform="translate(-3657 4802)"/>
						</g>
					</g>
				</svg>
			</button>
			<div class="hamburger-btn company-logo pe-lg-3 mx-auto mx-lg-0">
				<?php
					if (is_front_page()) {
						$tag = 'h1';
					} else {
						$tag = 'p';
					}
				?>
				<a href="<?php echo get_home_url(); ?>">
					<<?php echo $tag; ?> class="logo_img mx-auto pt-1 mb-0">
						<img src="<?php echo $site_logo ?>" alt="<?php echo $company_name ?>">
					</<?php echo $tag; ?>>
				</a>
			</div>
			<button id="js-search_trigger" class="hamburger-btn search_btn col py-1" style="opacity: 0; pointer-events: none;">
				<i class="fa-solid fa-magnifying-glass pe-3"></i>
			</button>
			<!-- <div id="js-search_modal" class="search_modal js-modal_box" style="display: none;">
				<div class="js-modal_close sitemap__header__close position-relative d-flex align-items-center my-2">
					<button class="w-100 bg-transparent text-dark d-block m-0 p-0 position-absolute">
						<p class="fw-bold mb-0 py-3 d-flex justify-content-center align-items-center"><i class="fa-solid fa-xmark pe-2 fs-6"></i><span>閉じる</span></p>
					</button>
				</div>
				<?php get_template_part( 'template-parts/search/search', 'product' ); ?>
			</div> -->
		</div>
	</div>
	<div id="js-sitemap_modal" class="js-modal_box" style="display: none;">
		<div class="sitemap sitemap__header__close position-absolute w-100 top-0 bottom-0 start-0 end-0 margin-auto bg-black">
			<div class="sitemap__header position-fixed w-100 bg-black">
				<div class="px-4">
					<div class="js-modal_close sitemap__header__close position-relative d-flex align-items-center my-2">
						<button class="w-100 bg-transparent text-dark d-block m-0 p-0 position-absolute">
							<p class="fw-bold mb-0 py-3 d-flex justify-content-center align-items-center"><i class="fa-solid fa-xmark pe-2 fs-6"></i><span>閉じる</span></p>
						</button>
					</div>
				</div>
			</div>
			<div class="sitemap__content pb-5">
				<div class="footer-sitemap">
					<div class="menu-list row">
						<div class="menu-list__item col-12 col-lg-4">
							<div class="parent-tit border-bottom-0 mb-0 pb-2">
								<a href="<?php echo home_url(); ?>">
									<div class="parent-tit__link d-flex justify-content-between align-items-center px-1">
										<p class="nav_menu-tit footer mb-0 px-1">トップページ</p>
										<img class="link-arrow" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/common/link-arrow.png">
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="header-sitemap">
					<?php get_template_part( 'template-parts/nav/nav', 'menu' ); ?>
				</div>
				<div class="site-footer__item sub py-2 row">
				<?php
					foreach( CFS()->get('footer_menu_list', $setting_page_id) as $footer_menu_list ) :
						$footer_menu_blank = $footer_menu_list['footer_menu_blank'];
				?>
					<div class="footer-link col-12 col-lg-4">
						<a href="<?php echo $footer_menu_list['footer_menu_url']; ?>" <?php if ($footer_menu_blank === 1) echo 'target="_blank"'; ?>>
							<div class="footer-link__name">
								<p class="nav_menu-tit footer mb-0"><img class="link-arrow footer-link pe-2" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/common/link-arrow.png"><?php echo $footer_menu_list['footer_menu_name']; ?></p>
							</div>
						</a>
					</div>
					<?php
						endforeach;
					?>
				</div>
			</div>
		</div>
	</div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
