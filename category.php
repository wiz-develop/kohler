<?php
/**
 * カテゴリー別記事一覧（NEWS）ページ
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();

$cat_object = get_queried_object();
$cat_id = $cat_object->term_id;
$cat_slug = $cat_object->slug;
$cat_name = $cat_object->name;
$cat_description = $cat_object->description;
$cat_parent = $cat_object->category_parent;

$back_url = '';
$year = '';
if (isset($_GET['archive'])) {
    $year = $_GET['archive'];
}

if ($cat_parent !== 0) {
    $cat_children = get_term_children( $cat_id, 'category' );
    $cat_ids = array_merge(array($cat_id), $cat_children);
    $cat_parent_data = get_category($cat_parent);
    $back_url = $cat_parent_data->slug;
} else {
    $cat_children = get_term_children( $cat_id, 'category' );
    $cat_ids = array_merge(array($cat_id), $cat_children);
    if ($year) {
        $back_url = $cat_slug;
    }
}
?>

	<div class="page">
		<div class="page-header position-relative header-bg">
			<div class="page-header__tit">
				<h1 class="mb-0">
                    <?php
                        if ($year) {
                            echo $year.'年の'; single_cat_title(); echo '記事一覧';
                        } else {
                            echo $cat_name;
                        }
                    ?>
                    <span class="d-block">NEWS</span>
                </h1>
			</div>
		</div>
        <div class="content_news">
            <div class="content">
                <div class="container-fluid">
                    <div class="row my-5">
                        <div class="content-body col-12 col-lg-8">
                            <?php
                                $paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
                                $args = array(
                                    'posts_per_page' => 10,
                                    'paged' => $paged,
                                    'post_type' => 'post',
                                    'orderby' => 'date',
                                    'category__in' => $cat_ids,
                                    'post_status' => 'publish',
                                );
                                if ($year) {
                                    $date_query = array (
                                        'date_query' => array(
                                            'year'  => $year,
                                        ),
                                    );
                                    $args = array_merge($args, $date_query);
                                }
            
                                $query = new WP_Query( $args );
                                if ( $query->have_posts() ) :
                            ?>
                                <div class="article-list anime is-animated">
                                    <?php
                                        while ( $query->have_posts() ) :
                                            $query->the_post();
                                            get_template_part('template-parts/post/post', 'news');
                                        endwhile;
                                    ?>
                                </div>
                            <div class="pnavi mt-3 mx-auto">
                                <?php
                                    if ($query->max_num_pages > 1) {
                                        echo paginate_links(array(
                                            'base'      => '%_%',
                                            'format'    => '?page=%#%',
                                            'current'   => max(1, $paged),
                                            'mid_size'  => 2,
                                            'total'     => $query->max_num_pages,
                                            'prev_text' => '<',
                                            'next_text' => '>',
                                            'type'      => 'list'
                                        ));
                                    }
                                ?>
                            </div>
                            <?php
                                else :
                                    echo '<p class="mb-0">最新の記事はありません</p>';
                                endif; wp_reset_postdata();
                                if ($back_url) :
                            ?>
                                <div class="link-btn black-btn text-center">
                                    <a href="/<?php echo $back_url; ?>/">
                                        <button class="px-4">
                                            <p class="mb-0">記事一覧へ戻る<i class="fa-solid fa-chevron-right"></i></p>
                                        </button>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <aside class="mt-4 mt-lg-0 col-12 col-lg-4">
                            <?php get_sidebar(); ?>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
	</div>
<?php
get_footer();
