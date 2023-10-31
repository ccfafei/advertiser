#!/bin/bash

#初始化mysql密码 
function init_passwd()
{
	result="`grep 'temporary password' /var/log/mysqld.log`"
	p1="`echo $result |awk '{print $NF}'`"
	read -p "请输入数据库密码：" num1
	read -s -p "请输入数据库密码：" num2
	if [ $num1 = $num2 ];then
		mysqladmin -uroot -p"$p1" password "$num1" 
		echo "passwd change successful"
		mysql -uroot -p$num1
	else
		echo "两次输入密码不一致"
		exit 0

	fi
}

# 先更新源
yum -y update

# 添加 nginx 源
echo "开始安装nginx"
rpm -ivh http://nginx.org/packages/centos/7/noarch/RPMS/nginx-release-centos-7-0.el7.ngx.noarch.rpm
yum -y install nginx
systemctl start nginx 

# 安装php
echo "开始安装php"
rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm 
rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm
yum -y install http://rpms.remirepo.net/enterprise/remi-release-7.rpm
yum -y install yum-utils
yum-config-manager --enable remi-php73
yum -y install php  php-cli php-common php-zip php-devel php-embedded php-fpm php-gd php-mbstring php-mysqlnd php-opcache php-pdo php-xml php-pecl-mongodb php-curl  php-bcmath php-gmp  php-pear
systemctl start php-fpm
systemctl enable php-fpm

# 安装mysql
rpm --import https://repo.mysql.com/RPM-GPG-KEY-mysql-2022
wget -i -c http://dev.mysql.com/get/mysql57-community-release-el7-10.noarch.rpm
yum -y install mysql57-community-release-el7-10.noarch.rpm
yum -y install mysql-community-server
systemctl start mysqld
systemctl enable mysqld

#初始化mysql密码
init_passwd
