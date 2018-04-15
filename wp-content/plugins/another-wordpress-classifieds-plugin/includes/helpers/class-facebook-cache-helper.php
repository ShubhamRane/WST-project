<?php

function awpcp_facebook_cache_helper() {
    return new AWPCP_FacebookCacheHelper( AWPCP_Facebook::instance() );
}

class AWPCP_FacebookCacheHelper {

    private $facebook;

    public function __construct( $facebook ) {
        $this->facebook = $facebook;
    }

    public function on_place_ad( $ad ) {
        $this->schedule_clear_cache_action( $ad );
    }

    private function schedule_clear_cache_action( $listing ) {
        $this->schedule_clear_cache_action_seconds_from_now( $listing, 10 );
    }

    private function schedule_clear_cache_action_seconds_from_now( $ad, $wait_time ) {
        if ( ! wp_next_scheduled( 'awpcp-clear-ad-facebook-cache', array( $ad->ad_id ) ) ) {
            wp_schedule_single_event( time() + $wait_time, 'awpcp-clear-ad-facebook-cache', array( $ad->ad_id ) );
        }
    }

    public function on_edit_ad( $ad ) {
        $this->schedule_clear_cache_action( $ad );
    }

    public function on_approve_ad( $ad ) {
        $this->schedule_clear_cache_action( $ad );
    }

    public function handle_clear_cache_event_hook( $ad_id ) {
        $this->clear_ad_cache( AWPCP_Ad::find_by_id( $ad_id ) );
    }

    private function clear_ad_cache( $ad ) {
        if (is_null( $ad ) || $ad->disabled ) {
            return;
        }

        $args = array(
            'timeout' => 30,
            'body' => array(
                'id' => url_showad( $ad->ad_id ),
                'scrape' => true,
                'access_token' => $this->facebook->get( 'user_token' ),
            ),
        );

        $response = wp_remote_post( 'https://graph.facebook.com/', $args  );

        if ( $this->is_successful_response( $response ) ) {
            do_action( 'awpcp-listing-facebook-cache-cleared', $ad );
        } else {
            $this->reschedule_clear_cache_action( $ad );
        }
    }

    private function is_successful_response( $response ) {
        if ( is_wp_error( $response ) || ! is_array( $response ) ) {
            return false;
        } else if ( ! isset( $response['response']['code'] ) ) {
            return false;
        } else if ( $response['response']['code'] != 200 ) {
            return false;
        }

        $listing_info = json_decode( $response['body'] );

        if ( ! isset( $listing_info->type ) || $listing_info->type != 'article' ) {
            return false;
        } else if ( empty( $listing_info->title ) ) {
            return false;
        } else if ( ! isset( $listing_info->description ) ) {
            return false;
        }

        return true;
    }

    private function reschedule_clear_cache_action( $listing ) {
        $this->schedule_clear_cache_action_seconds_from_now( $listing, 5 * MINUTE_IN_SECONDS );
    }
}
