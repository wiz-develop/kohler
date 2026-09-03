<div class="footer-sitemap mt-2">
	<div class="menu-list row">
		<div class="menu-list__item col-12 col-lg-4">
			<div class="parent-tit<?php if(wp_is_mobile()) : ?> ac-parent<?php endif; ?>">
				<p class="nav_menu-tit footer mb-0 px-2">商品情報</p>
			</div>
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
			<div class="child-list <?php if(wp_is_mobile()) : ?> ac-child<?php else: ?> d-flex flex-wrap<?php endif; ?>">
				<?php
					foreach ($terms as $the_term):
						$term_id = $the_term->term_id;
						$term_name =  $the_term->name;
						$term_slug =  $the_term->slug;
						$term_field_ids = $taxonomy."_".$term_id;
						$product_cat_img = get_field('product_cat_img', $term_field_ids);
						$product_cat_about = get_field('product_cat_about', $term_field_ids);
				?>
				<div class="child-list__item col-12 col-lg-6 px-2 mb-3">
					<div class="child-list__item__name mb-1">
						<p class="nav_menu-tit footer mb-0"><?php echo $term_name; ?></p>
					</div>
					<?php
						$children_terms = get_terms(
							$taxonomy,
							array(
								'parent' => $term_id,
							),
						);
						if ($children_terms) :
							foreach ($children_terms as $the_c_term):
								$c_term_id = $the_c_term->term_id;
								$c_term_name =  $the_c_term->name;
								$c_term_slug =  $the_c_term->slug;
					?>
					<div class="child-list__item__link px-1">
						<a href="<?php echo '/'.$taxonomy.'/'.$c_term_slug.'/'; ?>">
							<div class="child-list__item__link__name d-flex justify-content-between align-items-center">
								<p class="nav_menu-tit footer mb-0 fw-normal"><?php echo $c_term_name; ?></p>
								<i class="fa-solid fa-chevron-right grandchild-arrow"></i>
							</div>
						</a>
					</div>
					<?php
							endforeach;
						endif;
					?>
				</div>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
		<div class="menu-list__item col-12 col-lg-4">
			<div class="parent-tit border-bottom-0 mb-0 pb-2">
				<a href="<?php echo get_home_url() ; ?>/product-catalogue/">
					<div class="parent-tit__link d-flex justify-content-between align-items-center px-1">
						<p class="nav_menu-tit footer mb-0 px-1">カタログ</p>
						<img class="link-arrow" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/common/link-arrow.png">
					</div>
				</a>
			</div>
			<div class="parent-tit<?php if(wp_is_mobile()) : ?> mb-0 ac-parent<?php endif; ?>"<?php if(wp_is_mobile()) : ?> style="padding-bottom: .5rem;"<?php endif; ?>>
				<?php if(!wp_is_mobile()) : ?><a href="/portfolio/"><?php endif; ?>
					<div class="parent-tit__link d-flex justify-content-between align-items-center px-1">
						<p class="nav_menu-tit footer mb-0 px-1">施工事例</p>
						<?php if(!wp_is_mobile()) : ?><img class="link-arrow" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/common/link-arrow.png"><?php endif; ?>
					</div>
				<?php if(!wp_is_mobile()) : ?></a><?php endif; ?>
			</div>
			<div class="child-list<?php if(wp_is_mobile()) : ?> ac-child<?php endif; ?>"<?php if(wp_is_mobile()) : ?> style="border-top: 0;"<?php endif; ?>>
				<div class="child-list__item px-2">
					<a href="/portfolio-cat/domestic/">
						<div class="child-list__item__link d-flex justify-content-between align-items-center">
							<p class="nav_menu-tit footer mb-0 fw-normal">国内</p>
							<img class="link-arrow footer-link pe-0 ps-2" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/common/link-arrow.png">
						</div>
					</a>
				</div>
				<div class="child-list__item px-2">
					<a href="/portfolio-cat/foreign/">
						<div class="child-list__item__link d-flex justify-content-between align-items-center">
							<p class="nav_menu-tit footer mb-0 fw-normal">海外</p>
							<img class="link-arrow footer-link pe-0 ps-2" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/common/link-arrow.png">
						</div>
					</a>
				</div>
				<div class="child-list__item px-2">
					<a href="https://www.studiokohler.com" target="_blank">
						<div class="child-list__item__link d-flex justify-content-between align-items-center">
							<p class="nav_menu-tit footer mb-0 fw-normal">Studio KOHLER</p>
							<img class="link-arrow footer-link pe-0 ps-2" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/common/link-arrow.png">
						</div>
					</a>
				</div>
			</div>
			<div class="parent-tit border-bottom-0 mb-0 pb-2">
				<a href="/whats-new/">
					<div class="parent-tit__link d-flex justify-content-between align-items-center px-1">
						<p class="nav_menu-tit footer mb-0 px-1">新着情報</p>
						<img class="link-arrow" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/common/link-arrow.png">
					</div>
				</a>
			</div>
		</div>
		<div class="menu-list__item col-12 col-lg-4">
			<div class="parent-tit<?php if(wp_is_mobile()) : ?> mb-0 ac-parent<?php endif; ?>" style="border-bottom: solid 1px white; padding-bottom: .5rem;">
				<p class="mb-0 px-2">KOHLERについて</p>
			</div>
			<div class="child-list<?php if(wp_is_mobile()) : ?> ac-child<?php endif; ?>" style="border-top: 0;">
				<div class="child-list__item px-2">
					<a href="<?php echo get_home_url() ; ?>/company/about/">
						<div class="child-list__item__link d-flex justify-content-between align-items-center">
							<p class="nav_menu-tit footer mb-0 fw-normal">KOHLERとは</p>
							<img class="link-arrow footer-link pe-0 ps-2" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/common/link-arrow.png">
						</div>
					</a>
				</div>
				<div class="child-list__item px-2">
					<a href="<?php echo get_home_url() ; ?>/company/history/">
						<div class="child-list__item__link d-flex justify-content-between align-items-center">
							<p class="nav_menu-tit footer mb-0 fw-normal">ヒストリー</p>
							<img class="link-arrow footer-link pe-0 ps-2" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/common/link-arrow.png">
						</div>
					</a>
				</div>
				<div class="child-list__item px-2">
					<a href="<?php echo get_home_url() ; ?>/company/group/">
						<div class="child-list__item__link d-flex justify-content-between align-items-center">
							<p class="nav_menu-tit footer mb-0 fw-normal">ビジネスグループ</p>
							<img class="link-arrow footer-link pe-0 ps-2" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/common/link-arrow.png">
						</div>
					</a>
				</div>
				<div class="child-list__item px-2">
					<a href="<?php echo get_home_url() ; ?>/company/sustainability/">
						<div class="child-list__item__link d-flex justify-content-between align-items-center">
							<p class="nav_menu-tit footer mb-0 fw-normal">サステナビリティ</p>
							<img class="link-arrow footer-link pe-0 ps-2" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/common/link-arrow.png">
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>