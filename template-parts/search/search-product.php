<?php
    // $args = array(
    //     'freeword'     => $_GET['freeword'],
    //     'cat'     => $_GET['cat'],
    //     'date_from'     => $_GET['date_from'],
    //     'date_to'     => $_GET['date_to'],
    //     'target'     => $_GET['target'],
    //     'limit'     => 20
    // );
    // $post_data = get_product_list($args);
    $taxonomy = 'products-cat';
    $parent_terms = get_terms(
        $taxonomy,
        array(
            'parent' => 0,
            'hide_empty' => false,
        ),
    );
    if (isset($_GET['type']) && is_array($_GET['type'])) {
        $type = array_map('intval', $_GET['type']);
    }
    // if(isset($_GET['cat'])){
    //     $cats = (array)$_GET['cat'];
    //     if(!empty($cats)){
    //         foreach ($cats as $in_cat){
    //             array_push($cat,(int)$in_cat);
    //         }
    //     }
    // }
?>
<div class="product-search">
    <div class="product-search__item mb-0 mb-lg-3">
        <div class="product-search__tit">
            <p class="fw-bold mb-0">商品検索</p>
            <?php if (wp_is_mobile()) : ?>
            <div class="search-clear text-end">
                <a href="/products/">
                    <div class="search-clear__btn">
                        <p class="mb-0">検索条件をクリア</p>
                    </div>
                </a>
            </div>
            <?php endif; ?>
        </div>
        <?php if (!wp_is_mobile()) : ?>
        <div class="product-search__item__tit">
            <p class="mb-1">フリーワード</p>
        </div>
        <?php endif; ?>
        <div class="product-search__item__search-area">
            <form method="get" action="<?php echo esc_url( home_url( '/products/' ) ); ?>">
                <div class="position-relative">
                    <input type="text" id="search_word" placeholder="フリーワード・品番から検索" value="<?php echo get_search_query(); ?>" name="s">
                    <div class="search_btn link-btn black-btn">
                        <button class="search_word_btn text-white" type="submit" class="btn">検索</button>
                    </div>
                </div>
                <?php if (!wp_is_mobile()) : ?>
                <div class="search-clear text-end">
                    <a href="/products/">
                        <div class="search-clear__btn">
                            <p class="mb-0">検索条件をクリア</p>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
    <form method="get" action="<?php echo esc_url( home_url( '/products/' ) ); ?>">
        <input type="hidden" name="s" value="">
        <?php //if (wp_is_mobile()) : ?>
        <div class="ac-list">
        <?php //endif; ?>
            <?php //if (wp_is_mobile()) : ?>
                <div class="narrow-down_btn ac-parent d-block d-lg-none">
                    <p class="mb-0">条件を絞り込む</p>
                </div>
            <?php //endif; ?>
            <div class="product-search__item ac-child d-lg-block">
                <div class="product-search__item__tit">
                    <p class="mb-0">カテゴリー</p>
                </div>
                <?php if ($parent_terms) : ?>
                <div class="product-search__item__search-area">
                    <div class="cat-list">
                        <?php
                            foreach ($parent_terms as $p_term) :
                                $p_term_id = $p_term->term_id;
                                $p_term_name = $p_term->name;
                                $p_term_slug = $p_term->slug;
                        ?>
                        <div class="cat-list__item cat-parent">
                            <label class="cat-list__item__name d-flex align-items-baseline">
                                <input id="<?php echo $p_term_slug; ?>-cat" type="checkbox" name="type[]" value="<?php echo $p_term_id; ?>" <?php if (in_array($p_term_id, $type ?? [])) echo 'checked'; ?>>
                                <span class="d-block"><?php echo $p_term_name; ?></span>
                            </label>
                        </div>
                            <?php
                                $children_terms = get_term_children($p_term_id, $taxonomy);
                                if ($children_terms) :
                            ?>
                                <div class="cat-list__item cat-child ps-2">
                                    <?php
                                        foreach ($children_terms as $c_term) :
                                            $c_term_id = $c_term;
                                            $c_term_data = get_term($c_term_id, $taxonomy);  
                                            $c_term_name = $c_term_data->name;
                                            $c_term_slug = $c_term_data->slug;
                                    ?>
                                    <label class="cat-list__item__name d-flex align-items-baseline">
                                        <input id="<?php echo $c_term_slug; ?>-cat" type="checkbox" name="type[]" value="<?php echo $c_term_id; ?>" <?php if (in_array($c_term_id, $type ?? [])) echo 'checked'; ?>>
                                        <span class="d-block"><?php echo $c_term_name; ?></span>
                                    </label>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php //if (wp_is_mobile()) : ?>
                <div class="product-search__btn-content d-lg-none">
                    <div class="search_btn link-btn black-btn">
                        <button class="search_word_btn text-white" type="submit" class="btn">検索</button>
                    </div>
                    <div class="search-clear">
                        <a href="/products/">
                            <div class="search-clear__btn">
                                <p class="mb-0">検索条件をクリア</p>
                            </div>
                        </a>
                    </div>
                </div>
                <?php // endif; ?>
            </div>
        <?php //if (wp_is_mobile()) : ?>
        </div>
        <?php //endif; ?>

        <?php //if (!wp_is_mobile()) : ?>
        <div class="product-search__btn-content d-none d-lg-block">
            <div class="search_btn link-btn black-btn">
                <button class="search_word_btn text-white" type="submit" class="btn">検索</button>
            </div>
            <div class="search-clear">
                <a href="/products/">
                    <div class="search-clear__btn">
                        <p class="mb-0">検索条件をクリア</p>
                    </div>
                </a>
            </div>
        </div>
        <?php //endif; ?>
    </form>
</div>