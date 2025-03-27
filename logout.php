<?php
session_start();

// Facebook 세션 데이터 삭제
unset($_SESSION['fb_access_token']);
unset($_SESSION['fb_user_id']);
unset($_SESSION['fb_user_name']);
unset($_SESSION['fb_user_email']);
unset($_SESSION['fb_user_picture']);

// 세션 종료
session_destroy();

// JSON 응답
header('Content-Type: application/json');
echo json_encode(['success' => true]); 