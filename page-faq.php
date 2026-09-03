<?php
/**
 * Template Name: FAQ
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
        <?php
            $fields = CFS()->get('faq_list');
            foreach ($fields as $field) :
        ?>
        <section class="content_qa">
			<div class="content row">
                <h2><span><?php echo $field['faq_tit']; ?></span></h2>
                <?php
                    $fields = $field['faq_item'];
                    foreach ((array)$fields as $field):
                ?>
				<div class="faq-list">
                    <div class="faq-list__content">
                        <div class="ac-parent">
                            <p class="mb-0"><?php echo $field['faq_question']; ?></p>
                        </div>
                        <div class="ac-child">
                            <div class="answer">
                                <p class="mb-0"><?php echo $field['faq_answer']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    endforeach;
                ?>
			</div>
		</section>
        <?php
            endforeach;
        ?>

	</div>
<?php
get_footer();
