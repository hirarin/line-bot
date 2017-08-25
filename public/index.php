<?php
/**
 * index.php
 *
 * @copyright   Copyright (c) 2017 Syamusyeeru
 * @version     $Id$
 */

//Json用の準備
$json_string = file_get_contents('php://input');
$json_object = json_decode($json_string);

//受信イベントパラメータ
foreach ($json_object->events as $event) {
  //通常メッセージ
    if('message' == $event->type){


        //スロットの作成
        //キーワード抽出
        if(strrpos($event->getText(),'旅行プラン')==true){
            api_post_request($event->replyToken, 'どのような旅行にいたしましょうか？');//post
        }else if(strrpos($event->getText(),'記念')==true){
            api_post_request($event->replyToken, '');//post
        }
        api_post_request($event->replyToken, '');//post




  //Beaconメッセージ
    }else if('beacon' == $event->type){
        api_post_request($event->replyToken, 'ビーコンイベント');//post

    }
}

//アプリにポストするメソッド（現在テキストメッセージのみ返す仕様）
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
