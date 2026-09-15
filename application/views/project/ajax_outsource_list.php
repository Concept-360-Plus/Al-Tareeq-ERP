<?php
$i=1;

if(!empty($outsource))
{
    foreach($outsource as $row)
    {
?>
<tr>

    <td><?= $i++; ?></td>

    <td>OS-<?= str_pad($row['outsource_id'],5,'0',STR_PAD_LEFT); ?></td>

    <td><?= date('d-m-Y',strtotime($row['outsource_date'])); ?></td>
    <td><?= date('d-m-Y',strtotime($row['outsource_finish_date'])); ?></td>

    <td><?= $row['supplier_name']; ?></td>

    <td class="text-center"><?= $row['total_items']; ?></td>

    <td><?= $row['progress_percentage']; ?>%</td>

    <td><?= $row['status']; ?></td>

    <td>

        <button
            class="btn btn-info btn-xs viewOutsourceProducts"
            data-id="<?= $row['outsource_id']; ?>">

            <i class="fa fa-eye"></i>

        </button>

    </td>

</tr>
<?php
    }
}
else
{
?>
<tr>
    <td colspan="8" class="text-center">
        No Outsource Records Found
    </td>
</tr>
<?php
}
?>