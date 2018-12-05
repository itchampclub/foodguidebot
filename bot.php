<?php
require_once('./LINEBotTiny.php');
$channelAccessToken = 'WsEg0h0hvWL6AH/5vRTp/VoKgHexRMQ+FOgbI9xrJ19q07jk59Z4X9p6laKD7BR6s8F8E3rZ0pvht4n4NOAtNkA726d4quuAYJW/P0rqABDermZI5505WTp5ix0BjLn6WVb67TpH/sIl6Bwv7m+yagdB04t89/1O/w1cDnyilFU=';
$channelSecret = '88556d8dd777dea8d4508b361332a939';
date_default_timezone_set('Asia/Jakarta');
$client = new LINEBotTiny($channelAccessToken, $channelSecret);
foreach ($client->parseEvents() as $event) {
    switch ($event['type']) {
        case 'message':
            $message = $event['message'];
            
            
            $json = file_get_contents('https://spreadsheets.google.com/feeds/list/1tQCaj3LUVwH0tBuPrfBY2dOJuF-qzpYEdOqGdNvJRLc/od6/public/values?alt=json');
            $data = json_decode($json, true);
            $result = array();
            foreach ($data['feed']['entry'] as $item) {
                $keywords = explode(',', $item['gsx$keyword']['$t']);
                foreach ($keywords as $keyword) {
                    if (mb_strpos($message['text'], $keyword) !== false) {
                        $candidate = array(
                            'thumbnailImageUrl' => $item['gsx$photourl']['$t'],
                            'title' => $item['gsx$title']['$t'],
                            'text' => $item['gsx$title']['$t'],
                            'actions' => array(
                                array(
                                    'type' => 'uri',
                                    'label' => '8888888888888888888',
                                    'uri' => $item['gsx$url']['$t'],
                                    ),
                                ),
                            );
                        array_push($result, $candidate);
                    }
                }
            }
            

            switch ($message['type']) {
                case 'text':
                    $client->replyMessage([
                        'replyToken' => $event['replyToken'],
                        'messages' => [
                            [
                                'type' => 'text',
                                'text' => $message['text']
                            ],
                            [
                                'type' => 'template',
                                'altText' => '66666666666666',
                                'template' => [
                                    'type' => 'carousel',
                                    'columns' => $result,
                                    ]
                            ]
                            ]
                    ]);
                    break;
                default:
                    error_log('Unsupported message type: ' . $message['type']);
                    break;
            }
            break;
        default:
            error_log('Unsupported event type: ' . $event['type']);
            break;
    }
};
            
            
            
           
