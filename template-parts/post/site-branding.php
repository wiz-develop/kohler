<?php
/**
 * Displays header site branding
 *
 * @package WordPress
 * @subpackage wiz
 * @since wiz 2022.7
 */

$parts = $args['parts'];
$setting_page = get_page_by_path('setting');
$setting_page_id = $setting_page->ID;

?>
<?php
	$header_menu = CFS()->get('header_menu', $setting_page_id);
	if ($header_menu) :
?>
<ul class="menu-list__parent list-unstyled mb-0 d-lg-flex align-items-lg-center">
	<li class="menu-list__parent__list position-relative">
		<a href="<?php echo get_home_url(); ?>" class="menu-list__child__link px-4 px-lg-3 py-2 d-block">
			トップページ
		</a>
	</li>
	<li class="menu-list__parent__list position-relative">
		<a href="<?php echo get_home_url(); ?>" class="menu-list__child__link px-4 px-lg-3 py-2 d-block">
			商品情報
		</a>
	</li>
	<?php
		foreach($header_menu as $menu) :
			if ($menu['header_menu_url']) {
				$tag = 'a';
			} else {
				$tag = 'div';
			}
	?>
		<li class="menu-list__parent__list position-relative">
			<<?php echo $tag; ?> class="menu-list__parent__link d-block py-3 py-lg-0 px-4 px-lg-3 position-relative <?php if ($parts == 'footer' && $sub_menus) echo 'js-menu_child_open'; ?>" 
				<?php if ($menu['header_menu_url']) echo 'href="'.$menu['header_menu_url'].'"'; ?> <?php if ($menu['header_menu_blank']) echo 'target="_blank"'; ?>
			>
				<div class="d-flex align-items-center">
					<div class="text-lg-center d-flex d-lg-block align-items-center">
						<p class="letter-spacing-title d-block mb-0 fw-bolder me-3 me-lg-0">
							<?php echo $menu['header_menu_name']; ?>
						</p>
					</div>
					<div class="ms-auto d-lg-none">
						<svg class="open-icon" xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21">
							<defs>
								<style>.a{fill:#0F5398;}.b{fill:none;stroke:#fff;stroke-width:3px;}</style>
							</defs>
							<g transform="translate(-0.443 -0.04)">
								<circle class="a" cx="10.5" cy="10.5" r="10.5" transform="translate(0.443 0.039)"></circle>
								<line class="b" x2="12.12" transform="translate(4.557 10.764)"></line>
								<line class="b" x2="12.12" transform="translate(10.617 4.704) rotate(90)"></line>
							</g>
						</svg>
						<svg class="close-icon" xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21">
							<defs>
								<style>.a{fill:#0F5398;}.b{fill:none;stroke:#fff;stroke-width:3px;}</style>
							</defs>
							<g transform="translate(-0.443 -0.04)">
								<circle class="a" cx="10.5" cy="10.5" r="10.5" transform="translate(0.443 0.039)"></circle>
								<line class="b" x2="12.12" transform="translate(4.557 10.764)"></line>
							</g>
						</svg>
					</div>
				</div>
			</<?php echo $tag; ?>>
			<?php	
				$sub_menus = CFS()->get('header_sub_menus', $setting_page_id);
				if ($sub_menus) :
			?>
			<div class="js-menu_child menu-list__child">
				<ul class="list-unstyled">
					<?php foreach($sub_menus as $sub_menu) : ?>
						<li class="menu-list__child__list <?php if ($sub_menu['header_sub_menu_class']) : ?><?php echo $sub_menu['header_sub_menu_class']; ?><?php endif; ?> position-relative">
							<a href="<?php echo $sub_menu['header_sub_menu_url']; ?>" <?php if ($sub_menu['header_sub_menu_blank']) echo 'target="_blank"'; ?> class="menu-list__child__link hover-transform-end px-4 px-lg-3 py-2 d-block">
								<?php echo $sub_menu['header_sub_menu_title']; ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
	<li>
		<button id="js-sitemap_trigger" class="hamburger-btn bg-body-dark col py-1">
			<i class="fa-solid fa-magnifying-glass"></i>
			<span>商品検索</span>
		</button>
	</li>
</ul>
<?php endif; ?>
