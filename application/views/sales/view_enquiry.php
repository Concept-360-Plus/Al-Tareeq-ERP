<div class="container">

    <table class="table table-bordered">
        <tr>
            <th>Enquiry Code</th>
            <td><?= htmlspecialchars($enquiry_data['enquiry_code']) ?></td>
        </tr>
        <tr>
            <th>Enquiry Date</th>
            <td><?= htmlspecialchars($enquiry_data['enquiry_date']) ?></td>
        </tr>
        <tr>
            <th>Customer</th>
            <td><?= htmlspecialchars($enquiry_data['customer_name']) ?></td>
        </tr>
        <tr>
            <th>Branch</th>
            <td><?= htmlspecialchars($enquiry_data['branch_name']) ?></td>
        </tr>
        <tr>
            <th>Project Name</th>
            <td><?= htmlspecialchars($enquiry_data['project_name']) ?></td>
        </tr>
        <tr>
            <th>Project Location</th>
            <td><?= htmlspecialchars($enquiry_data['project_location']) ?></td>
        </tr>
        <tr>
            <th>Enquiry Category</th>
            <td><?= htmlspecialchars($enquiry_data['enquiry_category']) ?></td>
        </tr>
        <tr>
            <th>Enquiry Source</th>
            <td><?= htmlspecialchars($enquiry_data['enquiry_source']) ?></td>
        </tr>
        <tr>
            <th>Client Ref No</th>
            <td><?= htmlspecialchars($enquiry_data['client_ref_no']) ?></td>
        </tr>
                <tr>
            <th>Comments</th>
            <td><?= nl2br(htmlspecialchars($enquiry_data['comments'])) ?></td>
        </tr>
    </table>

    <h4>Item Details</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th width="100">Code</th>
                <th>Item</th>
                <th>Description</th>
                <th width="100">Qty</th>
                <th width="150">Price</th>
                <th width="150">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($cart_items)): ?>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item->product_code) ?></td>
                        <td><?= htmlspecialchars($item->product_name) ?></td>
                        <td><?= htmlspecialchars($item->description ?? '') ?></td>
                        <td><?= htmlspecialchars($item->qty) ?></td>
                        <td><?= number_format($item->price, 2) ?></td>
                        <td><?= number_format($item->amount, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No items added</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>