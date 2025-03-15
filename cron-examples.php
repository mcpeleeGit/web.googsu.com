<?php
require_once 'includes/functions.php';

$page_title = 'Cron 표현식 예제';
$current_page = 'cron-examples';

$additional_css = ['css/cron-examples.css'];
$additional_js = ['js/cron-examples.js'];

include 'includes/header.php';
?>

        <main>
            <section class="cron-examples-container">
                <h1>Cron 표현식 예제</h1>
                <p class="description">Cron 표현식의 각 필드와 예제를 확인하고, 입력한 값의 의미를 파악할 수 있습니다.</p>

                <div class="cron-input-section">
                    <h2>Cron 표현식 입력</h2>
                    <div class="form-group">
                        <input type="text" id="cron-input" placeholder="* * * * *" class="form-control">
                        <button id="parse-btn" class="btn btn-primary">분석하기</button>
                    </div>
                </div>

                <div class="cron-result-section" style="display: none;">
                    <h2>분석 결과</h2>
                    <div class="result-container">
                        <div class="result-item">
                            <h3>다음 실행 시간</h3>
                            <p id="next-run-time"></p>
                        </div>
                        <div class="result-item">
                            <h3>표현식 의미</h3>
                            <p id="expression-meaning"></p>
                        </div>
                    </div>
                </div>

                <div class="cron-examples-section">
                    <h2>자주 사용하는 예제</h2>
                    <div class="examples-grid">
                        <div class="example-card">
                            <h3>매 분 실행</h3>
                            <code>* * * * *</code>
                            <p>매 분마다 실행됩니다.</p>
                        </div>
                        <div class="example-card">
                            <h3>매 시간 실행</h3>
                            <code>0 * * * *</code>
                            <p>매 시간 정각에 실행됩니다.</p>
                        </div>
                        <div class="example-card">
                            <h3>매일 자정 실행</h3>
                            <code>0 0 * * *</code>
                            <p>매일 자정(00:00)에 실행됩니다.</p>
                        </div>
                        <div class="example-card">
                            <h3>매주 월요일 실행</h3>
                            <code>0 0 * * 1</code>
                            <p>매주 월요일 자정에 실행됩니다.</p>
                        </div>
                        <div class="example-card">
                            <h3>매월 1일 실행</h3>
                            <code>0 0 1 * *</code>
                            <p>매월 1일 자정에 실행됩니다.</p>
                        </div>
                        <div class="example-card">
                            <h3>5분마다 실행</h3>
                            <code>*/5 * * * *</code>
                            <p>5분 간격으로 실행됩니다.</p>
                        </div>
                        <div class="example-card">
                            <h3>특정 시간대 실행</h3>
                            <code>0 9-18 * * 1-5</code>
                            <p>평일 오전 9시부터 오후 6시까지 매 시간 정각에 실행됩니다.</p>
                        </div>
                        <div class="example-card">
                            <h3>여러 값 지정</h3>
                            <code>0 0,12 * * *</code>
                            <p>매일 자정과 정오에 실행됩니다.</p>
                        </div>
                    </div>
                </div>

                <div class="cron-fields-section">
                    <h2>Cron 필드 설명</h2>
                    <div class="fields-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>필드</th>
                                    <th>설명</th>
                                    <th>허용 값</th>
                                    <th>특수 문자</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>분</td>
                                    <td>실행할 분</td>
                                    <td>0-59</td>
                                    <td>* / , -</td>
                                </tr>
                                <tr>
                                    <td>시간</td>
                                    <td>실행할 시간</td>
                                    <td>0-23</td>
                                    <td>* / , -</td>
                                </tr>
                                <tr>
                                    <td>일</td>
                                    <td>실행할 일</td>
                                    <td>1-31</td>
                                    <td>* / , - ? L W</td>
                                </tr>
                                <tr>
                                    <td>월</td>
                                    <td>실행할 월</td>
                                    <td>1-12</td>
                                    <td>* / , -</td>
                                </tr>
                                <tr>
                                    <td>요일</td>
                                    <td>실행할 요일</td>
                                    <td>0-6</td>
                                    <td>* / , - ? L #</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="special-chars-section">
                        <h3>특수 문자 설명</h3>
                        <ul>
                            <li><code>*</code> : 모든 값</li>
                            <li><code>/</code> : 증가 값</li>
                            <li><code>,</code> : 여러 값</li>
                            <li><code>-</code> : 범위</li>
                            <li><code>?</code> : 특정 값 없음</li>
                            <li><code>L</code> : 마지막 값</li>
                            <li><code>W</code> : 가장 가까운 평일</li>
                            <li><code>#</code> : N번째 요일</li>
                        </ul>
                    </div>
                </div>
            </section>
        </main>

<?php include 'includes/footer.php'; ?> 