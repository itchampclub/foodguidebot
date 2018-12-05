<?php
require_once('./LINEBotTiny.php');
$channelAccessToken = 'WsEg0h0hvWL6AH/5vRTp/VoKgHexRMQ+FOgbI9xrJ19q07jk59Z4X9p6laKD7BR6s8F8E3rZ0pvht4n4NOAtNkA726d4quuAYJW/P0rqABDermZI5505WTp5ix0BjLn6WVb67TpH/sIl6Bwv7m+yagdB04t89/1O/w1cDnyilFU=';
$channelSecret = '88556d8dd777dea8d4508b361332a939';
date_default_timezone_set('Asia/Jakarta');
// Get message from Line API
$content = file_get_contents('php://input');
$events = json_decode($content, true);
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
    
        // Line API send a lot of event type, we interested in message only.
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
            // Get replyToken
            $replyToken = $event['replyToken'];
            switch($event['message']['text']) {
                
                case 'tel':
                    $respMessage = '089-5124512';
                    break;
                case 'address':
                    $respMessage = '99/451 Muang Nonthaburi';
                    break;
                case 'boss':
                    $respMessage = '089-2541545';
                    break;
                case 'idcard':
                    $respMessage = '5845122451245';
                    break;
                default:
                    break;
            }
            $httpClient = new CurlHTTPClient($channel_token);
            $bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret));
            $textMessageBuilder = new TextMessageBuilder($respMessage);
            $response = $bot->replyMessage($replyToken, $textMessageBuilder);
		}
	}
}
echo "OK";
            


