function timestampToTime(timestamp) {
    var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
    Y = date.getFullYear() + '-';
    M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
    D = date.getDate() + ' ';
    h = date.getHours() + ':';
    m = date.getMinutes() + ':';
    s = date.getSeconds();
    return Y+M+D+h+m+s;
}
function geturlvar(variable) {
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split("=");
        if (pair[0] == variable) {
            return pair[1];
        }
    }
    return (false);
}
// $('.item-setting').click(
//     function () {
//         let id = $(this).data('id');
//         let item = $('#dropdown-'+id);
//         toggleItem(item);
//     }
// );
$('.post-list').on('click', '.item-setting', function () {
    let id = $(this).data('id');
    let item = $('#dropdown-'+id);
    toggleItem(item);
});
$('.user-info').click(
    function () {
        let dropdownUser = $('.dropdown-user');
        toggleItem(dropdownUser);
    }
);
$('.post-list').on('click', '.a-item', function () {
    $(".content").remove();
    setTimeout(function(){$(".article-content").prepend("<div id='markdown' class='content'></div>");},10);
    let id = $(this).data('id');
    $.post("/admin/article/show", {
        'id': id
    }, function (data) {
        let item = JSON.parse(data);
        let testEditormdView;
        testEditormdView = editormd.markdownToHTML("markdown", {
            markdown        : item.content ,
            htmlDecode      : "style,script,iframe",
        });
        $('.article-title h4').html(item.title);
        $('.create-times').html(timestampToTime(item.create_time));
    });
});
$('#article-body,.sidebar,#write-item,#layout').click(
    function () {
        $('.dropdown-setting').css('display','none');
        $('.dropdown-user').css('display','none');
    }
);
function toggleItem(item) {
    if (item.css("display") == "none") {
        item.css('display','block');
    }else{
        item.css('display','none');
    }
}
$('.editcategory').click(
    function () {
        let id = $(this).data("id");
        $.post("/admin/category/edit/id",{
            'id' :id
        },function (data) {
            if (data){
                $('.categoryid').val(data.id);
                $('.category-name-input').val(data.name);
                $('.category-slug-input').val(data.slug);
            }
            else{
                showtips('请求出错，请重试!')
            }
        });
    }
);
function showtips(value) {
    $('.t-info').text(value);
    $('#tips').show(500);
    setTimeout(function(){$('#tips').hide(500)},2000);
}
function showreload(value) {
    $('.t-info').text(value);
    $('#tips').show(500);
    setTimeout(function(){location.reload();},2000);
}
function action(url,id,type,dbname,success,error) {
    $.post(url,
        {
            'id':id,
            'type':type,
            'dbname':dbname
        },function (data) {
            console.log(data);
            if(data == 1){
                if (type == 'del' || type == 'destroy') {
                    $('#post-item-'+id).hide(300);
                    showtips(success);
                }
                else if(type == 'star'){
                    showtips(success);
                }
                else{
                    showreload(success);
                }
            }else{
                console.log('操作失败');
                showreload(error);
            }
        }
    );
}
$(function(){
    //点击加载更多
    $('.pager li:nth-child(2) a').click(function() {
        let hrefThis = $(this);
        hrefThis.addClass('loading').text("正在努力加载"); //给a标签加载一个loading的class属性，可以用来添加一些加载效果
        let pageHref = hrefThis.attr("href"); //获取下一页的链接地址
        if (pageHref) { //如果地址存在
            $.ajax({ //发起ajax请求
                url: pageHref, //请求的地址就是下一页的链接
                type: "get", //请求类型是get
                error: function(request) {
                    alert('网络错误，请求失败!');
                },
                success: function(data) { //请求成功
                    $('.pager li:nth-child(1) a').remove();
                    hrefThis.removeClass('loading').text("Loading More"); //移除loading属性
                    let result = $(data).find(".post-list .post-item"); //从数据中挑出文章数据，请根据实际情况更改
                    $('.post-list').append(result); //将数据加载加进nobita-content的标签中。
                    let newHref = $(data).find(".pager li:nth-child(2) a").attr("href"); //找出新的下一页链接
                    if (newHref) {
                        hrefThis.removeClass('loading').attr("href", newHref); //移除loading属性
                    } else {
                        $(".pager li:nth-child(2) a").remove(); //如果没有下一页了，隐藏
                        $(".pager li:nth-child(2)").text('没有更多数据了');
                    }
                    return false;
                }
            });
        }
        return false;
    });
});