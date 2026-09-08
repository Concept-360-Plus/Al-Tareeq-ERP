<?php
$i=1;

if(!empty($requests))
{
    foreach($requests as $row)
    {
?>
<tr>

    <td><?= $i++; ?></td>

    <td><?= $row['mr_code']; ?></td>

    <td><?= date('d-m-Y',strtotime($row['requested_date'])); ?></td>

    <td><?= date('d-m-Y',strtotime($row['required_date'])); ?></td>

    <td class="text-center"><?= $row['total_products']; ?></td>

    <td><?= $row['status']; ?></td>

    <td>

        <a href="<?= base_url('index.php/Project/edit_material_request/'.$row['mr_id']); ?>"
           class="btn btn-warning btn-xs" target="_blank">
            <i class="fa fa-pencil"></i>
        </a>
        <button title="View products" class="btn btn-info btn-xs viewProducts" data-mr="<?= $row['mr_id']; ?>">
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
    <td colspan="7" class="text-center">
        No Material Requests Found
    </td>
</tr>
<?php
}
?>