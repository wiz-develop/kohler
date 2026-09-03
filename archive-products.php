<?php
/**
 * Template Name: 商品紹介
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();

// $img_block = CFS()->get('img_block');
?>
	<div class="page">
		<div class="page-header m-0 position-relative<?php //if ($img_block === 0) echo ' header-bg'; ?>">
			<!-- <?php if ('page_top_img'):?>
			<div class="page-header__tit  position-absolute">
				<h1 class="mb-0"><?php the_title(); ?><span class="d-block"><?php echo CFS()->get('page_tit_en'); ?></span></h1>
			</div>
			<?php else: ?>
			<div class="page-header__tit">
				<h1 class="mb-0"><?php the_title(); ?><span class="d-block"><?php echo CFS()->get('page_tit_en'); ?></span></h1>
			</div>
			<?php endif;?>
			<?php if ('page_top_img'):?>
			<div class="page-header__img">
				<img src="<?php echo CFS()->get('page_top_img'); ?>" alt="<?php the_title(); ?>">
			</div>
			<?php endif;?> -->

			<div class="page-header__tit  position-absolute">
				<h1 class="mb-0">商品紹介<span class="d-block">products</span></h1>
			</div>
			<div class="page-header__img">
				<img src="/cms/wp-content/uploads/2024/06/slide2_pc-scaled.jpg" alt="商品紹介">
			</div>
		</div>
		<section class="content_page-product">
			<div class="content">
				<div class="row">
					<div class="search-content col-12 col-lg-3">
						<?php get_template_part( 'template-parts/search/search', 'product' ); ?>
					</div>
					<div class="product-content col-12 col-lg-9">
						<?php get_template_part( 'template-parts/content/content', 'product' ); ?>
					</div>
				</div>
			</div>
		</section>
	</div>
<?php
get_footer();
