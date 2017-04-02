<?php
/*
Plugin Name: RestFul API
Description: A plugin for API Endpoint. The main purpose is for FCM service.
Author: Tan Bui
Version: 1.0.0
*/

require "FCMRestfulController.php";

$controller = new FCMRestfulController();

function prefix_get_endpoint_phrase() {
    // rest_ensure_response() wraps the data we want to return into a WP_REST_Response, and ensures it will be properly returned.
    return rest_ensure_response( 'Hello World, this is the WordPress REST API' );
}

/**
 * This function is where we register our routes for our example endpoint.
 * /wp-json/api/v1/test
 */
function prefix_register_example_routes() {
    // register_rest_route() handles more arguments but we are going to stick to the basics for now.
    register_rest_route( 'api/v1', '/test', array(
        // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
        'methods'  => WP_REST_Server::READABLE,
        // Here we register our callback. The callback is fired when this endpoint is matched by the WP_REST_Server class.
        'callback' => 'prefix_get_endpoint_phrase',
    ) );
}

add_action( 'rest_api_init', 'prefix_register_example_routes' );