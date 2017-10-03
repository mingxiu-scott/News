/**
 * Created by liyao on 2017/8/18.
 */
var login = {
  check : function () {
      var username = $('input[name="username"]').val();
      var password = $('input[name="password"]').val();

      var result = (!username || !password) ? (!username ? '用户名不能为空' : (!password ? '密码不能为空' : null)) : null;

      //可以加正则验证

      if (result)
      {
          dialog.error(result);
      }

      //准备数据和url提交给后台文件:

      var data = {
          username : username,
          password : password
      };

      var url = './admin.php?c=login&a=check';

      //使用ajax进行post请求
      $.post(url,data,function (res) {
          //将来后台会接收到打他,并返回以一个json格式的结果result
          if (res.status == 0)
          {
              dialog.error(res.message);
          }
          if (res.status == 1)
          {
              dialog.success(res.message,'./admin.php?c=index');
          }


      },'JSON');


  }
};