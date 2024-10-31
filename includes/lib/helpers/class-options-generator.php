<?php

require_once('class-fields-generator.php');

/**
 * Description of custom-fields
 *
 * @author Ryan
 */
if (!class_exists('rift_slider_options_generator')) {

    class rift_slider_options_generator {

        protected $_option_name;
        protected $_form_id;
        protected $_fields;
        protected $_options;
        protected $_fields_generator;

        /**
         * The Options_Generator constructor.
         * 
         * @param type $option_name
         * @param type $form_id
         * @param type $fields
         */
        public function __construct($option_name, $form_id, $fields) {

            $this->_option_name = $option_name;
            $this->_form_id = $form_id;
            $this->_fields = $fields;
            $this->_options = get_option($option_name);

            $this->_fields_generator = new rift_slider_fields_generator();
        }

        /**
         * This function renders the option form.
         */
        public function render() {

            $options = $this->_options;

            //use nonce for verification
            echo '<input type="hidden" name="wp_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

            echo '<form id="' . $this->_form_id . '" action="' . esc_attr($_SERVER['REQUEST_URI']) . '" enctype="multipart/form-data" method="POST">';
            echo '<table class="form-table">';

            foreach ($options['fields'] as $field) {

                echo '<tr class="synth-type-' . sanitize_html_class($field['type']) . ' cmb_id_' . sanitize_html_class($field['id']) . '">';

                if ($field['type'] == "title") {
                    echo '<td colspan="2">';
                } else {
                    if ($options['show_names'] == true) {
                        echo '<th style="width:18%"><label for="', $field['id'], '">', $field['name'], '</label></th>';
                    }
                    echo '<td>';
                }

                $meta = get_option($field['id']);

                $this->_fields_generator->render($field['type'], $field, $meta);

                echo '</td>', '</tr>';
            }

            echo '<tr>
                <td>
                    <input type="hidden" name="page" value="' . $options['page'] . '" />
                    <input type="hidden" name="action" value="' . $options['action'] . '" />                  
                    <input class="button-primary" type="submit" value="' . __("Save Changes", SYNTH_RIFT_SLIDER_DOMAIN) . '" />
                </td>
             </tr>';

            echo '</table>';
            echo '</form>';
        }

        /**
         * The save function will save the options on the page.
         * @return type
         */
        public function save_options() {

            $options = get_option($this->_option_name);

            foreach ($options['fields'] as $field) {

                $id = $field['id'];
                $value = $_REQUEST[$field['id']];

                if (isset($id)) {
                    update_option($id, $value);
                }
            }

            return;
        }

    }

}
?>
