<style>
    .action-icons i {
        font-size: 18px;
        margin: 0 5px;
        vertical-align: middle;
    }

    .document-count {
        font-size: 12px;
    }
</style>

<div class="card-body">

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('warning')): ?>
        <div class="alert alert-warning">
            <?php echo $this->session->flashdata('warning'); ?>
        </div>
    <?php endif; ?>

    <div class="dt-responsive table-responsive">

        <table id="datatable"
            class="table table-striped"
            data-toggle="data-table">

            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Document Name</th>
                    <th>Document No</th>
                    <th>Expiry Date</th>
                    <th>Attachments</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($records)): ?>

                    <?php $i = 1; ?>

                    <?php foreach ($records as $row): ?>

                        <tr>

                            <td>
                                <?php echo $i++; ?>
                            </td>

                            <td>
                                <?php echo html_escape($row->document_name); ?>
                            </td>

                            <td>
                                <?php echo html_escape($row->card_no); ?>
                            </td>

                            <td>
                                <?php
                                echo !empty($row->expiry_date)
                                    ? date(
                                        'd-M-Y',
                                        strtotime($row->expiry_date)
                                    )
                                    : '-';
                                ?>
                            </td>

                            <td>
                                <?php if (!empty($row->document_count)): ?>

                                    <span class="badge badge-info document-count">
                                        <?php echo (int)$row->document_count; ?>
                                        File(s)
                                    </span>

                                <?php else: ?>

                                    <span class="text-muted">
                                        No File
                                    </span>

                                <?php endif; ?>
                            </td>

                            <td class="action-icons">

                                <a href="<?php echo base_url(
                                                'index.php/Hr/edit_corporate_file/' .
                                                    $row->cop_id
                                            ); ?>"
                                    title="Edit">

                                    <i class="fa fa-edit"></i>

                                </a>

                                <a href="<?php echo base_url(
                                                'index.php/Hr/delete_corporate_file/' .
                                                    $row->cop_id
                                            ); ?>"
                                    title="Delete"
                                    onclick="return confirm(
                                       'Are you sure you want to delete this Corporate File and all its uploaded documents?'
                                   );">

                                    <i class="fa fa-trash"></i>

                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

            </tbody>

        </table>

    </div>
</div>