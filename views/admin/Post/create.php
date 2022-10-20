<?php

/**
 * @var $this \app\core\View
 */
$this->title = "Add post";
?>


<div class="app-title">
    <div>
        <h1><i class="fa fa-tags"></i> Post</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="title">
            <h3 class="tile-title">Create Post</h3>
            <form action="/admin/posts/store" method="POST">
                <div class="tile-body">
                    <div class="form-group">
                        <label class="control-label" for="category">Category <span class="m-l-5 text-danger"></span></label>
                        <select name="category" id="category" class="form-control">
                            <?php foreach ($categories as $category) {
                                echo "<option value='$category[id]'>$category[name]</option>";
                            }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">Name <span class="m-l-5 text-danger"></span></label>
                        <input class="form-control" type="text" name="name" id="name" value="" />
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="status">Status</label>
                        <textarea class="form-control" rows="4" name="status" id="status"></textarea>
                    </div>
                </div>
                <div class="tile-footer">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Post</button>
                    &nbsp;&nbsp;&nbsp;
                    <a class="btn btn-secondary" href="{{ route('admin.categories.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>