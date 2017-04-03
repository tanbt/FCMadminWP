<?php

/**
 * Created by PhpStorm.
 * User: tan
 * Date: 4/3/2017
 * Time: 11:02 AM
 */
class FCMNotificationSender
{
    private static $fcm_url = 'https://fcm.googleapis.com/fcm/send';
    private static $server_key = 'AAAAIcoqHrU:APA91bE4_MtSSIumla-YFoXVAwO7dBdzZUmuZLO_4Bax2yEqPII6VA5z7FnriV9WNP9-RB7vx8ooc9LASRdjPkCpstLrHUaAPMP8vtEoCAtFBDWZoXTxN2WRguw0fIPzJFX5KUV4Rhby';      //find it in Firebase Console

    public static function sendToDevicesInCategories($ID, $post) {
        $data = [
            "title" => $post->post_title,
            "message" => substr($post->post_content, 0, 150),
            "link" => get_permalink( $ID ),
        ];
        $tokens = 'e8RpR5_i2ys:APA91bEc1tvXrjPrHYJ5iA9HTcyCR7BtJwteNHlHUyxqSkne3YxFPCQql7-8C_b6DQ5-VHHAN7jw9kiXwMvLEigLBjVR3NlqiiOluKeGY_COBf4WRe_0t-YY5wkYQJ1qk6OdFABR7BxY';
        self::sendToMultipleDevices($tokens, $data);
    }

    public static function sendToMultipleDevices($tokens, $data) {
        if (empty($data['title'])) {
            throw new Exception("Your data array must include 'title'");
        } else if(empty($data['message'])) {
            throw new Exception("Your data array must include 'message'");
        } else if(empty($data['link'])) {
            throw new Exception("Your data array must include 'link'");
        }
        $message = [
            'to'    => $tokens,
            'data' => $data
        ];
        return self::pushNotification($message);
    }

    /**
     * @param array $message
     * @return mixed
     */
    public static function pushNotification($message) {
        $headers = array(
            'Authorization: key=' . self::$server_key,
            'Content-Type: application/json'
        );

        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, self::$fcm_url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
        return $result;
    }

}