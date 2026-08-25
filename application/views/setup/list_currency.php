<?php
$page_name = $this->uri->segment(1) . '/' . $this->uri->segment(2);
$user = $this->session->userdata('user_id');
?>

<div class="x_panel">

    <div class="x_content">
        <!-- SUCCESS -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <!-- ERROR -->
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <!-- WARNING -->
        <?php if ($this->session->flashdata('warning')): ?>
            <div class="alert alert-warning">
                <?= $this->session->flashdata('warning'); ?>
            </div>
        <?php endif; ?>


        <table
            id="currencyTable"
            class="table table-hover">

            <thead>
                <tr>
                    <th>Sl. No</th>
                    <th>Currency</th>
                    <th>Currency Name</th>
                    <th>Conversion Rate</th>
                    <th>Status</th>
                    <th width="150">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $i = 1;
                if (!empty($currencies)) {
                    foreach ($currencies as $row) {
                ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><strong><?= htmlspecialchars($row->currency_abbr); ?></strong></td>
                            <td><?= htmlspecialchars($row->currency_name); ?></td>
                            <td><?= number_format((float)$row->conversion_rate, 2); ?></td>
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

                            <td>
                                <?php if (
                                    has_access(
                                        $user,
                                        'Setup/list_currency',
                                        'E'
                                    )
                                ) { ?>
                                    <a href="<?= base_url('index.php/Setup/edit_currency/' .$row->currency_id); ?>" class="btn btn-primary btn-sm">
                                        Edit
                                    </a>
                                <?php } ?>

                                <?php if ($row->active == 1 && has_access($user,'Setup/list_currency','D')
                                ) { ?>

                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm"
                                        onclick="deactivateCurrency(
                                            <?= $row->currency_id; ?>
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


<script>
    function deactivateCurrency(id) {
        if (
            confirm(
                "Are you sure you want to deactivate this currency?"
            )
        ) {
            window.location.href ="<?= base_url('index.php/Setup/delete_currency/'); ?>" + id;
        }
    }

    $(document).ready(function() {
        $('#currencyTable').DataTable({
            pageLength: 10,
            order: [
                [0, 'asc']
            ]
        });
    });
</script>