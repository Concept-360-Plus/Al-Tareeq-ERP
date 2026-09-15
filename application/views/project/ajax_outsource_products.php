<?php
$i=1;
if(!empty($products))
{
    foreach($products as $row)
    {
?>
<tr>

    <td><?= $i++; ?></td>
    <!--<td><?= $row['outsource_type']; ?></td>-->
    <td><?= $row['nature_work']; ?></td>
    <!--<td><?= $row['outsource_type']; ?></td>-->
    <td><?= $row['outsource_item']; ?></td>
    <!--<td><?= $row['product_desc']; ?></td>-->
    <td class="text-right"><?= (int)$row['quantity'] ?></td>
    <td class="text-right"><?= $row['item_price'] ?></td>

</tr>
<?php
    }
}
else
{
?>
<tr>
    <td colspan="7" class="text-center">
        No Items Found
    </td>
</tr>
<?php
}
?>