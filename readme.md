### SIMCU SWG - 服务代理系统

#### 支持的功能:
 1. 支持基于RBAC的HTTP服务访问控制
 2. 支持HTTP和HTTPS站点常规代理和负载均衡
 3. 支持TCP协议的常规代理和负载均衡
 
 
#### 使用方法:
 
 > 你需要一个mysql服务器和Docker即可快速运行
 
 > docker run -d --name swg --net host -e [具体环境变量如下] registry.simcu.com/www/swg/aio

如果设置了 ADMIN_DOMAIN 将域名指向容器,直接访问域名即可
如果没有域名, 不要设置 ADMIN_DOMAIN 直接访问容器5233端口即可
 
#### 环境变量说明:
 
 - 任何服务必须配置的变量
 
 > REDIS_HOST=REDIS服务地址

 > REDIS_PORT=REDIS端口

 > REDIS_PASSWORD=REDIS密码(没有请不要设置)
 
 - 管理后台需要多配置
 
 > APP_NAME=管理后台显示的名称

 > ADMIN_DOMAIN=管理后台绑定的域名(设置了之后,会自动使用nginx代理到80端口,不设置就访问5233端口)

 > DB_HOST=MYSQL主机

 > DB_PORT=MYSQL端口

 > DB_DATABASE=MYSQL数据库(utf8_mb4)

 > DB_USERNAME=MYSQL用户

 > DB_PASSWORD=MYSQL密码
 
 
#### 容器运行参数说明
 本容器包含以下组件:
 1. openresty - 用于代理网关,web代理和负载均衡
 2. haproxy - 用于TCP的代理和负载均衡
 3. admin - 基于laravel开发的配置文件管理系统
 4. redis - 开放与 127.0.0.1:6379的redis
 容器默认运行
 > php artisan swg
 
 这是一个ALL IN ONE的启动模式,系统将会启动所有组件,当然你可以按需启动实现多种玩法,注意根据上文配置好环境变量.
 
 1. 只启动HTTP代理和网关服务
 > php artisan swg --http

 2. 指启动TCP代理负载均衡
 > php artisan swg --tcp

 3. 只启动管理平台
 > php artisan swg --admin

 4. 启动内置Redis
 > php artisan swg --redis

 5. 支持随意的混合启动
 > php artisan swg --redis --admin --tcp

 6. 更多请看:
 > php artisan swg -h


#### 关于端口的说明
 1. admin 服务会占用掉 0.0.0.0:80和127.0.0.1:9000端口
 2. http 服务会占用0.0.0.0:80和0.0.0.0:443端口
 3. redis 会占用127.0.0.1:6379

 多个服务之间的端口并不冲突.

#### 其他

 1. 关于分布式部署
 很简单,只需要在外边搭建一个REDIS,设置好REDIS地址,既可. TCP和HTTP代理可以分别开放不同的数据量

 2. 关于整体运作
 核心依靠REDIS, 只要redis不挂,HTTP和TCP就能正常工作. ADMIN和数据库只是为了持久化配置和同步配置用,只需要一份足以,不需要过多部署.

 3. 关于容器中TCP代理
 建议容易使用--net host 模式,除非你很确定你要代理的端口是多少,否则一律建议使用主机网络模式.