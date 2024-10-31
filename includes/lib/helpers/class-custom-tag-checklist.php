<?php
/**
 * Description of custom-tag-checklist-tag
 *
 * @author Ryan Haworth
 */
if (!class_exists('rift_slider_custom_tag_checklist_non_heirarchical')) {

    class rift_slider_custom_tag_checklist_non_heirarchical {

        private $_taxonomy;
        private $_post_type;

        /**
         * The class constructor.
         * @param type $taxonomy
         * @param type $post_type
         */
        function __construct($taxonomy, $post_type) {

            $this->_taxonomy = $taxonomy;
            $this->_post_type = $post_type;

            // Remove default taxonomy meta box
            add_action('admin_menu', array($this, 'remove_meta_box'));

            // Add new meta box
            add_action('add_meta_boxes', array($this, 'add_meta_box'));

            // Handle AJAX call for adding new term
            add_action('wp_ajax_add-' . $this->_taxonomy, array($this, '_wp_ajax_add_non_hierarchical_term'));
        }

        /**
         * Method to remove the original tags metabox.
         */
        public function remove_meta_box() {

            remove_meta_box('tagsdiv-' . $this->_taxonomy, $this->_post_type, 'normal');
        }

        /**
         * Method to add the new non heirarchical tags checklist metabox.
         */
        public function add_meta_box() {

            $tax = get_taxonomy($this->_taxonomy);
            add_meta_box('taglist-' . $this->_taxonomy, $tax->labels->name, array($this, 'metabox_content'), $this->_post_type, 'side', 'core');
        }

        /**
         * Method to add the metabox content.
         * @param type $post
         */
        public function metabox_content($post) {

            $defaults = array('taxonomy' => $this->_taxonomy);
            if (!isset($box['args']) || !is_array($box['args']))
                $args = array();
            else
                $args = $box['args'];
            extract(wp_parse_args($args, $defaults), EXTR_SKIP);
            $tax = get_taxonomy($taxonomy);
            ?>
            <div id="taxonomy-<?php echo $taxonomy; ?>" class="categorydiv">
                <ul id="<?php echo $taxonomy; ?>-tabs" class="category-tabs">
                    <li class="tabs"><a href="#<?php echo $taxonomy; ?>-all"><?php echo $tax->labels->all_items; ?></a></li>
                    <li class="hide-if-no-js"><a href="#<?php echo $taxonomy; ?>-pop"><?php _e('Most Used'); ?></a></li>
                </ul>

                <div id="<?php echo $taxonomy; ?>-pop" class="tabs-panel" style="display: none;">
                    <ul id="<?php echo $taxonomy; ?>checklist-pop" class="categorychecklist form-no-clear" >
                        <?php $popular_ids = wp_popular_terms_checklist($taxonomy); ?>
                    </ul>
                </div>

                <div id="<?php echo $taxonomy; ?>-all" class="tabs-panel">
                    <?php
                    $name = ( $taxonomy == $this->_taxonomy ) ? 'post_category' : 'tax_input[' . $taxonomy . ']';
                    echo "<input type='hidden' name='{$name}[]' value='0' />"; // Allows for an empty term set to be sent. 0 is an invalid Term ID and will be ignored by empty() checks.

                    $walker = new Walker_Tag_Checklist();
                    ?>                
                    <ul id="<?php echo $taxonomy; ?>checklist" data-wp-lists="list:<?php echo $taxonomy ?>" class="categorychecklist form-no-clear">
                        <?php wp_terms_checklist($post->ID, array('taxonomy' => $this->_taxonomy, 'popular_cats' => $popular_ids, 'walker' => $walker)) ?>
                    </ul>
                </div>
                <?php if (current_user_can($tax->cap->edit_terms)) : ?>
                    <div id="<?php echo $taxonomy; ?>-adder" class="wp-hidden-children">
                        <h4>
                            <a id="<?php echo $taxonomy; ?>-add-toggle" href="#<?php echo $taxonomy; ?>-add" class="hide-if-no-js">
                                <?php
                                /* translators: %s: add new taxonomy label */
                                printf(__('+ %s'), $tax->labels->add_new_item);
                                ?>
                            </a>
                        </h4>
                        <p id="<?php echo $taxonomy; ?>-add" class="category-add wp-hidden-child">
                            <label class="screen-reader-text" for="new<?php echo $taxonomy; ?>"><?php echo $tax->labels->add_new_item; ?></label>
                            <input type="text" name="new<?php echo $taxonomy; ?>" id="new<?php echo $taxonomy; ?>" class="form-required form-input-tip" value="<?php echo esc_attr($tax->labels->new_item_name); ?>" aria-required="true"/>
                            <input type="button" id="<?php echo $taxonomy; ?>-add-submit" data-wp-lists="add:<?php echo $taxonomy ?>checklist:<?php echo $taxonomy ?>-add" class="button category-add-submit" value="<?php echo esc_attr($tax->labels->add_new_item); ?>" />
                            <?php wp_nonce_field('add-' . $taxonomy, '_ajax_nonce-add-' . $taxonomy, false); ?>
                            <span id="<?php echo $taxonomy; ?>-ajax-response"></span>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
            <?php
        }

        /**
         * Method to add the term to the tags list this is performed
         * with ajax.
         */
        function _wp_ajax_add_non_hierarchical_term() {

            $action = $_POST['action'];
            $taxonomy = get_taxonomy(substr($action, 4));

            check_ajax_referer($action, '_ajax_nonce-add-' . $taxonomy->name);

            if (!current_user_can($taxonomy->cap->edit_terms))
                wp_die(-1);

            $names = explode(',', $_POST['new' . $taxonomy->name]);
            $parent = 0;

            if ($taxonomy->name == 'category')
                $post_category = isset($_POST['post_category']) ? (array) $_POST['post_category'] : array();
            else
                $post_category = ( isset($_POST['tax_input']) && isset($_POST['tax_input'][$taxonomy->name]) ) ? (array) $_POST['tax_input'][$taxonomy->name] : array();

            $checked_categories = array_map('absint', (array) $post_category);
            $popular_ids = wp_popular_terms_checklist($taxonomy->name, 0, 10, false);

            foreach ($names as $tax_name) {

                $tax_name = trim($tax_name);
                $category_nicename = sanitize_title($tax_name);

                if ('' === $category_nicename)
                    continue;

                if (!$cat_id = term_exists($tax_name, $taxonomy->name, $parent))
                    $cat_id = wp_insert_term($tax_name, $taxonomy->name, array('parent' => $parent));

                if (is_wp_error($cat_id))
                    continue;

                else if (is_array($cat_id))
                    $cat_id = $cat_id['term_id'];

                $checked_categories[] = $cat_id;

                if ($parent) // Do these all at once in a second
                    continue;

                $term = get_term($cat_id, $taxonomy->name);

                $html .= '<li id="carousel-' . $term->term_id . '">
                        <label class="selectit">
                            <input value="' . $term->slug . '" type="checkbox" name="tax_input[carousel][]" id="in-carousel-' . $term->term_id . '" checked="checked"> ' . $term->name .
                        '</label></li>';
            }

            $response = array(
                'what' => $taxonomy->name,
                'id' => '1',
                'data' => $html,
                'position' => 1
            );

            $x = new WP_Ajax_Response($response);
            $x->send();
        }

    }

}

