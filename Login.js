const express = require('express');
const mysql = require('mysql2/promise');
const bcrypt = require('bcryptjs');
const bodyParser = require('body-parser');

const app = express();
app.use(bodyParser.json());

// 数据库连接配置
const dbConfig = {
    host: 'localhost',
    user: 'your_mysql_user',
    password: 'your_mysql_password',
    database: 'your_database_name'
};

// 注册接口：加密密码并存储
app.post('/register', async (req, res) => {
    const { username, password } = req.body;
    if (!username || !password) return res.status(400).json({ msg: '缺少用户名或密码' });

    const hashedPassword = await bcrypt.hash(password, 10);
    const conn = await mysql.createConnection(dbConfig);
    try {
        await conn.execute('INSERT INTO users (username, password) VALUES (?, ?)', [username, hashedPassword]);
        res.json({ msg: '注册成功' });
    } catch (err) {
        res.status(500).json({ msg: '注册失败', error: err.message });
    } finally {
        await conn.end();
    }
});

// 登录接口：验证密码
app.post('/login', async (req, res) => {
    const { username, password } = req.body;
    if (!username || !password) return res.status(400).json({ msg: '缺少用户名或密码' });

    const conn = await mysql.createConnection(dbConfig);
    try {
        const [rows] = await conn.execute('SELECT password FROM users WHERE username = ?', [username]);
        if (rows.length === 0) return res.status(401).json({ msg: '用户不存在' });

        const isMatch = await bcrypt.compare(password, rows[0].password);
        if (isMatch) {
            res.json({ msg: '登录成功' });
        } else {
            res.status(401).json({ msg: '密码错误' });
        }
    } catch (err) {
        res.status(500).json({ msg: '登录失败', error: err.message });
    } finally {
        await conn.end();
    }
});

app.listen(3000, () => {
    console.log('Server running on http://localhost:3000');
});