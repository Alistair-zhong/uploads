## 文件上传模块

### 目标

    将文件上传到指定的存储介质中

### 现在的问题
composer 自动加载文件失败，tests目录下的文件都不能加载

### 思路

1. 先实现web路由的文件的上传部分

    * 实现google drive 配置

    * 测试现有的文件上传功能

    使用marco 魔术机制 将Storage指定的磁盘扩展方法

2. 实现整合google drive 配置，避免下次手动配置

    * 使用artisan  command发布google drive的配置文件和对应的Service Provide文件，实现用户选择是否采用

    * 测试现有的文件上传功能

3. 实现队列上传

    * 写队列work

4. 实现api路由的文件

    