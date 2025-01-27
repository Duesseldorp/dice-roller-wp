<?php
/*
Plugin Name: Dice Roller
Description: A tool to simulate rolling a dice or multiple dice. Use the shortcode [dice_roller] to display the tool.
Version: 1.0
Author: Martin Gräbing
Text Domain: dice-roller
Domain Path: /languages
*/

// Load the text domain for translations
function dr_load_textdomain() {
    load_plugin_textdomain(
        'dice-roller', // Text domain
        false, // Deprecated argument (always false)
        dirname(plugin_basename(__FILE__)) . '/languages' // Relative path to languages folder
    );
}
add_action('plugins_loaded', 'dr_load_textdomain');

// Enqueue CSS and JavaScript
function dr_enqueue_scripts() {
    // Enqueue CSS
    wp_enqueue_style('dr-style', plugins_url('style.css', __FILE__));

    // Enqueue JavaScript
    wp_enqueue_script('dr-script', plugins_url('script.js', __FILE__), array('jquery'), null, true);

    // Localize script for translations
    wp_localize_script('dr-script', 'dr_translations', array(
        'roll_dice' => esc_html__('Roll Dice', 'dice-roller'),
        'invalid_input' => esc_html__('Please enter a valid number of dice.', 'dice-roller'),
        'dice' => esc_html__('Dice', 'dice-roller'), // Add translation for "Dice"
        'total' => esc_html__('Total', 'dice-roller'), // Add translation for "Total"
    ));
}
add_action('wp_enqueue_scripts', 'dr_enqueue_scripts');

// Shortcode to display the tool
function dr_shortcode() {
    ob_start(); // Start output buffering
    ?>
    <div class="dr-container">
        <h1 class="dr-heading"><?php echo esc_html__('Dice Roller', 'dice-roller'); ?></h1>
        <div class="dr-explanation-box">
            <p>
                <?php echo esc_html__('This tool simulates rolling a dice or multiple dice. Enter the number of dice you want to roll and click "Roll Dice" to see the results.', 'dice-roller'); ?>
            </p>
        </div>
        <form id="dr-form">
            <label for="dr-number-of-dice"><?php echo esc_html__('Number of dice:', 'dice-roller'); ?></label>
            <input type="number" id="dr-number-of-dice" min="1" max="10" value="1" required>
            <button type="submit"><?php echo esc_html__('Roll Dice', 'dice-roller'); ?></button>
        </form>
        <div id="dr-output" class="dr-output"></div>
    </div>
    <?php
    return ob_get_clean(); // Return the buffered content
}
add_shortcode('dice_roller', 'dr_shortcode');