<?php
    $days = 7;
    $now = wp_date('U');
    $entry = get_the_time('U');
    $term = date('U', ($now - $entry)) / 86400;
    $cat_data = get_the_category();
    $cat_id_text = 'category_'.$cat_data[0]->term_id;
    $cat_color = get_field('cat_color', $cat_id_text);
?>
<article>
    <a href="<?php the_permalink(); ?>">
        <div class="article__header d-flex align-items-baseline">
            <?php
                if( $days > $term ) {
                    echo '<div class="new pe-2"><p class="mb-0 fw-bold">NEW</p></div>';
                }
                $date = get_the_date('Y.m.d');
            ?>
            <div class="date pe-2">
                <time datetime="<?php the_date('Y-m-d'); ?>"><?php echo $date; ?></time>
            </div>
            <div class="cat px-3 rounded-pill" <?php if($cat_color) echo 'style="background-color: '.$cat_color.'"'; ?>>
                <p class="mb-0"><?php echo $cat_data[0]->cat_name; ?></p>
            </div>
        </div>
        <div class="article__body">
            <h3 class=" typesquare_option"><?php the_title(); ?></h3>
        </div>
    </a>
</article>