<?php
return [
    'page' => [
        'title' => '텍스트 비교',
        'description' => '두 텍스트의 차이점을 비교하고 분석합니다.'
    ],
    'input' => [
        'text1_label' => '첫 번째 텍스트',
        'text2_label' => '두 번째 텍스트',
        'text1_placeholder' => '여기에 첫 번째 텍스트를 입력하세요...',
        'text2_placeholder' => '여기에 두 번째 텍스트를 입력하세요...'
    ],
    'buttons' => [
        'compare' => '비교하기',
        'clear' => '지우기',
        'copy_result' => '결과 복사',
        'swap' => '텍스트 위치 바꾸기'
    ],
    'results' => [
        'title' => '비교 결과',
        'differences_found' => '차이점 발견: {count}개',
        'no_differences' => '차이점이 없습니다.',
        'identical_texts' => '두 텍스트가 동일합니다.',
        'added' => '추가됨',
        'removed' => '삭제됨',
        'modified' => '수정됨'
    ],
    'options' => [
        'title' => '비교 옵션',
        'ignore_case' => '대소문자 무시',
        'ignore_whitespace' => '공백 무시',
        'ignore_punctuation' => '문장부호 무시'
    ],
    'help' => [
        'title' => '도움말',
        'description' => '이 도구 사용법',
        'steps' => [
            '1' => '1. 비교할 두 텍스트를 각각의 입력창에 붙여넣거나 입력하세요.',
            '2' => '2. 필요한 비교 옵션을 선택하세요.',
            '3' => '3. "비교하기" 버튼을 클릭하세요.',
            '4' => '4. 차이점이 하이라이트된 결과를 확인하세요.'
        ]
    ],
    'errors' => [
        'empty_input' => '비교할 텍스트를 모두 입력해주세요.',
        'same_text' => '동일한 텍스트를 입력했습니다.',
        'too_long' => '텍스트가 너무 깁니다. (최대 100,000자)'
    ]
]; 