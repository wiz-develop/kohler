<?php
/**
 * Template Name: ヒストリー
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();

$img_block = CFS()->get('img_block');
$page_top_img = CFS()->get('page_top_img');
$history_list = CFS()->get('history_list');
?>
	<div class="page">
		<div class="page-header position-relative<?php if ($img_block === 0) echo ' header-bg'; ?>">
			<div class="page-header__tit<?php if ($img_block === 1) echo ' position-absolute'; ?>">
				<h1 class="mb-0"><?php the_title(); ?><span class="d-block"><?php echo CFS()->get('page_tit_en'); ?></span></h1>
			</div>
			<?php if ($page_top_img):?>
			<div class="page-header__img">
				<img src="<?php echo $page_top_img; ?>" alt="<?php the_title(); ?>">
			</div>
			<?php endif;?>
		</div>
		<section class="content_history">
			<div class="content">
                <?php the_content();?>
                <?php
                    foreach ($history_list as $history_lists) :
                        $history_year = $history_lists['history_year'];
                        $history_th = $history_lists['history_th'];
                        $history_about = $history_lists['history_about'];
                ?>
				<div class="content-item row py-3">
                    <div class="year col-12 col-md-3 col-lg-2"><p class="mb-0 fw-bold fs-5"><?php echo $history_year; ?><span class="ps-1">年</span></p></div>
                    <div class="history_th col-4 col-md-3 col-lg-2"><img src="<?php echo $history_th; ?>"></div>
                    <div class="history_about col-8 col-md-6 col-lg-8"><p class="mb-0"><?php echo $history_about; ?></p></div>
                </div>
                <?php
                    endforeach;
                ?>
			</div>
		</section>
		<div class="link-btn black-btn text-center mb-5">
			<a href="/company/">
				<button class="px-4">
					<p class="mb-0">一覧へ<i class="fa-solid fa-chevron-right"></i></p>
				</button>
			</a>
		</div>
	</div>
<?php
get_footer();
