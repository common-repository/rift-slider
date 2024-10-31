<?php

/**
 * Description of fields-generator-class
 *
 * This class will generate fields for the meta boxes and settings pages.
 * 
 * @author Ryan
 */
if (!class_exists('rift_slider_fields_generator')) {

    class rift_slider_fields_generator {

        /**
         * The Fields_Generator constructor.
         */
        public function __construct() {
            
        }

        /**
         * Render the fields.
         * 
         * @param type $type
         * @param type $field
         * @param type $metaRender 
         */
        function render($type, $field, $meta) {

            switch ($type) {

                case 'text': $this->add_textbox($field, $meta);
                    break;
                case 'select': $this->add_select($field, $meta);
                    break;
                case 'checkbox-list': $this->add_checkbox_list($field, $meta);
                    break;
                case 'radio-list': $this->add_radio_list($field, $meta);
                    break;
                case 'image-radio': $this->add_image_radio($field, $meta);
                    break;
                case 'colorpicker': $this->add_color_picker($field, $meta);
                    break;
                case 'image': $this->add_image($field, $meta);
                    break;
                case 'notification': $this->add_notification($field);
                    break;
                default: echo '#error no control render function!!';
                    break;
            }
        }

        function add_promotion_box($promotion) {

            echo '<div style="background-color: #ffffe0; border: 1px solid #e6db55; border-radius: 3px; padding: 8px">
                <h4 style="margin: 0">' . $promotion['title'] . '</h4>
                <p style="margin: 0">' . $promotion['content'] . '</p>        
              </div>';
        }

        /**
         * Add a textbox field.     
         * @param type $field
         * @param type $meta
         */
        function add_textbox($field, $meta) {

            if (!empty($field['validations']))
                $validation = $this->add_validation($field['validations']);

            echo '<input type="text" name="' . $field['id'] . '" id="', $field['id'] . '" value="' . ("" != $meta ? $meta : $field['std']) . '" ' . $validation . ' /><p class="synth-metabox-description">' . $field['desc'] . '</p>';
        }

        /**
         * Add a select dropdown field.
         * @param type $field
         * @param type $meta
         */
        function add_select($field, $meta) {

            if (empty($meta) && !empty($field['std']))
                $meta = $field['std'];

            echo '<select name="' . $field['id'] . '" id="' . $field['id'] . '">';

            foreach ($field['options'] as $option) {
                echo '<option value="' . $option['value'] . '"' . ($meta === $option['value'] ? ' selected="selected"' : '') . '>' . $option['name'] . '</option>';
            }

            echo '</select>';
            echo '<p class = "synth-metabox-description">' . $field['desc'] . '</p>';
        }

        /**
         * Add a color picker.
         * @param type $field
         * @param type $meta
         */
        function add_color_picker($field, $meta) {

            $meta = '' !== $meta ? $meta : $field['std'];
            $hex_color = '(([a-fA-F0-9]){3}){1,2}$';

            if (preg_match('/^' . $hex_color . '/i', $meta)) // Value is just 123abc, so prepend #.
                $meta = '#' . $meta;
            elseif (!preg_match('/^#' . $hex_color . '/i', $meta)) // Value doesn't match #123abc, so sanitize to just #.
                $meta = "#";
            echo '<input class="synth-colorpicker synth-text-small" type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $meta . '" /><p class="synth-metabox-description">' . $field['desc'] . '</p>';
        }

        /**
         * Add a checkbox list.
         * @param type $field
         * @param type $meta
         */
        function add_checkbox_list($field, $meta) {

            if (empty($meta) && !empty($field['std']))
                $meta = $field['std'];

            if (empty($meta) && !empty($field['std']))
                $meta = $field['std'];

            $display = $field['display'];

            echo '<ul class="synth-checkbox-' . $display . '">';

            foreach ($field['options'] as $option) {
                echo '<li><input type="checkbox" name="' . $field['name'] . '" id="' . $field['id'] . '" value="' . $option['value'] . '"' . ($meta === $option['value'] ? ' checked="checked"' : '') . '>&nbsp;<label for="' . $field['id'] . '">' . $option['text'] . '</label></li>';
            }
            echo '</ul>';
            echo '<p class="synth-metabox-description">' . $field['desc'] . '</p>';
        }

        /**
         * Add a radio button list.
         * @param type $field
         * @param type $meta
         */
        function add_radio_list($field, $meta) {

            if (empty($meta) && !empty($field['std']))
                $meta = $field['std'];

            if (empty($meta) && !empty($field['std']))
                $meta = $field['std'];

            $display = $field['display'];

            echo '<ul id=' . $field['id'] . ' class="synth-radio-' . $display . '">';
            $i = 1;

            foreach ($field['options'] as $option) {
                echo '<li><input type="radio" id="' . $field['id'] . $i . '" name="' . $option['name'] . '" value="' . $option['value'] . '"' . ($meta === $option['value'] ? ' checked="checked"' : '') . '>&nbsp;<label for="' . $field['id'] . $i . '">' . $option['text'] . '</label></li>';
                $i++;
            }
            echo '</ul>';
            echo '<p class="synth-metabox-description">', $field['desc'], '</p>';
        }

        /**
         * Add a radio image button.
         * @param type $field
         * @param type $meta
         */
        function add_image_radio($field, $meta) {

            if (empty($meta) && !empty($field['std']))
                $meta = $field['std'];

            if (empty($meta) && !empty($field['std']))
                $meta = $field['std'];

            $display = $field['display'];

            echo '<ul id=' . $field['id'] . ' class="synth-image-radio-' . $display . '">';
            $i = 1;

            foreach ($field['options'] as $option) {

                if ($meta == $option['value']) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }

                echo '<li>
                    <input type="radio" id="' . $field['id'] . $i . '" name="' . $option['name'] . '" value="' . $option['value'] . '"' . ($meta == $option['value'] ? ' checked="checked"' : '') . ' />
                    <img class="' . $selected . '" src="' . $option['url'] . '" alt="" onClick="document.getElementById(\'' . $field['id'] . $i . '\').checked = true;" />
                  </li>';
                $i++;
            }
            echo '</ul>';
            echo '<p class="synth-metabox-description">' . $field['desc'] . '</p>';
        }

        function add_notification($field) {

            echo '<p class="update">' . $field['desc'] . '</p>';
        }

        function add_image($field, $meta) {

            echo '<img src="' . $field['url'] . '" alt="' . $field['alt'] . '" />
              <p class="synth-metabox-description">' . $field['desc'] . '</p>';
        }

        /**
         * Set the validation for the control fields.
         * @param type $validations
         * @return type
         */
        function add_validation($validations = array()) {

            $comparable = " ";

            foreach ($validations as $validation) {

                $type = $validation['type'];

                switch ($type) {

                    case 'required': {

                            $comparable .= "required ";
                        }
                        break;
                    case 'number': {

                            $min = $validation['min'];
                            $max = $validation['max'];

                            $comparable .= "number min='$min' max='$max' ";
                        }
                        break;
                }
            }

            return $comparable;
        }

    }

}
?>
