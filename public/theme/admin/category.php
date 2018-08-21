<?php include __THEME__.'/header.php'; ?>
    <div id="category" class="col-md-8">

        <div class="row category-list">
            <?php foreach ($data as $item): ?>
            <div class="col-md-4 category-item" id="post-item-<?=$item['id']?>">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="category-name"><?=$item['name']?></h5>
                        <p class="category-slug"><?=$item['slug']?></p>
                    </div>
                    <div class="flexbox text-center">
                        <span class="editcategory" data-toggle="quickview" data-id="<?=$item['id']?>">
                            <i class="czs-write-l"></i> 修改分类
                        </span>
                        <span class="text-muted" onclick="action('/admin/base/action',<?=$item['id']?>,'del','category','分类删除成功!','分类删除失败!')">
                            <i class="czs-trash-l"></i> 删除分类
                        </span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
<div id="category-edit" class="col-md-2">
<div class="row">
    <div class="category-body">
        <form class="quickview-block form-type-material" action="/admin/category/update" method="post">
            <input type="hidden" name="id" class="categoryid" value="">
            <div class="a-input col-md-12">
                <input type="text" class="category-name-input" name="name" placeholder="分类名称">
            </div>

            <div class="a-input col-md-12">
                <input type="text" class="category-slug-input" name="slug" placeholder="分类别名">
            </div>
            <div class="create-item col-md-12">
            <button type="submit">
                <i class="czs-write-l"></i> 提交分类
            </button>
            </div>
        </form>
    </div>
</div>
</div>
</div>
<?php include __THEME__.'/footer.php'; ?>