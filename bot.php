<? 

// MADE by Penjery

define('CALLBACK_API_CONFIRMATION_TOKEN', ''); // Строка, которую должен вернуть сервер 
define('VK_API_ACCESS_TOKEN', ''); // Ключ доступа сообщества 

define('CALLBACK_API_EVENT_CONFIRMATION', 'confirmation'); 
define('CALLBACK_API_EVENT_MESSAGE_NEW', 'message_new');
define('CALLBACK_API_EVENT_JOIN_NEW', 'group_join');
define('CALLBACK_API_EVENT_LEAVE_NEW', 'group_leave');  
define('CALLBACK_API_EVENT_POST_NEW', 'wall_post_new');
define('VK_API_ENDPOINT', 'https://api.vk.com/method/');
define('VK_API_VERSION', '5.82');
define("YOUTUBE_DATA_API_KEY", 'AIzaSyBfzOGEq8xYn7lnKYCNbXBj11NweDiZKj8');



$event = json_decode(file_get_contents('php://input'), true); 

switch ($event['type']) { 
  // Подтверждение сервера 
  case CALLBACK_API_EVENT_CONFIRMATION: 
    echo(CALLBACK_API_CONFIRMATION_TOKEN); 
    break; 

  
  
  case CALLBACK_API_EVENT_MESSAGE_NEW: 
  
    $message = $event['object']; 
    $peer_id = $message['peer_id'] ?: $message['user_id']; 
	$text = explode(" ", $message['text']);
	$text[0] = mb_strtolower($text[0]);
	$user = array_pop(usersGet($message['from_id']));
	$man = "{$user['first_name']}";
	$man1 = "{$user['last_name']}";
	$date = date("d.m.Y  H:i");
	$user_id = $data->object->user_id;
	$chat_id = $peer_id - 2000000000;
	$kick_idd = $text[1];
	$kick_id = explode("|", mb_substr($kick_idd, 3))[0];
	date_default_timezone_set('Europe/Moscow');
	$today = date("H:i:s");


	$keyboard = [
			"one_time" => false,
			"buttons" => [	
			]];
	$keyboard = json_encode($keyboard, JSON_UNESCAPED_UNICODE);
	
		if($text[0] == 'стата'){
			include 'comm/stats.php';
		}
		if($text[0] == 'видео'){
			include 'comm/video.php';
		}

		echo('ok'); 
		header("HTTP/1.1 200 OK");
		break; 
		default: 
			echo('Unsupported event'); 
		break; 

}

function send_message($peer_id, $message, $attach, $keyboard) { 
  api('messages.send', array( 
    'peer_id' => $peer_id, 
    'message' => $message,
	'attachment' => $attach,
	'keyboard' => $keyboard
  )); 
} 


function send_stiker($peer_id,$stiker) { 
  api('messages.send', array( 
    'peer_id' => $peer_id, 
    'sticker_id' => $stiker
  )); 
} 

function getChat($chat_id) {
	return api('messages.getChat', array(
    'peer_id' => $chat_id
  ));
}

function usersGet($user_id, $name_case, $fields) {
  return api('users.get', array(
    'user_id' => $user_id,
    'fields' => $fields,
	'name_case' => $name_case
  ));
}

function chatGet($chat_id) {
  return api('messages.getConversationMembers', array(
    'peer_id' => $chat_id
  ));
}

function userkick($chat_id, $user_id, $member_id) { 
 return api('messages.removeChatUser', array( 
 'chat_id' => $chat_id, 
 'user_id' => $kick_id, 
 'member_id' => $kick_id
 )); 
}

function api($method, $params) { 
  $params['access_token'] = VK_API_ACCESS_TOKEN; 
  $params['v'] = VK_API_VERSION; 
  $query = http_build_query($params); 
  $url = VK_API_ENDPOINT . $method . '?' . $query; 
  $curl = curl_init($url); 
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
  $json = curl_exec($curl); 
  $error = curl_error($curl); 
  if ($error) { 
    error_log($error); 
    throw new Exception("Failed {$method} request"); 
  } 
  curl_close($curl); 
  $response = json_decode($json, true); 
  if (!$response || !isset($response['response'])) { 
    error_log($json); 
    throw new Exception("Invalid response for {$method} request"); 
  } 
  return $response['response']; 
}