<?php

    // Required if your environment does not handle autoloading
    require __DIR__ . '/vendor/autoload.php';

    // Use the REST API Client to make requests to the Twilio REST API
    use Twilio\Rest\Client;
    
    // Your Account SID and Auth Token from twilio.com/console
    $sid = '';
    $token = '';
    $client = new Client($sid, $token);
    $phoneList=array();
    $res=array();
    $contents = $_POST['contents'];
    $phoneList = file($_FILES['phoneNumberList']['tmp_name']);
    str_replace(" ", "", $contents);
    if(empty($contents)) {
        echo "Message content is empty. Messages not sent to any number.";
    }else if(empty($phoneList)){
        echo "Phone list is empty. Messages not sent to any number.";
    }else{
        $contents = array_map("trim", $_POST);
        $contents = preg_replace('/\s+/', ' ', $_POST);
        for($i=1;$i<sizeof($phoneList);$i++){
            $res[] = explode(",",$phoneList[$i]);}
            }
        for($j=0;$j< sizeof($res);$j++){
            sendTextMessage($res[$j][1], $contents);
        }
        
    
    function sendTextMessage($phoneNumber, $messageContent) {
        global $client;
        $client->messages->create(
            // the number you'd like to send the message to
            '+1'.$phoneNumber,
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => '',
                // the body of the text message you'd like to send
                'body' => $messageContent
//                'mediaUrl' => "https://c1.staticflickr.com/3/2899/14341091933_1e92e62d12_b.jpg"
            )
        );
        echo "Message has sent to customer.",'<br>';
        echo "Phone Number : ".$phoneNumber.'<br>';
        echo "Message content : ";
        print_r($messageContent);
        echo '<br>';
        echo "------------------------------------".'<br>';
    }
