<?php

class FCMRestfulController extends WP_REST_Controller {

    function __construct()
    {
        add_action( 'rest_api_init',[$this, 'register_routes'] );
    }

    /**
     * Register the routes for the objects of the controller.
     * POST http://abc.com/wp-json/fcm/v1/device
     */
    public function register_routes() {
        $version = '1';
        $namespace = 'fcm/v' . $version;
        $base = 'device';
        register_rest_route( $namespace, '/' . $base, array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'create_item' ),
                'permission_callback' => [$this, 'create_item_permissions_check']
            ),
        ) );
    }

    /**
     * Create one item from the collection
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_REST_Response | WP_Error
     */
    public function create_item( $request ) {
        $post_id = wp_insert_post([
            'post_title'    => $this->prepare_item_for_database( $request ),
            'post_status'   => 'private',
        ]);

        if ($post_id != 0) {
            wp_set_post_categories($post_id, get_cat_ID('device'));
            return new WP_REST_Response( ['Success'] , 200 );
        } else {
            return new WP_Error('Failed', 'Failed');
        }
    }

    /**
     * @param WP_REST_Request $request
     * @return string
     */
    public function prepare_item_for_database($request) {
        return $request->get_param('device');
    }

    public function create_item_permissions_check($request)
    {
        $authentication_header = $request->get_header('authorization');     //'server' => $_SERVER['HTTP_AUTHORIZATION']
        return JWT_AUTH_SECRET_KEY == $authentication_header ? true : new WP_Error( 'auth_failed', 'Authentication failed!', array( 'status' => 403 ) );;
    }

}