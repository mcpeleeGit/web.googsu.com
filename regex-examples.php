<?php
require_once 'includes/functions.php';

$page_title = '정규식 예제';
$current_page = 'regex-examples';

$additional_css = ['css/regex-examples.css'];
$additional_js = ['js/regex-examples.js'];

include 'includes/header.php';
?>

        <main>
            <section class="regex-examples-container">
                <h1>정규식 예제</h1>
                <p class="description">자주 사용되는 정규식 패턴과 예제를 확인하고, 입력한 정규식의 의미를 파악할 수 있습니다.</p>

                <div class="regex-input-section">
                    <h2>정규식 입력</h2>
                    <div class="form-group">
                        <input type="text" id="regex-input" placeholder="/패턴/플래그" class="form-control">
                        <button id="parse-btn" class="btn btn-primary">분석하기</button>
                    </div>
                    <div class="test-input-group">
                        <input type="text" id="test-input" placeholder="테스트할 문자열" class="form-control">
                        <button id="test-btn" class="btn btn-secondary">테스트하기</button>
                    </div>
                </div>

                <div class="regex-result-section" style="display: none;">
                    <h2>분석 결과</h2>
                    <div class="result-container">
                        <div class="result-item">
                            <h3>정규식 의미</h3>
                            <p id="regex-meaning"></p>
                        </div>
                        <div class="result-item">
                            <h3>테스트 결과</h3>
                            <p id="test-result"></p>
                        </div>
                    </div>
                </div>

                <div class="regex-examples-section">
                    <h2>자주 사용하는 예제</h2>
                    <div class="examples-grid">
                        <div class="example-card">
                            <h3>이메일 주소</h3>
                            <code>/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/</code>
                            <p>이메일 주소 형식을 검증합니다.</p>
                        </div>
                        <div class="example-card">
                            <h3>전화번호</h3>
                            <code>/^01([0|1|6|7|8|9])-?([0-9]{3,4})-?([0-9]{4})$/</code>
                            <p>한국 휴대폰 번호 형식을 검증합니다.</p>
                        </div>
                        <div class="example-card">
                            <h3>URL</h3>
                            <code>/^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*\/?$/</code>
                            <p>URL 형식을 검증합니다.</p>
                        </div>
                        <div class="example-card">
                            <h3>날짜 (YYYY-MM-DD)</h3>
                            <code>/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/</code>
                            <p>YYYY-MM-DD 형식의 날짜를 검증합니다.</p>
                        </div>
                        <div class="example-card">
                            <h3>비밀번호</h3>
                            <code>/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/</code>
                            <p>최소 8자, 문자와 숫자 포함을 검증합니다.</p>
                        </div>
                        <div class="example-card">
                            <h3>한글</h3>
                            <code>/^[가-힣]+$/</code>
                            <p>한글만 포함된 문자열을 검증합니다.</p>
                        </div>
                        <div class="example-card">
                            <h3>숫자</h3>
                            <code>/^[0-9]+$/</code>
                            <p>숫자만 포함된 문자열을 검증합니다.</p>
                        </div>
                        <div class="example-card">
                            <h3>특수문자</h3>
                            <code>/[!@#$%^&*(),.?":{}|<>]/</code>
                            <p>특수문자를 포함하는지 검사합니다.</p>
                        </div>
                    </div>
                </div>

                <div class="regex-patterns-section">
                    <h2>정규식 패턴 설명</h2>
                    <div class="patterns-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>패턴</th>
                                    <th>설명</th>
                                    <th>예제</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>^</td>
                                    <td>문자열의 시작</td>
                                    <td>^Hello</td>
                                </tr>
                                <tr>
                                    <td>$</td>
                                    <td>문자열의 끝</td>
                                    <td>World$</td>
                                </tr>
                                <tr>
                                    <td>.</td>
                                    <td>임의의 한 문자</td>
                                    <td>h.t</td>
                                </tr>
                                <tr>
                                    <td>*</td>
                                    <td>0회 이상 반복</td>
                                    <td>ab*</td>
                                </tr>
                                <tr>
                                    <td>+</td>
                                    <td>1회 이상 반복</td>
                                    <td>ab+</td>
                                </tr>
                                <tr>
                                    <td>?</td>
                                    <td>0회 또는 1회</td>
                                    <td>ab?</td>
                                </tr>
                                <tr>
                                    <td>{n}</td>
                                    <td>n회 반복</td>
                                    <td>ab{2}</td>
                                </tr>
                                <tr>
                                    <td>{n,}</td>
                                    <td>n회 이상 반복</td>
                                    <td>ab{2,}</td>
                                </tr>
                                <tr>
                                    <td>{n,m}</td>
                                    <td>n회부터 m회까지 반복</td>
                                    <td>ab{2,4}</td>
                                </tr>
                                <tr>
                                    <td>[]</td>
                                    <td>문자 집합</td>
                                    <td>[abc]</td>
                                </tr>
                                <tr>
                                    <td>[^]</td>
                                    <td>부정 문자 집합</td>
                                    <td>[^abc]</td>
                                </tr>
                                <tr>
                                    <td>|</td>
                                    <td>또는</td>
                                    <td>a|b</td>
                                </tr>
                                <tr>
                                    <td>()</td>
                                    <td>그룹</td>
                                    <td>(ab)+</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="regex-flags-section">
                        <h3>정규식 플래그</h3>
                        <ul>
                            <li><code>g</code> : 전역 검색 (모든 일치)</li>
                            <li><code>i</code> : 대소문자 구분 없음</li>
                            <li><code>m</code> : 여러 줄 검색</li>
                            <li><code>s</code> : 점(.)이 줄바꿈을 포함</li>
                            <li><code>u</code> : 유니코드 모드</li>
                            <li><code>y</code> : 마지막 위치에서 검색 시작</li>
                        </ul>
                    </div>
                </div>
            </section>
        </main>

<?php include 'includes/footer.php'; ?> 