### SIMCU SWG - 服务代理系统

#### 支持的功能:
 1. 支持基于RBAC的HTTP服务访问控制
 2. 支持HTTP和HTTPS站点常规代理和负载均衡
 3. 支持TCP协议的常规代理和负载均衡
 
 
#### 使用方法:
 
 需要授权网关或者HTTP/HTTPS代理,请配合webproxy使用
 
 需要TCP代理服务,请配合TCPPROXY使用
 
 > docker run -d --name swg -p 8080:80  registry.simcu.com/www/swg/manager
