/**
 * Created by liyao on 2017/8/18.
 */
var dialog = {
    error : function (message) {
        layer.open({
           icon : 2,
            title : '错误提示',
            content : message
        });
    },

    success : function (message,url) {
        layer.open({
           icon : 1,
            title : '成功',
            content : message,
            yes : function () {
               location.href = url;
            }
        });

    }
};