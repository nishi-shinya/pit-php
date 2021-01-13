<?php
    require '../../common/auth.php';
    require '../../common/database.php';

    if (!isLogin()) {
        header('Location: ../login/');
        exit();
    }

    $user_id = getLoginUserId();
    $database_handler = getDatabaseConnection();

    $edit_id = $_POST['edit_id'];

    try {
        if ($stmt = $database_handler->prepare('DELETE FROM memos WHERE id = :edit_id AND user_id = :user_id')) {
            $stmt->bindParam('edit_id', $edit_id);
            $stmt->bindParam('user_id', $user_id);
            $stmt->execute();
        }

    } catch (Throwable $e) {
        $e->getMessage();
        exit();
    }

    unset($_SESSION['select_memo']);

    header('Location: ../../memo/');
    exit();