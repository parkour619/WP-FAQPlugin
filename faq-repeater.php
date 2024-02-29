<?php
/**
 * Plugin Name: FAQ Repeater Fields
 * Description: Single Post FAQ Repeater
 * Author: Mohsin
 * Version: 1.0.0
 * Author URI: https://www.linkedin.com/in/mohsin6savi
 **/

// Add meta box for repeater field
function faq_custom_meta_box() {
    add_meta_box(
        'faq-repeater-meta-box',
        'FAQ Repeater Field',
        'faq_render_repeater_meta_box',
        'post',  // Change to 'post' for default post type
        'normal',
        'default'
    );
}
add_action( 'add_meta_boxes', 'faq_custom_meta_box' );

function faq_render_repeater_meta_box( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'faq_repeater_meta_box_nonce' );

    // Get existing repeater field values
    $repeater_values = get_post_meta( $post->ID, 'faq_repeater_field', true );
    $repeater_textarea_values = get_post_meta( $post->ID, 'faq_repeater_field_textarea', true );
    ?>
    <style>
        .faq-repeater-row input[type="text"],
        .faq-repeater-row textarea {
            width: 100%;
            margin-bottom: 10px;
        }
        #add-row,
        .remove-row {
            float: right;
            margin-top: 10px;
            margin-left: 10px;
        }
    </style>
    <div id="faq-repeater-fields">
        <?php
        if ( $repeater_values && is_array( $repeater_textarea_values ) ) {
            foreach ( $repeater_values as $key => $value ) {
                // Check if the index exists in the $repeater_textarea_values array
                $textarea_value = isset( $repeater_textarea_values[ $key ] ) ? esc_textarea( $repeater_textarea_values[ $key ] ) : '';
                ?>
                <div class="faq-repeater-row">
                    <input type="text" name="faq_repeater_field[]" value="<?php echo esc_attr( $value ); ?>" placeholder="Question" />
                    <textarea name="faq_repeater_field_textarea[]" rows="4" cols="50" placeholder="Answer"><?php echo $textarea_value; ?></textarea>
                    <?php if ( $key > 0 ) { ?>
                        <button class="remove-row">Remove</button>
                    <?php } ?>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="faq-repeater-row">
                <input type="text" name="faq_repeater_field[]" placeholder="Question" />
                <textarea name="faq_repeater_field_textarea[]" rows="4" cols="50" placeholder="Answer"></textarea>
                <button class="remove-row" style="display:none;">Remove</button>
            </div>
            <?php
        }
        ?>
    </div>
    <button id="add-row">Add Row</button>
    <script>
        jQuery(document).ready(function($) {
            $('#add-row').on('click', function() {
                $('#faq-repeater-fields').append('<div class="faq-repeater-row">' +
                    '<input type="text" name="faq_repeater_field[]" placeholder="Question" />' +
                    '<textarea name="faq_repeater_field_textarea[]" rows="4" cols="50" placeholder="Answer"></textarea>' +
                    '<button class="remove-row">Remove</button>' +
                    '</div>');
            });

            $(document).on('click', '.remove-row', function() {
                $(this).closest('.faq-repeater-row').remove();
            });
        });
    </script>
    <?php
}

// Save repeater field data
function faq_save_repeater_field( $post_id ) {
    if ( ! isset( $_POST['faq_repeater_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['faq_repeater_meta_box_nonce'], basename( __FILE__ ) ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( isset( $_POST['faq_repeater_field'] ) && is_array( $_POST['faq_repeater_field'] ) ) {
        $repeater_field_values = array_map( 'sanitize_text_field', $_POST['faq_repeater_field'] );
        update_post_meta( $post_id, 'faq_repeater_field', $repeater_field_values );
    } else {
        delete_post_meta( $post_id, 'faq_repeater_field' );
    }

    if ( isset( $_POST['faq_repeater_field_textarea'] ) && is_array( $_POST['faq_repeater_field_textarea'] ) ) {
        $repeater_field_textarea_values = array_map( 'sanitize_textarea_field', $_POST['faq_repeater_field_textarea'] );
        update_post_meta( $post_id, 'faq_repeater_field_textarea', $repeater_field_textarea_values );
    } else {
        delete_post_meta( $post_id, 'faq_repeater_field_textarea' );
    }
}
add_action( 'save_post', 'faq_save_repeater_field' );

// Display FAQs on single post as an accordion
function display_faq_accordion() {
    // Get FAQ data
    $faq_questions = get_post_meta( get_the_ID(), 'faq_repeater_field', true );
    $faq_answers = get_post_meta( get_the_ID(), 'faq_repeater_field_textarea', true );

    if ( ! empty( $faq_questions ) && is_array( $faq_questions ) ) {
        ?>
        <div class="faq-accordion">
            <?php
            foreach ( $faq_questions as $key => $question ) {
                $answer = isset( $faq_answers[ $key ] ) ? wpautop( $faq_answers[ $key ] ) : '';

                if ( ! empty( $question ) && ! empty( $answer ) ) {
                    ?>
                    <div class="faq-item">
                        <p class="faq-question"><?php echo esc_html( $question ); ?><i class="fa fa-plus accordion-icon"></i><i class="fa fa-minus accordion-icon" style="display:none;"></i></p>
                        <div class="faq-answer"><?php echo $answer; ?></div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <?php
    }
}

add_action( 'faq_single_post_content', 'display_faq_accordion' );