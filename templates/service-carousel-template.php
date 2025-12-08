<?php
/**
 * Template Name: Service Carousel demo
 */

if (!defined('ABSPATH')) exit;

get_header(); 
?>
<main class="service-carousel-demo-template" style="padding: 0 25px">
    <?php echo do_shortcode('[service_carousel]'); ?>
</main>
<?php 
get_footer();
