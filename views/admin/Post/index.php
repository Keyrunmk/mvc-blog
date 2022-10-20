<?php

/**
 * @var $this \app\core\View
 */
$this->title = "Posts";
?>

<div class="app-title">
    <div>
        <h1><i class="fa fa-tags"></i> Posts</h1>
    </div>
    <a href="/admin/posts/create" class="btn btn-primary pull-right">Add Posts </a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th> # </th>
                            <th> Name </th>
                            <th> Status </th>
                            <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($posts as $post) {
                                echo "<tr>
                                    <td>$post[id]</td>
                                    <td>$post[name]</td>
                                    <td>$post[status]</td>
                                    <td class='text-center'>
                                        <div class='btn-group' role='group' aria-label='Second group'>
                                            <a href='/admin/posts/update?id=$post[id]' class='btn btn-sm btn-primary'><i class='fa fa-edit'></i></a>
                                            <a href='/admin/posts/delete?id=$post[id]', class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></a>
                                        </div>
                                    </td>
                                </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>