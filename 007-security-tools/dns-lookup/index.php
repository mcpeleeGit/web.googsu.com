<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>DNS Lookup - Googsu Tools</title>
    <meta name="description" content="도메인의 DNS 정보를 조회하는 도구입니다. IP 주소, MX 레코드, NS 레코드 등 다양한 DNS 정보를 확인하세요.">
    <meta property="og:title" content="DNS Lookup - Googsu Tools">
    <meta property="og:description" content="도메인의 DNS 정보를 조회하는 도구입니다. IP 주소, MX 레코드, NS 레코드 등 다양한 DNS 정보를 확인하세요.">
    <meta property="og:url" content="https://googsu.com/dns-lookup">
    <meta property="og:image" content="https://googsu.com/images/dns-lookup-og-image.png">
    <style>
        .tls-check-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px;
        }
        .search-form {
            margin: 20px 0;
            padding: 20px;
            background: #f5f5f5;
            border-radius: 5px;
        }
        .search-form input[type="text"] {
            width: 70%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .search-form button {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .search-form button:hover {
            background: #0056b3;
        }
        .result-section {
            margin-top: 20px;
        }
        .dns-record {
            margin: 10px 0;
            padding: 15px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .dns-record h3 {
            margin-top: 0;
            color: #333;
        }
        .error {
            color: #dc3545;
            padding: 10px;
            background: #f8d7da;
            border-radius: 4px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include '../../common/menu.php'; ?>
        
        <div class="content-area">
            <div class="tls-check-container">
                        
                <h1>DNS Lookup</h1>
                <p>도메인의 DNS 정보를 조회합니다. IP 주소, MX 레코드, NS 레코드 등 다양한 DNS 정보를 확인할 수 있습니다.</p>

                <div class="search-form">
                    <form method="GET" action="">
                        <input type="text" name="domain" placeholder="도메인을 입력하세요 (예: example.com)" 
                            value="<?php echo isset($_GET['domain']) ? htmlspecialchars($_GET['domain']) : ''; ?>">
                        <button type="submit">조회</button>
                    </form>
                </div>

                <?php
                if (isset($_GET['domain']) && !empty($_GET['domain'])) {
                    $domain = trim($_GET['domain']);
                    
                    // 도메인 형식 검증
                    if (!preg_match('/^(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}$/', $domain)) {
                        echo '<div class="error">올바른 도메인 형식이 아닙니다.</div>';
                    } else {
                        // A 레코드 조회
                        $a_records = dns_get_record($domain, DNS_A);
                        if ($a_records) {
                            echo '<div class="result-section">';
                            echo '<h2>A 레코드</h2>';
                            foreach ($a_records as $record) {
                                echo '<div class="dns-record">';
                                echo '<h3>IP 주소</h3>';
                                echo '<p>' . htmlspecialchars($record['ip']) . '</p>';
                                echo '</div>';
                            }
                            echo '</div>';
                        }

                        // MX 레코드 조회
                        $mx_records = dns_get_record($domain, DNS_MX);
                        if ($mx_records) {
                            echo '<div class="result-section">';
                            echo '<h2>MX 레코드</h2>';
                            foreach ($mx_records as $record) {
                                echo '<div class="dns-record">';
                                echo '<h3>메일 서버</h3>';
                                echo '<p>호스트: ' . htmlspecialchars($record['host']) . '</p>';
                                echo '<p>우선순위: ' . htmlspecialchars($record['pri']) . '</p>';
                                echo '</div>';
                            }
                            echo '</div>';
                        }

                        // NS 레코드 조회
                        $ns_records = dns_get_record($domain, DNS_NS);
                        if ($ns_records) {
                            echo '<div class="result-section">';
                            echo '<h2>NS 레코드</h2>';
                            foreach ($ns_records as $record) {
                                echo '<div class="dns-record">';
                                echo '<h3>네임서버</h3>';
                                echo '<p>' . htmlspecialchars($record['target']) . '</p>';
                                echo '</div>';
                            }
                            echo '</div>';
                        }

                        // TXT 레코드 조회
                        $txt_records = dns_get_record($domain, DNS_TXT);
                        if ($txt_records) {
                            echo '<div class="result-section">';
                            echo '<h2>TXT 레코드</h2>';
                            foreach ($txt_records as $record) {
                                echo '<div class="dns-record">';
                                echo '<h3>TXT 정보</h3>';
                                echo '<p>' . htmlspecialchars($record['txt']) . '</p>';
                                echo '</div>';
                            }
                            echo '</div>';
                        }

                        // 결과가 없는 경우
                        if (!$a_records && !$mx_records && !$ns_records && !$txt_records) {
                            echo '<div class="error">해당 도메인의 DNS 정보를 찾을 수 없습니다.</div>';
                        }
                    }
                }
                ?>
            </div>
        </div>
        <?php include '../../common/footer.php'; ?>
    </div>
</body>
</html>
