<?php

$page_name = $this->uri->segment(1) . '/' . $this->uri->segment(2);

$user = $this->session->userdata('user_id');

?>

<div class="page-content">

    <div class="container-fluid">


        <!-- FLASH MESSAGES -->

        <?php if ($this->session->flashdata('success')): ?>

            <div class="alert alert-success">
                <?= $this->session->flashdata('success'); ?>
            </div>

        <?php endif; ?>


        <?php if ($this->session->flashdata('error')): ?>

            <div class="alert alert-danger">
                <?= $this->session->flashdata('error'); ?>
            </div>

        <?php endif; ?>


        <?php if ($this->session->flashdata('warning')): ?>

            <div class="alert alert-warning">
                <?= $this->session->flashdata('warning'); ?>
            </div>

        <?php endif; ?>


        <div class="card">

            <div class="card-body">


                <div class="table-responsive">

                    <table
                        id="termsConditionsTable"
                        class="table table-hover">

                        <thead>

                            <tr>

                                <th width="60">
                                    Sl. No
                                </th>

                                <th>
                                    Term Type
                                </th>

                                <th>
                                    Terms & Conditions
                                </th>

                                <th>
                                    Description
                                </th>

                                <th>
                                    Status
                                </th>

                                <th width="180">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php

                            $i = 1;

                            if (!empty($terms_conditions)) {

                                foreach ($terms_conditions as $row) {

                            ?>

                                    <tr>


                                        <!-- SERIAL -->

                                        <td>
                                            <?= $i++; ?>
                                        </td>


                                        <!-- TERM TYPE -->

                                        <td>

                                            <?php

                                            $term_type = strtoupper(
                                                trim($row->term_type)
                                            );


                                            if ($term_type == 'PAYMENT') {

                                            ?>

                                                <span class="badge badge-info">
                                                    Payment
                                                </span>

                                            <?php

                                            } elseif ($term_type == 'DELIVERY') {

                                            ?>

                                                <span class="badge badge-warning">
                                                    Delivery
                                                </span>

                                            <?php

                                            } elseif ($term_type == 'GENERAL') {

                                            ?>

                                                <span class="badge badge-primary">
                                                    General
                                                </span>

                                            <?php

                                            } else {

                                            ?>

                                                <span class="badge badge-secondary">
                                                    <?= htmlspecialchars(
                                                        $row->term_type,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ); ?>
                                                </span>

                                            <?php } ?>

                                        </td>


                                        <!-- TERMS NAME -->

                                        <td>

                                            <strong>

                                                <?= htmlspecialchars(
                                                    $row->terms_name,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>

                                            </strong>

                                        </td>


                                        <!-- DESCRIPTION -->

                                        <td>

                                            <?php

                                            if (!empty($row->terms_description)) {

                                                $description =
                                                    trim(
                                                        $row->terms_description
                                                    );

                                                if (strlen($description) > 100) {

                                                    echo htmlspecialchars(
                                                        substr(
                                                            $description,
                                                            0,
                                                            100
                                                        ),
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    );

                                                    echo '...';
                                                } else {

                                                    echo htmlspecialchars(
                                                        $description,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    );
                                                }
                                            } else {

                                                echo '-';
                                            }

                                            ?>

                                        </td>


                                        <!-- STATUS -->

                                        <td>

                                            <?php if ($row->active == 1) { ?>

                                                <span class="badge badge-success">
                                                    Active
                                                </span>

                                            <?php } else { ?>

                                                <span class="badge badge-danger">
                                                    Inactive
                                                </span>

                                            <?php } ?>

                                        </td>


                                        <!-- ACTION -->

                                        <td>


                                            <?php

                                            if (
                                                has_access(
                                                    $user,
                                                    'Setup/list_terms_conditions',
                                                    'E'
                                                )
                                            ) {

                                            ?>

                                                <a
                                                    href="<?= base_url(
                                                                'index.php/Setup/edit_terms_conditions/' .
                                                                    $row->terms_id
                                                            ); ?>"
                                                    class="btn btn-primary btn-sm">
                                                    Edit
                                                </a>

                                            <?php } ?>


                                            <?php

                                            if (
                                                $row->active == 1 &&
                                                has_access(
                                                    $user,
                                                    'Setup/list_terms_conditions',
                                                    'D'
                                                )
                                            ) {

                                            ?>

                                                <button
                                                    type="button"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="deactivateTermsConditions(
                                                    <?= $row->terms_id; ?>
                                                )">
                                                    Deactivate
                                                </button>

                                            <?php } ?>


                                        </td>

                                    </tr>

                            <?php

                                }
                            }

                            ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>


<script>
    function deactivateTermsConditions(id) {
        if (
            confirm(
                "Are you sure you want to deactivate this Terms & Conditions record?"
            )
        ) {

            window.location.href =
                "<?= base_url(
                        'index.php/Setup/delete_terms_conditions/'
                    ); ?>" + id;
        }
    }


    $(document).ready(function() {

        $('#termsConditionsTable').DataTable({

            pageLength: 10,

            order: [
                [0, 'asc']
            ],

            columnDefs: [

                {
                    orderable: false,
                    targets: [5]
                }

            ]

        });

    });
</script>