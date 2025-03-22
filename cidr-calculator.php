
<?php
$page_title = 'IP 주소 대역 계산기';
include_once 'includes/header.php';
?>

<div class="container">
    <h1>IP 주소 대역 계산기</h1>
    
    <div class="mui-card">
        <div class="mui-card-content">
            <form method="POST" class="mb-4">
                <div class="input-group mb-3">
                    <label for="cidr" class="form-label">IP 주소/CIDR</label>
                    <input type="text" 
                           name="cidr" 
                           id="cidr" 
                           class="form-control" 
                           placeholder="예: 192.168.1.0/24" 
                           value="<?php echo isset($_POST['cidr']) ? htmlspecialchars($_POST['cidr']) : ''; ?>" 
                           required>
                </div>
                
                <button type="submit" class="mui-button large-button">
                    <i class="fas fa-calculator"></i> 계산하기
                </button>
            </form>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $cidr = $_POST['cidr'] ?? '';
                $error = '';
                $result = [];

                if (!empty($cidr)) {
                    // CIDR 형식 검증 (예: 192.168.1.0/24)
                    if (preg_match('/^(\d{1,3}\.){3}\d{1,3}\/\d{1,2}$/', $cidr)) {
                        list($ip, $mask) = explode('/', $cidr);
                        
                        // IP 주소 유효성 검사
                        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                            if ($mask >= 0 && $mask <= 32) {
                                // IP를 32비트 정수로 변환
                                $ip_long = ip2long($ip);
                                
                                // 네트워크 주소 계산
                                $netmask_long = -1 << (32 - $mask);
                                $network_long = $ip_long & $netmask_long;
                                
                                // 브로드캐스트 주소 계산
                                $broadcast_long = $network_long | (~$netmask_long);
                                
                                // 첫 번째와 마지막 사용 가능한 IP 계산
                                $first_ip_long = ($mask == 31) ? $network_long : ($network_long + 1);
                                $last_ip_long = ($mask == 31) ? $broadcast_long : ($broadcast_long - 1);
                                
                                // 사용 가능한 IP 주소 수 계산
                                $total_ips = ($mask == 32) ? 1 : (pow(2, (32 - $mask)));
                                $usable_ips = ($mask >= 31) ? $total_ips : ($total_ips - 2);
                                
                                // 결과 저장
                                $result = [
                                    'network' => long2ip($network_long),
                                    'broadcast' => long2ip($broadcast_long),
                                    'first_ip' => long2ip($first_ip_long),
                                    'last_ip' => long2ip($last_ip_long),
                                    'netmask' => long2ip($netmask_long),
                                    'wildcard' => long2ip(~$netmask_long),
                                    'total_ips' => $total_ips,
                                    'usable_ips' => $usable_ips
                                ];
                            } else {
                                $error = '서브넷 마스크는 0에서 32 사이의 값이어야 합니다.';
                            }
                        } else {
                            $error = '유효하지 않은 IP 주소입니다.';
                        }
                    } else {
                        $error = '올바른 CIDR 형식이 아닙니다. (예: 192.168.1.0/24)';
                    }
                }
            }
            ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger mt-4">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($result)): ?>
                <div class="result-section">
                    <h3>계산 결과</h3>
                    <div class="result-grid">
                        <div class="result-item">
                            <div class="result-label">네트워크 주소:</div>
                            <div class="result-value"><?php echo htmlspecialchars($result['network']); ?></div>
                        </div>
                        <div class="result-item">
                            <div class="result-label">브로드캐스트 주소:</div>
                            <div class="result-value"><?php echo htmlspecialchars($result['broadcast']); ?></div>
                        </div>
                        <div class="result-item">
                            <div class="result-label">첫 번째 사용 가능한 IP:</div>
                            <div class="result-value"><?php echo htmlspecialchars($result['first_ip']); ?></div>
                        </div>
                        <div class="result-item">
                            <div class="result-label">마지막 사용 가능한 IP:</div>
                            <div class="result-value"><?php echo htmlspecialchars($result['last_ip']); ?></div>
                        </div>
                        <div class="result-item">
                            <div class="result-label">서브넷 마스크:</div>
                            <div class="result-value"><?php echo htmlspecialchars($result['netmask']); ?></div>
                        </div>
                        <div class="result-item">
                            <div class="result-label">와일드카드 마스크:</div>
                            <div class="result-value"><?php echo htmlspecialchars($result['wildcard']); ?></div>
                        </div>
                        <div class="result-item">
                            <div class="result-label">전체 IP 주소 수:</div>
                            <div class="result-value"><?php echo number_format($result['total_ips']); ?></div>
                        </div>
                        <div class="result-item">
                            <div class="result-label">사용 가능한 IP 주소 수:</div>
                            <div class="result-value"><?php echo number_format($result['usable_ips']); ?></div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="mui-card mt-4">
        <div class="mui-card-header">
            <h3>도움말</h3>
        </div>
        <div class="mui-card-content">
            <ul class="help-list">
                <li>CIDR(Classless Inter-Domain Routing) 표기법을 사용하여 IP 주소 대역을 계산합니다.</li>
                <li>입력 형식: IP주소/서브넷마스크 (예: 192.168.1.0/24)</li>
                <li>계산 결과:
                    <ul>
                        <li>네트워크 주소: 해당 네트워크의 시작 주소</li>
                        <li>브로드캐스트 주소: 해당 네트워크의 마지막 주소</li>
                        <li>사용 가능한 IP 범위: 실제로 할당 가능한 IP 주소 범위</li>
                        <li>서브넷 마스크: 네트워크 부분과 호스트 부분을 구분하는 마스크</li>
                        <li>와일드카드 마스크: 서브넷 마스크의 반전된 형태</li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

<style>
.input-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: bold;
    color: var(--mui-text-primary);
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    font-size: 1.1rem;
    border: 1px solid #ced4da;
    border-radius: 4px;
    transition: border-color 0.15s ease-in-out;
}

.form-control:focus {
    border-color: var(--mui-primary);
    outline: none;
}

.large-button {
    padding: 1rem 2rem;
    font-size: 1.1rem;
}

.large-button i {
    margin-right: 0.5rem;
}

.result-section {
    margin-top: 2rem;
}

.result-section h3 {
    color: var(--mui-primary);
    margin-bottom: 1.5rem;
    text-align: center;
}

.result-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1rem;
    background-color: #f8f9fa;
    padding: 1.5rem;
    border-radius: 4px;
}

.result-item {
    background-color: white;
    padding: 1rem;
    border-radius: 4px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.result-label {
    font-weight: bold;
    color: var(--mui-text-secondary);
    margin-bottom: 0.5rem;
}

.result-value {
    font-family: monospace;
    font-size: 1.1rem;
    color: var(--mui-text-primary);
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

.help-list ul {
    list-style-type: circle;
    margin-top: 0.5rem;
    margin-left: 1.5rem;
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

.mt-4 {
    margin-top: 1.5rem;
}

.mb-3 {
    margin-bottom: 1rem;
}

.mb-4 {
    margin-bottom: 1.5rem;
}
</style>

<?php
include_once 'includes/footer.php';
?>

