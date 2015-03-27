<?php $posts_orgd = array();

while (have_posts()) {
  the_post();

  $date = get_the_date('Y-m-d');

  if (!array_key_exists($date, $posts_orgd)) {
    $posts_orgd[$date] = array(get_post());
  } else {
    $posts_orgd[$date][] = get_post();
  }
}

foreach ($posts_orgd as $date => $posts_by_date) { ?>
  <section id="<?= $date ?>" class="posts-date">
    <h1 class="posts-date-header"><?= $date; ?></h1>
    <?php foreach ($posts_by_date as $post) get_template_part('templates/content'); ?>
  </section>
<?php }
?>
