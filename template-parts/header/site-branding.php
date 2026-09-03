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
	<li class="menu-list__parent__list">
		<a href="<?php echo get_home_url(); ?>" class="menu-list__parent__link d-block py-3 py-lg-0 ">
			<div class="text-lg-center d-flex d-lg-block align-items-center">
				<p class="letter-spacing-title d-block mb-0 fw-bolder me-3 me-lg-0">
					トップページ
				</p>
			</div>
		</a>
	</li>
	<li class="menu-list__parent__list">
		<a href="/products/" class="menu-list__parent__link d-block py-3 py-lg-0">
			<div class="d-flex align-items-center">
				<div class="text-lg-center d-flex d-lg-block align-items-center">
					<p class="letter-spacing-title d-block mb-0 fw-bolder me-3 me-lg-0">
						商品情報
					</p>
				</div>
			</div>
		</a>
		<?php
			$taxonomy = 'products-cat';
			$terms = get_terms(
				$taxonomy,
				array(
					'parent' => 0,
					'hide_empty' => false, 
				),
			);
			if ($terms) :
		?>
		<div class="js-menu_child menu-list__child">
			<ul class="list-unstyled row">
				<?php
					foreach ($terms as $the_term):
						$term_id = $the_term->term_id;
						$term_name =  $the_term->name;
						$term_slug =  $the_term->slug;
						$term_field_ids = $taxonomy."_".$term_id;
						$product_cat_img = get_field('product_cat_img', $term_field_ids);
						$product_cat_about = get_field('product_cat_about', $term_field_ids);
				?>
				<li class="menu-list__child__list col-3">
					<a href="<?php echo '/'.$taxonomy.'/'.$term_slug.'/'; ?>" class="menu-list__child__link hover-transform-end pb-2 d-block">
						<div class="parent-tit__link d-flex justify-content-between align-items-center">
							<p class="nav_menu-tit footer mb-0"><?php echo $term_name; ?></p>
							<img class="link-arrow" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/common/link-arrow.png">
						</div>
					</a>
					<div class="product-link_list d-flex">
						<div class="product-link_list__item col-4">
							<img src="<?php echo $product_cat_img; ?>" alt="<?php echo $term_name; ?>">
						</div>
						<?php
							$children_terms = get_terms(
								$taxonomy,
								array(
									'parent' => $term_id,
								),
							);
							if ($children_terms) :
						?>
						<div class="product-link_list__item col-8">
							<?php
								foreach ($children_terms as $the_c_term):
									$c_term_id = $the_c_term->term_id;
									$c_term_name =  $the_c_term->name;
									$c_term_slug =  $the_c_term->slug;
							?>
							<div class="product-link_list__item__name">
								<a href="<?php echo '/'.$taxonomy.'/'.$c_term_slug.'/'; ?>" class="menu-list__child__link hover-transform-end pb-2 d-block">
									<div class="parent-tit__link d-flex justify-content-between align-items-center px-1">
										<p class="nav_menu-tit footer mb-0 px-1"><?php echo $c_term_name; ?></p>
										<i class="fa-solid fa-chevron-right"></i>
									</div>
								</a>
							</div>
							<?php endforeach; ?>
							<!-- <div class="product-link_list__item__name">
								<a href="" class="menu-list__child__link hover-transform-end pb-2 d-block">
									<div class="parent-tit__link d-flex justify-content-between align-items-center px-1">
										<p class="nav_menu-tit footer mb-0 px-1">洗面ボウル</p>
										<i class="fa-solid fa-chevron-right"></i>
									</div>
								</a>
							</div>
							<div class="product-link_list__item__name">
								<a href="" class="menu-list__child__link hover-transform-end pb-2 d-block">
									<div class="parent-tit__link d-flex justify-content-between align-items-center px-1">
										<p class="nav_menu-tit footer mb-0 px-1">ミラー・ミラーキャビネット</p>
										<i class="fa-solid fa-chevron-right"></i>
									</div>
								</a>
							</div>
							<div class="product-link_list__item__name">
								<a href="" class="menu-list__child__link hover-transform-end pb-2 d-block">
									<div class="parent-tit__link d-flex justify-content-between align-items-center px-1">
										<p class="nav_menu-tit footer mb-0 px-1">バスアクセサリー</p>
										<i class="fa-solid fa-chevron-right"></i>
									</div>
								</a>
							</div>
							<div class="product-link_list__item__name">
								<a href="" class="menu-list__child__link hover-transform-end pb-2 d-block">
									<div class="parent-tit__link d-flex justify-content-between align-items-center px-1">
										<p class="nav_menu-tit footer mb-0 px-1">洗面給排水金物</p>
										<i class="fa-solid fa-chevron-right"></i>
									</div>
								</a>
							</div> -->
						</div>
						<?php endif; ?>
					</div>
				</li>
				<?php
					endforeach;
				?>
				<!-- <li class="menu-list__child__list col-3">
					<a href="" class="menu-list__child__link hover-transform-end pb-2 d-block">
						<div class="parent-tit__link d-flex justify-content-between align-items-center">
							<p class="nav_menu-tit footer mb-0">キッチン</p>
							<img class="link-arrow" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/common/link-arrow.png">
						</div>
					</a>
					<div class="product-link_list d-flex">
						<div class="product-link_list__item col-4">
							<img src="http://kohler2024re.xsrv.jp/cms/wp-content/uploads/2024/06/kitchen_th.jpg" alt="キッチン">
						</div>
						<div class="product-link_list__item col-8">
							<div class="product-link_list__item__name">
								<a href="" class="menu-list__child__link hover-transform-end pb-2 d-block">
									<div class="parent-tit__link d-flex justify-content-between align-items-center px-1">
										<p class="nav_menu-tit footer mb-0 px-1">キッチン水栓</p>
										<i class="fa-solid fa-chevron-right"></i>
									</div>
								</a>
							</div>
							<div class="product-link_list__item__name">
								<a href="" class="menu-list__child__link hover-transform-end pb-2 d-block">
									<div class="parent-tit__link d-flex justify-content-between align-items-center px-1">
										<p class="nav_menu-tit footer mb-0 px-1">キッチンシンク</p>
										<i class="fa-solid fa-chevron-right"></i>
									</div>
								</a>
							</div>
							<div class="product-link_list__item__name">
								<a href="" class="menu-list__child__link hover-transform-end pb-2 d-block">
									<div class="parent-tit__link d-flex justify-content-between align-items-center px-1">
										<p class="nav_menu-tit footer mb-0 px-1">キッチンアクセサリー</p>
										<i class="fa-solid fa-chevron-right"></i>
									</div>
								</a>
							</div>
							<div class="product-link_list__item__name">
								<a href="" class="menu-list__child__link hover-transform-end pb-2 d-block">
									<div class="parent-tit__link d-flex justify-content-between align-items-center px-1">
										<p class="nav_menu-tit footer mb-0 px-1">キッチン給排水金物</p>
										<i class="fa-solid fa-chevron-right"></i>
									</div>
								</a>
							</div>
						</div>
					</div>
				</li>
				<li class="menu-list__child__list col-3">
					<a href="" class="menu-list__child__link hover-transform-end pb-2 d-block">
						<div class="parent-tit__link d-flex justify-content-between align-items-center">
							<p class="nav_menu-tit footer mb-0">バス</p>
							<img class="link-arrow" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/common/link-arrow.png">
						</div>
					</a>
					<div class="product-link_list d-flex">
						<div class="product-link_list__item col-4">
							<img src="http://kohler2024re.xsrv.jp/cms/wp-content/uploads/2024/06/bath_th.jpg" alt="バス">
						</div>
						<div class="product-link_list__item col-8">
							<div class="product-link_list__item__name">
								<a href="" class="menu-list__child__link hover-transform-end pb-2 d-block">
									<div class="parent-tit__link d-flex justify-content-between align-items-center px-1">
										<p class="nav_menu-tit footer mb-0 px-1">シャワー</p>
										<i class="fa-solid fa-chevron-right"></i>
									</div>
								</a>
							</div>
							<div class="product-link_list__item__name">
								<a href="" class="menu-list__child__link hover-transform-end pb-2 d-block">
									<div class="parent-tit__link d-flex justify-content-between align-items-center px-1">
										<p class="nav_menu-tit footer mb-0 px-1">バスタブ</p>
										<i class="fa-solid fa-chevron-right"></i>
									</div>
								</a>
							</div>
							<div class="product-link_list__item__name">
								<a href="" class="menu-list__child__link hover-transform-end pb-2 d-block">
									<div class="parent-tit__link d-flex justify-content-between align-items-center px-1">
										<p class="nav_menu-tit footer mb-0 px-1">バス水栓</p>
										<i class="fa-solid fa-chevron-right"></i>
									</div>
								</a>
							</div>
						</div>
					</div>
				</li>
				<li class="menu-list__child__list col-3">
					<a href="" class="menu-list__child__link hover-transform-end pb-2 d-block">
						<div class="parent-tit__link d-flex justify-content-between align-items-center">
							<p class="nav_menu-tit footer mb-0">ミラー・ミラーキャビネット</p>
							<img class="link-arrow" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/common/link-arrow.png">
						</div>
					</a>
					<div class="product-link_list d-flex">
						<div class="product-link_list__item col-4">
							<img src="http://kohler2024re.xsrv.jp/cms/wp-content/uploads/2024/06/mirror-cabinet_th.jpg" alt="ミラー・ミラーキャビネット">
						</div>
						<div class="product-link_list__item col-8">
							<div class="product-link_list__item__name">
								<a href="" class="menu-list__child__link hover-transform-end pb-2 d-block">
									<div class="parent-tit__link d-flex justify-content-between align-items-center px-1">
										<p class="nav_menu-tit footer mb-0 px-1">ミラー・ミラーキャビネット</p>
										<i class="fa-solid fa-chevron-right"></i>
									</div>
								</a>
							</div>
						</div>
					</div>
				</li> -->
			</ul>
		</div>
		<?php endif; ?>
	</li>
	<?php
		foreach($header_menu as $menu) :
			if ($menu['header_menu_url']) {
				$tag = 'a';
			} else {
				$tag = 'div';
			}
	?>
		<li class="menu-list__parent__list">
			<<?php echo $tag; ?> class="menu-list__parent__link d-block py-3 py-lg-0" 
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
				// $sub_menus = $menu['header_sub_menus'];
				// var_dump($menu['header_sub_menus']);
				if (!empty($menu['header_sub_menus'])) :
			?>
			<div class="js-menu_child menu-list__child">
				<ul class="list-unstyled row">
					<?php foreach($menu['header_sub_menus'] as $sub_menu) : ?>
						<li class="menu-list__child__list <?php if ($sub_menu['header_sub_menu_class']) echo $sub_menu['header_sub_menu_class']; ?> col-3">
							<a href="<?php echo $sub_menu['header_sub_menu_url']; ?>" <?php if ($sub_menu['header_sub_menu_blank']) echo 'target="_blank"'; ?> class="menu-list__child__link hover-transform-end pb-1 d-block">
								<div class="menu-list__child__list__link d-flex justify-content-between align-items-center px-1">
									<p class="nav_menu-tit footer mb-0 px-1"><?php echo $sub_menu['header_sub_menu_title']; ?></p>
									<img class="link-arrow" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/common/link-arrow.png">
								</div>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
	<!-- <li class="menu-list__parent__list">
		<button id="js-search_trigger_pc" class="hamburger-btn col py-1">
			<i class="fa-solid fa-magnifying-glass"></i>
			<span>商品検索</span>
		</button>
		<div id="js-search_modal_pc" class="js-modal_box" style="display: none;">
			<div class="js-modal_close sitemap__header__close d-flex align-items-center my-2">
				<button class="w-100 bg-transparent text-dark d-block m-0 p-0 position-absolute">
					<p class="fw-bold mb-0 py-3 d-flex justify-content-center align-items-center"><i class="fa-solid fa-xmark pe-2 fs-6"></i><span>閉じる</span></p>
				</button>
			</div>
			<?php //get_template_part( 'template-parts/search/search', 'product' ); ?>
		</div>
	</li> -->
</ul>
<?php endif; ?>
