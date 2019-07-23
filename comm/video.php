<?php 

// https://www.googleapis.com/youtube/v3/videos?part=snippet&id=DkxGGcqAPqg&key=AIzaSyBfzOGEq8xYn7lnKYCNbXBj11NweDiZKj8

if($text[1] == null){
	send_message($peer_id, "Укажите ссылку на видео");
} elseif (strpos($text[1], 'https://www.youtube.com/watch?v=') !== false) {
	$a = substr_replace($text[1], null, 0, 32);

	$title = title($a);
	$views = views($a);
	$likes = likes($a);
	$dislike = dislike($a);
	$comment = comment($a);
	$des = des($a);

	send_message($peer_id, "Статистика видео: {$title} \n\nПросмотров: {$views}\nЛайков: {$likes}\nДизлайков: {$dislike}\nКомментариев: {$comment}\n\nОписание: \n{$des}");
}

function title($video_id) {
    $json = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=snippet&id=" . $video_id . "&key=". YOUTUBE_DATA_API_KEY );
    $jsonData = json_decode($json);
    $title = $jsonData->items[0]->snippet->title;
    return $title;
}
function des($video_id) {
    $json = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=snippet&id=" . $video_id . "&key=". YOUTUBE_DATA_API_KEY );
    $jsonData = json_decode($json);
    $des = $jsonData->items[0]->snippet->localized->description;
    return $des;
}
function views($video_id) {
    $json = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=statistics&id=" . $video_id . "&key=". YOUTUBE_DATA_API_KEY );
    $jsonData = json_decode($json);
    $views = $jsonData->items[0]->statistics->viewCount;
    return $views;
}
function likes($video_id) {
    $json = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=statistics&id=" . $video_id . "&key=". YOUTUBE_DATA_API_KEY );
    $jsonData = json_decode($json);
    $likes = $jsonData->items[0]->statistics->likeCount;
    return $likes;
}
function dislike($video_id) {
    $json = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=statistics&id=" . $video_id . "&key=". YOUTUBE_DATA_API_KEY );
    $jsonData = json_decode($json);
    $dislike = $jsonData->items[0]->statistics->dislikeCount;
    return $dislike;
}
function comment($video_id) {
    $json = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=statistics&id=" . $video_id . "&key=". YOUTUBE_DATA_API_KEY );
    $jsonData = json_decode($json);
    $comment = $jsonData->items[0]->statistics->commentCount;
    return $comment;
}