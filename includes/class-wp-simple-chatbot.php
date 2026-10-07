<?php
if (!defined('ABSPATH')) {
    exit;
}

class WP_Simple_Chatbot
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_shortcode('mortgage_broker_chatbot', [$this, 'render_shortcode']);
    }

    public function enqueue_assets()
    {
        wp_register_style('wp-simple-chatbot', WPSIMPLE_CHATBOT_PLUGIN_URL . 'assets/css/chatbot.css', [], '1.1.0');
        wp_register_script('wp-simple-chatbot', WPSIMPLE_CHATBOT_PLUGIN_URL . 'assets/js/chatbot.js', ['jquery'], '1.1.0', true);

        wp_localize_script('wp-simple-chatbot', 'wpSimpleChatbot', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wp_simple_chatbot_save'),
            'strings' => [
                'agentTyping' => __('Agent Typing', 'wp-simple-chatbot'),
                'emptyMessage' => __('Oh sorry! Please answer the question correctly.', 'wp-simple-chatbot'),
            ],
        ]);

        wp_enqueue_style('wp-simple-chatbot');
        wp_enqueue_script('wp-simple-chatbot');
    }

    public function render_shortcode($atts = [])
    {
        $atts = shortcode_atts([
            'title' => 'Online',
        ], $atts, 'mortgage_broker_chatbot');

        $title = esc_html($atts['title']);

        ob_start();
        ?>
        <div class="wp-simple-chatbot-container">
            <div id="mbd_chatbot" class="ui-widget-content wp-simple-chatbot">
                <div class="btn-group dropup" id="chatbot_wrap">
                    <button type="button" id="button_toggle" data-popup="on" class="btn btn-primary dropdown-toggle pl-3" aria-expanded="false">
                        <span class="wp-simple-chatbot-label">Chat</span>
                        <span id="message_counter" class="d-none" aria-live="polite">
                            <svg viewBox="0 0 512 512" aria-hidden="true"><path d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.5c0-4.9 5.8-7.8 9.7-4.7L164.2 300c13.9 11.1 33.7 17.2 54.1 17.2s40.2-6.1 54.1-17.2L502.3 190.8zM48 32C21.5 32 0 53.5 0 80v13.7l256 163.7L512 93.7V80c0-26.5-21.5-48-48-48H48z"/></svg>
                            <i>1</i>
                        </span>
                    </button>

                    <div class="dropdown-menu p-0" style="width: 20rem;">
                        <div class="card border-0">
                            <div class="card-header bg-primary text-white">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/broker_img_icon.png'); ?>" class="img-fluid" alt="Broker avatar" />
                                <span class="ml-2"><?php echo $title; ?></span>
                                <button type="button" class="btn float-right" id="close_chatbot" aria-label="Close chatbot">
                                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"/></svg>
                                </button>
                            </div>

                            <div class="card-body ml-3 p-0">
                                <div class="message_wrapper pt-2" aria-live="polite"></div>
                            </div>

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-10 px-0">
                                        <input type="text" class="form-control" id="input_type_here" placeholder="Type here..." style="height: 38px; font-size: 14px; resize: none;" />
                                    </div>
                                    <div class="col-lg-2 px-0">
                                        <button type="button" id="btn_send_chat" class="btn btn-dark" aria-label="Send message">
                                            <svg viewBox="0 0 57 54" aria-hidden="true"><path d="M5.4 44.5h11.2l4.5-24.1c.6-3.3 5.3-3.3 5.9 0l4.7 24.1H52c2.8 0 3.6-3.9 1.8-5.5L30.1 18.5c-1.8-1.7-4.7-1.7-6.5 0L3.6 39c-1.8 1.6-1 5.5 1.8 5.5z"/></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php

        return ob_get_clean();
    }
}
