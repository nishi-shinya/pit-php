<?php

/**
 * 空文字チェック
 * @param $error
 * @param $check_value
 * @param $message
 */
function emptyCheck (&$error, $check_value, $message) {
    if (empty(trim($check_value))) {
        array_push($error, $message);
    }
}

/**
 * 最小文字数チェック
 * @param $errors
 * @param $check_value
 * @param $message
 * @param int $min_size
 */
function stringMinSizeCheck(&$error, $check_value, $message, $min_size = 8) {
    if (mb_strlen($check_value) < $min_size) {
        array_push($error, $message);
    }
}

/**
 * 最大文字数チェック
 * @param $errors
 * @param $check_value
 * @param $message
 * @param int $max_size
 */
function stringMaxSizeCheck(&$error, $check_value, $message, $max_size = 255) {
    if (mb_strlen($check_value) > $max_size) {
        array_push($error, $message);
    }
}

/**
 * メールアドレスチェック
 * @param $errors
 * @param $check_value
 * @param $message
 */
function mailAddressCheck(&$errors, $check_value, $message) {
    if (filter_var($check_value, FILTER_VALIDATE_EMAIL) == false) {
        array_push($errors, $message);
    }
}

/**
 * 半角英数字チェック
 * @param $errors
 * @param $check_value
 * @param $message
 */
function halfAlphanumericCheck(&$errors, $check_value, $message) {
    if (preg_match("/^[a-zA-z0-9]+$/", $check_value) == false) {
        array_push($errors, $message);
    }
}

function mailAddressDuplicationCheck(&$errors, $check_value, $message) {
    $database_handler = getDatabaseConnection();
    if ($stmt = $database_handler->prepare('SELECT id FROM users WHERE email = :user_email')) {
        $stmt->bindParam(':user_email', $check_value);
        $stmt->execute();
    }

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        array_push($errors, $message);
    }
}