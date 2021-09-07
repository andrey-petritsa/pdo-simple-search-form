<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../vendor/autoload.php';

use App\Components\Mysql\MysqlConnectionSingle;

header('Content-type: application/json');
$MIN_COMMENT_CONTAINED_TEXT_LENGHT = 3;
$_POST = json_decode(file_get_contents("php://input"), true);
$comment_contained_text = $_POST['post-comment-contain-text'];

if (strlen($comment_contained_text) < $MIN_COMMENT_CONTAINED_TEXT_LENGHT) {
    echo json_encode(['message' => "Поддерживается поиск не меньше $MIN_COMMENT_CONTAINED_TEXT_LENGHT символов"]);
    return;
}

$mysql_cursor = MysqlConnectionSingle::getInstance();
