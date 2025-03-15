document.addEventListener('DOMContentLoaded', function() {
    const curlInput = document.getElementById('curl-input');
    const targetLanguage = document.getElementById('target-language');
    const convertBtn = document.getElementById('convert-btn');
    const convertedCode = document.getElementById('converted-code');
    const copyBtn = document.getElementById('copy-btn');
    const clearBtn = document.getElementById('clear-btn');

    // 변환 버튼 클릭 이벤트
    convertBtn.addEventListener('click', function() {
        const curlCommand = curlInput.value.trim();
        if (!curlCommand) {
            alert('CURL 명령어를 입력해주세요.');
            return;
        }

        const language = targetLanguage.value;
        const converted = convertCurlToLanguage(curlCommand, language);
        
        // 코드 표시 및 구문 강조
        convertedCode.textContent = converted;
        convertedCode.className = `language-${language}`;
    });

    // 복사 버튼 클릭 이벤트
    copyBtn.addEventListener('click', function() {
        navigator.clipboard.writeText(convertedCode.textContent)
            .then(() => alert('코드가 클립보드에 복사되었습니다.'))
            .catch(err => console.error('복사 실패:', err));
    });

    // 초기화 버튼 클릭 이벤트
    clearBtn.addEventListener('click', function() {
        curlInput.value = '';
        convertedCode.textContent = '';
        convertedCode.className = 'language-php';
    });

    // CURL 명령어를 선택한 언어로 변환하는 함수
    function convertCurlToLanguage(curlCommand, language) {
        // CURL 명령어 파싱
        const parsed = parseCurlCommand(curlCommand);
        
        // 언어별 변환
        switch (language) {
            case 'php':
                return convertToPHP(parsed);
            case 'python':
                return convertToPython(parsed);
            case 'javascript':
                return convertToJavaScript(parsed);
            case 'javascript-axios':
                return convertToJavaScriptAxios(parsed);
            case 'java':
                return convertToJava(parsed);
            case 'go':
                return convertToGo(parsed);
            case 'ruby':
                return convertToRuby(parsed);
            case 'csharp':
                return convertToCSharp(parsed);
            case 'swift':
                return convertToSwift(parsed);
            case 'kotlin':
                return convertToKotlin(parsed);
            default:
                return '지원하지 않는 언어입니다.';
        }
    }

    // CURL 명령어 파싱 함수
    function parseCurlCommand(curlCommand) {
        const result = {
            method: 'GET',
            url: '',
            headers: {},
            data: null,
            options: {}
        };

        // URL 추출
        const urlMatch = curlCommand.match(/curl\s+['"]?([^'"]+)['"]?/);
        if (urlMatch) {
            result.url = urlMatch[1];
        }

        // HTTP 메서드 추출
        if (curlCommand.includes('-X POST')) {
            result.method = 'POST';
        } else if (curlCommand.includes('-X PUT')) {
            result.method = 'PUT';
        } else if (curlCommand.includes('-X DELETE')) {
            result.method = 'DELETE';
        }

        // 헤더 추출
        const headerMatches = curlCommand.match(/-H\s+['"]([^'"]+)['"]/g);
        if (headerMatches) {
            headerMatches.forEach(header => {
                const [key, value] = header.replace(/-H\s+['"]/, '').replace(/['"]$/, '').split(': ');
                result.headers[key] = value;
            });
        }

        // 데이터 추출
        const dataMatch = curlCommand.match(/--data\s+['"]([^'"]+)['"]/);
        if (dataMatch) {
            result.data = dataMatch[1];
        }

        return result;
    }

    // PHP 변환 함수
    function convertToPHP(parsed) {
        let code = '<?php\n\n';
        code += '$ch = curl_init();\n\n';
        code += `curl_setopt($ch, CURLOPT_URL, '${parsed.url}');\n`;
        code += `curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);\n`;
        
        if (parsed.method !== 'GET') {
            code += `curl_setopt($ch, CURLOPT_CUSTOMREQUEST, '${parsed.method}');\n`;
        }

        if (Object.keys(parsed.headers).length > 0) {
            code += 'curl_setopt($ch, CURLOPT_HTTPHEADER, [\n';
            Object.entries(parsed.headers).forEach(([key, value]) => {
                code += `    '${key}: ${value}',\n`;
            });
            code += ']);\n';
        }

        if (parsed.data) {
            code += `curl_setopt($ch, CURLOPT_POSTFIELDS, '${parsed.data}');\n`;
        }

        code += '\n$response = curl_exec($ch);\n';
        code += 'curl_close($ch);\n\n';
        code += 'echo $response;\n';

        return code;
    }

    // Python 변환 함수
    function convertToPython(parsed) {
        let code = 'import requests\n\n';
        code += `url = '${parsed.url}'\n`;
        
        if (Object.keys(parsed.headers).length > 0) {
            code += 'headers = {\n';
            Object.entries(parsed.headers).forEach(([key, value]) => {
                code += `    '${key}': '${value}',\n`;
            });
            code += '}\n\n';
        }

        if (parsed.data) {
            code += `data = '${parsed.data}'\n\n`;
        }

        code += `response = requests.${parsed.method.toLowerCase()}(url`;
        if (Object.keys(parsed.headers).length > 0) {
            code += ', headers=headers';
        }
        if (parsed.data) {
            code += ', data=data';
        }
        code += ')\n\n';
        code += 'print(response.text)';

        return code;
    }

    // JavaScript (Fetch) 변환 함수
    function convertToJavaScript(parsed) {
        let code = `fetch('${parsed.url}', {\n`;
        code += `    method: '${parsed.method}',\n`;
        
        if (Object.keys(parsed.headers).length > 0) {
            code += '    headers: {\n';
            Object.entries(parsed.headers).forEach(([key, value]) => {
                code += `        '${key}': '${value}',\n`;
            });
            code += '    },\n';
        }

        if (parsed.data) {
            code += `    body: '${parsed.data}'\n`;
        }

        code += '})\n';
        code += '.then(response => response.text())\n';
        code += '.then(data => console.log(data))\n';
        code += '.catch(error => console.error(error));';

        return code;
    }

    // JavaScript (Axios) 변환 함수
    function convertToJavaScriptAxios(parsed) {
        let code = 'const axios = require(\'axios\');\n\n';
        code += `axios.${parsed.method.toLowerCase()}(`;
        code += `'${parsed.url}'`;
        
        if (Object.keys(parsed.headers).length > 0 || parsed.data) {
            code += ', {\n';
            if (Object.keys(parsed.headers).length > 0) {
                code += '    headers: {\n';
                Object.entries(parsed.headers).forEach(([key, value]) => {
                    code += `        '${key}': '${value}',\n`;
                });
                code += '    },\n';
            }
            if (parsed.data) {
                code += `    data: '${parsed.data}'\n`;
            }
            code += '}';
        }
        
        code += ')\n';
        code += '.then(response => console.log(response.data))\n';
        code += '.catch(error => console.error(error));';

        return code;
    }

    // Java 변환 함수
    function convertToJava(parsed) {
        let code = 'import java.net.http.HttpClient;\n';
        code += 'import java.net.http.HttpRequest;\n';
        code += 'import java.net.http.HttpResponse;\n';
        code += 'import java.net.URI;\n\n';
        
        code += 'HttpClient client = HttpClient.newHttpClient();\n\n';
        
        code += 'HttpRequest request = HttpRequest.newBuilder()\n';
        code += `    .uri(URI.create("${parsed.url}"))\n`;
        code += `    .method("${parsed.method}", HttpRequest.BodyPublishers.noBody())\n`;
        
        if (Object.keys(parsed.headers).length > 0) {
            Object.entries(parsed.headers).forEach(([key, value]) => {
                code += `    .header("${key}", "${value}")\n`;
            });
        }

        if (parsed.data) {
            code += `    .method("${parsed.method}", HttpRequest.BodyPublishers.ofString("${parsed.data}"))\n`;
        }

        code += '    .build();\n\n';
        code += 'try {\n';
        code += '    HttpResponse<String> response = client.send(request, HttpResponse.BodyHandlers.ofString());\n';
        code += '    System.out.println(response.body());\n';
        code += '} catch (Exception e) {\n';
        code += '    e.printStackTrace();\n';
        code += '}';

        return code;
    }

    // Go 변환 함수
    function convertToGo(parsed) {
        let code = 'package main\n\n';
        code += 'import (\n';
        code += '    "fmt"\n';
        code += '    "io/ioutil"\n';
        code += '    "net/http"\n';
        code += '    "strings"\n';
        code += ')\n\n';
        
        code += 'func main() {\n';
        code += `    url := "${parsed.url}"\n`;
        
        if (parsed.data) {
            code += `    payload := strings.NewReader("${parsed.data}")\n\n`;
        }
        
        code += '    client := &http.Client{}\n';
        code += `    req, err := http.NewRequest("${parsed.method}", url`;
        if (parsed.data) {
            code += ', payload';
        }
        code += ')\n';
        code += '    if err != nil {\n';
        code += '        fmt.Println(err)\n';
        code += '        return\n';
        code += '    }\n\n';
        
        if (Object.keys(parsed.headers).length > 0) {
            Object.entries(parsed.headers).forEach(([key, value]) => {
                code += `    req.Header.Add("${key}", "${value}")\n`;
            });
        }
        
        code += '\n    resp, err := client.Do(req)\n';
        code += '    if err != nil {\n';
        code += '        fmt.Println(err)\n';
        code += '        return\n';
        code += '    }\n';
        code += '    defer resp.Body.Close()\n\n';
        code += '    body, err := ioutil.ReadAll(resp.Body)\n';
        code += '    if err != nil {\n';
        code += '        fmt.Println(err)\n';
        code += '        return\n';
        code += '    }\n';
        code += '    fmt.Println(string(body))\n';
        code += '}';

        return code;
    }

    // Ruby 변환 함수
    function convertToRuby(parsed) {
        let code = 'require "net/http"\n';
        code += 'require "uri"\n\n';
        
        code += `uri = URI("${parsed.url}")\n`;
        code += 'http = Net::HTTP.new(uri.host, uri.port)\n\n';
        
        code += `request = Net::HTTP::${parsed.method}.new(uri.request_uri)\n`;
        
        if (Object.keys(parsed.headers).length > 0) {
            Object.entries(parsed.headers).forEach(([key, value]) => {
                code += `request["${key}"] = "${value}"\n`;
            });
        }

        if (parsed.data) {
            code += `request.body = "${parsed.data}"\n`;
        }

        code += '\nresponse = http.request(request)\n';
        code += 'puts response.body';

        return code;
    }

    // C# 변환 함수
    function convertToCSharp(parsed) {
        let code = 'using System;\n';
        code += 'using System.Net.Http;\n';
        code += 'using System.Threading.Tasks;\n\n';
        
        code += 'class Program\n';
        code += '{\n';
        code += '    static async Task Main(string[] args)\n';
        code += '    {\n';
        code += '        using (var client = new HttpClient())\n';
        code += '        {\n';
        
        if (Object.keys(parsed.headers).length > 0) {
            Object.entries(parsed.headers).forEach(([key, value]) => {
                code += `            client.DefaultRequestHeaders.Add("${key}", "${value}");\n`;
            });
        }

        code += `            var response = await client.${parsed.method}Async("${parsed.url}"`;
        if (parsed.data) {
            code += `, new StringContent("${parsed.data}")`;
        }
        code += ');\n';
        
        code += '            var result = await response.Content.ReadAsStringAsync();\n';
        code += '            Console.WriteLine(result);\n';
        code += '        }\n';
        code += '    }\n';
        code += '}';

        return code;
    }

    // Swift 변환 함수
    function convertToSwift(parsed) {
        let code = 'import Foundation\n\n';
        code += `let url = URL(string: "${parsed.url}")!\n`;
        code += `var request = URLRequest(url: url)\n`;
        code += `request.httpMethod = "${parsed.method}"\n\n`;
        
        if (Object.keys(parsed.headers).length > 0) {
            Object.entries(parsed.headers).forEach(([key, value]) => {
                code += `request.setValue("${value}", forHTTPHeaderField: "${key}")\n`;
            });
        }

        if (parsed.data) {
            code += `request.httpBody = "${parsed.data}".data(using: .utf8)\n\n`;
        }

        code += 'let task = URLSession.shared.dataTask(with: request) { (data, response, error) in\n';
        code += '    if let error = error {\n';
        code += '        print("Error: \\(error)")\n';
        code += '        return\n';
        code += '    }\n\n';
        code += '    if let data = data {\n';
        code += '        if let string = String(data: data, encoding: .utf8) {\n';
        code += '            print(string)\n';
        code += '        }\n';
        code += '    }\n';
        code += '}\n';
        code += 'task.resume()';

        return code;
    }

    // Kotlin 변환 함수
    function convertToKotlin(parsed) {
        let code = 'import okhttp3.*\n';
        code += 'import java.io.IOException\n\n';
        
        code += 'fun main() {\n';
        code += '    val client = OkHttpClient()\n\n';
        
        code += '    val requestBuilder = Request.Builder()\n';
        code += `        .url("${parsed.url}")\n`;
        code += `        .method("${parsed.method}", null)\n`;
        
        if (Object.keys(parsed.headers).length > 0) {
            Object.entries(parsed.headers).forEach(([key, value]) => {
                code += `        .addHeader("${key}", "${value}")\n`;
            });
        }

        if (parsed.data) {
            code += `        .post(RequestBody.create("${parsed.data}".toByteArray()))\n`;
        }

        code += '        .build()\n\n';
        code += '    client.newCall(requestBuilder).enqueue(object : Callback {\n';
        code += '        override fun onFailure(call: Call, e: IOException) {\n';
        code += '            e.printStackTrace()\n';
        code += '        }\n\n';
        code += '        override fun onResponse(call: Call, response: Response) {\n';
        code += '            println(response.body?.string())\n';
        code += '        }\n';
        code += '    })\n';
        code += '}';

        return code;
    }
}); 