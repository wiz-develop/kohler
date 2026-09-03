<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();

$back_url = 'news';
$article_title = get_the_title();

$date = get_the_date('Y.m.d');
$cat_data = get_the_terms(get_the_ID(), 'portfolio-cat');
$cat_id_text = 'portfolio-cat_'.$cat_data[0]->term_id;
$cat_color = get_field('cat_color', $cat_id_text);
?>

	<div class="page">
		<div class="content mt-5">
			<div class="container-fluid">
				<div class="content-post row">
					<div class="col-12 col-lg-8">
						<?php
							while ( have_posts() ) :
								the_post();
						?>
							<div class="d-flex align-items-center mb-2">
								<div class="content-post__date me-2">
									<time datetime="<?php the_date('Y-m-d'); ?>"><?php echo $date; ?></time>
								</div>
								<?php if ($cat_data) : ?>
								<div class="content-post__cat rounded-pill px-3 py-1 me-2" <?php if($cat_color) echo 'style="background-color: '.$cat_color.'"'; ?>>
									<p class="mb-0 text-white"><?php echo $cat_data[0]->name; ?></p>
								</div>
								<?php endif; ?>
							</div>
							<?php
								if ($article_title) {
									echo '<h1 class="content-post__title letter-spacing-title fs-5 fw-bolder mb-3">'.$article_title.'</h1>';
								}
							?>
							<div class="content-post__main clearfix">
								<?php the_content(); ?>
							</div>
							<div class="content-post__footer my-5 d-sm-flex align-items-sm-center">
								<?php
									$prevpost = get_adjacent_post(); //前の記事
									$nextpost = get_adjacent_post( false, '', false ); //次の記事
								?>
								<div class="next-article-btn me-sm-2">
									<?php if ( $prevpost ) : ?>
										<div class="link-btn white-btn text-center">
											<a href="<?php echo get_permalink($prevpost->ID); ?>">
												<button class="px-4">
													<p class="mb-0"><i class="fa-solid fa-chevron-left ps-0 pe-1"></i>過去の記事</p>
												</button>
											</a>
										</div>
									<?php endif; ?>
								</div>
                                <div class="next-article-btn">
									<div class="link-btn black-btn text-center">
										<a href="/portfolio/">
											<button class="px-4">
												<p class="mb-0">記事一覧へ戻る</p>
											</button>
										</a>
									</div>
								</div>
								<div class="next-article-btn ms-sm-2">
									<?php if ( $nextpost ) : ?>
										<div class="link-btn white-btn text-center">
											<a href="<?php echo get_permalink($nextpost->ID); ?>">
												<button class="px-4">
													<p class="mb-0">新しい記事<i class="fa-solid fa-chevron-right"></i></p>
												</button>
											</a>
										</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endwhile; ?>
					</div>
					<aside class="col-12 col-lg-4">
						<?php get_sidebar('portfolio'); ?>
					</aside>
				</div>
			</div>
		</div>
	</div>
<?php
get_footer();
