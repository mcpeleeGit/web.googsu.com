<html>
    <head>
        <title>Kakao API</title>
        <script src="https://t1.kakaocdn.net/kakao_js_sdk/2.7.8/kakao.min.js" integrity="sha384-WUSirVbD0ASvo37f3qQZuDap8wy76aJjmGyXKOYgPL/NdAs8HhgmPlk9dz2XQsNv" crossorigin="anonymous"></script>
        <script>
            Kakao.init('96372245e58849f89c06dc96796b00f7');
            function shareToKakao() {
                Kakao.Share.sendDefault({
                objectType: 'feed',
                content: {
                    title: '오늘의 디저트',
                    description: '아메리카노, 빵, 케익',
                    imageUrl:
                    'https://mud-kage.kakao.com/dn/NTmhS/btqfEUdFAUf/FjKzkZsnoeE4o19klTOVI1/openlink_640x640s.jpg',
                    link: {
                    mobileWebUrl: 'https://developers.kakao.com',
                    webUrl: 'https://developers.kakao.com',
                    },
                },
                itemContent: {
                    profileText: 'Kakao',
                    profileImageUrl: 'https://mud-kage.kakao.com/dn/Q2iNx/btqgeRgV54P/VLdBs9cvyn8BJXB3o7N8UK/kakaolink40_original.png',
                    titleImageUrl: 'https://mud-kage.kakao.com/dn/Q2iNx/btqgeRgV54P/VLdBs9cvyn8BJXB3o7N8UK/kakaolink40_original.png',
                    titleImageText: 'Cheese cake',
                    titleImageCategory: 'Cake',
                    items: [
                    {
                        item: 'Cake1',
                        itemOp: '1000원',
                    },
                    {
                        item: 'Cake2',
                        itemOp: '2000원',
                    },
                    {
                        item: 'Cake3',
                        itemOp: '3000원',
                    },
                    {
                        item: 'Cake4',
                        itemOp: '4000원',
                    },
                    {
                        item: 'Cake5',
                        itemOp: '5000원',
                    },
                    ],
                    sum: 'Total',
                    sumOp: '15000원',
                },
                social: {
                    likeCount: 10,
                    commentCount: 20,
                    sharedCount: 30,
                },
                buttons: [
                    {
                    title: '웹으로 이동',
                    link: {
                        mobileWebUrl: 'https://developers.kakao.com',
                        webUrl: 'https://developers.kakao.com',
                    },
                    },
                    {
                    title: '앱으로 이동',
                    link: {
                        mobileWebUrl: 'https://developers.kakao.com',
                        webUrl: 'https://developers.kakao.com',
                    },
                    },
                ],
                serverCallbackArgs: JSON.stringify({ ref: 'web', path: window.location.pathname, ts: Date.now() })
                });
            }
        </script>
    </head>
    <body>
        <h1>Kakao API</h1>
        <div class="kakao-share-container">
            <button id="kakaoShareButton" class="kakao-share-button" onclick="shareToKakao()">
                <span>카카오톡으로 공유</span>
            </button>
        </div>

        <style>
            .kakao-share-container {
                margin-top: 16px;
            }
            .kakao-share-button {
                background: #FEE500;
                color: #000;
                border: none;
                border-radius: 8px;
                padding: 10px 16px;
                font-weight: 700;
                cursor: pointer;
            }
            .kakao-share-button:hover {
                filter: brightness(0.95);
            }
        </style>
    </body>
</html>