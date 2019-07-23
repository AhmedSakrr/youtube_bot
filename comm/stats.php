<?php
			if($text[1] == null){
				send_message($peer_id, "Укажите ссылку на канал");
			} elseif (strpos($text[1], 'https://www.youtube.com/channel/') !== false) {  
				$a = substr_replace($text[1], null, 0, 32);

				$subs = subs($a);
				$title = title($a);
				$video = video($a);
				$views = view($a);
				$des = des($a);

				$subs = number_format($subs, 0, ',', '.');
				$title = number_format($title, 0, ',', '.');
				$video = number_format($video, 0, ',', '.');
				$views = number_format($views, 0, ',', '.');
				$des = number_format($des, 0, ',', '.');

				send_message($peer_id, "Статистика канала: {$title} \n\nПодписчиков: {$subs} \nКоличество роликов: {$video} \nКоличество просмотров: {$views} \n\nОписание: {$des}");
			} elseif (strpos($text[1], 'https://www.youtube.com/user/') !== false) {
				$a = substr_replace($text[1], null, 0, 29);

				$ssubs = ssubs($a);
				$ttitle = ttitle($a);
				$vvideo = vvideo($a);
				$vviews = vview($a);
				$ddes = ddes($a);

				$ssubs = number_format($ssubs, 0, ',', '.');
				$ttitle = number_format($ttitle, 0, ',', '.');
				$vvideo = number_format($vvideo, 0, ',', '.');
				$vviews = number_format($vviews, 0, ',', '.');
				$ddes = number_format($ddes, 0, ',', '.');

				send_message($peer_id, "Статистика канала: {$ttitle} \n\nПодписчиков: {$ssubs} \nКоличество роликов: {$vvideo} \nКоличество просмотров: {$vviews} \n\nОписание: {$ddes}");
			}

function ttitle($video_id) {
    $json = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=snippet&forUsername=" . $video_id . "&key=". YOUTUBE_DATA_API_KEY );
    $jsonData = json_decode($json);
    $views = $jsonData->items[0]->snippet->title;
    return $views;
}
function ddes($video_id) {
    $json = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=snippet&forUsername=" . $video_id . "&key=". YOUTUBE_DATA_API_KEY );
    $jsonData = json_decode($json);
    $des = $jsonData->items[0]->snippet->localized->description;
    return $des;
}
function vview($video_id) {
    $json = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=statistics&forUsername=" . $video_id . "&key=". YOUTUBE_DATA_API_KEY );
    $jsonData = json_decode($json);
    $view = $jsonData->items[0]->statistics->viewCount;
    return $view;
}
function vvideo($video_id) {
    $json = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=statistics&forUsername=" . $video_id . "&key=". YOUTUBE_DATA_API_KEY );
    $jsonData = json_decode($json);
    $video = $jsonData->items[0]->statistics->videoCount;
    return $video;
}
function ssubs($video_id) {
    $json = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=statistics&forUsername=" . $video_id . "&key=". YOUTUBE_DATA_API_KEY );
    $jsonData = json_decode($json);
    $subs = $jsonData->items[0]->statistics->subscriberCount;
    return $subs;
}




function title($video_id) {
    $json = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=snippet&id=" . $video_id . "&key=". YOUTUBE_DATA_API_KEY );
    $jsonData = json_decode($json);
    $views = $jsonData->items[0]->snippet->title;
    return $views;
}
function des($video_id) {
    $json = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=snippet&id=" . $video_id . "&key=". YOUTUBE_DATA_API_KEY );
    $jsonData = json_decode($json);
    $des = $jsonData->items[0]->snippet->localized->description;
    return $des;
}
function view($video_id) {
    $json = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=statistics&id=" . $video_id . "&key=". YOUTUBE_DATA_API_KEY );
    $jsonData = json_decode($json);
    $view = $jsonData->items[0]->statistics->viewCount;
    return $view;
}
function video($video_id) {
    $json = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=statistics&id=" . $video_id . "&key=". YOUTUBE_DATA_API_KEY );
    $jsonData = json_decode($json);
    $video = $jsonData->items[0]->statistics->videoCount;
    return $video;
}
function subs($video_id) {
    $json = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=statistics&id=" . $video_id . "&key=". YOUTUBE_DATA_API_KEY );
    $jsonData = json_decode($json);
    $subs = $jsonData->items[0]->statistics->subscriberCount;
    return $subs;
}