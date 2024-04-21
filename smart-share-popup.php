<?php
/*
Plugin Name: Smart Share Popup
Description: A robust tool that boosts sharing your website link.
Version: 1.1
Author: Vadym Zosiak
Text Domain: smart-share-popup
Domain Path: /languages
*/

if (!defined('WPINC')) {
    die;
}

define('SMART_SHARE_POPUP', 'Smart Share Popup');

function add_to_home_screen_popup_enqueue_scripts()
{
    wp_enqueue_style('smart-share-popup-style', plugin_dir_url(__FILE__) . 'css/style.css');
    wp_enqueue_script('smart-share-popup-script', plugin_dir_url(__FILE__) . 'js/script.js', array(), '1.0', true);

    $smartBgColor = get_option('smart_share_popup_background_color');
    $smartTextColor = get_option('smart_share_popup_text_color');
    $smartDelay = get_option('smart_share_popup_initial_delay');
    $smartNoDelay = get_option('smart_share_popup_no_delay');

    $localization_data = array(
        'smartBgColor' => ($smartBgColor) ? $smartBgColor : '#060D0D',
        'smartTextColor' => ($smartTextColor) ? $smartTextColor : '#ffffff',
        'smartDelay' => ($smartDelay) ? $smartDelay : 5,
        'smartNoDelay' => ($smartNoDelay) ? $smartNoDelay : 15,
    );

    wp_add_inline_script('smart-share-popup-script', 'var smartShareSettings = ' . json_encode($localization_data) . ';');
}

function add_to_home_screen_popup_output()
{
    $popup_content = '<div id="fotozSmartPopup">
      <div class="fixed-circle smart-popup-yes" id="fotozSmartShareIcon">
      <div class="circle-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-share-fill" viewBox="0 0 16 16">
            <path d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5z"/>
          </svg>
        </div>
      </div>
      <div class="smart-popup-container" id="smartPopupContainer">
        <div class="smart-popup-question">' . esc_html__('Would you like to save or share?', 'smart-share-popup') . '</div>
        <div class="smart-popup-buttons">
          <button class="smart-popup-button smart-popup-yes">' . esc_html__('Yes', 'smart-share-popup') . '</button>
          <button class="smart-popup-button smart-popup-no">' . esc_html__('No', 'smart-share-popup') . '</button>
          <button class="smart-popup-button smart-popup-maybe">' . esc_html__('Maybe', 'smart-share-popup') . '</button>
        </div>
      </div>
      <div class="fotoz-smart-modal" id="smartShareModal">
      <div class="modal-content">
        <span class="modal-close" id="modalClose">&times;</span>
        <div class="modal-body">
          <div class="modal-icons">
            <!-- First row -->
            <div class="modal-icons-row">
              <!-- Facebook -->
              <a id="facebookLink" href="#" target="_blank" rel="noopener noreferrer" title="Share on Facebook">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="white" class="bi bi-facebook modal-icon" viewBox="0 0 16 16">
      <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
    </svg>
              </a>
              <!-- Twitter -->
              <a id="twitterLink" href="#" target="_blank" rel="noopener noreferrer" title="Share on Twitter">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="white" class="bi bi-twitter modal-icon" viewBox="0 0 16 16">
      <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
    </svg>
              </a>
              <!-- Pinterest -->
              <a id="pinterestLink" href="#" target="_blank" rel="noopener noreferrer" title="Pin on Pinterest">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="white" class="bi bi-pinterest modal-icon" viewBox="0 0 16 16">
      <path d="M8 0a8 8 0 0 0-2.915 15.452c-.07-.633-.134-1.606.027-2.297.146-.625.938-3.977.938-3.977s-.239-.479-.239-1.187c0-1.113.645-1.943 1.448-1.943.682 0 1.012.512 1.012 1.127 0 .686-.437 1.712-.663 2.663-.188.796.4 1.446 1.185 1.446 1.422 0 2.515-1.5 2.515-3.664 0-1.915-1.377-3.254-3.342-3.254-2.276 0-3.612 1.707-3.612 3.471 0 .688.265 1.425.595 1.826a.24.24 0 0 1 .056.23c-.061.252-.196.796-.222.907-.035.146-.116.177-.268.107-1-.465-1.624-1.926-1.624-3.1 0-2.523 1.834-4.84 5.286-4.84 2.775 0 4.932 1.977 4.932 4.62 0 2.757-1.739 4.976-4.151 4.976-.811 0-1.573-.421-1.834-.919l-.498 1.902c-.181.695-.669 1.566-.995 2.097A8 8 0 1 0 8 0z"/>
    </svg>
              </a>
            </div>
            <!-- Second row -->
            <div class="modal-icons-row">
              <!-- LinkedIn -->
              <a id="linkedinLink" href="#" target="_blank" rel="noopener noreferrer" title="Share on LinkedIn">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="white" class="bi bi-linkedin modal-icon" viewBox="0 0 16 16">
      <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
    </svg>
              </a>
              <!-- Telegram -->
              <a id="telegramLink" href="#" target="_blank" rel="noopener noreferrer" title="Share on Telegram">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="white" class="bi bi-telegram modal-icon" viewBox="0 0 16 16">
      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.287 5.906c-.778.324-2.334.994-4.666 2.01-.378.15-.577.298-.595.442-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294.26.006.549-.1.868-.32 2.179-1.471 3.304-2.214 3.374-2.23.05-.012.12-.026.166.016.047.041.042.12.037.141-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8.154 8.154 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629.093.06.183.125.27.187.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.426 1.426 0 0 0-.013-.315.337.337 0 0 0-.114-.217.526.526 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09z"/>
    </svg>
              </a>
              <!-- WhatsApp -->
              <a id="whatsappLink" href="#" target="_blank" rel="noopener noreferrer" title="Share on WhatsApp">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="white" class="bi bi-whatsapp modal-icon" viewBox="0 0 16 16">
      <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
    </svg>
              </a>
            </div>
          </div>
          <button id="copyButton" class="full-width-button" data-copy-text="' . esc_attr__("Copy Page Link", "smart-share-popup") . '" data-copied-text="' . esc_attr__("Page Link Copied", "smart-share-popup") . '">' . esc_html__("Copy Page Link", "smart-share-popup") . '</button>
        </div>
      </div>
    </div>';
    echo $popup_content;
}

