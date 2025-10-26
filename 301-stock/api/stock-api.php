<?php
// 오류 보고 활성화
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// OPTIONS 요청 처리
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// 한국투자증권 API 설정 (실제 사용 시 API 키 필요)
class StockAPI {
    private $apiKey;
    private $apiSecret;
    private $baseUrl = 'https://openapi.koreainvestment.com:9443';
    
    public function __construct() {
        // 실제 API 키는 환경변수나 설정 파일에서 관리
        $this->apiKey = $_ENV['KIS_API_KEY'] ?? 'your_api_key_here';
        $this->apiSecret = $_ENV['KIS_API_SECRET'] ?? 'your_api_secret_here';
    }
    
    // 주식 검색
    public function searchStock($query) {
        // 실제 API 호출 대신 모의 데이터 반환
        $mockStocks = [
            ['name' => '삼성전자', 'code' => '005930', 'market' => 'KOSPI'],
            ['name' => 'SK하이닉스', 'code' => '000660', 'market' => 'KOSPI'],
            ['name' => 'LG에너지솔루션', 'code' => '373220', 'market' => 'KOSPI'],
            ['name' => 'NAVER', 'code' => '035420', 'market' => 'KOSPI'],
            ['name' => '카카오', 'code' => '035720', 'market' => 'KOSPI'],
            ['name' => '현대차', 'code' => '005380', 'market' => 'KOSPI'],
            ['name' => 'LG화학', 'code' => '051910', 'market' => 'KOSPI'],
            ['name' => 'POSCO홀딩스', 'code' => '005490', 'market' => 'KOSPI'],
            ['name' => 'KB금융', 'code' => '105560', 'market' => 'KOSPI'],
            ['name' => '신한지주', 'code' => '055550', 'market' => 'KOSPI']
        ];
        
        $results = [];
        foreach ($mockStocks as $stock) {
            if (stripos($stock['name'], $query) !== false || strpos($stock['code'], $query) !== false) {
                $results[] = $stock;
            }
        }
        
        return $results;
    }
    
    // 주식 현재가 조회
    public function getCurrentPrice($code) {
        // 실제 API 호출 대신 모의 데이터 생성
        $basePrice = $this->getBasePrice($code);
        $change = (rand(-1000, 1000) / 100) * $basePrice;
        $currentPrice = $basePrice + $change;
        $changePercent = ($change / $basePrice) * 100;
        
        return [
            'code' => $code,
            'name' => $this->getStockName($code),
            'price' => round($currentPrice),
            'change' => round($change),
            'changePercent' => round($changePercent, 2),
            'volume' => rand(100000, 10000000),
            'high' => round($currentPrice * (1 + rand(0, 500) / 10000)),
            'low' => round($currentPrice * (1 - rand(0, 500) / 10000)),
            'open' => round($basePrice),
            'prevClose' => round($basePrice),
            'marketCap' => round($currentPrice * rand(100000000, 10000000000)),
            'timestamp' => time()
        ];
    }
    
    // 여러 주식 현재가 조회
    public function getMultiplePrices($codes) {
        $results = [];
        foreach ($codes as $code) {
            $results[] = $this->getCurrentPrice($code);
        }
        return $results;
    }
    
    // 기술적 분석 데이터 생성
    public function getTechnicalAnalysis($code) {
        $price = $this->getCurrentPrice($code);
        
        // RSI 계산 (모의)
        $rsi = rand(20, 80);
        
        // MACD 계산 (모의)
        $macd = (rand(-100, 100) / 1000) * $price['price'];
        $macdSignal = (rand(-100, 100) / 1000) * $price['price'];
        
        // 볼린저 밴드 (모의)
        $bbUpper = $price['price'] * (1 + rand(50, 200) / 10000);
        $bbLower = $price['price'] * (1 - rand(50, 200) / 10000);
        $bbMiddle = $price['price'];
        
        // 이동평균 (모의)
        $ma5 = $price['price'] * (1 + (rand(-200, 200) / 10000));
        $ma20 = $price['price'] * (1 + (rand(-300, 300) / 10000));
        $ma60 = $price['price'] * (1 + (rand(-500, 500) / 10000));
        
        return [
            'rsi' => $rsi,
            'macd' => round($macd, 2),
            'macdSignal' => round($macdSignal, 2),
            'bbUpper' => round($bbUpper),
            'bbLower' => round($bbLower),
            'bbMiddle' => round($bbMiddle),
            'ma5' => round($ma5),
            'ma20' => round($ma20),
            'ma60' => round($ma60),
            'volume' => $price['volume'],
            'volumeRatio' => rand(50, 200) / 100,
            'volatility' => rand(10, 50) / 100
        ];
    }
    
