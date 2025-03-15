document.addEventListener('DOMContentLoaded', function() {
    const cronInput = document.getElementById('cron-input');
    const parseBtn = document.getElementById('parse-btn');
    const resultSection = document.querySelector('.cron-result-section');
    const nextRunTime = document.getElementById('next-run-time');
    const expressionMeaning = document.getElementById('expression-meaning');

    parseBtn.addEventListener('click', function() {
        const expression = cronInput.value.trim();
        if (!expression) {
            alert('Cron 표현식을 입력해주세요.');
            return;
        }

        try {
            const parsed = parseCronExpression(expression);
            const nextRun = calculateNextRun(parsed);
            const meaning = getExpressionMeaning(parsed);

            nextRunTime.textContent = nextRun.toLocaleString();
            expressionMeaning.textContent = meaning;
            resultSection.style.display = 'block';
        } catch (error) {
            alert('올바른 Cron 표현식을 입력해주세요.');
            console.error(error);
        }
    });

    function parseCronExpression(expression) {
        const parts = expression.split(/\s+/);
        if (parts.length !== 5) {
            throw new Error('Cron 표현식은 5개의 필드로 구성되어야 합니다.');
        }

        return {
            minute: parseField(parts[0], 0, 59),
            hour: parseField(parts[1], 0, 23),
            day: parseField(parts[2], 1, 31),
            month: parseField(parts[3], 1, 12),
            weekday: parseField(parts[4], 0, 6)
        };
    }

    function parseField(field, min, max) {
        if (field === '*') {
            return { type: 'all' };
        }

        if (field.includes('/')) {
            const [value, step] = field.split('/');
            return {
                type: 'step',
                value: value === '*' ? min : parseInt(value),
                step: parseInt(step)
            };
        }

        if (field.includes(',')) {
            return {
                type: 'list',
                values: field.split(',').map(v => parseInt(v))
            };
        }

        if (field.includes('-')) {
            const [start, end] = field.split('-').map(v => parseInt(v));
            return {
                type: 'range',
                start,
                end
            };
        }

        const value = parseInt(field);
        if (isNaN(value) || value < min || value > max) {
            throw new Error(`값은 ${min}에서 ${max} 사이여야 합니다.`);
        }

        return {
            type: 'value',
            value
        };
    }

    function calculateNextRun(parsed) {
        const now = new Date();
        let next = new Date(now);
        next.setSeconds(0);
        next.setMilliseconds(0);

        // 다음 분으로 이동
        if (parsed.minute.type === 'all') {
            next.setMinutes(next.getMinutes() + 1);
        } else if (parsed.minute.type === 'value') {
            if (next.getMinutes() >= parsed.minute.value) {
                next.setHours(next.getHours() + 1);
            }
            next.setMinutes(parsed.minute.value);
        } else if (parsed.minute.type === 'step') {
            const currentMinute = next.getMinutes();
            const step = parsed.minute.step;
            const nextMinute = Math.ceil(currentMinute / step) * step;
            if (nextMinute <= currentMinute) {
                next.setHours(next.getHours() + 1);
                next.setMinutes(0);
            } else {
                next.setMinutes(nextMinute);
            }
        }

        // 다음 시간으로 이동
        if (parsed.hour.type === 'all') {
            // 현재 시간이 유효한 경우 유지
        } else if (parsed.hour.type === 'value') {
            if (next.getHours() > parsed.hour.value) {
                next.setDate(next.getDate() + 1);
            }
            next.setHours(parsed.hour.value);
        }

        // 다음 일로 이동
        if (parsed.day.type === 'all') {
            // 현재 일이 유효한 경우 유지
        } else if (parsed.day.type === 'value') {
            if (next.getDate() > parsed.day.value) {
                next.setMonth(next.getMonth() + 1);
            }
            next.setDate(parsed.day.value);
        }

        // 다음 월로 이동
        if (parsed.month.type === 'all') {
            // 현재 월이 유효한 경우 유지
        } else if (parsed.month.type === 'value') {
            if (next.getMonth() + 1 > parsed.month.value) {
                next.setFullYear(next.getFullYear() + 1);
            }
            next.setMonth(parsed.month.value - 1);
        }

        // 요일 확인
        if (parsed.weekday.type !== 'all') {
            const currentWeekday = next.getDay();
            const targetWeekday = parsed.weekday.type === 'value' ? parsed.weekday.value : 0;
            
            if (currentWeekday !== targetWeekday) {
                const daysToAdd = (targetWeekday - currentWeekday + 7) % 7;
                next.setDate(next.getDate() + daysToAdd);
            }
        }

        return next;
    }

    function getExpressionMeaning(parsed) {
        const meanings = [];

        // 분
        if (parsed.minute.type === 'all') {
            meanings.push('매 분');
        } else if (parsed.minute.type === 'value') {
            meanings.push(`${parsed.minute.value}분`);
        } else if (parsed.minute.type === 'step') {
            meanings.push(`${parsed.minute.step}분마다`);
        }

        // 시간
        if (parsed.hour.type === 'all') {
            meanings.push('매 시간');
        } else if (parsed.hour.type === 'value') {
            meanings.push(`${parsed.hour.value}시`);
        }

        // 일
        if (parsed.day.type === 'all') {
            meanings.push('매일');
        } else if (parsed.day.type === 'value') {
            meanings.push(`${parsed.day.value}일`);
        }

        // 월
        if (parsed.month.type === 'all') {
            meanings.push('매월');
        } else if (parsed.month.type === 'value') {
            meanings.push(`${parsed.month.value}월`);
        }

        // 요일
        if (parsed.weekday.type === 'value') {
            const weekdays = ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'];
            meanings.push(weekdays[parsed.weekday.value]);
        }

        return meanings.join(' ');
    }
}); 