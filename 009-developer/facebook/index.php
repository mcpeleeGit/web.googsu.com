<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../../common/head.php'; ?>
    <title>Facebook Developers - Googsu Tools</title>
    <meta name="description" content="Facebook Developers를 위한 다양한 도구와 리소스를 제공합니다. API 통합, 앱 개발, 분석 도구 등을 활용하세요.">
    <meta property="og:title" content="Facebook Developers - Googsu Tools">
    <meta property="og:description" content="Facebook Developers를 위한 다양한 도구와 리소스를 제공합니다. API 통합, 앱 개발, 분석 도구 등을 활용하세요.">
    <meta property="og:url" content="https://googsu.com/facebook-developers">
    <meta property="og:image" content="https://googsu.com/images/facebook-developers-og-image.png">
    <style>
        /* 기존 스타일 코드 */
    </style>
</head>
<body>
    <div class="container">
        <?php include '../../common/menu.php'; ?>
        <div class="content-area">
            <div id="fb-root"></div>
            <script>
            window.fbAsyncInit = function() {
                FB.init({
                appId      : '1696849443815546',
                cookie     : true,
                xfbml      : true,
                version    : 'v15.0'
                });
                
                FB.AppEvents.logPageView();   
                
            };

            (function(d, s, id){
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement(s); js.id = id;
                js.src = "https://connect.facebook.net/ko_KR/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
            </script>

            <div class="fb-login-button" 
                data-width="" 
                data-size="large" 
                data-button-type="login_with" 
                data-layout="default" 
                data-auto-logout-link="false" 
                data-use-continue-as="false" 
                onlogin="checkLoginState();"></div>

            <!-- Facebook 공유하기 버튼 -->
            <div class="fb-share-button" 
                 data-href="https://googsu.com" 
                 data-layout="button_count">
            </div>

            <!-- 피드 대화상자 공유 버튼 -->
            <button onclick="shareToFeed()">페이스북에 공유하기</button>

            <!-- 보내기 대화상자 버튼 -->
            <button onclick="sendToFriend()">페이스북으로 보내기</button>

            <!-- 좋아요 버튼 -->
            <div class="fb-like" 
                 data-href="https://googsu.com" 
                 data-width="" 
                 data-layout="standard" 
                 data-action="like" 
                 data-size="small" 
                 data-share="true">
            </div>

            <!-- 댓글 플러그인 -->
            <div class="fb-comments" 
                 data-href="https://googsu.com" 
                 data-width="100%" 
                 data-numposts="5">
            </div>

            <!-- 페이지 플러그인 -->
            <div class="fb-page" 
                 data-href="https://www.facebook.com/facebook" 
                 data-tabs="timeline" 
                 data-width="" 
                 data-height="" 
                 data-small-header="false" 
                 data-adapt-container-width="true" 
                 data-hide-cover="false" 
                 data-show-facepile="true">
            </div>

            <!-- 저장 버튼 -->
            <div class="fb-save" 
                 data-uri="https://googsu.com">
            </div>
        </div>
        <?php include '../../common/footer.php'; ?>
    </div>

    <script>
      function checkLoginState() {
        FB.getLoginStatus(function(response) {
          statusChangeCallback(response);
        });
      }

      function statusChangeCallback(response) {
        if (response.status === 'connected') {
          console.log('Logged in.');
          // 사용자 정보 가져오기
          FB.api('/me', function(response) {
            console.log('Successful login for: ' + response.name);
          });
        } else {
          console.log('User not authenticated');
        }
      }

      function shareToFeed() {
        FB.ui({
          method: 'share',
          href: 'https://googsu.com', // 공유할 URL
        }, function(response){
          if (response && !response.error_message) {
            alert('Posting completed.');
          } else {
            alert('Error while posting.');
          }
        });
      }

      function sendToFriend() {
        FB.ui({
          method: 'send',
          link: 'https://googsu.com', // 공유할 URL
        });
      }
    </script>

</body>
</html> 