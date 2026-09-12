<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid mt-3">
    <!-- <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Work Order - <?= html_escape($wo_type); ?></h4>
        <a href="<?= base_url('index.php/AMC/work_order_add/' . strtolower($wo_type)); ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> New
        </a>
    </div> -->

    
    <table class="table table-bordered table-striped" id="woTable">
        <thead class="table-dark">
            <tr>                
                <th>Ref. No.</th>
                <th>Ref. Date</th>
                <th>Customer Code</th>
                <th>Customer Name</th>
                <th>Type of Service</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($wo_list)): ?>
            <?php foreach ($wo_list as $wo): ?>
                <tr>
                    <td><?= html_escape($wo->ref_no); ?></td>                    
                   <td><?= html_escape($wo->ref_date); ?><br>Maintenance Type: <?= html_escape($wo->wo_type); ?></td>
                    <td><?= html_escape($wo->customer_code); ?></td>
                    <td><?= html_escape($wo->customer_name); ?></td>
                    <td><?= html_escape($wo->type_of_service); ?></td>
                    <td><span class="badge bg-secondary"><?= html_escape($wo->order_status); ?></span></td>
                    <td>
                        <a href="<?= base_url('index.php/AMC/work_order_edit/' . $wo->wo_id); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7" class="text-center">No records found</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>