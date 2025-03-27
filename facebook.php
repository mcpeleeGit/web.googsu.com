<!DOCTYPE html>
<html lang="kr">
<head>
    <style>
        main.container {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: calc(100vh - 200px);
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            max-width: 600px;
            width: 90%;
        }
        main.container h1 {
            color: #000;
            border-bottom: 2px solid #1877f2;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        main.container .login-section {
            width: 100%;
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f8f8;
            border-radius: 4px;
        }
        main.container .login-status {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        main.container .user-info {
            display: flex;
            align-items: center;
        }
        main.container .login-btn {
            background-color: #1877f2;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        main.container .login-btn:hover {
            opacity: 0.9;
        }
        main.container .login-btn img {
            width: 16px;
            height: 16px;
        }
        main.container .share-section {
            width: 100%;
            margin-bottom: 30px;
        }
        main.container .share-input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        main.container .button-group {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin: 20px 0;
        }
        main.container .share-btn {
            background-color: #1877f2;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        main.container .share-btn.messenger {
            background-color: #0084FF;
        }
        main.container .share-btn:hover {
            opacity: 0.9;
        }
        main.container .share-btn img {
            width: 20px;
            height: 20px;
        }
        main.container .preview-section {
            width: 100%;
            margin-top: 30px;
            padding: 20px;
            background: #f8f8f8;
            border-radius: 4px;
            display: none;
        }
        main.container .preview-section h2 {
            margin-top: 0;
            color: #333;
        }
        main.container .preview-section img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        main.container .messenger-section {
            width: 100%;
            margin-top: 30px;
            padding: 20px;
            background: #f8f8f8;
            border-radius: 4px;
        }
        main.container .messenger-section h2 {
            margin-top: 0;
            color: #333;
            margin-bottom: 20px;
        }
        main.container .messenger-input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        main.container .messenger-btn {
            background-color: #0084FF;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 10px 0;
        }
        main.container .messenger-btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
    </div>

    <main class="container">
        <h1>페이스북 공유하기</h1>
        
        <div class="login-section">
            <div id="loginStatus" class="login-status">
                <div class="user-info" style="display: none;">
                    <img id="userProfilePic" src="" alt="프로필 사진" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
                    <span id="userName"></span>
                </div>
                <button id="loginBtn" class="login-btn">
                    페이스북 로그인
                </button>
                <button id="logoutBtn" class="login-btn" style="display: none;">
                    로그아웃
                </button>
            </div>
        </div>

        <div class="share-section">
            <input type="text" id="shareTitle" class="share-input" placeholder="공유할 제목을 입력하세요" value="페이스북 공유 테스트">
            <input type="text" id="shareUrl" class="share-input" placeholder="공유할 URL을 입력하세요" value="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
            <textarea id="shareDescription" class="share-input" rows="4" placeholder="공유할 설명을 입력하세요">페이스북 공유 기능 테스트입니다.</textarea>
            <input type="text" id="shareImage" class="share-input" placeholder="공유할 이미지 URL을 입력하세요" value="https://developers.facebook.com/static/img/logo_facebook_rgb_white.png">
            
            <div class="button-group">
                <button id="shareBtn" class="share-btn">
                    페이스북으로 공유
                </button>
                <button id="messengerBtn" class="share-btn messenger">
                    메신저로 공유
                </button>
            </div>
        </div>

        <div id="previewSection" class="preview-section">
            <h2>공유 미리보기</h2>
            <div id="previewContent"></div>
        </div>

        <div class="messenger-section">
            <h3>페이스북 메신저로 메시지 보내기</h3>
            <div class="input-group">
                <label for="recipientPSID">받는 사람 PSID</label>
                <input type="text" id="recipientPSID" class="share-input" placeholder="받는 사람의 PSID를 입력하세요">
            </div>
            <div class="input-group">
                <label for="messageText">메시지 내용</label>
                <textarea id="messageText" class="share-input" placeholder="메시지 내용을 입력하세요"></textarea>
            </div>
            <button id="sendMessageBtn" class="primary-btn">메신저로 보내기</button>
        </div>
    </main>

    <script>
        // 페이스북 SDK 초기화
        window.fbAsyncInit = function() {
            FB.init({
                appId: '3040550802927623',
                cookie: true,
                xfbml: true,
                version: 'v18.0'
            });

            // 로그인 상태 확인
            FB.getLoginStatus(function(response) {
                updateLoginStatus(response);
            });
        };

        // 페이스북 SDK 로드
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/ko_KR/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        // 로그인 상태 업데이트 함수
        function updateLoginStatus(response) {
            const userInfo = document.querySelector('.user-info');
            const loginBtn = document.getElementById('loginBtn');
            const logoutBtn = document.getElementById('logoutBtn');
            const userName = document.getElementById('userName');
            const userProfilePic = document.getElementById('userProfilePic');

            if (response.status === 'connected') {
                // 로그인된 상태
                userInfo.style.display = 'flex';
                loginBtn.style.display = 'none';
                logoutBtn.style.display = 'block';
                
                // 사용자 정보 가져오기
                FB.api('/me', {fields: 'name,picture'}, function(response) {
                    userName.textContent = response.name;
                    userProfilePic.src = response.picture.data.url;
                });
            } else {
                // 로그아웃 상태
                userInfo.style.display = 'none';
                loginBtn.style.display = 'block';
                logoutBtn.style.display = 'none';
                userName.textContent = '';
                userProfilePic.src = '';
            }
        }

        // 로그인 버튼 클릭 이벤트
        document.getElementById('loginBtn').addEventListener('click', function() {
            FB.login(function(response) {
                updateLoginStatus(response);
            }, {
                scope: 'email,public_profile,pages_messaging',
                display: 'popup'
            });
        });

        // 로그아웃 버튼 클릭 이벤트
        document.getElementById('logoutBtn').addEventListener('click', function() {
            FB.logout(function(response) {
                updateLoginStatus(response);
            });
        });

        // 공유 데이터 가져오기 함수
        function getShareData() {
            return {
                title: document.getElementById('shareTitle').value,
                url: document.getElementById('shareUrl').value,
                description: document.getElementById('shareDescription').value,
                image: document.getElementById('shareImage').value
            };
        }

        // 페이스북 공유 버튼 클릭 이벤트
        document.getElementById('shareBtn').addEventListener('click', function() {
            const shareData = getShareData();
            updatePreview(shareData);

            FB.ui({
                method: 'share',
                href: shareData.url,
                quote: shareData.description
            }, function(response) {
                if (response && !response.error_message) {
                    alert('공유가 완료되었습니다!');
                }
            });
        });

        // 메신저 공유 버튼 클릭 이벤트
        document.getElementById('messengerBtn').addEventListener('click', function() {
            const shareData = getShareData();
            updatePreview(shareData);

            // 페이스북 로그인 상태 확인
            FB.getLoginStatus(function(response) {
                if (response.status === 'connected') {
                    // 로그인된 상태에서 메신저 공유
                    FB.ui({
                        method: 'send',
                        link: shareData.url,
                        quote: shareData.description,
                        display: 'popup'
                    }, function(response) {
                        if (response && !response.error_message) {
                            alert('메신저로 공유되었습니다!');
                        } else {
                            alert('메신저 공유에 실패했습니다. 다시 시도해주세요.');
                        }
                    });
                } else {
                    // 로그인이 필요한 경우
                    FB.login(function(response) {
                        if (response.status === 'connected') {
                            // 로그인 성공 후 메신저 공유
                            FB.ui({
                                method: 'send',
                                link: shareData.url,
                                quote: shareData.description,
                                display: 'popup'
                            }, function(response) {
                                if (response && !response.error_message) {
                                    alert('메신저로 공유되었습니다!');
                                } else {
                                    alert('메신저 공유에 실패했습니다. 다시 시도해주세요.');
                                }
                            });
                        } else {
                            alert('페이스북 로그인이 필요합니다.');
                        }
                    }, {
                        scope: 'email,public_profile,pages_messaging',
                        display: 'popup'
                    });
                }
            });
        });

        // 메시지 보내기 버튼 클릭 이벤트
        document.getElementById('sendMessageBtn').addEventListener('click', function() {
            const recipientPSID = document.getElementById('recipientPSID').value;
            const messageText = document.getElementById('messageText').value;

            if (!recipientPSID) {
                alert('받는 사람의 PSID를 입력해주세요.');
                return;
            }

            if (!messageText) {
                alert('메시지 내용을 입력해주세요.');
                return;
            }

            // 서버로 메시지 전송 요청
            fetch('send_message.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    recipient_id: recipientPSID,
                    message: messageText
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('메시지가 전송되었습니다!');
                    document.getElementById('messageText').value = '';
                } else {
                    alert('메시지 전송에 실패했습니다: ' + data.error);
                }
            })
            .catch(error => {
                alert('메시지 전송 중 오류가 발생했습니다: ' + error);
            });
        });

        // 미리보기 업데이트 함수
        function updatePreview(data) {
            const previewContent = document.getElementById('previewContent');
            const previewSection = document.getElementById('previewSection');
            const previewHtml = `
                <img src="${data.image}" alt="${data.title}">
                <h3>${data.title}</h3>
                <p>${data.description}</p>
                <p><small>${data.url}</small></p>
            `;
            previewContent.innerHTML = previewHtml;
            previewSection.style.display = 'block';
        }

        // 입력값 변경 시 미리보기 업데이트
        document.querySelectorAll('.share-input').forEach(input => {
            input.addEventListener('input', function() {
                updatePreview(getShareData());
            });
        });
    </script>
</body>
</html>
