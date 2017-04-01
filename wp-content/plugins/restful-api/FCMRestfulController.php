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
     * @return WP_Error|WP_REST_Request
     */
    public function create_item( WP_REST_Request $request ) {
        $item = $this->prepare_item_for_database( $request );

        return new WP_REST_Response( $item , 200 );
    }

    public function prepare_item_for_database($request) {
        return ['device' => $request->get_param('device')];
    }

    public function create_item_permissions_check($request)
    {
        $authentication_header = $request->get_header('authorization');     //'server' => $_SERVER['HTTP_AUTHORIZATION']
        return JWT_AUTH_SECRET_KEY == $authentication_header ? true : new WP_Error( 'auth_failed', 'Authentication failed!', array( 'status' => 403 ) );;
    }

}