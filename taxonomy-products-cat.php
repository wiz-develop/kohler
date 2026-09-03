<?php
/**
 * Template Name: 商品情報カテゴリー詳細
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();

// $taxonomy = $queried_object->taxonomy;
// $term_object = get_queried_object();
// $product_cat_img = get_field('product_cat_img', $term_object);
// $product_cat_about = get_field('product_cat_about', $term_object);
$taxonomy = 'products-cat';
$term_object = get_queried_object();
// var_dump($term_object);

$term_id = $term_object->term_id;
$term_name =  $term_object->name;
$term_slug =  $term_object->slug;
$term_field_ids = $taxonomy."_".$term_id;
$product_cat_img = get_field('product_cat_img', $term_field_ids);
$product_cat_img_sp = get_field('product_cat_img_sp', $term_field_ids);
$product_cat_about = get_field('product_cat_about', $term_field_ids);

// 親カテゴリー取得
if (!$product_cat_img && !$product_cat_img_sp) {
	$ancestors = get_ancestors( $term_id, $taxonomy );
	$parent_id = array_shift( $ancestors );
	$term_field_parent_ids = $taxonomy."_".$parent_id;
	$product_cat_img = get_field('product_cat_img', $term_field_parent_ids);
	$product_cat_img_sp = get_field('product_cat_img_sp', $term_field_parent_ids);
}

// 指定する ACF 名（ここを変更してください）
$control_acf_name = 'main_catch'; // ← ここにあなたの ACF フィールド名を入れる

// 現在タームにその ACF が設定されているか（設定されていれば truthy）
$control_acf_value = $control_acf_name ? get_field( $control_acf_name, $term_field_ids ) : null;

// 補助フィールド（else ブロックで使用）
$product_cat_about  = get_field( 'product_cat_about', $term_field_ids );
$main_catch  = get_field( 'main_catch', $term_field_ids );
$main_catch_img  = get_field( 'main_catch_img', $term_field_ids );
$sub_catch  = get_field( 'sub_catch', $term_field_ids );
$product_cat_detail  = get_field( 'product_cat_detail', $term_field_ids );
$merit_about  = get_field( 'merit_about', $term_field_ids );
$merit1_tit  = get_field( 'merit1_tit', $term_field_ids );
$merit2_tit  = get_field( 'merit2_tit', $term_field_ids );
$merit3_tit  = get_field( 'merit3_tit', $term_field_ids );
$merit1_img  = get_field( 'merit1_img', $term_field_ids );
$merit2_img  = get_field( 'merit2_img', $term_field_ids );
$merit3_img  = get_field( 'merit3_img', $term_field_ids );
$merit1_about  = get_field( 'merit1_about', $term_field_ids );
$merit2_about  = get_field( 'merit2_about', $term_field_ids );
$merit3_about  = get_field( 'merit3_about', $term_field_ids );
$main_products_about  = get_field( 'main_products_about', $term_field_ids );
$main_product1_name  = get_field( 'main_product1_name', $term_field_ids );
$main_product2_name  = get_field( 'main_product2_name', $term_field_ids );
$main_product3_name  = get_field( 'main_product3_name', $term_field_ids );
$main_product1_img  = get_field( 'main_product1_img', $term_field_ids );
$main_product2_img  = get_field( 'main_product2_img', $term_field_ids );
$main_product3_img  = get_field( 'main_product3_img', $term_field_ids );
$main_product1_about  = get_field( 'main_product1_about', $term_field_ids );
$main_product2_about  = get_field( 'main_product2_about', $term_field_ids );
$main_product3_about  = get_field( 'main_product3_about', $term_field_ids );
$main_product1_link  = get_field( 'main_product1_link', $term_field_ids );
$main_product2_link  = get_field( 'main_product2_link', $term_field_ids );
$main_product3_link  = get_field( 'main_product3_link', $term_field_ids );
$recommend_about  = get_field( 'product_cat_about', $term_field_ids );
$recommend_bg  = get_field( 'recommend_bg', $term_field_ids );
$recommend_point1_tit  = get_field( 'recommend_point1_tit', $term_field_ids );
$recommend_point2_tit  = get_field( 'recommend_point2_tit', $term_field_ids );
$recommend_point3_tit  = get_field( 'recommend_point3_tit', $term_field_ids );
$recommend_point1_icon  = get_field( 'recommend_point1_icon', $term_field_ids );
$recommend_point2_icon  = get_field( 'recommend_point2_icon', $term_field_ids );
$recommend_point3_icon  = get_field( 'recommend_point3_icon', $term_field_ids );
$recommend_point1_about  = get_field( 'recommend_point1_about', $term_field_ids );
$recommend_point2_about  = get_field( 'recommend_point2_about', $term_field_ids );
$recommend_point3_about  = get_field( 'recommend_point3_about', $term_field_ids );

// 親判定（デフォルト：トップレベルを親とみなす）
$is_top_level = ( isset( $term_object->parent ) && $term_object->parent == 0 );

// もし「子を持つカテゴリを親とみなす」なら下を有効化して $is_parent_term に変更してください。
// $children = get_terms(array('taxonomy'=>$taxonomy,'parent'=>$term_id,'hide_empty'=>false));
// $has_children = ( ! is_wp_error($children) && count($children) > 0 );
// $is_parent_term = $has_children;

// デフォルト（トップレベル OR 別の親定義に変えたい場合は上を利用）
$is_parent_term = $is_top_level;
?>
	<div class="page page-products-cat">
		<div class="page-header position-relative m-0">
			<div class="page-header__tit position-absolute">
				<h1 class="mb-0"><?php echo $term_name; ?></h1>
			</div>
			<div class="page-header__img">
				<?php if ($product_cat_img) : ?>
					<img src="<?php echo $product_cat_img; ?>" alt="<?php echo $term_name; ?>" class="d-none d-md-block">
				<?php else: ?>
					<img src="/cms/wp-content/uploads/2024/06/slide2_pc-scaled.jpg" alt="<?php echo $term_name; ?>" class="d-none d-md-block">
				<?php endif; ?>
				<?php if ($product_cat_img_sp) : ?>
					<img src="<?php echo $product_cat_img_sp; ?>" alt="<?php echo $term_name; ?>" class="d-md-none">
				<?php else: ?>
					<img src="/cms/wp-content/uploads/2024/10/top-slide_sp2.jpg" alt="<?php echo $term_name; ?>" class="d-md-none">
				<?php endif; ?>
			</div>
		</div>
		<?php if ( $is_parent_term && $control_acf_value ) : ?>
		<div class="content_product_cat-archive pb-0">
			<section class="content_cat-about content">
				<div class="main-catch mb-3">
					<p class="main-catch__line"><?php echo $main_catch; ?></p>
				</div>
				<div class="row align-items-start gx-4">
					<div class="content_cat-about__main col-12 col-lg-8">
						<div class="hero-image position-relative">
							<img src="<?php echo $main_catch_img; ?>" class="img-fluid w-100 hero-image__img">
						</div>
					</div>
					<div class="content_cat-about__sub col-12 col-lg-4">
						<h3 class="sub-catch"><?php echo $sub_catch; ?></h3>
						<p class="sub-text"><?php echo $product_cat_detail; ?></p>
					</div>
				</div>
			</section>
			<section class="content_area features-section">
				<div class="row gx-5 align-items-start content">
					<div class="content_area__inner">
						<h2 class="content_area__title">特長</h2>
						<p class="content_area__sub">MERIT</p>
						<p class="content_area__desc"><?php echo $merit_about; ?></p>
					</div>
					<div class="content-body px-0 mb-0">
						<div class="row gx-4 gy-5">
							<div class="col-12 col-lg-4 content_area_card">
								<h3 class="content_area_card__title"><?php echo $merit1_tit; ?></h3>
								<div class="content_area_card__media position-relative">
									<img src="<?php echo $merit1_img; ?>" class="img-fluid w-100">
								</div>
								<p class="content_area_card__desc"><?php echo $merit1_about; ?></p>
							</div>
							<div class="col-12 col-lg-4 content_area_card">
								<h3 class="content_area_card__title"><?php echo $merit2_tit; ?></h3>
								<div class="content_area_card__media position-relative">
									<img src="<?php echo $merit2_img; ?>" class="img-fluid w-100">
								</div>
								<p class="content_area_card__desc"><?php echo $merit2_about; ?></p>
							</div>
							<div class="col-12 col-lg-4 content_area_card">
								<h3 class="content_area_card__title"><?php echo $merit3_tit; ?></h3>
								<div class="content_area_card__media position-relative">
									<img src="<?php echo $merit3_img; ?>" class="img-fluid w-100">
								</div>
								<p class="content_area_card__desc"><?php echo $merit3_about; ?></p>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="content_area main-product_section">
				<div class="row gx-5 align-items-start content">
					<div class="content_area__inner">
						<h2 class="content_area__title">主力商品</h2>
						<p class="content_area__sub">PRODUCT</p>
						<p class="content_area__desc"><?php echo $main_products_about; ?></p>
					</div>
					<div class="content-body px-0 mb-0">
						<div class="row gx-4 gy-5">
							<div class="col-12 col-lg-4 content_area_card">
								<h3 class="content_area_card__title"><?php echo $main_product1_name; ?></h3>
								<div class="content_area_card__media position-relative">
									<img src="<?php echo $main_product1_img; ?>" class="img-fluid w-100">
								</div>
								<p class="content_area_card__desc"><?php echo $main_product1_about; ?></p>
								<div class="link-btn black-btn">
									<a href="<?php echo home_url() ; ?>/<?php echo $main_product1_link; ?>">
										<button>
											<p class="mb-0"><?php echo $main_product1_name; ?>の商品を見る<i class="fa-solid fa-chevron-right"></i></p>
										</button>
									</a>
								</div>
							</div>
							<div class="col-12 col-lg-4 content_area_card">
								<h3 class="content_area_card__title"><?php echo $main_product2_name; ?></h3>
								<div class="content_area_card__media position-relative">
									<img src="<?php echo $main_product2_img; ?>" class="img-fluid w-100">
								</div>
								<p class="content_area_card__desc"><?php echo $main_product2_about; ?></p>
								<div class="link-btn black-btn">
									<a href="<?php echo home_url() ; ?>/<?php echo $main_product2_link; ?>">
										<button>
											<p class="mb-0"><?php echo $main_product2_name; ?>の商品を見る<i class="fa-solid fa-chevron-right"></i></p>
										</button>
									</a>
								</div>
							</div>
							<div class="col-12 col-lg-4 content_area_card">
								<h3 class="content_area_card__title"><?php echo $main_product3_name; ?></h3>
								<div class="content_area_card__media position-relative">
									<img src="<?php echo $main_product3_img; ?>" class="img-fluid w-100">
								</div>
								<p class="content_area_card__desc"><?php echo $main_product3_about; ?></p>
								<div class="link-btn black-btn">
									<a href="<?php echo home_url() ; ?>/<?php echo $main_product3_link; ?>">
										<button>
											<p class="mb-0"><?php echo $main_product3_name; ?>の商品を見る<i class="fa-solid fa-chevron-right"></i></p>
										</button>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="content_area recommend_section" style="background-image: url(<?php echo $recommend_bg; ?>);">
				<div class="row gx-5 align-items-start content">
					<div class="content_area__inner">
						<h2 class="content_area__title">こんな人におすすめ</h2>
						<p class="content_area__sub">RECOMMEND</p>
						<p class="content_area__desc"><?php echo $recommend_about; ?></p>
					</div>
					<div class="content-body px-0 mb-0">
						<div class="row gx-4 gy-5">
							<div class="col-12 col-lg-4 content_area_card">
								<h3 class="content_area_card__title"><?php echo $recommend_point1_tit; ?></h3>
								<div class="content_area_card__media position-relative">
									<img src="<?php echo $recommend_point1_icon; ?>" class="img-fluid w-100">
								</div>
								<p class="content_area_card__desc"><?php echo $recommend_point1_about; ?></p>
							</div>
							<div class="col-12 col-lg-4 content_area_card">
								<h3 class="content_area_card__title"><?php echo $recommend_point2_tit; ?></h3>
								<div class="content_area_card__media position-relative">
									<img src="<?php echo $recommend_point2_icon; ?>" class="img-fluid w-100">
								</div>
								<p class="content_area_card__desc"><?php echo $recommend_point2_about; ?></p>
							</div>
							<div class="col-12 col-lg-4 content_area_card">
								<h3 class="content_area_card__title"><?php echo $recommend_point3_tit; ?></h3>
								<div class="content_area_card__media position-relative">
									<img src="<?php echo $recommend_point3_icon; ?>" class="img-fluid w-100">
								</div>
								<p class="content_area_card__desc"><?php echo $recommend_point3_about; ?></p>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="content_area faq_section">
				<div class="row gx-5 align-items-start content">
					<div class="content_area__inner">
						<h2 class="content_area__title">よくあるご質問</h2>
						<p class="content_area__sub">FAQ</p>
						<p class="content_area__desc"><?php echo $main_products_about; ?></p>
					</div>
					<div class="content-body px-0 mb-0">
						<?php echo do_shortcode('[faq_list posts_per_page="15"]'); ?>
					</div>
				</div>
			</section>
			<section class="content_area contact_section">
				<div class="row gx-5 align-items-center content">
					<div class="col-12 col-lg-6">
						<div class="content_area__inner">
							<h2 class="content_area__title">お問い合わせ</h2>
							<p class="content_area__sub">CONTACT</p>
							<p class="content_area__desc">商品に関するお問い合わせ、ご不明点など、お気軽にご相談ください。<br>専門スタッフが迅速に対応させていただきます。</p>
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="row gx-4 gy-5">
							<div class="contact-link_list d-flex flex-column align-items-center justify-content-center">
								<a class="btn-contact btn-contact--primary w-100 mb-2" href="/contact/">お問い合わせ</a>
								<a class="btn-contact btn-contact--outline w-100" href="/catalogue-request/">カタログ資料請求</a>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<?php else : ?>
		<div class="content_product_cat-archive">
			<div class="content">
				<?php if ( $product_cat_about ) : ?>
					<div class="content-body">
						<p class="mb-0"><?php echo wp_kses_post( $product_cat_about ); ?></p>
					</div>
				<?php endif; ?>

				<?php
				$args = array(
					'post_type'      => 'products',
					'posts_per_page' => -1,
					'meta_key'       => 'product_display_order',
					'orderby'        => 'meta_value_num',
					'order'          => 'ASC',
					'tax_query'      => array(
						array(
							'taxonomy' => $taxonomy,
							'field'    => 'slug',
							'terms'    => $term_slug,
						),
					),
				);
				$query = new WP_Query( $args );
				if ( $query->have_posts() ) :
				?>
					<div class="product_cat-archive__list row">
						<?php
						while ( $query->have_posts() ) : $query->the_post();
							// CFS を使っている想定（必要なら global $cfs; を有効にする）
							if ( ! isset( $cfs ) ) {
								global $cfs;
							}
							$image_pc = $cfs->get( 'product_image_pc' );
							$image_sp = $cfs->get( 'product_image_sp' );
							$colors   = $cfs->get( 'product_colors' );
						?>
						<div class="product_cat-archive__list__item col-6 col-lg-3">
							<a href="<?php the_permalink(); ?>">
								<div class="cat-img">
									<?php if ( $image_pc ) : ?>
										<img src="<?php echo esc_url( $image_pc ); ?>" alt="<?php echo esc_attr( strip_tags( get_the_title() ) ); ?>" class="<?php if ( $image_sp ) echo 'd-none d-sm-block'; ?>">
									<?php elseif ( ! empty( $colors[0]['color_file_1'] ) ) : ?>
										<img src="<?php echo esc_url( $colors[0]['color_file_1'] ); ?>" alt="<?php echo esc_attr( strip_tags( get_the_title() ) ); ?>" class="<?php if ( $image_sp ) echo 'd-none d-sm-block'; ?>">
									<?php endif; ?>

									<?php if ( $image_sp ) : ?>
										<img src="<?php echo esc_url( $image_sp ); ?>" alt="<?php echo esc_attr( strip_tags( get_the_title() ) ); ?>" class="d-sm-none">
									<?php endif; ?>
								</div>
								<div class="cat-name d-flex justify-content-between align-items-center">
									<p class="nav_menu-tit footer mb-0 text-dark"><?php the_title(); ?></p>
									<img class="link-arrow" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/common/link-arrow_black.png' ); ?>">
								</div>
							</a>
						</div>
						<?php endwhile; ?>
					</div>
				<?php else : ?>
					<p class="mb-0">準備中です。</p>
				<?php endif; wp_reset_postdata(); ?>
			</div>
			<div class="link-btn black-btn text-center">
				<a href="/products/">
					<button class="px-4">
						<p class="mb-0">一覧へ<i class="fa-solid fa-chevron-right"></i></p>
					</button>
				</a>
			</div>
		</div>
		<?php endif; ?>
	</div>
<?php
get_footer();
