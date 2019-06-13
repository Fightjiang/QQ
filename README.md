﻿## 本项目完成的功能有：

* 登录注册账号
* 增删好友功能
* 实现 Web 的点对点即时的文本消息聊天功能
* 实现本地消息的存储

## 技术支持

* 前端：Bootstrap 、Jquery 、JavaScript 、HTML 、 CSS
* 后端：Thinkphp3   

## 优化

* 好友发送消息的实时展示是通过 Ajax 方式来模拟实时的效果，在每次客户端和服务器端交互的时候都是一次 HTTP 的请求和应答的过程，而每一次的 HTTP 请求和应答都带有完整的 HTTP 头信息，这就增加了每次传输的数据量，会导致服务器压力大 。
* 后期有时间改用 HTML5 WebSocket 构建实时 Web 应用 。
* 