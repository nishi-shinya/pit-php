<?php
    require '../../common/auth.php';
    require '../../common/database.php';

    if (!isLogin()) {
        header('Location: ../login/');
        exit();
    }

    $id = $_GET['id'];
    $user_id = getLoginUserId();

    $database_handler = getDatabaseConnection();
    if ($stmt = $database_handler->prepare("SELECT id, title, content FROM memos WHERE id = :id AND user_id = :user_id")) {
        $stmt->bindParam('id', $id);
        $stmt->bindParam('user_id', $user_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    $_SESSION['select_memo'] = [
        'id' => $result['id'],
        'title' => $result['title'],
        'content' => $result['content']
    ];
    header('Location: ../../memo/');
    exit();