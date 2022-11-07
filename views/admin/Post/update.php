<?php

/**
 * @var $this \app\core\View
 */
$this->title = "Update post";
?>


<div class="app-title">
    <div>
        <h1><i class="fa fa-tags"></i> Post</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="title">
            <h3 class="tile-title">Update Post</h3>
            <form action="/admin/posts/update" method="POST">
                <div class="tile-body">
                    <div class="form-group">
                        <label class="control-label" for="name">Name <span class="m-l-5 text-danger"></span></label>
                        <input class="form-control" type="text" name="name" id="name" value="<?php echo $post['name'] ?>" />
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="status">Status</label>
                        <textarea class="form-control" rows="4" name="status" id="status"></textarea>
                    </div>
                </div>
                <input type="hidden" name="id" value="<?php echo $post['id'] ?>">
                <div class="tile-footer">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Post</button>
                    &nbsp;&nbsp;&nbsp;
                    <a class="btn btn-secondary" href="{{ route('admin.categories.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>