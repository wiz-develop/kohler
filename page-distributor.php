<?php
/**
 * Template Name: 店舗一覧
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
$shop_list = CFS()->get('shop_list');
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
                <?php if ($shop_list) : ?>
                    <div class="row">
                    <?php
                        foreach ($shop_list as $shop_lists) :
                            $shop_name = $shop_lists['shop_name'];
                            $shop_about = $shop_lists['shop_about'];
                            $shop_link = $shop_lists['shop_link'];
                            $shop_link_blank = $shop_lists['shop_link_blank'];
                    ?>
                    <div class="content-item py-3 col-12 col-lg-6">
                        <div class="history_about d-block">
                            <p class="mb-2 fw-bold"><?php echo $shop_name; ?></p>
                            <p class="mb-0"><?php echo $shop_about; ?></p>
                            <?php if ($shop_link):?>
                            <a href="<?php echo $shop_link; ?>"<?php if ($shop_link_blank === 1) echo ' target="_blank"'; ?>>
                                <p class="mb-2 d-inline-block border px-2 py-1 mt-2" style="border-color: black !important;">webサイトへ<i class="fa-solid fa-arrow-up-right-from-square ps-2"></i></p>
                            </a>
                            <?php endif;?>
                        </div>
                    </div>
                    <?php
                        endforeach;
                    ?>
                    </div>
                <?php endif; ?>
			</div>
		</section>
		
	</div>
<?php
get_footer();
