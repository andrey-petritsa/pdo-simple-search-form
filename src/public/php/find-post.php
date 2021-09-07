<?php
$_POST = json_decode(file_get_contents("php://input"), true);
$comment_contained_text = $_POST['post-comment-contain-text'];