<?php

/**
 * @var $this \app\core\View
 */
$this->title = "Categories";
?>

<div class="app-title">
    <div>
        <h1><i class="fa fa-tags"></i> Category</h1>
    </div>
    <a href="/admin/category/create" class="btn btn-primary pull-right">Add Category</a>
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
                            <th class="text-center"> Description </th>
                            <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($categories as $category) {
                            echo "<tr>
                                    <td>$category[id]</td>
                                    <td>$category[name]</td>
                                    <td>$category[description]</td>
                                    <td class='text-center'>
                                        <div class='btn-group' role='group' aria-label='Second group'>
                                            <a href='/admin/category/update?id=$category[id]' class='btn btn-sm btn-primary'><i class='fa fa-edit'></i></a>
                                            <a href='/admin/category/delete?id=$category[id]', class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></a>
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