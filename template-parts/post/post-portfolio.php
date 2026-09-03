<?php
    $image_pc = CFS()->get('portfolio_img_pc');
    $image_sp = CFS()->get('portfolio_img_sp');
    $c_terms = get_the_terms(get_the_ID(), 'portfolio-cat');
    $acf_term = 'portfolio-cat_'.$c_terms[0]->term_id;
    $cat_color = get_field('cat_color', $acf_term);
    $c_about = CFS()->get('portfolio_about');
?>
<a href="<?php the_permalink(); ?>" class="d-block mb-4 col-12 col-lg-4">
    <article class="construction-list__item">
        <div class="construction-list__item__img mb-2 position-relative">
            <p class="construction-list__item__cat mb-0 position-absolute top-0 left-0 text-white fw-bolder px-2 py-1 <?php if(!$cat_color) echo 'bg-dark'; ?>" <?php if($cat_color) echo 'style="background-color: '.$cat_color.'"'; ?>>
                <?php echo $c_terms[0]->name; ?>
            </p>
            <?php if ($image_pc) : ?>
                <img src="<?php echo $image_pc; ?>" alt="<?php echo strip_tags(get_the_title()); ?>" class="<?php if ($image_sp) echo 'd-none d-sm-block'; ?>">
            <?php endif; ?>
            <?php if ($image_sp) : ?>
            <img src="<?php echo $image_sp; ?>" alt="<?php echo strip_tags(get_the_title()); ?>" class="d-sm-none">
            <?php endif; ?>
        </div>
        <div class="construction-list__item__about">
            <div class="d-flex justify-content-between align-items-center border-bottom border-dark pb-1">
                <h2 class="construction-tit mb-0 pe-2"><?php the_title(); ?></h2>
                <img class="link-arrow" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/common/link-arrow_black.png">
            </div>
            <?php if ($c_about) echo '<p class="mt-1 mb-0">'.$c_about.'</p>'; ?>
        </div>
    </article>
</a>