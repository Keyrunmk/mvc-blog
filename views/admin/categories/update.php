<?php

/**
 * @var $this \app\core\View
 */
$this->title = "Create category";
?>


<div class="app-title">
    <div>
        <h1><i class="fa fa-tags"></i> Category</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="tile">
            <h3 class="tile-title">Create Category</h3>
            <form action="/admin/category/update" method="POST">
                <div class="tile-body">
                    <div class="form-group">
                        <label class="control-label" for="name">Name <span class="m-l-5 text-danger"></span></label>
                        <input class="form-control" type="text" name="name" id="name" value="<?php echo $category->name ?>" />
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="description">Description</label>
                        <textarea class="form-control" rows="4" name="description" id="description"></textarea>
                    </div>
                </div>
                <input type="hidden" name="id" value="<?php echo $category->id ?>">
                <div class=" tile-footer">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Category</button>
                    &nbsp;&nbsp;&nbsp;
                    <a class="btn btn-secondary" href="{{ route('admin.categories.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>