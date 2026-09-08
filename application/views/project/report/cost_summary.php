<div class="x_panel">

    <div class="x_title">
        <h2>Project Cost Summary</h2>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">

        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th width="70%">Cost Head</th>
                    <th width="30%" class="text-right">Amount</th>
                </tr>
            </thead>

            <tbody>

                <tr>
                    <td>Material Cost</td>

                    <td class="text-right">
                        <?= number_format(
                            $cost_summary->material_cost,
                            2
                        ); ?>
                    </td>
                </tr>

                <tr>
                    <td>Outsource Cost</td>

                    <td class="text-right">
                        <?= number_format(
                            $cost_summary->outsource_cost,
                            2
                        ); ?>
                    </td>
                </tr>

                <tr>
                    <th>Total Project Cost</th>

                    <th class="text-right">
                        <?= number_format(
                            $cost_summary->total_cost,
                            2
                        ); ?>
                    </th>
                </tr>

            </tbody>

        </table>

    </div>

</div>