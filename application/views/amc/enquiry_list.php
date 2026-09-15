<div class="card-body">

    <div class="dt-responsive table-responsive">

        <table
            id="datatable"
            class="table table-striped"
            data-toggle="data-table">

            <thead>

                <tr>

                    <th>Sr.no</th>

                    <th>Enq Code</th>

                    <th>Date</th>

                    <th>AMC Branch</th>

                    <th>Enquiry Type</th>

                    <th>Project</th>

                    <th>Customer</th>

                    <th>Status</th>

                    <th>Action</th>

                </tr>

            </thead>


            <tbody>

            <?php

            $i = 1;

            if (!empty($records)):

                foreach ($records as $row):

            ?>

                <tr>

                    <!-- =====================================
                         SERIAL NUMBER
                    ====================================== -->

                    <td>
                        <?php echo $i++; ?>
                    </td>


                    <!-- =====================================
                         ENQUIRY CODE
                    ====================================== -->

                    <td>

                        <strong>
                            <?php
                            echo html_escape(
                                $row->amc_enq_code
                            );
                            ?>
                        </strong>

                    </td>


                    <!-- =====================================
                         DATE
                    ====================================== -->

                    <td>

                        <?php

                        if (
                            !empty($row->enq_date) &&
                            $row->enq_date != '0000-00-00'
                        ) {

                            echo date(
                                'd-M-Y',
                                strtotime($row->enq_date)
                            );

                        }

                        ?>

                    </td>


                    <!-- =====================================
                         AMC BRANCH
                         
                         IMPORTANT:
                         This is amc_enquiry_master.branch_id.
                         
                         It is NOT customer_master.branch_id.
                    ====================================== -->

                    <td>

                        <?php
                        echo html_escape(
                            $row->branch_id
                        );
                        ?>

                    </td>


                    <!-- =====================================
                         ENQUIRY TYPE
                    ====================================== -->

                    <td>

                        <?php

                        if ($row->enq_type == '1') {

                            echo 'Company Products';

                        } elseif ($row->enq_type == '2') {

                            echo 'New Products';

                        } elseif ($row->enq_type == '3') {

                            echo 'Partial Company / Partial New';

                        } else {

                            echo '-';

                        }

                        ?>

                    </td>


                    <!-- =====================================
                         PROJECT
                    ====================================== -->

                    <td>

                        <?php

                        echo html_escape(
                            $row->project_name
                        );

                        ?>

                    </td>


                    <!-- =====================================
                         CUSTOMER
                    ====================================== -->

                    <td>

                        <?php if (!empty($row->cust_id)): ?>

                            <a
                                title="View customer details"
                                target="_blank"
                                href="<?php
                                echo base_url(
                                    'index.php/Users/edit_customer/'
                                    . $row->cust_id
                                );
                                ?>">

                                <?php

                                echo html_escape(
                                    $row->customer_name
                                );

                                ?>

                                <?php if (!empty($row->customer_code)): ?>

                                    <br>

                                    <small>
                                        (
                                        <?php
                                        echo html_escape(
                                            $row->customer_code
                                        );
                                        ?>
                                        )
                                    </small>

                                <?php endif; ?>

                            </a>

                        <?php else: ?>

                            -

                        <?php endif; ?>

                    </td>


                    <!-- =====================================
                         STATUS
                    ====================================== -->

                    <td>

                        <?php

                        if ($row->cancelled == 1) {

                            echo '<span class="badge bg-danger">
                                    Cancelled
                                  </span>';

                        } elseif ($row->order_status == 1) {

                            echo '<span class="badge bg-success">
                                    Completed
                                  </span>';

                        } else {

                            echo '<span class="badge bg-warning">
                                    Pending
                                  </span>';

                        }

                        ?>

                    </td>


                    <!-- =====================================
                         ACTION
                    ====================================== -->

                    <td>

                        <!-- EDIT -->

                        <a
                            href="<?php  echo base_url('index.php/AMC/edit_enquiry/'. $row->amc_enq_id. '/1/'. $row->revision); ?>"
                            title="Edit" style="margin-right:10px;">
                             <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>


                        </a>
                        <!-- DELETE -->

                        <a  href="javascript:void(0);"  onclick="confirmcancel(<?php echo $row->amc_enq_id;  ?>)"  title="Delete">
                             <i class="glyphicon glyphicon-trash"></i>
                        </a>

                        <!-- ATTACHMENT -->

                        <?php if (!empty($row->other_file)): ?>

                            <a
                                href="<?php
                                echo base_url(
                                    'public/uploaded_documents/'
                                    . rawurlencode(
                                        $row->other_file
                                    )
                                );
                                ?>"
                                target="_blank"
                                title="View Attachment">

                                <i class="fa fa-paperclip"></i>

                            </a>

                        <?php endif; ?>

                    </td>				 

                </tr>

            <?php

                endforeach;

            endif;

            ?>

            </tbody>

        </table>

    </div>

</div>


<script>

function confirmcancel(enquiry_id)
{
    var r = confirm(
        "Are you sure you want to Delete Record?"
    );


    if (r === true)
    {

        $.ajax({

            url:
                "<?php echo base_url(); ?>index.php/AMC/delete_enquiry",

            type: "POST",

            data: {
                enquiry_id: enquiry_id
            },

            success: function(msg)
            {

                if (msg == 1)
                {

                    alert("Record deleted.");

                    window.location.href =
                        "<?php echo base_url(); ?>index.php/AMC/view_enquiry_list";

                }
                else
                {

                    alert(
                        "Can't Delete record. Data already exist!!!"
                    );

                }

            },

            error: function()
            {

                alert(
                    "Unable to delete record. Please try again."
                );

            }

        });

    }

}

</script>