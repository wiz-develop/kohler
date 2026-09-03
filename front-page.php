<?php
/**
 * Template Name: トップページ
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();
$catalog_about = CFS()->get('catalog_about');
$concept_about = CFS()->get('concept_about');
$concept_catch = CFS()->get('concept_catch');
$contact_about = CFS()->get('contact_about');
$link_list = CFS()->get('link_list');
?>

	<div id="front-page" class="front-page">
		<section class="content_first-view py-0">
			<div class="slick-first_view">
				<?php
					$slide_fields = CFS()->get('top_slide_list');
					foreach ($slide_fields as $slide_field) :
						$slide_tit = $slide_field['slide_tit'];
						$slide_about = $slide_field['slide_about'];
						$slide_link = $slide_field['slide_link'];
						$slide_blank = $slide_field['slide_blank'];
						$slide_img_pc = $slide_field['slide_img_pc'];
						$slide_img_sp= $slide_field['slide_img_sp'];
				?>
					<div class="slick-first_view__item">
						<?php if ($slide_link) : ?>
						<a href="<?php echo $slide_link; ?>" <?php if ($slide_blank === 1) echo 'target="_blank"'; ?>>
						<?php endif; ?>
						<div class="slick-first_view__item__img">
							<img src="<?php echo $slide_img_sp; ?>" alt="<?php echo $slide_tit; ?>" class="d-block d-md-none">
							<img src="<?php echo $slide_img_pc; ?>" alt="<?php echo $slide_tit; ?>" class="d-none d-md-block">
						</div>
						<?php if ($slide_link) : ?>
						</a>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="slick-first_view_text_wrap">
				<div class="slick-first_view_text">
					<?php
						$slide_field = [];
						$slide_tit = [];
						$slide_about = [];
						foreach ($slide_fields as $slide_field) :
							$slide_tit = $slide_field['slide_tit'];
							$slide_about = $slide_field['slide_about'];
					?>
						<div class="slick-first_view_text__about">
							<h3 class="fw-bold"><?php echo $slide_tit; ?></h3>
							<p class="mb-0"><?php echo $slide_about; ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<section class="content_product">
			<div class="content">
				<div class="content-header text-center">
					<h2>商品情報<span class="d-block">PRODUCT</span></h2>
				</div>
				<?php if(wp_is_mobile()) : ?>
				<div class="content_product__menu row anime">
					<div class="content_product__menu__item col-6 text-center">
						<a href="#washroom">
							<button>
								<p class="mb-0 d-flex justify-content-center align-items-center"><span class="d-block">洗面</span><i class="fa-solid fa-chevron-right fa-rotate-90"></i></p>
							</button>
						</a>
					</div>
					<div class="content_product__menu__item col-6 text-center">
						<a href="#kitchen">
							<button>
								<p class="mb-0 d-flex justify-content-center align-items-center"><span class="d-block">キッチン</span><i class="fa-solid fa-chevron-right fa-rotate-90"></i></p>
							</button>
						</a>
					</div>
					<div class="content_product__menu__item col-6 text-center">
						<a href="#bath">
							<button>
								<p class="mb-0 d-flex justify-content-center align-items-center"><span class="d-block">バス</span><i class="fa-solid fa-chevron-right fa-rotate-90"></i></p>
							</button>
						</a>
					</div>
					<div class="content_product__menu__item col-6 text-center">
						<a href="#mirror-cabinet">
							<button>
								<p class="mb-0 d-flex justify-content-center align-items-center"><span class="d-block">ミラー・ミラーキャビネット</span><i class="fa-solid fa-chevron-right fa-rotate-90"></i></p>
							</button>
						</a>
					</div>
				</div>
				<?php endif; ?>
				<div class="content-body">
					<?php get_template_part( 'template-parts/content/content', 'product' ); ?>
				</div>
			</div>
		</section>
		<section class="content_portfolio position-relative">
			<div class="content position-relative">
				<div class="content-header text-center anime">
					<h2>施工事例<span class="d-block">REMODEL PORTFOLIO</span></h2>
				</div>
				<?php
					if (wp_is_mobile()) {
						$slick_on_posts = 1;
					} else {
						$slick_on_posts = 3;
					}

					// 国内
					$portfolio_d_args = array(
						'post_type' => 'portfolio',
						'taxonomy' => 'portfolio-cat',
						'term' => 'domestic',
						'orderby' => 'date',
						'posts_per_page' => '5',
					);
					$domestic_query = get_posts( $portfolio_d_args );
					$domestic_count = count($domestic_query);

					// 海外
					$portfolio_f_args = array(
						'post_type' => 'portfolio',
						'taxonomy' => 'portfolio-cat',
						'term' => 'foreign',
						'orderby' => 'date',
						'posts_per_page' => '5',
					);
					$foreign_query = get_posts( $portfolio_f_args );
					$foreign_count = count($foreign_query);

				?>
				<div class="content-body">
					<div class="btn-list row justify-content-center">
						<div class="btn-list__item col-6">
							<button id="domestic-tab" class="active" data-bs-target="#domestic" type="button" role="tab">
								<p class="mb-0">日本</p>
							</button>
						</div>
						<div class="btn-list__item col-6">
							<button id="foreign-tab" class="" data-bs-toggle="tab" data-bs-target="#foreign" type="button" role="tab">
								<p class="mb-0">海外</p>
							</button>
						</div>
					</div>
					<div id="js-portfolio-tab" class="portfolio-tab position-relative w-100">
						<div id="domestic" class="article-list active position-absolute d-block" role="tabpanel" aria-labelledby="domestic-tab">
							<?php if ( $domestic_query ): ?>
							<div class="slick-portfolio <?php if ($domestic_count <= $slick_on_posts) echo 'slick-off'; ?>">
								<?php
									foreach ( $domestic_query as $post ) : setup_postdata( $post );
										$postid = get_the_ID();
										$portfolio_img = CFS()->get('portfolio_img_pc', $postid);
										$portfolio_about = CFS()->get('portfolio_about', $postid);
								?>
								<article>
									<a href="<?php the_permalink();?>">
										<div class="slick-portfolio__item">
											<div class="slick-portfolio__item__img">
												<img src="<?php echo $portfolio_img; ?>" alt="<?php strip_tags(get_the_title()); ?>">
											</div>
											<div class="slick-portfolio__item__about">
												<h3 class="text-white"><?php the_title(); ?></h3>
												<?php if ($portfolio_about) echo '<p class="mb-0">'.$portfolio_about.'</p>'; ?>
											</div>
										</div>
									</a>
								</article>
								<?php endforeach; ?>
							</div>
							<?php else : ?>
								<p class="mb-0">準備中です。</p>
							<?php endif; wp_reset_postdata(); ?>
							<div class="link-btn white-btn">
								<a href="/portfolio-cat/domestic/">
									<button>
										<p class="mb-0">一覧へ<i class="fa-solid fa-chevron-right"></i></p>
									</button>
								</a>
							</div>
						</div>
						<div id="foreign" class="article-list position-absolute d-block" role="tabpanel" aria-labelledby="foreign-tab">
							<?php if ( $foreign_query ): ?>
							<div class="slick-portfolio <?php if ($foreign_count <= $slick_on_posts) echo 'slick-off'; ?>">
								<?php
									foreach ( $foreign_query as $post ) : setup_postdata( $post );
										$postid = get_the_ID();
										$portfolio_img = CFS()->get('portfolio_img_pc', $postid);
										$portfolio_about = CFS()->get('portfolio_about', $postid);
								?>
								<article>
									<a href="<?php the_permalink();?>">
										<div class="slick-portfolio__item">
											<div class="slick-portfolio__item__img">
												<img src="<?php echo $portfolio_img; ?>" alt="<?php strip_tags(get_the_title()); ?>">
											</div>
											<div class="slick-portfolio__item__about">
												<h3 class="text-white"><?php the_title(); ?></h3>
												<?php if ($portfolio_about) echo '<p class="mb-0">'.$portfolio_about.'</p>'; ?>
											</div>
										</div>
									</a>
								</article>
								<?php endforeach; ?>
							</div>
							<?php else : ?>
								<p class="mb-0">準備中です。</p>
							<?php endif; wp_reset_postdata(); ?>
							<div class="link-btn white-btn">
								<a href="/portfolio-cat/foreign/">
									<button>
										<p class="mb-0">一覧へ<i class="fa-solid fa-chevron-right"></i></p>
									</button>
								</a>
							</div>
						</div>
					</div>

				</div>
			</div>
			<div class="content_portfolio__bg position-absolute bottom-0">
				<?php if(wp_is_mobile()) : ?>
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/top/portfolio-bg_sp.png">
				<?php else : ?>
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/top/portfolio-bg_pc.png">
				<?php endif; ?>
			</div>
		</section>
		<section class="content_news">
			<div class="content row">
				<div class="content-header col-12 col-lg-3 anime">
					<h2>新着情報<span class="d-block">NEWS</span></h2>
					<?php if(!wp_is_mobile()) : ?>
					<div class="link-btn black-btn">
						<a href="<?php echo home_url(); ?>/news/">
							<button class="px-4">
								<p class="mb-0">一覧へ<i class="fa-solid fa-chevron-right"></i></p>
							</button>
						</a>
					</div>
					<?php endif; ?>
				</div>
				<div class="content-body col-12 col-lg-9">
					<div class="article-list anime">
						<?php
							$args = array(
								'post_type' => 'post',
								'category_name' => 'whats-new',
								'orderby' => 'date',
								'posts_per_page' => '3',
							);
							$args = get_posts( $args );
							if ( $args ) :
								foreach ($args as $post) : setup_postdata( $post );
									$days = 7;
									$now = wp_date('U');
									$entry = get_the_time('U');
									$term = date('U', ($now - $entry)) / 86400;
									$cat_data = get_the_category();
									$cat_id_text = 'category_'.$cat_data[0]->term_id; 
									$cat_color = get_field('cat_color', $cat_id_text);
						?>
						<article>
							<a href="<?php the_permalink();?>">
								<div class="article__header d-flex align-items-baseline">
									<?php
										if( $days > $term ) {
											echo '<div class="new pe-2"><p class="mb-0 fw-bold">NEW</p></div>';
										}
									?>
									<div class="date pe-2">
										<time datetime="<?php the_time('Y.m.d'); ?>"><?php the_time('Y.m.d'); ?></time>
									</div>
									<div class="cat px-3 rounded-pill" <?php if($cat_color) echo 'style="background-color: '.$cat_color.'"'; ?>>
										<p class="mb-0"><?php echo $cat_data[0]->cat_name; ?></p>
									</div>
								</div>
								<div class="article__body">
									<h3><?php the_title();?></h3>
								</div>
							</a>
						</article>
						<?php
								endforeach;
								else :
									echo '<p class="mb-0">最新の記事はありません</p>';
								wp_reset_postdata();
							endif;
						?>
						<?php if(wp_is_mobile()) : ?>
						<div class="link-btn black-btn">
							<a href="<?php echo home_url(); ?>/domestic/">
								<button class="px-4">
									<p class="mb-0">一覧へ<i class="fa-solid fa-chevron-right"></i></p>
								</button>
							</a>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>
		<section class="content_concept">
			<div class="content">
				<div class="content-header anime">
					<h2><?php echo $concept_catch; ?><span class="d-block">CONCEPT</span></h2>
				</div>
				<div class="content-body anime">
					<p class="mb-0"><?php echo $concept_about; ?></p>
				</div>
				<div class="link-btn white-btn mt-4 anime">
					<a href="<?php echo home_url(); ?>/company/about/">
						<button class="px-4">
							<p class="mb-0">詳細へ<i class="fa-solid fa-chevron-right"></i></p>
						</button>
					</a>
				</div>
			</div>
		</section>
		<div class="row p-0">
			<section class="content_catalog col-12 col-lg-6 position-relative">
				<div class="content_catalog__bg position-absolute top-0 end-0">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/top/catalog_bg.png">
				</div>
				<div class="content position-relative anime">
					<div class="content-header">
						<h2>カタログ<span class="d-block">CATALOG</span></h2>
					</div>
					<div class="content-body anime">
						<p class="mb-0"><?php echo $catalog_about; ?></p>
					</div>
					<div class="link-btn white-btn mt-4 anime">
						<a href="<?php echo home_url(); ?>/product-catalogue/">
							<button class="px-4">
								<p class="mb-0">一覧へ<i class="fa-solid fa-chevron-right"></i></p>
							</button>
						</a>
					</div>
				</div>
			</section>
			<section class="content_contact col-12 col-lg-6 position-relative">
				<div class="content position-relative anime">
					<div class="content-header">
						<h2>お問合せ<span class="d-block">CONTACT</span></h2>
					</div>
					<div class="content-body anime">
						<p class="mb-0"><?php echo $contact_about; ?></p>
					</div>
					<div class="link-btn black-btn mt-4 anime">
						<a href="<?php echo home_url(); ?>/contact/">
							<button class="px-4">
								<p class="mb-0">お問合せフォームへ<i class="fa-solid fa-chevron-right"></i></p>
							</button>
						</a>
					</div>
				</div>
				<div class="content_contact__bg position-absolute bottom-0">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/top/contact_bg.png">
				</div>
			</section>
		</div>
		<section class="content_information">
			<div class="content">
				<div class="content_information__list row justify-content-center">
					<?php
						foreach ($link_list as $link_lists) :
							$link_name = $link_lists['link_name'];
							$link_icon = $link_lists['link_icon'];
							$link_url = $link_lists['link_url'];
							$link_blank = $link_lists['link_blank'];
					?>
					<div class="content_information__list__item col-12 col-lg-3 anime">
						<a href="<?php echo $link_url ;?>" <?php if ($link_blank === 1) echo 'target="_blank"'; ?>>
							<div class="link-icon mx-auto">
								<img src="<?php echo $link_icon ;?>" alt="<?php echo $link_name ;?>">
							</div>
							<div class="link-name d-flex justify-content-between align-items-center px-1">
								<p class="mb-0 px-1"><?php echo $link_name ;?></p>
								<img class="link-arrow" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/common/link-arrow_black.png">
							</div>
						</a>
					</div>
					<?php
						endforeach;
					?>
				</div>
			</div>
		</section>
	</div>

	<script>
		class ParallaxEffectBackground {
		constructor() {
			this.devided = 10;
			this.target = '.content_concept';
			this.setBackgroundPosition();
		}

		getScrollTop() {
			return Math.max(
			window.pageYOffset,
			document.documentElement.scrollTop,
			document.body.scrollTop,
			window.scrollY
			);
		}

		setBackgroundPosition() {
			document.addEventListener('scroll', e => {
			const scrollTop = this.getScrollTop();
			const position = scrollTop / this.devided;
			// console.log('scrollTop: '+scrollTop);
			// console.log('position: '+position);
			if (position) {
				document.querySelectorAll(this.target).forEach(element => {
				element.style.backgroundPosition = 'center bottom -' + position + 'px';
				});
			}
			});
		}
		}

		document.addEventListener('DOMContentLoaded', event => {
		new ParallaxEffectBackground();
		});
	</script>
<?php
get_footer();
