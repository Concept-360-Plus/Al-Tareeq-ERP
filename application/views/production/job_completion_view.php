<div class="clearfix"></div>
<style>
    .col-md-3 div{margin-top:10px;}
    h5{margin-bottom:15px;}
</style>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">

        <h1>
            <div class="pull-right">

                <a
                    href="<?= base_url('index.php/Production/job_completion_edit/'. $completion->job_completion_id) ?>"
                     style="font-size: 19px; border: 1px;" class="btn" title="Edit">

                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                   

                </a>
            </div>

        </h1>

    </section>
                <h5 class="box-title">
                    Job Completion Details
                </h5>
                <div class="row">
                    <div class="col-md-3">
                        <strong>
                            Job Completion No
                        </strong>

                        <div>
                            <?= htmlspecialchars(
                                $completion->job_completion_no
                            ) ?>
                        </div>

                    </div>


                    <div class="col-md-3">

                        <strong>
                            Job Order No
                        </strong>

                        <div>
                            <?= htmlspecialchars(
                                $completion->job_order_no
                            ) ?>
                        </div>

                    </div>


                    <div class="col-md-3">

                        <strong>
                            Project
                        </strong>

                        <div>
                            <?= htmlspecialchars(
                                $completion->project_name ?? ''
                            ) ?>
                        </div>

                    </div>


                    <div class="col-md-3">

                        <strong>
                            Completion Date
                        </strong>

                        <div>

                            <?= !empty(
                                $completion->completion_date
                            )
                                ? date(
                                    'd-m-Y',
                                    strtotime(
                                        $completion->completion_date
                                    )
                                )
                                : ''
                            ?>

                        </div>

                    </div>

                </div>


                <hr>


                <h5>
                    Completed Items
                </h5>


                <div class="table-responsive">

                    <table
                        class="table table-bordered table-striped">

                        <thead>

                            <tr>

                                <th width="50">
                                    #
                                </th>

                                <th>
                                    Item
                                </th>

                                <th>
                                    Ordered Quantity
                                </th>

                                <th>
                                    Completed Quantity
                                </th>

                                <th>
                                    Remaining Quantity
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                        <?php if (!empty($items)): ?>

                            <?php foreach (
                                $items as $index => $item
                            ): ?>

                                <tr>

                                    <td>
                                        <?= $index + 1 ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $item->item_description ?? ''
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= $item->ordered_quantity ?>
                                    </td>
                                    <td>
                                        <strong>
                                            <?= (int)$item->completed_quantity ?>
                                        </strong>
                                    </td>

                                    <td>
                                        <?= $item->remaining_quantity ?>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center">

                                    No completed items found.

                                </td>

                            </tr>

                        <?php endif; ?>

                        </tbody>

                    </table>

                </div>


                <?php if (!empty($completion->remarks)): ?>

                    <hr>

                    <h5>
                        Remarks
                    </h5>

                    <div class="well">

                        <?= nl2br(
                            htmlspecialchars(
                                $completion->remarks
                            )
                        ) ?>

                    </div>

                <?php endif; ?>

            </div>

        </div>

   
</div>