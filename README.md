## 文件上传模块

### 目标

    将文件上传到指定的存储介质中

### 现在的问题
1. composer 自动加载文件失败，tests目录下的文件都不能加载

2. queue类中单例化的对象失效了。

根源：laravel的work是一个独立的长期存在的进程，保存了laravel项目启动时的状态。而单例化的对象在一个服务容器中只存在一份，但是由于work是另一个服务容器，所以work中的单例对象是与之不同的对象，这意味着我们在服务容器中对单例对象做得修改是不会同步到worker中的。

3. 在通过container获取处理类实例对象时，如果传入的name对应的className不存在，那么返回null还是直接抛出异常。如果抛出异常那么，会立即终止上层程序的运行，如果返回null的话，上层调用时总是要判断返回的结果是不是null。

需要使用 `Artisan::call('queue:restart')`，但是显示该命令不存在?原因是在register方法中调用的时候，artisan还没被加载。
新思路 
1. 把closure存到某个文件中

2. 把处理数据部分的方法写到一个类中，让使用者实现规定好的方法 

    ---采用此方案
    步骤：  指定Contract
            实现基础实现类
            允许用户注册自定义处理数据类

 注册用户自定义的处理类

### 思路

1. 先实现web路由的文件的上传部分

    * 实现google drive 配置
    ---这个还是不实现的比较好，因为每个人的配置不一样
    * 测试现有的文件上传功能
    ---基本测试完成，还需要一些错误异常处理即可
    使用marco 魔术机制 将Storage指定的磁盘扩展方法
    ---Storage类无法使用macro机制扩展

2. 实现整合google drive 配置，避免下次手动配置

    * 使用artisan  command发布google drive的配置文件和对应的Service Provide文件，实现用户选择是否采用
    ---vendor：publish命令可以实现
    * 测试现有的文件上传功能

3. 可替代方案

    [spatie/laravel-medialibrary](https://github.com/spatie/laravel-medialibrary/blob/master/)但是该package并不能完全满足我们的需求。我们需要保存文件路径，还需要实现队列上传。再经过数据库表字段的比队之后，发现缺少文件路径字段，但是有collection_name字段，或许可以替代，但是他还多了多态多对一关联关系的字段，这两个字段是必填的。这和我们的附件表是相同的，但是和知识库的uploads表不同。如果用了这个package，那么知识库部分还需要重新开发。
    

3. 实现队列上传

    * 写队列work

    * 返回文件信息

4. 优化代码

    * 将Uploader类通用化处理，将disk解绑，从配置文件中读取
    
    * 队列worker解绑，只依赖注入ShouldQueue接口，让用户在配置文件中修改，或者在服务提供者中修改,或者使用容器的思想，将用户自定义的队列工作者注册到容器中。

5. 实现api路由的文件

### 收获

1. 使用getMetadata方法，可以通过id（path）获取到文件的元数据

### 使用说明

如果想要使用实现配置好的google drive，那么需要使用artisan command ，` php artisan vendor:publish --tag=uploads-google`,并且在app中注册 `App\Providers\GoogleDriveServiceProvider::class,`.

publish ServiceProvider 之后记得在config/app.php中注册

