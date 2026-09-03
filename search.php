<?php
/**
 * 検索結果
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();
$taxonomy = 'products-cat';
$type = [];

global $wp_query;

// if(isset($_GET['s'])){
//     $s = $_GET['s'];
// } 
// if (isset($_GET['type']) && is_array($_GET['type'])) {
//     $type = array_map('intval', $_GET['type']);
// }
// $type_name = "";
// foreach($type as $type_val){
//     $type_data = get_terms($type_val, $taxonomy);
//     $type_name .= $type_data->name . "　";
// }
// $type_name = rtrim($type_name, '　');
?>
	<div class="page">
		<div class="page-header m-0 position-relative">
			<div class="page-header__tit  position-absolute">
				<h1 class="mb-0">商品紹介<span class="d-block">products</span></h1>
			</div>
			<div class="page-header__img">
				<img src="http://kohler2024re.xsrv.jp/cms/wp-content/uploads/2024/06/slide2_pc-scaled.jpg" alt="商品紹介">
			</div>
		</div>
		<section class="content_page-product">
			<div class="content">
                <div class="row">
					<div class="search-content col-12 col-lg-3">
						<?php get_template_part( 'template-parts/search/search', 'product' ); ?>
					</div>
                    <div class="col-12 col-lg-9">
                        <?php
                            // if($s && $type_name){
                            //     $archive_title = '<span class="color-accent">絞り込み条件：</span>' . $s . "," .$type_name. '<span class="color-accent"></span>';
                            // }elseif(!$s && $type_name){
                            //     $archive_title = '<span class="color-accent">絞り込み条件：</span>' . $type_name. '<span class="color-accent"></span>';
                            // }elseif($s){
                            //     $archive_title = '<span class="color-accent">絞り込み条件：</span>' . $s . '<span class="color-accent"></span>';
                            // }elseif(get_search_query()){
                            //     $archive_title = '<span class="color-accent">絞り込み条件：</span>' . get_search_query() . '<span class="color-accent"></span>';
                            // }else{
                            //     $archive_title = '<span class="color-accent">絞り込み条件：なし</span>';
                            // }
                        ?>
                        <h2 class="search-title mb-4">検索結果<span class="ms-3"><?php echo $wp_query->found_posts; ?>件</span></h2>
                        <?php if (have_posts()) : ?>
                            <div class="product_cat-archive__list row">
                                <?php
                                    while (have_posts()) : the_post();
                                        $image_pc = $cfs->get('product_image_pc');
                                        $image_sp = $cfs->get('product_image_sp');
                                        $model_number = $cfs->get('model_number');
                                        $terms = get_the_terms(get_the_ID(), $taxonomy);
                                        $colors = $cfs->get('product_colors');
                                ?>
                                <div class="product_cat-archive__list__item col-6 col-lg-4">
                                    <a href="<?php the_permalink(); ?>" class="product_cat-archive__list__item__link">
                                        <div class="cat-img">
                                            <?php if ($image_pc) : ?>
                                                <img src="<?php echo $image_pc; ?>" alt="<?php echo strip_tags(get_the_title()); ?>" class="<?php if ($image_sp) echo 'd-none d-sm-block'; ?>">
                                            <?php elseif ($colors[0]['color_file_1']) : ?>
                                                <img src="<?php echo $colors[0]['color_file_1']; ?>" alt="<?php echo strip_tags(get_the_title()); ?>" class="<?php if ($image_sp) echo 'd-none d-sm-block'; ?>">
                                            <?php endif; ?>                                            <?php if ($image_sp) : ?>
                                            <img src="<?php echo $image_sp; ?>" alt="<?php echo strip_tags(get_the_title()); ?>" class="d-sm-none">
                                            <?php endif; ?>
                                        </div>
                                        <div class="cat-name">
                                            <div class="d-flex justify-content-between align-items-center pb-1 border-bottom border-secondary">
                                                <p class="nav_menu-tit footer mb-0 text-dark"><?php the_title(); ?></p>
                                                <img class="link-arrow" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/common/link-arrow_black.png">
                                            </div>
                                            <?php if ($model_number) echo '<p class="model_number text-dark fw-bold mb-0">'.$model_number.'</p>'; ?>
                                            <?php if ($terms) : ?>
                                                <ul class="p_terms text-secondary list-unstyled mb-0 d-flex flex-wrap">
                                                    <?php foreach( $terms as $term ):?>
                                                    <li class="me-1"><?php echo $term->name; ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                </div>
                                <?php endwhile; ?>
                            </div>
                            <div class="pnavi mt-3 mx-auto">
                                <?php
                                    // if ($query->max_num_pages > 1) {
                                        echo paginate_links(array(
                                            'base'      => '%_%',
                                            'format'    => '?paged=%#%',
                                            'current'   => max(1, get_query_var('paged')),
                                            'mid_size'  => 2,
                                            // 'total'     => $query->max_num_pages,
                                            'prev_text' => '<',
                                            'next_text' => '>',
                                            'type'      => 'list'
                                        ));
                                    // }
                                ?>
                            </div>
                        <?php else : ?>
                            <p class="mb-0">該当する商品はございません。</p>
                        <?php endif; wp_reset_postdata(); ?>
                    </div>
                </div>
            </div>
		</section>
	</div>
<?php
get_footer();
