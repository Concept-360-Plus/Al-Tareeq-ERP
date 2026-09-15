<?php

if(!empty($products))
{
    $i = 1;

    foreach($products as $row)
    {
?>

<tr>

    <td><?= $i++; ?></td>

    <td><?= $row['product_code']; ?></td>

    <td><?= $row['product_name']; ?></td>

    <td><?= $row['description']; ?></td>

    <td class="text-right"><?= number_format($row['item_qty'],2); ?></td>

    <td><?= $row['unit_abbr']; ?></td>

    <!--<td><?= $row['item_remarks']; ?></td>-->

</tr>

<?php
    }
}
else
{
?>

<tr>
    <td colspan="7" class="text-center text-danger">
        No Products Found
    </td>
</tr>

<?php
}
?>