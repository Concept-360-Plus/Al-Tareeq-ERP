<div class="row">

    <div class="col-md-12">

        <div class="x_panel">

            <div class="x_title">

                <h2>
                    View Material Request
                </h2>

                <!--<a href="<?= base_url(
                    'index.php/Production/material_requests'
                ) ?>"
                   class="btn btn-default btn-sm pull-right">

                    <i class="fa fa-arrow-left"></i>
                    Back

                </a>-->

                <div class="clearfix"></div>

            </div>


            <div class="x_content">

                <!-- Header -->

                <div class="row">

                    <div class="col-md-3">

                        <label>
                            Material Request No
                        </label>

                        <input type="text"
                               class="form-control"
                               value="<?= htmlspecialchars(
                                   $request->material_request_no
                               ) ?>"
                               readonly>

                    </div>


                    <div class="col-md-3">

                        <label>
                            Job Order
                        </label>

                        <input type="text"
                               class="form-control"
                               value="<?= htmlspecialchars(
                                   $request->job_order_no
                               ) ?>"
                               readonly>

                    </div>


                    <div class="col-md-3">

                        <label>
                            Project
                        </label>

                        <input type="text"
                               class="form-control"
                               value="<?= htmlspecialchars(
                                   $request->project_name ?? ''
                               ) ?>"
                               readonly>

                    </div>


                    <div class="col-md-3">

                        <label>
                            Request Date
                        </label>

                        <input type="text"
                               class="form-control"
                               value="<?= !empty(
                                   $request->request_date
                               )
                                   ? date(
                                       'd-m-Y',
                                       strtotime(
                                           $request->request_date
                                       )
                                   )
                                   : '' ?>"
                               readonly>

                    </div>

                </div>


                <br>


                <!-- Materials -->

                <div class="panel panel-default">

                    <div class="panel-heading">

                        <strong>
                            Requested Materials
                        </strong>

                    </div>

                    <div class="panel-body">

                        <div class="table-responsive">

                            <table class="table table-bordered table-striped">

                                <thead>

                                    <tr>

                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Material</th>
                                        <th>Required Qty</th>
                                        <th>Previously Requested</th>
                                        <th>Remaining Qty</th>
                                        <th>Unit</th>
                                        <th>Unit Cost</th>
                                        <th>Total Cost</th>

                                    </tr>

                                </thead>

                                <tbody>

                                <?php foreach (
                                    $items as $index => $item
                                ): ?>

                                    <tr>

                                        <td>
                                            <?= $index + 1 ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $item->product_name
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $item->material_name
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= number_format(
                                                $item->required_quantity,
                                                2
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= number_format(
                                                $item->previously_requested,
                                                2
                                            ) ?>
                                        </td>

                                        <td>
                                            <!--<?= number_format(
                                                $item->request_quantity,
                                                2
                                            ) ?>-->
                                            <?php
                                           // $request =  (float)$item->required_quantity -  (float)$item->previously_requested;
                                           $request =  $item->remaining_quantity;
                                            echo number_format($request,2);
                                            ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $item->unit
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= number_format(
                                                $item->unit_cost,
                                                2
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= number_format(
                                                $item->total_cost,
                                                2
                                            ) ?>
                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>


                <div class="form-group">

                    <label>
                        Remarks
                    </label>

                    <textarea class="form-control"
                              rows="3"
                              readonly><?= htmlspecialchars(
                                  $request->remarks ?? ''
                              ) ?></textarea>

                </div>

            </div>

        </div>

    </div>

</div>