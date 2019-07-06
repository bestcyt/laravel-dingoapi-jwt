# laravel-dingoapi-jwt
结合了dingo和jwt的一个laravel的利用token实现的用户注册登录更新资料删除的小demo


主要用到 api.php AuthController 还有一些别的request验证等

参考的jwt知识在
https://learnku.com/articles/10885/full-use-of-jwt#16e5ad  

https://learnku.com/articles/10889/detailed-implementation-of-jwt-extensions#4849a0

可在postman上测试

注册：http://laravel-dingoapi-jwt.test/api/auth/register   post带上name，email,password三个参数

登录：http://laravel-dingoapi-jwt.test/api/auth/login  post参数同上
 
查看用户：http://laravel-dingoapi-jwt.test/api/auth/me  get, header带上token

刷新token：http://laravel-dingoapi-jwt.test/api/auth/refresh  get

更新：http://laravel-dingoapi-jwt.test/api/auth/update  patch ,带个name

删除：http://laravel-dingoapi-jwt.test/api/auth/users/3  delete
