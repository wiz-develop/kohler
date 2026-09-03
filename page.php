<?php
/**
 * Template Name: 固定ページテンプレート
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
$contents_list = CFS()->get('contents_list');
$content_class = CFS()->get('content_class');
?>
	<div class="page">
		<div class="page-header position-relative<?php if ($img_block === 0) { echo ' header-bg'; } else if ($img_block === 1) { echo ' m-0'; } ?>">
			<div class="page-header__tit<?php if ($img_block === 1) echo ' position-absolute'; ?>">
				<h1 class="mb-0"><?php the_title(); ?><span class="d-block"><?php echo CFS()->get('page_tit_en'); ?></span></h1>
			</div>
			<?php if ($page_top_img):?>
			<div class="page-header__img">
				<img src="<?php echo $page_top_img; ?>" alt="<?php the_title(); ?>">
			</div>
			<?php endif;?>
		</div>
		<?php if ($contents_list):?>
		<?php
			foreach ($contents_list as $contents_lists) :
				$content_name = $contents_list['content_name'];
				$content_width = $contents_list['content_width'];
				$content_about = $contents_list['content_about'];
		?>
		<section class="content_<?php echo $content_name; ?>">
			<div class="content<?php if ($content_width === 1) echo ' w-100'; ?>">
				<?php echo $content_about; ?>
			</div>
		</section>
		<?php
			endforeach;
		?>
		<?php else: ?>
		<section class="content_<?php echo $content_class; ?>">
			<div class="content">
				<?php the_content();?>
			</div>
		</section>
		<?php endif;?>
	</div>
<?php
get_footer();
