<?php
/**
 * Template for displaying a single Book (Custom Post Type)
 * Location: mini-bookstore/single-book.php
 */

get_header();

if ( have_posts() ) :
  while ( have_posts() ) : the_post();
    $author  = get_field('author');
    $isbn    = get_field('isbn');
    $cover   = get_field('cover_image');
    $summary = get_field('summary');

    // Match ISBN to WooCommerce product SKU
    $product_id = $isbn ? wc_get_product_id_by_sku($isbn) : false;
?>
<main class="single-book-container">
  <article class="book-details">

    <?php if ($cover): ?>
      <div class="book-cover">
        <img src="<?php echo esc_url($cover['url']); ?>" 
             alt="<?php echo esc_attr(get_the_title()); ?>" />
      </div>
    <?php endif; ?>

    <h1 class="book-title"><?php the_title(); ?></h1>

    <?php if ($author): ?>
      <p class="book-author">by <strong><?php echo esc_html($author); ?></strong></p>
    <?php endif; ?>

    <?php if ($isbn): ?>
      <p class="book-isbn"><strong>ISBN:</strong> <?php echo esc_html($isbn); ?></p>
    <?php endif; ?>

    <?php if ($summary): ?>
      <div class="book-summary">
        <?php echo wpautop($summary); ?>
      </div>
    <?php endif; ?>

    <div class="book-buy-section">
      <?php
      if ($product_id) {
        echo '<div class="mb-buy-container">';
        echo do_shortcode('[add_to_cart id="' . $product_id . '"]');
        echo '</div>';
      } else {
        echo '<p class="book-error">Product not found for this book. Please check the ISBN and SKU link.</p>';
      }
      ?>
    </div>

  </article>
</main>

<?php
  endwhile;
endif;

get_footer();