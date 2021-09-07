<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Components\Mysql\MysqlConnectionSingle;

mysqli_report(MYSQLI_REPORT_ALL);
$mysql_cursor = MysqlConnectionSingle::getInstance();

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

$total_posts_inserted = 0;
$prepared_query_insert_post = $mysql_cursor->prepare("INSERT IGNORE INTO Posts(postId, userId, title, body) VALUES (?, ?, ?, ?)");
$posts = get_json_from_url($POSTS_URL);
foreach ($posts as $post) {
    $prepared_query_insert_post->bind_param('iiss', $post->id, $post->userId, $post->title, $post->body);
    $prepared_query_insert_post->execute();
    $total_posts_inserted += $mysql_cursor->affected_rows;
}

$total_comments_inserted = 0;
$prepared_query_insert_comments = $mysql_cursor->prepare("INSERT IGNORE INTO Comments(commentId, postId, name, email, body) VALUES (?, ?, ?, ?, ?)");
$comments = get_json_from_url($COMMENTS_URL);
foreach ($comments as $comment) {
    $prepared_query_insert_comments->bind_param('iisss', $comment->id, $comment->postId, $comment->name, $comment->email, $comment->body);
    $prepared_query_insert_comments->execute();
    $total_comments_inserted += $mysql_cursor->affected_rows;
}

echo "Загружено $total_posts_inserted записей и Y $total_comments_inserted комментариев";

$mysql_cursor->close();


