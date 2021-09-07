<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '../../');
$dotenv->load();

mysqli_report(MYSQLI_REPORT_ALL);

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

$mysql_cursor = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME'], $_ENV['DB_PORT']);
if ($mysql_cursor->connect_error) {
    die("Connection failed: " . $mysql_cursor->connect_error);
}

$prepared_query_insert_post = $mysql_cursor->prepare("INSERT INTO Posts(postId, userId, title, body) VALUES (?, ?, ?, ?)");
$posts = get_json_from_url($_ENV['POSTS_URL']);
foreach ($posts as $post) {
    $prepared_query_insert_post->bind_param('iiss', $post->id, $post->userId, $post->title, $post->body);
    $prepared_query_insert_post->execute();
}

$mysql_cursor->close();


