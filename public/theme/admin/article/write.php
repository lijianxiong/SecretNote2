<?php include __THEME__.'/header.php'; ?>
    <style>
        .note-body {
            margin: 0;
            width: 100%;
            height: 100vh;
            overflow: overlay;
        }
    </style>
<div id="write-item" class="col-md-10">
    <link rel="stylesheet" href="/static/markdown/css/editormd.css" />
    <div id="layout">
        <form action="/admin/article/update" method="post">
            <input type="hidden" name="id" value="<?=$data['id']?>">
        <div class="c-title a-input">
            <input class="form-control" name="title" type="text" value="<?=$data['title']?>" placeholder="输入创作标题">
        </div>
            <div class="c-category a-input">
                <select name="category_id">
                    <?php foreach ($userCategory as $item): ?>
                    <option value="<?=$item['id']?>" <?=$data['category_id'] == $item['id'] ? 'selected' :''?>><?=$item['name']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        <div class="c-time a-input">
            <input class="form-control" name="create_time" type="text" value="<?=$data['create_time']?>" placeholder="输入创作时间">
        </div>
        <div class="c-desc a-input">
            <input type="text" class="form-control" name="description" placeholder="输入简介内容建议200文字以内..." value="<?=$data['description']?>">
        </div>
        <div id="test-editormd" class="a-input">
            <textarea style="display:none;" name="content"><?=$data['content']?></textarea>
        </div>
        <div class="a-submit create-item">
            <button type="submit"> 发布创作</button>
        </div>
        </form>
    </div>

    <!-- Latest compiled and minified JavaScript -->
    <script src="/static/markdown/editormd.js"></script>
    <script type="text/javascript">
        let testEditor;
        $(function() {
            testEditor = editormd("test-editormd", {
                width: "100%",
                height: '60vh',
                path : '/static/markdown/lib/',
                codeFold : true,
                saveHTMLToTextarea : true,
                searchReplace : true,
                htmlDecode : "style,script,iframe|on*",
                imageUpload : true,
                imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                imageUploadURL : "/admin/base/upload",
            });
        });
    </script>
</div>
<?php include __THEME__.'/footer.php'; ?>