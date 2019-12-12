<?php
require_once('../../vendor/autoload.php');

$MP = new \danog\MadelineProto\API('session.madeline');
$MP->start();
/*
$lines = file('session.madeline');
$results = print_r($lines, true);
$MP->messages->sendMessage(['peer' => '@Ogneyar_ya', 'message' => $results]);
*/
$me = $MP->get_self();
$MP->logger($me);
$me = print_r($me, true);
$MP->messages->sendMessage(['peer' => '@Ogneyar_ya', 'message' => $me]);

/*
$contact = ['_' => 'inputPhoneContact', 'client_id' => 0, 'phone' => '+79xxxxxxxxx', 'first_name' => '', 'last_name' => ''];
$import = $MP->contacts->importContacts(['contacts' => [$contact]]);
// $import['imported'][0]['user_id'] - ID пользователя
*/

/*
$messages = $MadelineProto->messages->getHistory([

	'peer' => 'hutor_yanin', 
	'offset_id' => 0, 
	'offset_date' => 0, 
	'add_offset' => 0,
	'limit' => 20,
	'max_id' => 9999999, 

	'min_id' => $lastid, 
]);

$messages = $messages['messages'];
foreach(array_reverse($messages) as $i => $message){

        $MadelineProto->messages->sendMessage([
              'peer' => 'test_group_ot',
              'message' => $message['message']
        ]);
}
*/

?>