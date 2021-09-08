<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../vendor/autoload.php';

use App\Components\Mysql\MysqlConnectionSingle;

function main()
{
    header('Content-type: application/json');
    $_POST = json_decode(file_get_contents("php://input"), true);
    validate_request();
    $founded_posts = get_posts_with_contained_commentary($_POST['post-comment-contain-text']);
        exit(json_encode(['posts' => $founded_posts]));
}

function validate_request()
{
    $MIN_COMMENT_CONTAINED_TEXT_LENGHT = 3;
    $comment_contained_text = $_POST['post-comment-contain-text'];
    if (!isset($comment_contained_text)) {
        exit(json_encode(['message' => "Не передана строка поиска"]));
    }

    if (strlen($comment_contained_text) < $MIN_COMMENT_CONTAINED_TEXT_LENGHT) {
        exit(json_encode(['message' => "Поддерживается поиск не меньше $MIN_COMMENT_CONTAINED_TEXT_LENGHT символов"]));
    }
}

function get_posts_with_contained_commentary($commentary_part)
{
    $mysql_cursor = MysqlConnectionSingle::getInstance();

    $prepared_query_find_posts = $mysql_cursor->prepare("SELECT p.postId, p.title AS postTitle, c.body as commentBody FROM Comments c INNER JOIN Posts p on c.postId = p.postId WHERE c.body LIKE ?");
    $commentary_search_template = '%' . $commentary_part . '%';
    $prepared_query_find_posts->bind_param('s', $commentary_search_template);
    $prepared_query_find_posts->execute();

    $query_find_post_result = $prepared_query_find_posts->get_result();
    if (!$query_find_post_result) {
        exit(json_encode(['message' => "Ошибка при поиске комментария"]));
    }

    $founded_posts_with_comments = [];
    while ($row = $query_find_post_result->fetch_assoc()) {
        $current_row_post_id = $row['postId'];
        if(isset($founded_posts_with_comments[$row['postId']])) {
            $founded_posts_with_comments[$row['postId']]['comments'][] = $row['commentBody'];
        } else {
            $post = ['postId' => $row['postId'], 'comments' => [$row['commentBody']], 'postTitle' => $row['postTitle']];
            $founded_posts_with_comments[$row['postId']] = $post;
        }
    }
    $mysql_cursor->close();
    return $founded_posts_with_comments;

}


main();