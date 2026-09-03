<?php
/**
 * Template Name: カタログ
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
$catalogue_list = CFS()->get('catalogue_list');
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
		<section class="content_catalogue">
			<div class="content row">
                <?php the_content();?>
                <?php
                    foreach ($catalogue_list as $catalogue_lists) :
                        $catalogue_tit = $catalogue_lists['catalogue_tit'];
                        $catalogue_th = $catalogue_lists['catalogue_th'];
                        $catalogue_about = $catalogue_lists['catalogue_about'];
                        $catalogue_link = $catalogue_lists['catalogue_link'];
                        $catalogue_contact = $catalogue_lists['catalogue_contact'];
                ?>
				<div class="content-item py-3 col-12 col-md-12 col-lg-6 mb-4 d-lg-flex d-md-flex d-block">
                    <div class="catalogue_th col-12 col-md-5 col-lg-5">
                        <img src="<?php echo $catalogue_th; ?>" alt="<?php echo $catalogue_tit; ?>">
                    </div>
                    <div class="catalogue_about col-12 col-md-7 col-lg-7 ps-0 ps-lg-3 ps-md-3">
                        <div class="catalogue_about__item">
                            <div class="catalogue-tit mt-2 mb-1 mt-lg-0 mt-md-0">
                                <p class="mb-0 fw-bold fs-5"><?php echo $catalogue_tit; ?></p>
                            </div>
                            <div class="catalogue-txt">
                                <p class="mb-0"><?php echo $catalogue_about; ?></p>
                            </div>
                        </div>
                        <div class="catarog_link-list d-block d-md-flex d-lg-flex align-items-baseline"> 
                            <div class="link-item__name mt-4 border border-dark py-1 px-2 col-12 col-md-6 col-lg-6" style="background-color: black">
                                <a href="<?php echo $catalogue_link; ?>" target="_blank" class="gtm-click-download" data-name="<?php echo $catalogue_tit; ?>" data-gtm-click="pdf_download">
                                    <span class="d-flex align-items-center justify-content-center">
                                        <p class="txt-white nav_menu-tit footer mb-0 fw-bold">カタログを見る<i class="fa-solid fa-arrow-up-right-from-square ps-2"></i></p>
                                    </span>
                                </a>
                            </div>
                            <?php if ($catalogue_contact == 1) : ?>
                            <div class="link-item__name mt-2 py-1 px-2 col-12 col-md-6 col-lg-6" style="background-color: #e66c46; border: solid 1px #e66c46 !important;">
                                <a href="<?php echo home_url() ; ?>/catalogue-request/" target="_blank">
                                    <span class="d-flex align-items-center justify-content-center">
                                        <p class="txt-white nav_menu-tit footer mb-0 fw-bold">カタログ請求へ<i class="fa-regular fa-envelope ps-2"></i></i></p>
                                    </span>
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php
                    endforeach;
                ?>
			</div>
		</section>
		
	</div>
<?php
get_footer();
