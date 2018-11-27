<?php include __THEME__.'/header.php'; ?>
    <div id="list-item" class="col-md-4">
        <div class="post-list">
            <?php foreach ($result as $item):?>
            <div class="post-item" id="post-item-<?=$item['id']?>">
                <div class="col-md-12">
                    <div class="a-item" data-id="<?=$item['id']?>">
                    <div class="post-title">
                        <h4><?=$item['title']?></h4>
                    </div>
                    <div class="post-summary">
                        <p>
                            <?=$item['description']?$item['description']:mb_substr(strip_tags($item['content']),0,200, 'utf-8')?>
                        </p>
                    </div>
                    </div>
                    <div class="post-info">
                        <span><i class="czs-share"></i> <?=$item['links']!= 1 ?'<a href="/openlinks/'.$item['links'].'" target="_blank">'.$item['links'].'</a>':'暂无外链'?></span>
                        <span class="line"></span>
                        <span><i class="czs-category-l"></i> <a href="/admin/category/show/id/<?=$item['category_id']?>"><?=$category[$item['category_id']]?></a></span>
                        <span class="line"></span>
                        <span><i class="czs-time-plugin-l"></i> <?=date('Y-m-d H:i:s',$item['create_time'])?></span>
                        <span class="item-setting" data-id="<?=$item['id']?>"><i class="czs-setting-l"></i> 操作 <div class="dropdown-setting" id="dropdown-<?=$item['id']?>">
                            <a class="dropdown-item" href="/admin/article/write/id/<?=$item['id']?>"><i class="fa fa-fw fa-pencil-square-o"></i> 修改</a>
                            <a class="dropdown-item" onclick="action('/admin/base/action',<?=$item['id']?>,'star','content','收藏成功','取消收藏')"><i class="fa fa-fw fa-star"></i> <?=@$item['star'] == '0' ? '添加收藏':'取消收藏'?></a>
                                <a class="dropdown-item" onclick="action('/admin/base/action',<?=$item['id']?>,'link','content','外链生成啦','外链取消啦')"><i class="fa fa-fw fa-share-alt"></i> <?=$item['links']==1?'生成外链':'取消外链'?></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" onclick="action('/admin/base/action',<?=$item['id']?>,'del','content','创作删除成功','创作删除失败')"><i class="fa fa-fw fa-trash"></i> 删除创作</a>
                        </div></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="page-nav">
            <?php echo str_replace(['&laquo;','&raquo;'],['Previous page','Loading More'],@$page);   //输出分页代码 ?>
        </div>
    </div>
        <link rel="stylesheet" href="/static/markdown/css/editormd.preview.css" />
        <script src="/static/markdown/lib/marked.min.js"></script>
        <script src="/static/markdown/lib/prettify.min.js"></script>
        <script src="/static/markdown/editormd.js"></script>
    <div id="article-body" class="col-md-6">
        <div class="article-title">
            <h4>面朝大海春暖花开</h4>
            <p class="a-times">发布于：<span class="create-times">2018年8月10日16:41:10</span></p>
        </div>
        <div class="article-content">
            <div id="markdown" class="content">
<!--                <p>从明天起，做一个幸福的人</p>-->
<!--                <p>喂马，劈柴，周游世界</p>-->
<!--                <p>从明天起，关心粮食和蔬菜</p>-->
<!--                <p>我有一所房子，面朝大海，春暖花开</p>-->
<!--                <br>-->
<!--                <p>从明天起，和每一个亲人通信</p>-->
<!--                <p>告诉他们我的幸福</p>-->
<!--                <p>那幸福的闪电告诉我的</p>-->
<!--                <p>我将告诉每一个人</p>-->
<!--                <br>-->
<!--                <p>给每一条河每一座山取一个温暖的名字</p>-->
<!--                <p>陌生人，我也为你祝福</p>-->
<!--                <p>愿你有一个灿烂的前程</p>-->
<!--                <p>愿你有情人终成眷属</p>-->
<!--                <p>愿你在尘世获得幸福</p>-->
<!--                <p>我只愿面朝大海，春暖花开</p>-->
            </div>
        </div>
    </div>
    </div>
<?php include __THEME__.'/footer.php'; ?>