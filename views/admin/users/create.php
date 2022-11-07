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
            <h3 class="tile-title">Create Admin Users</h3>
            <form action="/admin/users/store" method="POST">
                <div class="tile-body">
                    <div class="form-group">
                        <label for="control-label" for="role">Select Roles</label>
                        <select name="role" id="role">
                            <?php foreach ($roles as $role) : ?>
                                <option value="<?php echo $role["id"] ?>"><?php echo $role["name"] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">Name <span class="m-l-5 text-danger"></span></label>
                        <input class="form-control" type="text" name="name" id="name" value="" maxlength="50" />
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="email">Email <span class="m-l-5 text-danger"></span></label>
                        <input class="form-control" type="text" name="email" id="email" value="" maxlength="50" />
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password">Password</label>
                        <input class="form-control" type="password" name="password" id="password" maxlength="50"></input>
                    </div>
                </div>
                <div class="tile-footer">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Category</button>
                    &nbsp;&nbsp;&nbsp;
                    <a class="btn btn-secondary" href="{{ route('admin.categories.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>