<?php
session_start();
require_once 'includes/functions.php';
require_once 'includes/language.php';

// GET 또는 POST로 전달된 lang 파라미터 확인
$lang = $_REQUEST['lang'] ?? 'ko';

// 언어 설정 변경
setLang($lang);

// 이전 페이지로 리다이렉트
$referer = $_SERVER['HTTP_REFERER'] ?? '/';
header('Location: ' . $referer);
exit; 