/**
 * Walker_Tag_Checklist Class.
 */
if (!class_exists('walker_tag_checklist')) {

    class walker_tag_checklist extends Walker {

        var $tree_type = 'tag';
        var $db_fields = array('parent' => 'parent', 'id' => 'term_id'); //TODO: decouple this

        function start_lvl(&$output, $depth = 0, $args = array()) {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent<ul class='children'>\n";
        }

        function end_lvl(&$output, $depth = 0, $args = array()) {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>\n";
        }

        function start_el(&$output, $tax_term, $depth, $args, $id = 0) {
            extract($args);
            if (empty($taxonomy))
                $taxonomy = 'tag';

            if ($taxonomy == 'tag')
                $name = 'post_tag';
            else
                $name = 'tax_input[' . $taxonomy . ']';

            $class = in_array($tax_term->term_id, $popular_cats) ? ' class="popular-category"' : '';
            $output .= "\n<li id='{$taxonomy}-{$tax_term->term_id}'$class>" . '<label class="selectit"><input value="' . $tax_term->slug . '" type="checkbox" name="' . $name . '[]" id="in-' . $taxonomy . '-' . $tax_term->term_id . '"' . checked(in_array($tax_term->term_id, $selected_cats), true, false) . disabled(empty($args['disabled']), false, false) . ' /> ' . esc_html(apply_filters('the_category', $tax_term->name)) . '</label>';
        }

        function end_el(&$output, $tax_term, $depth = 0, $args = array()) {
            $output .= "</li>\n";
        }

    }

}
?>
