<?php
return [
    'hero' => [
        'title' => '유틸리티 모음',
        'description' => '개발자와 디자이너를 위한 유용한 도구들을 모아놓은 사이트입니다.'
    ],
    'search' => [
        'placeholder' => '도구 검색...',
        'label' => '도구 검색'
    ],
    'sections' => [
        'popular_tools' => '인기 도구',
        'favorites' => '즐겨찾기한 도구',
        'key_features' => '주요 특징'
    ],
    'common' => [
        'use_tool' => '사용하기',
        'popular' => '인기'
    ],
    'features' => [
        'fast_processing' => [
            'title' => '빠른 처리',
            'description' => '모든 도구는 최적화되어 있어 빠른 응답 시간을 제공합니다.'
        ],
        'secure_processing' => [
            'title' => '안전한 처리',
            'description' => '모든 입력은 안전하게 처리되며, XSS 공격으로부터 보호됩니다.'
        ],
        'responsive_design' => [
            'title' => '반응형 디자인',
            'description' => '모든 디바이스에서 최적화된 사용자 경험을 제공합니다.'
        ]
    ],
    'menu' => [
        'home' => '홈',
        'calculator' => '계산기',
        'encoder_decoder' => '인코더/디코더',
        'converters' => '변환기',
        'unit_converter' => '단위 변환기',
        'security_tools' => '보안 도구',
        'dev_tools' => '개발자 도구',
        'design_tools' => '디자인 도구',
        'text_tools' => '텍스트 도구',
        
        // 인코더/디코더 서브메뉴
        'url_encoder' => 'URL 인코더/디코더',
        'jwt_decoder' => 'JWT 디코더',
        'base64_converter' => 'Base64 변환기',
        'hash_generator' => '해시 생성기',
        
        // 변환기 서브메뉴
        'hex_image' => 'HEX 이미지 변환기',
        'curl_converter' => 'CURL 변환기',
        'qr_generator' => 'QR 코드 생성기',
        'timestamp_converter' => '타임스탬프 변환기',
        'markdown_converter' => 'Markdown 변환기',
        
        // 단위 변환기 서브메뉴
        'length' => '길이 변환',
        'weight' => '무게 변환',
        'temperature' => '온도 변환',
        'area' => '면적 변환',
        
        // 보안 도구 서브메뉴
        'tls_checker' => 'TLS 버전 체크',
        'ip_info' => 'IP 정보 확인',
        'cidr_calculator' => 'CIDR 계산기',
        'firewall_check' => '방화벽 체크',
        
        // 개발자 도구 서브메뉴
        'json_formatter' => 'JSON 포맷터/뷰어',
        'xml_validator' => 'XML 검증기',
        'cron_examples' => 'Cron 예제',
        'regex_examples' => '정규식 예제',
        
        // 디자인 도구 서브메뉴
        'rgb_picker' => 'RGB 코드 피커',
        'color_palette' => '색상 팔레트 생성기',
        
        // 텍스트 도구 서브메뉴
        'text_compare' => '텍스트 비교',
        'char_counter' => '문자 수 세기',
        'html_entities' => 'HTML 특수문자 변환기'
    ],
    'tools' => [
        'calculator' => [
            'title' => '공학용 계산기',
            'description' => '기본적인 수학 연산부터 공학 계산까지 가능한 계산기입니다.'
        ],
        'url_encoder' => [
            'title' => 'URL 인코더/디코더',
            'description' => 'URL을 인코딩하거나 디코딩할 수 있습니다.'
        ],
        'jwt_decoder' => [
            'title' => 'JWT 디코더',
            'description' => 'JWT 토큰을 디코딩하여 내용을 확인할 수 있습니다.'
        ],
        'base64' => [
            'title' => 'Base64 인코더/디코더',
            'description' => '텍스트를 Base64로 인코딩하거나 디코딩할 수 있습니다.'
        ],
        'hex_image' => [
            'title' => 'HEX 이미지 변환기',
            'description' => '이미지를 HEX 코드로 변환하거나 HEX 코드를 이미지로 변환할 수 있습니다.'
        ],
        'curl_converter' => [
            'title' => 'CURL 변환기',
            'description' => 'CURL 명령어를 다양한 프로그래밍 언어 코드로 변환할 수 있습니다.'
        ],
        'qr_generator' => [
            'title' => 'QR 코드 생성기',
            'description' => '텍스트나 URL을 QR 코드로 변환할 수 있습니다.'
        ],
        'timestamp' => [
            'title' => '타임스탬프 변환기',
            'description' => '타임스탬프와 날짜를 서로 변환할 수 있습니다.'
        ],
        'markdown' => [
            'title' => 'Markdown 뷰어/변환기',
            'description' => 'Markdown 문법으로 작성된 텍스트를 HTML로 변환하여 미리보기할 수 있습니다.'
        ],
        'unit_converter' => [
            'title' => '단위 변환기',
            'description' => '길이, 무게, 온도, 면적 등 다양한 단위를 변환할 수 있습니다.'
        ],
        'tls_checker' => [
            'title' => 'TLS 버전 체크',
            'description' => '웹사이트의 TLS/SSL 버전과 인증서 정보를 확인할 수 있습니다.'
        ],
        'ip_info' => [
            'title' => 'IP 정보 확인',
            'description' => 'IP 주소의 위치, ISP, 국가 등 상세 정보를 확인할 수 있습니다.'
        ],
        'cidr' => [
            'title' => 'IP 주소 대역 계산기',
            'description' => 'CIDR 표기법으로 IP 주소 범위를 계산할 수 있습니다.'
        ],
        'firewall' => [
            'title' => '방화벽 체크',
            'description' => '특정 포트가 방화벽에 의해 차단되었는지 확인할 수 있습니다.'
        ],
        'json_formatter' => [
            'title' => 'JSON 포맷터/뷰어',
            'description' => 'JSON 데이터를 보기 좋게 정렬하고 문법을 검증할 수 있습니다.'
        ],
        'xml_validator' => [
            'title' => 'XML 검증기',
            'description' => 'XML 문서의 유효성을 검사하고 보기 좋게 정렬할 수 있습니다.'
        ],
        'cron' => [
            'title' => 'Cron 표현식 생성기',
            'description' => 'Cron 표현식을 쉽게 생성하고 테스트할 수 있습니다.'
        ],
        'regex' => [
            'title' => '정규식 테스터',
            'description' => '정규식을 테스트하고 결과를 실시간으로 확인할 수 있습니다.'
        ],
        'rgb_picker' => [
            'title' => 'RGB 코드 피커',
            'description' => '색상을 선택하여 RGB, HEX 코드를 확인할 수 있습니다.'
        ],
        'color_palette' => [
            'title' => '웹 색상 팔레트 생성기',
            'description' => '웹사이트에 어울리는 색상 조합을 추천받을 수 있습니다.'
        ],
        'text_compare' => [
            'title' => '텍스트 비교',
            'description' => '두 텍스트의 차이점을 비교할 수 있습니다.'
        ],
        'char_counter' => [
            'title' => '문자 수 세기',
            'description' => '텍스트의 글자 수, 단어 수, 줄 수를 계산할 수 있습니다.'
        ],
        'html_entities' => [
            'title' => 'HTML 특수문자 변환기',
            'description' => 'HTML 특수문자와 일반 텍스트를 서로 변환할 수 있습니다.'
        ],
        'hash_generator' => [
            'title' => '해시 생성기',
            'description' => '문자열의 MD5, SHA-1, SHA-256 등 다양한 해시값을 생성할 수 있습니다.'
        ],
        'weight' => [
            'title' => '무게 변환기',
            'description' => '밀리그램, 그램, 킬로그램, 톤, 온스, 파운드 등 다양한 무게 단위를 변환합니다.'
        ],
        'temperature' => [
            'title' => '온도 변환기',
            'description' => '섭씨, 화씨, 켈빈 등 다양한 온도 단위를 변환합니다.'
        ],
        'area' => [
            'title' => '면적 변환기',
            'description' => '제곱미터, 평, 에이커, 헥타르 등 다양한 면적 단위를 변환합니다.'
        ]
    ]
]; 