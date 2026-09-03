<?php 
    $taxonomy = 'products-cat';
    $terms = get_terms(
        $taxonomy,
        array(
            'parent' => 0,
            'hide_empty' => false, 
        ),
    );
    if ($terms) :
?>
<div class="product-cat_list row">
    <?php
        foreach ($terms as $the_term):
            // var_dump($the_term);
            $term_id = $the_term->term_id;
            $term_name =  $the_term->name;
            $term_slug =  $the_term->slug;
            $term_field_ids = $taxonomy."_".$term_id;
            $product_cat_img = get_field('product_cat_img', $term_field_ids);
            $product_cat_about = get_field('product_cat_about', $term_field_ids);
    ?>
    <article id="<?php echo $term_slug; ?>" class="product-cat_list__item anime col-12 col-lg-6 d-block d-lg-flex">
        <div class="product-cat_header d-flex align-items-center justify-content-between d-lg-none">
            <h3><?php echo $term_name; ?></h3>
            <div class="link-btn black-btn">
                <a href="/products-cat/<?php echo $term_slug; ?>/">
                    <button>
                        <p class="mb-0">詳細を見る<i class="fa-solid fa-chevron-right"></i></p>
                    </button>
                </a>
            </div>
        </div>
        <div class="product-cat_list__item__img">
            <img src="<?php echo $product_cat_img; ?>" alt="<?php echo $term_name; ?>">
        </div>
        <div class="product-cat_list__item__about">
            <div class="product-cat_header align-items-center justify-content-between d-none d-lg-flex">
                <h3><?php echo $term_name; ?></h3>
                <div class="link-btn black-btn">
                    <a href="/products-cat/<?php echo $term_slug; ?>/">
                        <button>
                            <p class="mb-0">詳細を見る<i class="fa-solid fa-chevron-right"></i></p>
                        </button>
                    </a>
                </div>
            </div>
            <?php if ($product_cat_about) : ?>
                <div class="article-detail">
                    <p class="mb-0"><?php echo $product_cat_about; ?></p>
                </div>
            <?php endif; ?>

            <?php
                $children_terms = get_terms(
                    $taxonomy,
                    array(
                        'parent' => $term_id,
                    ),
                );
                if ($children_terms) :
            ?>
            <div class="product-cat_list__item__about__link-list row">
                <?php
                    foreach ($children_terms as $the_c_term):
                        $c_term_id = $the_c_term->term_id;
                        $c_term_name =  $the_c_term->name;
                        $c_term_slug =  $the_c_term->slug;
                ?>
                <div class="link-item col-6">
                    <a href="/products-cat/<?php echo $c_term_slug; ?>/">
                        <div class="link-item__name d-flex justify-content-between align-items-center">
                            <p class="nav_menu-tit footer mb-0"><?php echo $c_term_name; ?></p>
                            <img class="link-arrow" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/common/link-arrow_black.png">
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </article>
    <?php 
        endforeach;
        wp_reset_postdata();
    ?>
</div>
<?php endif; ?>