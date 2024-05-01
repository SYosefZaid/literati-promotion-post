<?php

namespace Literati\Example;

/**
 * Blocks class.
 */
class Blocks
{
    /**
     * Init
     */
    public static function init()
    {
        add_action('init', [__CLASS__, 'register_blocks']);
    }

    /**
     * Register the Blocks
     */
    public static function register_blocks()
    {
        register_block_type('literati-example/promotion-carousel', [
            'render_callback' => [__CLASS__, 'render_promotion_carousel_block']
        ]);
    }

    /**
     * Render the Promotion Carousel Block
     */
    public static function render_promotion_carousel_block($attributes, $content)
    {
      ?>

        <!doctype html>
        <html lang="en">
          <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
          </head>
          
          <body>
            <div id="carouselExampleControls" class="carousel">
              <div class="carousel-inner">

              <?php 
                $posts = get_posts([
                  'post_type' => 'promotion',
                  'numberposts' => -1
                ]);

                if (empty($posts)) {
                  echo '<p>No promotions available.</p>';
                } else {
                    foreach ($posts as $post) {
                      $heading = get_post_meta($post->ID, '_literati_promotion_header', true);
                      $text_desc = get_post_meta($post->ID, '_literati_promotion_text', true);
                      $button_text = get_post_meta($post->ID, '_literati_promotion_button_text', true);
                      $image_id = get_post_meta($post->ID, '_literati_promotion_image', true);
                      $full_image_base_path =  wp_get_upload_dir()['baseurl']."/".date("Y")."/".date("m")."/".$image_id;
                      ?>
                        <div class="carousel-item active">
                            <div class="card">
                                <div class="img-wrapper">
                                    <?php if ($image_id): ?>
                                        <img src="<?php echo esc_url($full_image_base_path); ?>" class="d-block w-100" alt="<?php echo esc_attr($heading); ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo esc_html($heading); ?></h5>
                                    <p class="card-text"><?php echo esc_html($text_desc); ?></p>
                                    <a href="#" class="btn btn-primary"><?php echo esc_html($button_text); ?></a>
                                </div>
                            </div>
                        </div>
                  <?php
                    }
              ?>
                </div>  

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> 
          </body>
        </html>
            <?php
      }
          
  }
}