<?php


$API_URL = 'https://api.line.me/v2/bot/message';
$ACCESS_TOKEN = '7eViULw01UvGcdLJ/rNE6RE9n9So2moevxRDEDkAjCiZYouAu0V7jjMcOhLmLmrFLbO3rCds4L/JDUyytULe3Q03cBT3prX9aThPwX0b7KbK2NOCAre56eX2OcH+NtivsxC9d2OZTrxAkpFGrhQDGgdB04t89/1O/w1cDnyilFU='; 
$channelSecret = 'fc615e7b5ecf3312782ba23e2453d739';

$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array


if ( sizeof($request_array['events']) > 0 ) {

    foreach ($request_array['events'] as $event) {

        $reply_message = '';
        $reply_token = $event['replyToken'];

        // $text = $event['message']['text'];
        $messages = array(
		  "type" => "sticker",
		  "packageId" => "789",
		  "stickerId" => "10855"
		);
        $data = [
            'replyToken' => $reply_token,
            // 'messages' => [['type' => 'text', 'text' => json_encode($request_array) ]]  Debug Detail message
            'messages' => json_encode($messages)
        ];
        $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);

        $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);

        echo "Result: ".$send_result."\r\n";
    }
}

echo "OK";




function send_reply_message($url, $post_header, $post_body)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

?>
