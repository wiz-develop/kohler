<?php
/**
 * カテゴリー別施工事例一覧ページ
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();
$term_object = get_queried_object();
$term_name =  $term_object->name;
?>
	<div class="page">
		<div class="page-header position-relative my-0 mx-auto">
			<div class="page-header__tit  position-absolute">
				<h1 class="mb-0 fw-bolder"><?php echo $term_name; ?>の施工事例<span class="d-block">REMODEL PORTFOLIO</span></h1>
			</div>
			<div class="page-header__img">
				<img src="/cms/wp-content/uploads/2024/10/haworth-hotel-banner.jpg" alt="施工事例">
			</div>
		</div>
        <div class="content mt-5">
            <div class="content_construction__item">
                <?php if (have_posts()) : ?>
                    <div class="construction-list row">
                        <?php
                            while (have_posts()) : the_post();
                                get_template_part('template-parts/post/post', 'portfolio');
                            endwhile;
                        ?>
                    </div>
                    <?php
                        $maxlist = 999999;
                        $args = array(
                            'type'      => 'list',
                            'next_text' => '>',
                            'prev_text' => '<',
                            'mid_size'  => 3,
                            'end_size'  => 3,
                            'base'      => str_replace($maxlist, '%#%', esc_url(get_pagenum_link($maxlist))),
                            'format'    => '?page=%#%',
                            'current'   => max(1, get_query_var('paged'))
                        );
                        echo paginate_links($args);
                    ?>
                <?php else : ?>
                    <p class="text-center mb-0"><?php echo $term_name; ?>の施工事例はございません。</p>
                <?php endif; wp_reset_postdata(); ?>
            </div>
        </div>
        <div class="link-btn black-btn text-center mb-5">
            <a href="/portfolio/">
                <button class="px-4">
                    <p class="mb-0">全ての記事を見る<i class="fa-solid fa-chevron-right"></i></p>
                </button>
            </a>
        </div>
	</div>
<?php
get_footer();
