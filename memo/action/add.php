<?php

require '../../common/database.php';
require '../../common/auth.php';

if (!isLogin()) {
    header('Location: ../login/');
    exit();
}

$user_id = getLoginUserId();
$database_handler = getDatabaseConnection();


try {
    $title = '新規メモ';
    if ($stmt = $database_handler->prepare('INSERT INTO memos (user_id, title, content) VALUES (:user_id, :title, null)')) {
        $stmt->bindParam('user_id', $user_id);
        $stmt->bindParam('title', $title);
        $stmt->execute();
    };

    $_SESSION['select_memo'] = [
        'id' => $database_handler->lastInsertId(),
        'title' => $title,
        'content' => ''
    ];
} catch (Throwable $e) {
    $e->getMessage();
    exit();
}
header('Location: ../../memo/');
exit();