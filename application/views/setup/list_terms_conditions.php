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

                <!-- TABLE -->
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
                                    Terms & Conditions
                                </th>

                                <th>
                                    Applicable To
                                </th>

                                <th>
                                    Validity
                                </th>

                                <th>
                                    Payment Terms
                                </th>

                                <th>
                                    Warranty
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


                                        <!-- APPLICABLE TO -->
                                        <td>

                                            <?php
                                            $applicable_to = strtoupper(
                                                trim($row->applicable_to)
                                            );

                                            if ($applicable_to == 'SALES') {
                                            ?>

                                                <span class="badge badge-info">
                                                    Sales
                                                </span>

                                            <?php
                                            } elseif ($applicable_to == 'PURCHASE') {
                                            ?>

                                                <span class="badge badge-warning">
                                                    Purchase
                                                </span>

                                            <?php
                                            } elseif ($applicable_to == 'BOTH') {
                                            ?>

                                                <span class="badge badge-primary">
                                                    Both
                                                </span>

                                            <?php
                                            } else {
                                            ?>

                                                <span class="badge badge-secondary">
                                                    <?= htmlspecialchars(
                                                        $row->applicable_to,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ); ?>
                                                </span>

                                            <?php } ?>

                                        </td>


                                        <!-- VALIDITY -->
                                        <td>

                                            <?= !empty($row->validity)
                                                ? htmlspecialchars(
                                                    $row->validity,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                )
                                                : '-'; ?>

                                        </td>


                                        <!-- PAYMENT TERMS -->
                                        <td>

                                            <?= !empty($row->payment_terms)
                                                ? htmlspecialchars(
                                                    $row->payment_terms,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                )
                                                : '-'; ?>

                                        </td>


                                        <!-- WARRANTY -->
                                        <td>

                                            <?php if (!empty($row->warranty)) { ?>

                                                <span
                                                    title="<?= htmlspecialchars(
                                                                $row->warranty_description ?? '',
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            ); ?>">

                                                    <?= htmlspecialchars(
                                                        $row->warranty,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ); ?>

                                                </span>

                                            <?php } else { ?>

                                                -

                                            <?php } ?>

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
                                            /*
                                             * EDIT
                                             */
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
                                            /*
                                             * DEACTIVATE
                                             *
                                             * Only show when currently active.
                                             */
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
            confirm("Are you sure you want to deactivate this Terms & Conditions record?")
        ) {
            window.location.href = "<?= base_url('index.php/Setup/delete_terms_conditions/'); ?>" + id;
        }
    }

    $(document).ready(function() {
        $('#termsConditionsTable').DataTable({
            pageLength: 10,
            order: [
                [0, 'asc']
            ],
            columnDefs: [{
                orderable: false,
                targets: [7]
            }]
        });
    });
</script>