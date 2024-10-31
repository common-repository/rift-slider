<?php

/**
 * Description of custom-post-type-list-columns-class
 *
 * @author Ryan Haworth
 */
if (!class_exists('rift_slider_custom_post_type_list_columns')) {

    class rift_slider_custom_post_type_list_columns {

        /**
         * Class constructor.
         * @param type $post_type
         */
        public function __construct($post_type) {

            //create the list column headers for the post type
            add_filter('manage_' . $post_type . '_posts_columns', array(&$this, 'posts_column_headers'), 10);

            //create the list columns content
            add_action('manage_' . $post_type . '_posts_custom_column', array(&$this, 'posts_columns_content'), 10, 2);
        }

        /**
         * Method which sets the post column headers on the lists.
         * @param type $defaults
         * @return type
         */
        function posts_column_headers($defaults) {

            $defaults['carousels'] = __('Attached to Carousel', SYNTH_RIFT_SLIDER_DOMAIN);
            $defaults['featured_image'] = __('Featured Image', SYNTH_RIFT_SLIDER_DOMAIN);

            return $defaults;
        }

        /**
         * Method which sets the post column content in the lists.
         * @param type $column_name
         * @param type $post_id
         */
        function posts_columns_content($column_name, $post_id) {

            if ($column_name == 'carousels') {

                $html = '';
                $terms = wp_get_post_terms($post_id, 'carousel');

                foreach ($terms as $term) {

                    $url = sprintf('%1$s/wp-admin/edit.php?taxonomy=carousel&term=%2$s&post_type=rift_slide', get_site_url(), $term->slug);
                    $html .= '[ <a href="' . $url . '">' . $term->name . '</a> ] ';
                }

                echo $html;
            }

            if ($column_name == 'featured_image') {

                $post_featured_image = $this->featured_image($post_id);

                if ($post_featured_image) {
                    echo '<img src="' . $post_featured_image . '" style="height: 80px; width: 100px" />';
                } else {
                    echo '<img src="' . plugins_url('/images/no-image.png') . '" style="margin: 10px; height: 80px; width: 80px" />';
                }
            }
        }

        /**
         * Method to create the featured image.
         * @param type $post_id
         * @return type
         */
        function featured_image($post_id) {

            $post_thumbnail_id = get_post_thumbnail_id($post_id);

            if ($post_thumbnail_id) {
                $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'featured_preview');

                return $post_thumbnail_img[0];
            }
        }

    }

}
?>
