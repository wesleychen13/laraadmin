## 后台截图

## 安装

- git clone 到本地
- 执行 `composer install` 创建好数据库
- 配置 **.env** 中数据库连接信息,没有.env请复制.env.example命名为.env
- 执行 `php artisan key:generate`
- 执行 `php artisan migrate`
- 执行 `php artisan db:seed`
- 执行 `php artisan passport:install`
- storage下所有目录 和 bootstrap/cache 目录应该是可写的
- 键入 '域名/admin/login'(后台登录)
- 用户名：admin；密码：admin

- 生成文档 apidoc -i app/Http/Controllers/Api/V1 -o public/apidoc
- api文档在public/apidoc里面, 也可以看上面的 `在线api文档`


## 图片上传widget  

##### 本地上传
- 单文件
 {!!  widget('Tools.ImgUpload')->single2('avatar','data[avatar]',isset($data['avatar'])? $data['avatar'] : "",'avatar'),[]!!}
 
- 多文件
 {!!  widget('Tools.ImgUpload')->multi2('avatar','data[avatar]',isset($data['avatar'])? $data['avatar'] : "",'avatar') !!}
 
   参数说明：  $id： 选择器ID, 
             $name： name值, 
             $file： value值, 
             $folder： 图片保存文件夹, 
             $option = [] 
                可选值：position：文件保存位置（local：本地(默认值)，alioss:阿里云）
                       width: 图片最大宽度
                       height: 图片最大高度
                       maxSize： 图片最大（kb）
                       maxCount：允许上传的最大图片张数（多文件有效）
 
##### 选择图片
- 单文件
 {!!  widget('Tools.ImgUpload')->single('avatar','data[avatar]',isset($data['avatar'])? $data['avatar'] : "",) !!}
 
- 多文件
 {!!  widget('Tools.ImgUpload')->multi('avatar','data[avatar]',isset($data['avatar'])? $data['avatar'] : "",[]) !!}
 
 
 
 ##富文本编辑器
 {!! editor('local') !!}
 <script id="container" name="content" type="text/plain">{{ $data['content'] or ''}}</script>

