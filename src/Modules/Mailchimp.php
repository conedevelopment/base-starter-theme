<?php

namespace Base\Modules;

class Mailchimp extends Module
{
    /**
     * Get the API token.
     *
     * @return string
     */
    protected function getToken()
    {
        return base64_encode(sprintf('%s:%s', MAILCHIMP_USER, MAILCHIMP_API_KEY));
    }

    /**
     * Subscribe an email address to the Mailchimp audience.
     *
     * @param  string  $email
     * @param  string  $fname
     * @return array|\WP_Error
     */
    public function subscribe($email, $fname)
    {
        return wp_remote_post(MAILCHIMP_URL, [
            'headers' => [
                'Authorization' => "Basic {$this->getToken()}",
                'Content-type' => 'application/json',
            ],
            'body' => json_encode([
                'status' => 'subscribed',
                'email_address' => $email,
                'merge_fields' => [
                    'FNAME' => $fname,
                ],
            ]),
        ]);
    }

    /**
     * Static method to handle AJAX subscription requests.
     */
    public static function mailchimpSubscribe()
    {
        if (! wp_verify_nonce($_POST['_wpnonce'], 'subscribe')) {
            http_response_code(403);
            die;
        }

        if (empty($_POST['fname']) || empty($_POST['email'])) {
            http_response_code(422);
            die;
        }

        $client = new self();
        $response = $client->subscribe($_POST['email'], $_POST['fname']);

        $body = json_decode(wp_remote_retrieve_body($response), true);

        if (is_wp_error($response) || ! isset($body['id'])) {
            http_response_code(422);
        }

        wp_send_json_success([
            'success' => true,
        ]);
    }

    /**
     * Boot the Mailchimp class by registering AJAX actions.
     */
    public function boot(): void
    {
        add_action('wp_ajax_nopriv_mailchimp-subscribe', [static::class, 'mailchimpSubscribe']);
        add_action('wp_ajax_mailchimp_subscribe', [static::class, 'mailchimpSubscribe']);

    }
}
