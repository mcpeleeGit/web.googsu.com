document.addEventListener('DOMContentLoaded', function() {
    const text1 = document.getElementById('text1');
    const text2 = document.getElementById('text2');
    const compareBtn = document.getElementById('compareBtn');
    const clearBtn = document.getElementById('clearBtn');
    const compareResult = document.getElementById('compareResult');

    compareBtn.addEventListener('click', function() {
        const str1 = text1.value;
        const str2 = text2.value;
        
        if (!str1 || !str2) {
            alert('두 텍스트를 모두 입력해주세요.');
            return;
        }

        const diff = compareTexts(str1, str2);
        compareResult.innerHTML = diff;
    });

    clearBtn.addEventListener('click', function() {
        text1.value = '';
        text2.value = '';
        compareResult.innerHTML = '';
    });

    function findDifferences(str1, str2) {
        const len1 = str1.length;
        const len2 = str2.length;
        let result = '';
        let i = 0;
        
        while (i < len1 || i < len2) {
            if (i < len1 && i < len2) {
                if (str1[i] === str2[i]) {
                    result += escapeHtml(str1[i]);
                } else {
                    result += `<span class="char-removed">${escapeHtml(str1[i])}</span>`;
                }
            } else if (i < len1) {
                result += `<span class="char-removed">${escapeHtml(str1[i])}</span>`;
            }
            i++;
        }
        
        return result;
    }

    function compareTexts(text1, text2) {
        const lines1 = text1.split('\n');
        const lines2 = text2.split('\n');
        let result = '';

        const maxLines = Math.max(lines1.length, lines2.length);
        const lineNumberWidth = String(maxLines).length;

        for (let i = 0; i < maxLines; i++) {
            const line1 = lines1[i] || '';
            const line2 = lines2[i] || '';
            const lineNumber = String(i + 1).padStart(lineNumberWidth, '0');

            if (line1 === line2) {
                result += `<div class="line"><span class="line-number">${lineNumber}</span>${escapeHtml(line1)}</div>`;
            } else {
                if (line1) {
                    result += `<div class="diff-removed"><span class="line-number">${lineNumber}</span>- ${findDifferences(line1, line2)}</div>`;
                }
                if (line2) {
                    result += `<div class="diff-added"><span class="line-number">${lineNumber}</span>+ ${findDifferences(line2, line1)}</div>`;
                }
            }
        }

        return result;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}); 