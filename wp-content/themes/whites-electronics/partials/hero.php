<?php
$heroBgImage = get_field('hero_background');
$title = get_field('page_title');
$subtitle = get_field('subtitle');

$backgroundImg  ='';
if (!empty($heroBgImage) && !empty($heroBgImage['url'])) {
    $backgroundImg = "background-image: url('" . $heroBgImage['sizes']['large'] . "')";
}

if ($title) {
    $title = get_field('page_title');
} else {
    $title = get_the_title();
} ?>

<div class="outer-wrapper">
    <div class="hero">
        <div class="bg-image" style="<?php echo $backgroundImg; ?>"></div>
        <?php if (!$subtitle) : ?>
            <h1 class="no-subtitle"><?php echo $title; ?></h1>
        <?php else : ?>
            <h1><?php echo $title; ?></h1>
            <h2><?php echo $subtitle; ?></h2>
        <?php endif; ?>
    </div>
</div>
