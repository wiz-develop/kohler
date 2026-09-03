<?php
/**
 * Template Name: ショールーム
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 */

get_header();

$post_id = get_the_ID();
$features = preg_split('/\r\n|\r|\n/', kohler_showroom_get_value($post_id, 'features_items'));
$features = array_values(array_filter(array_map('trim', $features), 'strlen'));

function kohler_showroom_multiline($value) {
    return nl2br(esc_html($value));
}

function kohler_showroom_external_link($post_id, $prefix) {
    $text = kohler_showroom_get_value($post_id, $prefix . '_link_text');
    $url = kohler_showroom_get_value($post_id, $prefix . '_link_url');

    if ('' === $text || '' === $url) {
        return;
    }
    ?>
    <a class="showroom-link" href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer">
        <span><?php echo esc_html($text); ?></span>
        <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
        <span class="screen-reader-text">（新しいタブで開きます）</span>
    </a>
    <?php
}
?>
<div class="page page-showroom">
    <div class="page-header position-relative">
        <div class="page-header__tit">
            <h1 class="mb-0"><?php the_title(); ?><span class="d-block"></span></h1>
        </div>
    </div>

    <section class="showroom-content">
        <div class="content showroom-content__inner">
            <header class="showroom-intro">
                <h2><?php echo esc_html(kohler_showroom_get_value($post_id, 'lead_title')); ?></h2>
                <p><?php echo esc_html(kohler_showroom_get_value($post_id, 'lead_text')); ?></p>
            </header>

            <div class="showroom-list">
                <article class="showroom-location">
                    <div class="showroom-location__name">
                        <h3><?php echo kohler_showroom_multiline(kohler_showroom_get_value($post_id, 'tokyo_name')); ?></h3>
                    </div>
                    <div class="showroom-location__details">
                        <p><?php echo kohler_showroom_multiline(kohler_showroom_get_value($post_id, 'tokyo_details')); ?></p>
                        <?php kohler_showroom_external_link($post_id, 'tokyo'); ?>
                    </div>
                </article>

                <article class="showroom-location">
                    <div class="showroom-location__name">
                        <h3><?php echo kohler_showroom_multiline(kohler_showroom_get_value($post_id, 'aoyama_name')); ?></h3>
                    </div>
                    <div class="showroom-location__details">
                        <p><?php echo kohler_showroom_multiline(kohler_showroom_get_value($post_id, 'aoyama_details')); ?></p>
                        <?php kohler_showroom_external_link($post_id, 'aoyama'); ?>
                    </div>
                </article>

                <article class="showroom-location showroom-location--renovation">
                    <div class="showroom-location__name">
                        <p class="showroom-location__status"><?php echo esc_html(kohler_showroom_get_value($post_id, 'osaka_status')); ?></p>
                        <h3><?php echo esc_html(kohler_showroom_get_value($post_id, 'osaka_name')); ?></h3>
                    </div>
                    <div class="showroom-location__details">
                        <p><?php echo kohler_showroom_multiline(kohler_showroom_get_value($post_id, 'osaka_details')); ?></p>
                    </div>
                </article>
            </div>

            <section class="showroom-features" aria-labelledby="showroom-features-title">
                <h2 id="showroom-features-title"><?php echo esc_html(kohler_showroom_get_value($post_id, 'features_title')); ?></h2>
                <?php if ($features) : ?>
                    <ul>
                        <?php foreach ($features as $feature) : ?>
                            <li><?php echo esc_html($feature); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </section>
        </div>
    </section>
</div>
<?php
get_footer();
