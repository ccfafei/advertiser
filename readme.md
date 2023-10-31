## <p align="center">自媒体业务管理系统</p>



### 系统介绍

该系统主要采用Laravel-admin开发的多媒体业务管理系统，有以下功能：

- 客户管理： 主要是录入自己的客户资料.
- 网络/微信/微博 媒体管理: 主要包括媒体录入、导出、查询等.
- 业务流量表: 主要是录入媒体报价、客户回款情况等.
- 财务管理：分类统计入款、出款情况。
- 权限管理: 后台用户使用的权限.
- 日志查询： 查询操作日志



### 系统结构
- Laravel-admin version :5.5
- Mysql version: 5.7
- PHP7.3
- Linux系统
- Nginx服务器

### 安装步骤

1. 下载源码到网站目录/var/www
```code
  cd /var/www
  git clone https://github.com/ccfafei/advertiser
```
2. 安装系统环境 php/mysql/nginx
```code
  cd ./advertiser
  ./install-php.sh
```

3. 配置nginx
```code
vim /etc/nginx/conf.d/advertiser.conf


server {
    listen       8080;
    server_name  localhost;
    root   /var/www/advertiser/public;
    index  index.php index.html index.htm;
    #charset koi8-r;
    
    #access_log /dev/null;
    access_log  /var/log/nginx/access.log  main;
    error_log  /var/log/nginx/error.log  warn;
    location / {
       try_files $uri $uri/ /index.php?$query_string;
    }   
    #error_page  404              /404.html;

    # redirect server error pages to the static page /50x.html
    #
    error_page   500 502 503 504  /50x.html;
    location = /50x.html {
        root   /usr/share/nginx/html;
    }

    # proxy the PHP scripts to Apache listening on 127.0.0.1:80
    #
    #location ~ \.php$ {
    #    proxy_pass   http://127.0.0.1;
    #}


    # pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
    #
   location ~ \.php(.*)$ {
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_split_path_info  ^((?U).+\.php)(/?.+)$;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        fastcgi_param  PATH_INFO  $fastcgi_path_info;
        fastcgi_param  PATH_TRANSLATED  $document_root$fastcgi_path_info;
        include        fastcgi_params;
   }

}


```

5. 创建数据库
````code
  mysql -uroot -p
  CREATE DATABASE `advertiser` CHARACTER SET utf8;  
````

6. 迁移数据
```code
 cd /var/www/advertiser
 php artisan migrate
 php artisan db:seed
```
7. 启动服务
```code
systemctl restart mysqld
systemctl restart nginx
```
8. 访问网站
```
http://localhost:8080
用户名:admin
密码:123456
```