    // 투자 추천 생성
    public function getInvestmentRecommendation($code) {
        $price = $this->getCurrentPrice($code);
        $technical = $this->getTechnicalAnalysis($code);
        
        $score = 0;
        $factors = [];
        
        // RSI 분석
        if ($technical['rsi'] < 30) {
            $score += 2;
            $factors[] = ['type' => 'good', 'text' => 'RSI 과매도 구간 (매수 기회)'];
        } elseif ($technical['rsi'] > 70) {
            $score -= 2;
            $factors[] = ['type' => 'bad', 'text' => 'RSI 과매수 구간 (매도 고려)'];
        } else {
            $factors[] = ['type' => 'neutral', 'text' => 'RSI 중립 구간'];
        }
        
        // 이동평균 분석
        if ($price['price'] > $technical['ma5'] && $technical['ma5'] > $technical['ma20']) {
            $score += 1;
            $factors[] = ['type' => 'good', 'text' => '상승 추세 (이동평균 정배열)'];
        } elseif ($price['price'] < $technical['ma5'] && $technical['ma5'] < $technical['ma20']) {
            $score -= 1;
            $factors[] = ['type' => 'bad', 'text' => '하락 추세 (이동평균 역배열)'];
        }
        
        // 거래량 분석
        if ($technical['volumeRatio'] > 1.5) {
            $score += 1;
            $factors[] = ['type' => 'good', 'text' => '거래량 급증 (관심 증가)'];
        } elseif ($technical['volumeRatio'] < 0.5) {
            $score -= 1;
            $factors[] = ['type' => 'bad', 'text' => '거래량 감소 (관심 저하)'];
        }
        
        // 변동성 분석
        if ($technical['volatility'] < 0.2) {
            $score += 1;
            $factors[] = ['type' => 'good', 'text' => '낮은 변동성 (안정적)'];
        } elseif ($technical['volatility'] > 0.4) {
            $score -= 1;
            $factors[] = ['type' => 'bad', 'text' => '높은 변동성 (위험)'];
        }
        
        // MACD 분석
        if ($technical['macd'] > $technical['macdSignal']) {
            $score += 1;
            $factors[] = ['type' => 'good', 'text' => 'MACD 골든크로스'];
        } elseif ($technical['macd'] < $technical['macdSignal']) {
            $score -= 1;
            $factors[] = ['type' => 'bad', 'text' => 'MACD 데드크로스'];
        }
        
        // 추천 결정
        if ($score >= 3) {
            $recommendation = 'buy';
            $confidence = min(90, 60 + $score * 5);
        } elseif ($score <= -3) {
            $recommendation = 'sell';
            $confidence = min(90, 60 + abs($score) * 5);
        } else {
            $recommendation = 'hold';
            $confidence = 50;
        }
        
        return [
            'recommendation' => $recommendation,
            'confidence' => $confidence,
            'score' => $score,
            'factors' => $factors,
            'technical' => $technical
        ];
    }
    
    private function getBasePrice($code) {
        $basePrices = [
            '005930' => 70000,  // 삼성전자
            '000660' => 120000, // SK하이닉스
            '373220' => 450000, // LG에너지솔루션
            '035420' => 200000, // NAVER
            '035720' => 50000,  // 카카오
            '005380' => 180000, // 현대차
            '051910' => 400000, // LG화학
            '005490' => 300000, // POSCO홀딩스
            '105560' => 60000,  // KB금융
            '055550' => 45000   // 신한지주
        ];
        
        return $basePrices[$code] ?? 50000;
    }
    
    private function getStockName($code) {
        $names = [
            '005930' => '삼성전자',
            '000660' => 'SK하이닉스',
            '373220' => 'LG에너지솔루션',
            '035420' => 'NAVER',
            '035720' => '카카오',
            '005380' => '현대차',
            '051910' => 'LG화학',
            '005490' => 'POSCO홀딩스',
            '105560' => 'KB금융',
            '055550' => '신한지주'
        ];
        
        return $names[$code] ?? '알 수 없는 종목';
    }
}

// API 요청 처리
try {
    $api = new StockAPI();
    $action = $_GET['action'] ?? '';

    // 요청 로깅
    error_log("API 요청: action=$action, GET=" . json_encode($_GET));
    error_log("REQUEST_URI: " . $_SERVER['REQUEST_URI']);
    error_log("SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME']);
    error_log("DOCUMENT_ROOT: " . $_SERVER['DOCUMENT_ROOT']);

    switch ($action) {
        case 'search':
            $query = $_GET['query'] ?? '';
            if (empty($query)) {
                echo json_encode(['success' => false, 'message' => '검색어가 필요합니다.']);
                break;
            }
            $results = $api->searchStock($query);
            echo json_encode(['success' => true, 'data' => $results]);
            break;
            
        case 'price':
            $code = $_GET['code'] ?? '';
            if (empty($code)) {
                echo json_encode(['success' => false, 'message' => '종목코드가 필요합니다.']);
                break;
            }
            $price = $api->getCurrentPrice($code);
            echo json_encode(['success' => true, 'data' => $price]);
            break;
            
        case 'prices':
            $codes = $_GET['codes'] ?? '';
            if (empty($codes)) {
                echo json_encode(['success' => false, 'message' => '종목코드들이 필요합니다.']);
                break;
            }
            $codesArray = explode(',', $codes);
            $prices = $api->getMultiplePrices($codesArray);
            echo json_encode(['success' => true, 'data' => $prices]);
            break;
            
        case 'analysis':
            $code = $_GET['code'] ?? '';
            if (empty($code)) {
                echo json_encode(['success' => false, 'message' => '종목코드가 필요합니다.']);
                break;
            }
            $analysis = $api->getInvestmentRecommendation($code);
            echo json_encode(['success' => true, 'data' => $analysis]);
            break;
            
        case 'test':
            echo json_encode(['success' => true, 'message' => 'API가 정상적으로 작동합니다.', 'timestamp' => date('Y-m-d H:i:s')]);
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => '잘못된 요청입니다.', 'available_actions' => ['search', 'price', 'prices', 'analysis', 'test']]);
            break;
    }
} catch (Exception $e) {
    error_log("API 오류: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => '서버 오류가 발생했습니다.', 
        'error' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
} catch (Error $e) {
    error_log("API 치명적 오류: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => '치명적 오류가 발생했습니다.', 
        'error' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
}
?>
