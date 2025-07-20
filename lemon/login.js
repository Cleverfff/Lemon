document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login-form');
    const errorMessage = document.getElementById('error-message');

    loginForm.addEventListener('submit', function(event) {
        // 1. 阻止表单的默认提交行为 (防止页面刷新)
        event.preventDefault();

        // 2. 获取用户输入
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        // 3. 对密码进行一个简单的凯撒密码加密 (向右移动3位)
        // 这是一个非常基础的加密，仅用于演示目的。
        // 'password' -> 'sdvvzrug'
        const shift = 3;
        let encryptedPassword = "";
        for (let i = 0; i < password.length; i++) {
            let charCode = password.charCodeAt(i);
            // 只加密字母
            if (charCode >= 97 && charCode <= 122) { // a-z
                charCode = ((charCode - 97 + shift) % 26) + 97;
            } else if (charCode >= 65 && charCode <= 90) { // A-Z
                charCode = ((charCode - 65 + shift) % 26) + 65;
            }
            encryptedPassword += String.fromCharCode(charCode);
        }

        // 4. 使用 fetch API 将数据发送到服务器
        fetch('login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                username: username,
                password: encryptedPassword // 发送加密后的密码
            })
        })
        .then(response => response.json())
        .then(data => {
            // 5. 处理服务器返回的结果
            if (data.success) {
                // 登录成功，跳转到主页
                window.location.href = 'index.php';
            } else {
                // 登录失败，显示错误信息
                errorMessage.textContent = data.message || 'Invalid username or password.';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            errorMessage.textContent = 'An error occurred. Please try again.';
        });
    });
});