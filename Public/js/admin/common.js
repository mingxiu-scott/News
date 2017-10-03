/**
 * Created by liyao on 2017/8/22.
 */


$('#button-add').click(function () {

    var url = SCOPE.add_url;
    window.location.href = url;
});

$("#cms-button-submit").click(function () {

    //获取前端界面的表单数据:
    var dataArray = $('#cms-form').serializeArray();

    // console.log(dataArray);


    var data = {};

    $.each(dataArray, function () {
        //this是每一次遍历出来的对象
        data[this.name] = this.value;
    });

    $.post(SCOPE.save_url, data, function (res) {

        if (res.status == 1) {
            return dialog.success(res.message, SCOPE.jump_url);
        }
        if (res.status == 0) {
            return dialog.error(res.message);
        }
    }, "JSON")
});

//删除按钮点击事件

$(".cms-table #cms-delete").click(function () {

    var id = $(this).attr('attr-id');
    // var status = $(this).attr("attr-status");
    //删除是指将数据库里的这个id对应的status改为-1

    var data = {
        id: id,
        status: -1
    };

    // console.log(data);
    layer.open({
        icon: 2,
        title: '提示',
        btn: ['yes', 'no'],
        content: '确认删除吗?',
        yes: function () {
            toDelete(data);
        }
    });
});

function toDelete(data) {
    $.post(SCOPE.delete_url, data, function (res) {
        if (res.status == 1) {
            dialog.success(res.message, SCOPE.jump_url);
            return;
        }
        if (res.status == 0) {
            dialog.error(res.message);
            return;
        }
    }, 'JSON');
}

//编辑 方法
$('.cms-table #cms-edit').click(function () {

    var id = $(this).attr('attr-id');

    console.log(id);
    //跳转到后端的Menu的edit方法
    location.href = SCOPE.edit_url + "&id=" + id;
});

//点击更新排序
$("#button-listorder").click(function () {
    //去更新当前Menu_id的listorder的值

    // var arr = $('input[name*="listorder"]');

    var dataArray = $("#cms-listorder").serializeArray();

    // console.log(dataArray);

    var data = {};
    $.each(dataArray, function () {
        data[this.name] = this.value;
    });

    $.post(SCOPE.listorder_url, data, function (res) {
        if (res.status == 1) {
            dialog.success(res.message, SCOPE.jump_url);
        }
        if (res.status == 0) {
            dialog.error(res.message);
        }
    }, "JSON");
});

//
// $('.form-control').on('change',function () {
//     var id = this.value;
//     window.location.href = './admin.php?c=positioncontent&a=index&position_id='+id;
// });

$('#cms-push').click(function () {

    var id = $('#select-push').val();
    if (id == 0)
    {
        return dialog.error('请选择推荐位');
    }

    var pushData = {};
    var postData = {};
    //被选中的checkbox, 获取value
    $.each($('input[name="pushcheck"]:checked'),function (i) {
        pushData[i] = $(this).val();
    });

    postData['newsIDs'] = pushData;
    postData['position_id'] = id;

    // console.log(postData)

    $.post(SCOPE.push_url,postData,function (res) {

        if (res.status == 1)
        {
            return dialog.success(res.message,SCOPE.jump_url);
        }
        if (res.status == 0)
        {
            return dialog.error(res.message);
        }


    },'JSON');


});