function smart_share_popup_settings_page()
{
    require_once plugin_dir_path(__FILE__) . 'settings.php';
}

function smart_share_popup_menu()
{
    add_submenu_page(
        'tools.php',
        'Smart Share Popup Settings',
        'Smart Share Popup',
        'manage_options',
        'smart-share-popup-settings',
        'smart_share_popup_settings_page'
    );
}

function smart_share_popup_register_settings()
{
    add_option('smart_share_popup_background_color', '#060D0D');
    add_option('smart_share_popup_text_color', '#ffffff');
    add_option('smart_share_popup_initial_delay', 5);
    add_option('smart_share_popup_no_delay', 15);
}

function smart_share_options_update_callback()
{
    $background_color = sanitize_text_field($_POST['background_color']);
    $text_color = sanitize_text_field($_POST['text_color']);
    $initial_delay = intval($_POST['initial_delay']);
    $no_delay = intval($_POST['no_delay']);

    update_option('smart_share_popup_background_color', $background_color);
    update_option('smart_share_popup_text_color', $text_color);
    update_option('smart_share_popup_initial_delay', $initial_delay);
    update_option('smart_share_popup_no_delay', $no_delay);

    $response = array(
        'success' => true,
        'message' => 'Settings updated successfully.',
    );
    wp_send_json($response);
}

function add_plugin_settings_link($links)
{
    $settings_link = '<a href="' . admin_url('admin.php?page=smart-share-popup-settings') . '">' . esc_html__('Settings', 'smart-share-popup') . '</a>';
    $links[] = $settings_link;
    return $links;
}

function smart_share_popup_load_textdomain()
{
    $text_domain = 'smart-share-popup';
    $plugin_languages_dir = dirname(plugin_basename(__FILE__)) . '/languages/';
    load_plugin_textdomain($text_domain, false, $plugin_languages_dir);
}


register_activation_hook(__FILE__, 'smart_share_popup_menu');
register_activation_hook(__FILE__, 'smart_share_popup_register_settings');
add_action('wp_enqueue_scripts', 'add_to_home_screen_popup_enqueue_scripts');
add_action('admin_menu', 'smart_share_popup_menu');
add_action('wp_footer', 'add_to_home_screen_popup_output');
add_action('plugins_loaded', 'smart_share_popup_load_textdomain');
add_action('wp_ajax_smart_share_options_update', 'smart_share_options_update_callback');
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'add_plugin_settings_link');
