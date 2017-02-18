<?php
/**
 * index.php
 *
 * @copyright   Copyright (c) 2016 sonicmoov Co.,Ltd.
 * @version     $Id$
 */
/*
use LINE\LINEBot\EchoBot\Dependency;
use LINE\LINEBot\EchoBot\Route;
use LINE\LINEBot\EchoBot\Setting;

require __DIR__ . '/../vendor/autoload.php';

$setting = Setting::getSetting();
$app = new Slim\App($setting);

(new Dependency())->register($app);
(new Route())->register($app);

$app->run();
*/

$json_string = file_get_contents('php://input');
$json_object = json_decode($json_string);

foreach ($json_object->events as $event) {
    if('message' == $event->type){
        api_post_request($event->replyToken, $event->message->text);
    }else if('beacon' == $event->type){
        api_post_request($event->replyToken, 'スプラッシュマウンテンの近くに来たね！');
    }
}

function api_post_request($token, $message) {
    $url = 'https://api.line.me/v2/bot/message/reply';
    $channel_access_token = 'TzygpCcTzSCDAuQqhP4Q5D/wNfweFepCkeIFeCfPCo/8lhH5oovCCYO3dcDwAaQFPofPsEdnEvNPn++0VUTcpxQgX7/kMxiazAWGc4+WIpEAARox2aRLwwm7855PJ6Unwg9I3pqXYbbZD9jnkV67OAdB04t89/1O/w1cDnyilFU=';
    $headers = array(
        'Content-Type: application/json',
        "Authorization: Bearer {$channel_access_token}"
    );
    $post = array(
        'replyToken' => $token,
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $message
            )
        )
    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_exec($curl);
}
