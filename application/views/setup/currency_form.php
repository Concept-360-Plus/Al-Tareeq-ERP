<div class="page-content">
    <div class="container-fluid">

        <div class="page-title-box">
            <h4 class="page-title">
                <?php echo isset($currency) ? 'Edit Currency' : 'Add Currency'; ?>
            </h4>
        </div>

        <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php } ?>

        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php } ?>

        <?php if ($this->session->flashdata('warning')) { ?>
            <div class="alert alert-warning">
                <?php echo $this->session->flashdata('warning'); ?>
            </div>
        <?php } ?>

        <div class="card">
            <div class="card-body">

                <form method="post"
                    action="<?php
                            if (isset($currency)) {
                                echo base_url('index.php/Setup/update_currency_data');
                            } else {
                                echo base_url('index.php/Setup/add_currency_data');
                            }
                            ?>">

                    <?php if (isset($currency)) { ?>

                        <input type="hidden"
                            name="currency_id"
                            value="<?php echo $currency->currency_id; ?>">

                    <?php } ?>


                    <!-- ROW 1 -->
                    <div class="row">

                        <div class="col-md-6">
                            <label>
                                Currency Abbreviation
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="currency_abbr"
                                class="form-control"
                                maxlength="100"
                                required
                                style="text-transform: uppercase;"
                                value="<?php echo isset($currency) ? $currency->currency_abbr : ''; ?>">

                            <small class="text-muted">
                                Example: USD, AED, INR
                            </small>
                        </div>


                        <div class="col-md-6">
                            <label>
                                Currency Name
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="currency_name"
                                class="form-control"
                                maxlength="50"
                                required
                                value="<?php echo isset($currency) ? $currency->currency_name : ''; ?>">
                        </div>

                    </div>


                    <br>


                    <!-- ROW 2 -->
                    <div class="row">

                        <div class="col-md-6">
                            <label>
                                Conversion Rate
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="number"
                                name="conversion_rate"
                                class="form-control"
                                step="0.01"
                                min="0"
                                required
                                value="<?php echo isset($currency) ? $currency->conversion_rate : '1.00'; ?>">

                            <small class="text-muted">
                                Default conversion rate: 1.00
                            </small>
                        </div>


                        <div class="col-md-6">

                            <label>Status</label>

                            <select
                                name="active"
                                class="form-control">

                                <option value="1"
                                    <?php
                                    if (isset($currency)) {
                                        if ($currency->active == 1)
                                            echo "selected";
                                    } else {
                                        echo "selected";
                                    }
                                    ?>>
                                    Active
                                </option>

                                <option value="0"
                                    <?php
                                    if (isset($currency)) {
                                        if ($currency->active == 0)
                                            echo "selected";
                                    }
                                    ?>>
                                    Inactive
                                </option>

                            </select>

                        </div>

                    </div>


                    <br>


                    <!-- BUTTONS -->
                    <button
                        type="submit"
                        class="btn btn-primary">

                        <?php echo isset($currency)
                            ? 'Update Currency'
                            : 'Save Currency'; ?>

                    </button>


                    <a href="<?php echo base_url('index.php/Setup/list_currency'); ?>"
                        class="btn btn-secondary">
                        Cancel
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>