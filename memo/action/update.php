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
    $edit_title = $_POST['edit_title'];
    $edit_content = $_POST['edit_content'];

    try {
        if ($stmt = $database_handler->prepare('UPDATE memos SET title = :edit_title, content = :edit_content, updated_at = NOW() WHERE id = :edit_id AND user_id = :user_id')) {
            $stmt->bindParam('edit_title', $edit_title);
            $stmt->bindParam('edit_content', $edit_content);
            $stmt->bindParam('edit_id', $edit_id);
            $stmt->bindParam('user_id', $user_id);
            $stmt->execute();
        }

        if ($stmt = $database_handler->prepare('SELECT id, title, content FROM memos WHERE id = :edit_id AND user_id = :user_id')) {
            $stmt->bindParam('edit_id', $edit_id);
            $stmt->bindParam('user_id', $user_id);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['select_memo'] = [
                'id' => $result['id'],
                'title' => $result['title'],
                'content' => $result['content']
            ];
        }
    } catch (Throwable $e) {
        $e->getMessage();
        exit();
    }

    header('Location: ../../memo');
    exit();

