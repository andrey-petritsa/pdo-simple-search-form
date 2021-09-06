<?php
$POSTS_URL = 'https://jsonplaceholder.typicode.com/posts';
$COMMENTS_URL = 'https://jsonplaceholder.typicode.com/comments';

function get_json_from_url($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $page = curl_exec($ch);
    curl_close($ch);
    return json_decode($page);
}



