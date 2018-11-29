这是一个php webserver对接dueros oauth的guide。

# 如何run这个demo:

1. 你可以将本项目clone下来

2. 将schema.sql导入mysql

3. 在server.php中填入你的db连接信息

    $dsn      = 'mysql:dbname=XXX;host=XXX';
    
    $username = 'XXX';
    
    $password = 'XXX';
    
4. 把整个项目部署到php服务器上（推荐你买一个百度云bch主机，会很方便哦）

5. 为你的php网站开启https（如果你用的是百度云bch主机，需要申购一个免费ssl证书，然后开启即可）

6. 将你的网站信息填写到dueros的智能家居技能配置中

    授权地址：https://your.domain.name/authorize.php
    
    Client_Id: testclient
    
    Token地址： https://your.domain.name/token.php
    
    ClientSecret: testpass
    
    WebService: https://your.domain.name/bot.php

7. 为dueros写入一条oauth信息

    INSERT INTO oauth_clients (client_id, client_secret, redirect_uri) VALUES ("testclient", "testpass", "https://xiaodu.baidu.com/saiya/auth/xxxxxxxxxxxxx");

8. 在dueros配置页点击"保存"，"授权"然后输入一个用户名并点击确认

9. 在dueros测试页面或小度音箱上可以测试 "发现设备"，"打开吸顶灯", "关闭吸顶灯"灯指令啦

# 将代码集成到你自己的php项目中

1. 将这些代码都拷贝到你的项目中

2. 修改authorize.php将通过文本框输入获取userId的模式修改为从session中获取userId的模式。当然你也可以进一步改进UI交互体验。

3. 将bot.php中的发现设备/开灯/关灯的mock实现替换成你真正的控制设备的逻辑

4. 就这么简单

官方文档：http://bshaffer.github.io/oauth2-server-php-docs/cookbook/