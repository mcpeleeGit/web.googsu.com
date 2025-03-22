<?php
// 쿠키 만료 시간 설정 (30일)
$cookie_expire = time() + (86400 * 30);

// 기본 언어 설정 (한국어)
if (!isset($_COOKIE['lang'])) {
    setcookie('lang', 'ko', $cookie_expire, '/');
    $current_lang = 'ko';
} else {
    $current_lang = $_COOKIE['lang'];
}

// 언어 변경 처리
if (isset($_GET['lang']) && ($_GET['lang'] == 'en' || $_GET['lang'] == 'ko')) {
    $current_lang = $_GET['lang'];
    setcookie('lang', $current_lang, $cookie_expire, '/');
    
    // 이전 페이지로 리다이렉트 (lang 파라미터 제거)
    $redirect = $_SERVER['HTTP_REFERER'] ?? '/';
    $redirect = preg_replace('/([?&])lang=[^&]+(&|$)/', '$1', $redirect);
    $redirect = rtrim($redirect, '?&');
    header('Location: ' . $redirect);
    exit;
}

/**
 * 현재 언어 설정을 가져오는 함수
 * @return string 현재 설정된 언어 코드 (ko 또는 en)
 */
function getCurrentLang() {
    // 세션에서 언어 설정 확인
    if (isset($_SESSION['lang'])) {
        return $_SESSION['lang'];
    }
    
    // 쿠키에서 언어 설정 확인
    if (isset($_COOKIE['lang'])) {
        return $_COOKIE['lang'];
    }
    
    // 브라우저 언어 설정 확인
    $browser_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'ko', 0, 2);
    if ($browser_lang === 'en') {
        return 'en';
    }
    
    // 기본값으로 한국어 반환
    return 'ko';
}

/**
 * 언어 설정을 변경하는 함수
 * @param string $lang 언어 코드 (ko 또는 en)
 */
function setLang($lang) {
    $allowed_langs = ['ko', 'en'];
    $lang = in_array($lang, $allowed_langs) ? $lang : 'ko';
    
    $_SESSION['lang'] = $lang;
    setcookie('lang', $lang, time() + (86400 * 30), '/'); // 30일간 유지
}

/**
 * 번역된 문자열을 가져오는 함수
 * @param string $key 번역 키
 * @return string 번역된 문자열
 */
function __($key) {
    global $current_lang, $current_page;
    static $translations = [];
    static $page_translations = [];
    
    // 기본 언어 파일 로드
    if (empty($translations)) {
        $translations = require __DIR__ . '/../lang/' . $current_lang . '.php';
    }
    
    // 현재 페이지의 언어 파일 로드
    if (empty($page_translations) && $current_page) {
        $page_lang_file = __DIR__ . '/../lang/' . $current_page . '/' . $current_lang . '.php';
        if (file_exists($page_lang_file)) {
            $page_translations = require $page_lang_file;
        }
    }
    
    $keys = explode('.', $key);
    
    // 먼저 페이지별 번역에서 검색
    if (!empty($page_translations)) {
        $value = $page_translations;
        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                break;
            }
            $value = $value[$k];
        }
        if (is_string($value)) {
            return $value;
        }
    }
    
    // 페이지별 번역이 없으면 기본 번역에서 검색
    $value = $translations;
    foreach ($keys as $k) {
        if (!isset($value[$k])) {
            return $key;
        }
        $value = $value[$k];
    }
    
    return $value;
} 