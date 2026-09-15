<?php $i=1; ?>

<?php foreach($work_orders as $row){ ?>

<tr>

    <td><?= $i++; ?></td>

    <td><?= $row['wo_code']; ?></td>

    <td><?= date('d-m-Y',strtotime($row['work_order_date'])); ?></td>

    <td><?= $row['status']; ?></td>

    <td><?php if( $row['approve_flag']=='0'){ echo 'No';}else{ echo 'Yes';} ?></td>

    <td>
        <a href="<?= base_url('index.php/Project/edit_work_order/'.$row['work_id']); ?>"
           class="btn btn-warning btn-xs" target="_blank">
            <i class="fa fa-pencil"></i>
        </a>
        <a href="<?= base_url('index.php/Project/print_work_order/'.$row['work_id']); ?>"
           target="_blank" class="btn btn-info btn-xs">
            <i class="fa fa-print"></i>
        </a>
    </td>

</tr>

<?php } ?>

<?php if(empty($work_orders)){ ?>

<tr>
    <td colspan="6" class="text-center">
        No Work Orders Found
    </td>
</tr>

<?php } ?>