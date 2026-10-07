<?php
if (!defined('ABSPATH')) {
    exit;
}

class WP_Simple_Chatbot_Ajax
{
    public function __construct()
    {
        add_action('wp_ajax_wp_simple_chatbot_save', [$this, 'save_chat']);
        add_action('wp_ajax_nopriv_wp_simple_chatbot_save', [$this, 'save_chat']);
    }

    public function save_chat()
    {
        check_ajax_referer('wp_simple_chatbot_save', 'nonce');

        $conversation = isset($_POST['convo']) ? wp_unslash($_POST['convo']) : '';
        $messages = $this->normalize_messages($conversation);

        if (empty($messages)) {
            wp_send_json_error([
                'message' => __('No valid chat data provided.', 'wp-simple-chatbot'),
            ]);
        }

        global $wpdb;

        $legacy_table = $wpdb->prefix . 'mbd_chatbot';
        $modern_table = $wpdb->prefix . 'wp_simple_chatbot_messages';

        if ($this->table_exists($legacy_table)) {
            $fields = [
                'chat_q1' => '',
                'chat_answer_q1' => '',
                'chat_q2' => '',
                'chat_answer_q2' => '',
                'chat_q3' => '',
                'chat_answer_q3' => '',
            ];

            $values = array_values($messages);
            foreach ($fields as $key => $value) {
                $fields[$key] = isset($values[array_search($key, array_keys($fields))]) ? sanitize_text_field((string) $values[array_search($key, array_keys($fields))]) : '';
            }

            $insert = $wpdb->insert(
                $legacy_table,
                $fields,
                ['%s', '%s', '%s', '%s', '%s', '%s']
            );

            if ($insert) {
                wp_send_json_success(['message' => __('Successfully sent.', 'wp-simple-chatbot')]);
            }

            wp_send_json_error(['message' => __('Failed to save the conversation.', 'wp-simple-chatbot')]);
        }

        $wpdb->query(
            "CREATE TABLE IF NOT EXISTS `{$modern_table}` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                `session_id` varchar(64) NOT NULL DEFAULT '',
                `message_data` longtext NOT NULL,
                `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `session_id` (`session_id`),
                KEY `created_at` (`created_at`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
        );

        $session_id = wp_generate_uuid4();
        $insert = $wpdb->insert(
            $modern_table,
            [
                'session_id' => $session_id,
                'message_data' => wp_json_encode($messages),
            ],
            ['%s', '%s']
        );

        if ($insert) {
            wp_send_json_success(['message' => __('Successfully sent.', 'wp-simple-chatbot')]);
        }

        wp_send_json_error(['message' => __('Failed to save the conversation.', 'wp-simple-chatbot')]);
    }

    private function table_exists($table_name)
    {
        global $wpdb;

        $query = $wpdb->prepare('SHOW TABLES LIKE %s', $table_name);

        return $wpdb->get_var($query) === $table_name;
    }

    private function normalize_messages($payload)
    {
        $payload = trim((string) $payload);
        if ($payload === '') {
            return [];
        }

        $decoded = json_decode(stripslashes($payload), true);

        if (is_array($decoded) && !empty($decoded)) {
            $payload = $decoded;
        } else {
            $payload = array_filter(array_map('trim', explode('|', $payload)));
        }

        $messages = [];

        foreach ($payload as $index => $value) {
            if (is_array($value)) {
                $text = isset($value['text']) ? (string) $value['text'] : '';
                $role = isset($value['role']) ? sanitize_key((string) $value['role']) : 'user';
            } else {
                $text = (string) $value;
                $role = $index % 2 === 0 ? 'bot' : 'user';
            }

            $text = sanitize_text_field($text);
            if ($text === '') {
                continue;
            }

            $messages[] = [
                'role' => $role,
                'text' => $text,
            ];
        }

        return array_slice($messages, 0, 50);
    }
}
