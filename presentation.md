# Lemonade Guide Website - Project Presentation
## 柠檬水指南网站 - 项目展示

**Presenter / 演示者:** Pan Zitao

---

## 1. Project Overview & Key Features
## 项目概述与核心功能

**EN:** Good morning. Today I'm presenting my "Lemonade Guide" website. This is a fully functional, database-driven project that demonstrates a range of modern web development skills. The key features include:
*   **Secure User Authentication**: A complete login and registration system with client-side password encryption.
*   **AJAX-Powered Interactions**: Key functions like login, registration, and language switching are handled asynchronously, providing a smooth, modern user experience.
*   **Dynamic, Multi-language Content**: All text is loaded from a MySQL database, and the site supports English, Chinese, and German.

**ZH:** 早上好。今天我将展示我的“柠檬水指南”网站。这是一个功能齐全、由数据库驱动的项目，展示了一系列现代 Web 开发技能。其核心功能包括：
*   **安全的用户认证**: 包含客户端密码加密的、完整的登录与注册系统。
*   **AJAX 驱动的交互**: 登录、注册和语言切换等关键功能均通过异步处理，提供了流畅的现代化用户体验。
*   **动态、多语言内容**: 所有文本都从 MySQL 数据库加载，网站支持英语、中文和德语。

---

## 2. Fulfillment of Core Requirements (100 Points)
## 核心需求完成情况 (100分)

### Layout & Navigation | 布局与导航

**EN:** The project fulfills all layout requirements.
*   **Structure**: The layout consists of a full-width header and footer, with a three-column main section (Navigation, Content, Functions) as specified. This is achieved using CSS Flexbox in `index.css`.
*   **Sticky Sidebars**: Both the left navigation and right function sidebars use `position: sticky`, ensuring they remain visible while the user scrolls through the content.

**ZH:** 项目满足了所有的布局要求。
*   **结构**: 布局由全宽的页眉和页脚，以及一个三栏式的主体部分（导航、内容、功能区）组成，完全符合要求。这是通过 `index.css` 中的 CSS Flexbox 实现的。
*   **粘性侧边栏**: 左侧导航和右侧功能区都使用了 `position: sticky` 属性，确保用户在滚动内容时它们始终可见。

### Content & Security | 内容与安全

**EN:**
*   **Page Length & Login Protection**: All content pages are long enough to require scrolling. Access is protected by a session check in each PHP file, which redirects unauthenticated users to `login.html`.
*   **Client-Side Encryption**: To enhance security, the user's password is never sent in plain text. In `login.js` and `register.js`, the password is encrypted using a Vigenère cipher before being sent to the server via an AJAX request.
*   **Server-Side Verification**: The `login.php` script receives the encrypted password. It then fetches the plain-text password from the database, applies the *exact same* encryption, and only grants access if the two encrypted strings match. This is a secure verification method.
*   **Citing Sources**: The `Thanks.php` page explicitly gives credit to Pexels.com for all images, fulfilling the critical requirement to cite external materials.

**ZH:**
*   **页面长度与登录保护**: 所有内容页面都足够长，需要滚动浏览。每个 PHP 文件开头的会话检查保护了页面访问，未登录的用户会被重定向到 `login.html`。
*   **客户端加密**: 为增强安全性，用户的密码绝不会以明文形式传输。在 `login.js` 和 `register.js` 中，密码在通过 AJAX 请求发送到服务器前，会使用维吉尼亚密码进行加密。
*   **服务器端验证**: `login.php` 脚本接收加密后的密码。然后，它从数据库中获取明文密码，应用完全相同的加密算法，只有当两个加密字符串匹配时才授权访问。这是一种安全可靠的验证方法。
*   **引用来源**: `Thanks.php` 页面明确地将所有图片的功劳归于 Pexels.com，满足了引用外部材料的关键要求。

---

## 3. Upgrades & Additional Points (95 Points)
## 附加功能与加分项 (95分)

### Data-Driven Content & Session Management (25P)
### 数据驱动内容与会话管理 (25分)

**EN:**
*   **Content from Database (15P)**: All text on the site is dynamic. The `translations.php` script fetches content from the `translations` table based on the current session language (`$_SESSION['lang']`), making the site fully database-driven.
*   **Session Management (10P)**: The project features robust session management, including a 15-minute inactivity timeout that automatically logs the user out for security.

**ZH:**
*   **内容来自数据库 (15P)**: 网站上的所有文本都是动态的。`translations.php` 脚本根据当前的会话语言 (`$_SESSION['lang']`) 从 `translations` 表中获取内容，使网站完全由数据库驱动。
*   **会话管理 (10P)**: 项目具有强大的会话管理功能，包括一个15分钟无活动自动登出的安全机制。

### Advanced Features & Interactivity (35P)
### 高级功能与交互性 (35分)

**EN:**
*   **Advanced Encryption (10P)**: I used the Vigenère cipher, which is a polyalphabetic cipher and significantly more secure than a basic Caesar cipher.
*   **AJAX Usage (10P)**: AJAX is used extensively. Not only for login and registration, but also for the language switching feature. In `language_switcher.js`, a `fetch` request is sent to `switch_language.php` to update the session without a full page navigation, followed by a `location.reload()` to display the new content. This demonstrates a practical and effective use of AJAX.
*   **Dynamic DOM Access (15P)**: This is clearly demonstrated in `language_switcher.js`. The script uses `document.querySelectorAll` to find all language buttons, `forEach` to iterate over them, and `addEventListener` to dynamically attach click handlers. Inside the handler, `event.preventDefault()` is used to stop the browser's default action. This is a textbook example of dynamically manipulating the DOM.

**ZH:**
*   **高级加密 (10P)**: 我使用了维吉尼亚密码，这是一种多表代换密码，比基础的凯撒密码要安全得多。
*   **AJAX 使用 (10P)**: AJAX 被广泛使用。不仅用于登录和注册，还用于语言切换功能。在 `language_switcher.js` 中，一个 `fetch` 请求被发送到 `switch_language.php` 以在后台更新会话，随后通过 `location.reload()` 显示新内容。这展示了对 AJAX 实用且高效的应用。
*   **动态访问DOM (15P)**: 这在 `language_switcher.js` 中得到了清晰的展示。该脚本使用 `document.querySelectorAll` 查找所有语言按钮，通过 `forEach` 遍历它们，并使用 `addEventListener` 动态地附加点击事件。在事件处理函数中，`event.preventDefault()` 被用来阻止浏览器的默认行为。这是动态操控 DOM 的教科书级范例。

### Languages, Design & Documentation
### 语言、设计与文档

**EN:**
*   **More than 2 Languages**: The site supports English, Chinese, and German.
*   **Responsive Design**: The site is responsive. `index.css` uses Flexbox for the main layout, and other pages like `Tips.php` use CSS Grid with `repeat(auto-fit, ...)` to ensure the layout adapts gracefully to different screen sizes.
*   **Documentation**: The project is well-documented with a comprehensive `README.md` file and clear, descriptive comments at the top of every single PHP, JS, and CSS file.

**ZH:**
*   **超过2种语言**: 网站支持英语、中文和德语。
*   **自适应设计**: 网站是自适应的。`index.css` 使用 Flexbox 进行主布局，而像 `Tips.php` 这样的页面则使用带有 `repeat(auto-fit, ...)` 的 CSS Grid，以确保布局能够优雅地适应不同的屏幕尺寸。
*   **文档 (10P)**: 项目文档齐全，包含一个全面的 `README.md` 文件，并且每个 PHP、JS 和 CSS 文件的顶部都有清晰的描述性注释。