<?php include __THEME__.'/header.php'; ?>
    <div id="setting" class="col-md-10">

        <div class="setting-list card">
            <form action="/admin/setting/update" method="post">
            <div class="row">
            <div class="col-md-6">
            <div class="setting-name a-input col-md-12">
                网站名称:
                <input type="text" name="site_name" value="<?=$data['site_name']?>">
            </div>
            <div class="admin-email a-input col-md-12">
                管理员E-mail:
                <input type="email" name="admin_email" value="<?=$data['admin_email']?>">
            </div>
            <div class="web-url a-input col-md-12">
                网站地址:
                <input type="url" name="web_url" value="<?=$data['web_url']?>">
            </div>
                <div class="description a-input col-md-12">
                    站点关键词:
                    <input type="text" name="keyword" value="<?=@$data['keyword']?>">
                </div>
            <div class="description a-input col-md-12">
                网站介绍:
                <input type="text" name="description" value="<?=$data['description']?>">
            </div>
            <div class="icp a-input col-md-12">
                网站备案号:
                <input type="text" name="icp" value="<?=$data['icp']?>">
            </div>
            </div>
            <div class="col-md-6">
            <div class="a-input col-md-12">
                邮件服务器:
                    <input type="text" name="host" placeholder="请输入邮件服务器" value="<?=$data['host']?>">
            </div>
            <div class="a-input col-md-12">
                邮箱登录名:
                    <input type="text" name="username" placeholder="请输入登录名" value="<?=$data['username']?>">
            </div>
            <div class="a-input col-md-12">
                邮箱发信密码:
                    <input type="password" name="password" placeholder="请输入密码" value="<?=$data['password']?>">
            </div>
            <div class="a-input col-md-12">
                邮箱端口号:
                    <input type="number" name="port" placeholder="请输入端口" value="<?=$data['port']?>">
            </div>
            <div class="a-input col-md-12">
                发送人名称:
                    <input type="text" name="nickname" placeholder="请输入发送人名称" value="<?=$data['nickname']?>">
            </div>
            <div class="a-input col-md-12">
                邮箱加密类型:
                    <input type="text" name="secure" placeholder="请输入加密类型" value="<?=$data['secure']?>">
            </div>
            </div>
            </div>
            <div class="create-item col-md-12" style="text-align: center;border-top: 1px solid #eee;padding: 30px 0px 0px 0px;">
                <button type="submit">
                    <i class="czs-write-l"></i> 提交修改
                </button>
            </div>
            </form>
        </div>

    </div>
<?php include __THEME__.'/footer.php'; ?>