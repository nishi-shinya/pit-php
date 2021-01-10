<?php

if (!isset($_SESSION)) {
    session_start();
}

/**
 * ログインしているかどうかチェック
 * @return bool
 */
function isLogin (): bool {
    return isset($_SESSION['user']);
}

/**
 * ログインしているユーザーの名前を返す。
 * @return string
 */
function getLoginUserName (): string {
    if ($_SESSION['user']) {
        $name = $_SESSION['user']['name'];

        if (mb_strlen($name) < 7) {
            $name = mb_substr($name,0, 7) . '...';
        }

        return $name;
    }

    return '';
}

/**
 * ログインしているユーザーのIDを返す。
 * @return mixed|null
 */
function getLoginUserId () {
    if ($_SESSION['user']) {
        return $_SESSION['user']['id'];
    }
    return null;
}
