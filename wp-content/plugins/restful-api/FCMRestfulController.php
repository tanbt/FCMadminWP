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
            array(
                'methods'         => WP_REST_Server::EDITABLE,
                'callback'        => array( $this, 'update_item' ),
                'permission_callback' => [$this, 'create_item_permissions_check']
            )
        ) );
    }

    /**
     * Append a category to a post's categories
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response | WP_Error
     *
        PUT /FCMadminWP/wp-json/fcm/v1/device HTTP/1.1
        Host: localhost
        Content-Type: application/x-www-form-urlencoded
        Authorization: myownsecretkey
        Cache-Control: no-cache
        Postman-Token: 82a966be-73a3-1fff-dbbb-5577046799e1

        device=eVCsmuOnpzM%3AAPA91bHnJ6n9w5GtsKdAm2eWC-vrOUOtAjN_IhFhcTM4bCR87Y98kJELcqo_TmeWjDoAok-UaQgt8qsgssrsB_tFKyqmdBbgpAKGV4-t4wz1xKzRUU-dOazUdLdXQNGbX9JS-jnA8SIA&cat_name=exchange+student
     *
     */
    public function update_item($request)
    {
        $post_id = get_page_by_title($request->get_param('device'), OBJECT, 'post')->ID;
        if( is_null($post_id)) {
            $post_id = wp_insert_post([
                'post_title' => $this->prepare_item_for_database($request),
                'post_status' => 'private',
            ]);
        }
        wp_set_post_categories($post_id, get_cat_ID('device'));
        $result = wp_set_post_categories($post_id, [get_cat_ID($request->get_param('cat_name'))], true);
        if(is_array($result)) {
            return new WP_REST_Response( ['Success'] , 200 );
        } else {
            return new WP_Error('Failed', 'Failed');
        }
    }

    /**
     * Create one item from the collection
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_REST_Response | WP_Error
     *
     *  POST /FCMadminWP/wp-json/fcm/v1/device HTTP/1.1
        Host: localhost
        Content-Type: application/x-www-form-urlencoded
        Authorization: myownsecretkey

        device=eVCsmuOnpzM%3AAPA91bHnJ6n9w5GtsKdAm2eWC-vrOUOtAjN_IhFhcTM4bCR87Y98kJELcqo_TmeWjDoAok-UaQgt8qsgssrsB_tFKyqmdBbgpAKGV4-t4wz1xKzRUU-dOazUdLdXQNGbX9JS-jnA8SIA
     */
    public function create_item( $request ) {
        $is_exist = get_page_by_title($request->get_param('device'), OBJECT, 'post');
        if( is_null($is_exist)) {
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
        } else {
            return new WP_REST_Response( ['Token existed'] , 200 );
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