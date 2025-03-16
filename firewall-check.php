<?php
$page_title = '방화벽 체크';
$additional_css = ['/css/text-compare.css'];
include_once 'includes/header.php';

// 입력값 검증 및 실행 함수
function validateInput($input) {
    // IP 주소나 도메인 형식 검증
    if (filter_var($input, FILTER_VALIDATE_IP) || 
        preg_match('/^(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}$/', $input)) {
        return true;
    }
    return false;
}

function executeTraceroute($target) {
    // 명령어 주입 방지를 위한 이스케이프
    $target = escapeshellarg($target);
    
    // OS에 따른 traceroute 명령어 설정
    $os = strtolower(PHP_OS);
    if (strpos($os, 'win') === 0) {
        $cmd = "tracert -h 30 $target";
    } else {
        $cmd = "traceroute -m 30 $target";
    }
    
    // 명령어 실행
    exec($cmd . " 2>&1", $output, $return_var);
    
    return [
        'output' => $output,
        'status' => $return_var
    ];
}

$result = null;
$error = null;

// POST 요청 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target = trim($_POST['target'] ?? '');
    
    if (empty($target)) {
        $error = "IP 주소 또는 도메인을 입력해주세요.";
    } elseif (!validateInput($target)) {
        $error = "올바른 IP 주소 또는 도메인을 입력해주세요.";
    } else {
        $result = executeTraceroute($target);
    }
}
?>

<div class="container">
    <div class="text-compare-container">
        <h1>방화벽 체크</h1>
        
        <div class="mui-card">
            <div class="mui-card-header">
                <h3>IP/도메인 입력</h3>
            </div>
            <div class="mui-card-content">
                <form method="POST" class="mb-4">
                    <div class="input-group mb-3">
                        <input type="text" 
                               name="target" 
                               class="form-control" 
                               placeholder="IP 주소 또는 도메인 입력 (예: 8.8.8.8 또는 google.com)" 
                               value="<?php echo htmlspecialchars($_POST['target'] ?? ''); ?>"
                               required>
                        <button type="submit" class="mui-button">체크하기</button>
                    </div>
                </form>
            </div>
        </div>

        <?php if ($error): ?>
        <div class="mui-card mt-4">
            <div class="mui-card-content">
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($result): ?>
        <div class="mui-card mt-4">
            <div class="mui-card-header">
                <h3>체크 결과</h3>
            </div>
            <div class="mui-card-content">
                <pre class="traceroute-output"><?php
                foreach ($result['output'] as $line) {
                    echo htmlspecialchars($line) . "\n";
                }
                ?></pre>
            </div>
        </div>
        <?php endif; ?>

        <div class="mui-card mt-4">
            <div class="mui-card-header">
                <h3>도움말</h3>
            </div>
            <div class="mui-card-content">
                <ul class="help-list">
                    <li>입력한 IP 주소 또는 도메인으로의 네트워크 경로를 추적합니다.</li>
                    <li>각 홉(hop)에서의 응답 시간과 경유 서버 정보를 확인할 수 있습니다.</li>
                    <li>타임아웃이나 응답 거부는 해당 구간에 방화벽이 설정되어 있을 수 있음을 의미합니다.</li>
                    <li>일부 서버는 보안상의 이유로 traceroute 요청에 응답하지 않을 수 있습니다.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
.traceroute-output {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 4px;
    font-family: monospace;
    white-space: pre-wrap;
    word-wrap: break-word;
    max-height: 500px;
    overflow-y: auto;
}

.help-list {
    list-style-type: disc;
    padding-left: 1.5rem;
    margin: 0;
}

.help-list li {
    margin-bottom: 0.5rem;
    color: var(--mui-text-secondary);
}

.alert {
    padding: 1rem;
    border-radius: 4px;
    margin-bottom: 1rem;
}

.alert-danger {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}
</style>

<?php
include_once 'includes/footer.php';
?> 