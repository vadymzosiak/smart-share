<?php
if (!defined('WPINC')) {
    die;
}
?>
<style>
    .smart-popup-container {
        position: fixed;
        display: block;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 10px;
        background-color: <?php echo esc_attr(get_option('smart_share_popup_background_color')) ?>;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        z-index: 9999;
        text-align: center;
    }

    .smart-popup-question {
        font-size: 18px;
        margin-bottom: 8px;
        display: inline-block;
        color: <?php echo esc_attr(get_option('smart_share_popup_text_color')) ?>;
    }

    .smart-popup-buttons {
        display: inline-block;
        text-align: center;
        margin-top: 6px;
    }

    .smart-popup-button {
        display: inline-block;
        padding: 8px 16px;
        background-color: #3498db;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-right: 10px;
        font-size: 16px !important;
    }

    .smart-popup-yes {
        background-color: #28a745;
    }

    .smart-popup-maybe {
        background-color: #007bff;
    }

    .smart-popup-no {
        background-color: #e74c3c;
    }

    @media (min-width: 768px) {
        .smart-popup-question {
            margin-right: 10px;
        }
    }
</style>
<div class="wrap">
    <h3><?php echo esc_html(SMART_SHARE_POPUP); ?></h3>
    <h1><?php echo esc_html__('Settings', 'smart-share-popup') ?></h1>

    <form id="smartShareOptions">
        <table class="form-table" role="presentation">
            <tbody>
            <tr>
                <th scope="row"><?php echo esc_html__('Background Color', 'smart-share-popup') ?></th>
                <td width="60">
                    <p>
                        <input type="color" id="background_color" style="width:60px;"
                               value="<?php echo esc_attr(get_option('smart_share_popup_background_color')); ?>"
                               class="color-picker"/>
                    </p>
                </td>
                <td>
                    <p class="description"><?php echo esc_html__('Choose a background color for the popup panel and modal window.', 'smart-share-popup') ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php echo esc_html__('Text Color', 'smart-share-popup') ?></th>
                <td width="60">
                    <p>
                        <input type="color" id="text_color" style="width:60px;"
                               value="<?php echo esc_attr(get_option('smart_share_popup_text_color')); ?>"
                               class="color-picker"/>
                    </p>
                </td>
                <td>
                    <p class="description"><?php echo esc_html__('Choose a color for the question and icons in the desktop version.', 'smart-share-popup') ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php echo esc_html__('Initial Delay', 'smart-share-popup') ?></th>
                <td>
                    <p>
                        <input type="number" id="initial_delay" style="width:60px;"
                               value="<?php echo esc_attr(get_option('smart_share_popup_initial_delay')); ?>"/>
                    </p>
                </td>
                <td>
                    <p class="description"><?php echo esc_html__('Display a popup panel once the page has loaded after a specified number of seconds.', 'smart-share-popup') ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php echo esc_html__('Delay After NO Button Click', 'smart-share-popup') ?></th>
                <td>
                    <p>
                        <input type="number" id="no_delay" style="width:60px;"
                               value="<?php echo esc_attr(get_option('smart_share_popup_no_delay')); ?>"/>
                    </p>
                </td>
                <td>
                    <p class="description"><?php echo esc_html__('Stop displaying the pop-up panel for the specified number of minutes.', 'smart-share-popup') ?></p>
                </td>
            </tr>

            </tbody>
        </table>
        <button type="submit"
                class="button button-primary"><?php echo esc_html__('Save changes', 'smart-share-popup') ?></button>
    </form>
    <form id="smartShareDefaults" style="margin-top: 24px;">
        <button type="submit"
                class="button"><?php echo esc_html__('Restore default settings', 'smart-share-popup') ?></button>
    </form>

    <div class="smart-popup-container" id="smartPopupContainer">
        <div class="smart-popup-question" id="question"><?php echo esc_html__('Would you like to save or share?', 'smart-share-popup') ?></div>
        <div class="smart-popup-buttons">
            <button class="smart-popup-button smart-popup-yes"><?php echo esc_html__('Yes', 'smart-share-popup') ?></button>
            <button class="smart-popup-button smart-popup-no"><?php echo esc_html__('No', 'smart-share-popup') ?></button>
            <button class="smart-popup-button smart-popup-maybe"><?php echo esc_html__('Maybe', 'smart-share-popup') ?></button>
        </div>
    </div>
</div>

<script>

    const backgroundColor = document.getElementById('background_color');
    const panel = document.getElementById('smartPopupContainer');
    const textColor = document.getElementById('text_color');
    const question = document.getElementById('question');

    jQuery(document).ready(function ($) {

        $('#smartShareOptions').on('submit', function (event) {
            event.preventDefault();

            var formData = {
                action: 'smart_share_options_update',
                background_color: $('#background_color').val(),
                text_color: $('#text_color').val(),
                initial_delay: $('#initial_delay').val(),
                no_delay: $('#no_delay').val(),
            };

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: formData,
                success: function (response) {
                    alert('Settings updated successfully.');
                },
                error: function (error) {
                    alert('Error updating settings. Please try again.');
                },
            });
        });

        $('#smartShareDefaults').on('submit', function (event) {
            event.preventDefault();

            var formData = {
                action: 'smart_share_options_update',
                background_color: '#060D0D',
                text_color: '#ffffff',
                initial_delay: 5,
                no_delay: 15,
            };

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: formData,
                success: function (response) {
                    location.reload();
                },
                error: function (error) {
                    alert('Error updating settings. Please try again.');
                },
            });
        });
    });

    backgroundColor.addEventListener('input', function() {
        const selectedColor = backgroundColor.value;
        panel.style.backgroundColor = selectedColor;
    });

    textColor.addEventListener('input', function() {
        const selectedTextColor = textColor.value;
        question.style.color = selectedTextColor;
    });

</script>


