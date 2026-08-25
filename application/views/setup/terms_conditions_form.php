<div class="page-content">
    <div class="container-fluid">

        <div class="page-title-box">
            <h4 class="page-title">
                <?php
                echo isset($terms_conditions)
                    ? 'Edit Terms & Conditions'
                    : 'Add Terms & Conditions';
                ?>
            </h4>
        </div>


        <!-- SUCCESS -->
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php } ?>


        <!-- ERROR -->
        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php } ?>


        <!-- WARNING -->
        <?php if ($this->session->flashdata('warning')) { ?>
            <div class="alert alert-warning">
                <?php echo $this->session->flashdata('warning'); ?>
            </div>
        <?php } ?>


        <div class="card">
            <div class="card-body">

                <form
                    method="post"
                    action="<?php

                            if (isset($terms_conditions)) {

                                echo base_url(
                                    'index.php/Setup/update_terms_conditions_data'
                                );
                            } else {

                                echo base_url(
                                    'index.php/Setup/add_terms_conditions_data'
                                );
                            }

                            ?>">


                    <!-- EDIT ID -->
                    <?php if (isset($terms_conditions)) { ?>

                        <input
                            type="hidden"
                            name="terms_id"
                            value="<?php echo $terms_conditions->terms_id; ?>">

                    <?php } ?>


                    <!-- ROW 1 -->
                    <div class="row">

                        <!-- TERMS NAME -->
                        <div class="col-md-6">

                            <label>
                                Terms & Conditions Name
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="terms_name"
                                class="form-control"
                                maxlength="150"
                                required
                                value="<?php
                                        echo isset($terms_conditions)
                                            ? htmlspecialchars(
                                                $terms_conditions->terms_name,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )
                                            : '';
                                        ?>">

                            <small class="text-muted">
                                Example: Standard Purchase Terms
                            </small>

                        </div>


                        <!-- APPLICABLE TO -->
                        <div class="col-md-6">

                            <label>
                                Applicable To
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                name="applicable_to"
                                class="form-control"
                                required>

                                <option value="">
                                    Select Applicable To
                                </option>


                                <option
                                    value="SALES"
                                    <?php
                                    if (
                                        isset($terms_conditions) &&
                                        strtoupper(
                                            $terms_conditions->applicable_to
                                        ) == 'SALES'
                                    ) {
                                        echo 'selected';
                                    }
                                    ?>>
                                    Sales
                                </option>


                                <option
                                    value="PURCHASE"
                                    <?php
                                    if (
                                        isset($terms_conditions) &&
                                        strtoupper(
                                            $terms_conditions->applicable_to
                                        ) == 'PURCHASE'
                                    ) {
                                        echo 'selected';
                                    }
                                    ?>>
                                    Purchase
                                </option>


                                <option
                                    value="BOTH"
                                    <?php
                                    if (
                                        isset($terms_conditions) &&
                                        strtoupper(
                                            $terms_conditions->applicable_to
                                        ) == 'BOTH'
                                    ) {
                                        echo 'selected';
                                    }
                                    ?>>
                                    Both
                                </option>

                            </select>

                        </div>

                    </div>


                    <br>


                    <!-- ROW 2 -->
                    <div class="row">

                        <!-- VALIDITY -->
                        <div class="col-md-6">

                            <label>
                                Validity
                            </label>

                            <input
                                type="text"
                                name="validity"
                                class="form-control"
                                maxlength="100"
                                placeholder="Example: 30 Days / 60 Days"
                                value="<?php
                                        echo isset($terms_conditions)
                                            ? htmlspecialchars(
                                                $terms_conditions->validity,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )
                                            : '';
                                        ?>">

                        </div>


                        <!-- WARRANTY -->
                        <div class="col-md-6">

                            <label>
                                Warranty
                            </label>

                            <input
                                type="text"
                                name="warranty"
                                class="form-control"
                                maxlength="255"
                                placeholder="Example: 1 Year"
                                value="<?php
                                        echo isset($terms_conditions)
                                            ? htmlspecialchars(
                                                $terms_conditions->warranty,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )
                                            : '';
                                        ?>">

                        </div>

                    </div>


                    <br>


                    <!-- ROW 3 -->
                    <div class="row">

                        <!-- PAYMENT TERMS -->
                        <div class="col-md-6">

                            <label>
                                Payment Terms
                            </label>

                            <textarea
                                name="payment_terms"
                                rows="5"
                                class="form-control"
                                placeholder="Enter payment terms...">
                                <?php
                                echo isset($terms_conditions)
                                    ? htmlspecialchars(
                                        $terms_conditions->payment_terms,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    )
                                    : '';
                                ?>
                            </textarea>

                        </div>


                        <!-- DELIVERY TERMS -->
                        <div class="col-md-6">

                            <label>
                                Delivery Terms
                            </label>

                            <textarea
                                name="delivery_terms"
                                rows="5"
                                class="form-control"
                                placeholder="Enter delivery terms...">
                                <?php
                                echo isset($terms_conditions)
                                    ? htmlspecialchars(
                                        $terms_conditions->delivery_terms,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    )
                                    : '';
                                ?>
                            </textarea>

                        </div>

                    </div>


                    <br>


                    <!-- ROW 4 -->
                    <div class="row">

                        <!-- GENERAL TERMS -->
                        <div class="col-md-6">

                            <label>
                                General Terms
                            </label>

                            <textarea name="general_terms" rows="5" class="form-control" placeholder="Enter general terms and conditions..."><?php echo isset($terms_conditions) ? htmlspecialchars($terms_conditions->general_terms, ENT_QUOTES, 'UTF-8') : ''; ?>
                            </textarea>

                        </div>


                        <!-- WARRANTY DESCRIPTION -->
                        <div class="col-md-6">

                            <label>
                                Warranty Description
                            </label>

                            <textarea
                                name="warranty_description"
                                rows="5"
                                class="form-control"
                                placeholder="Enter detailed warranty information...">
                                <?php
                                echo isset($terms_conditions)
                                    ? htmlspecialchars(
                                        $terms_conditions->warranty_description,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    )
                                    : '';
                                ?>
                            </textarea>

                        </div>

                    </div>


                    <br>


                    <!-- ROW 5 -->
                    <div class="row">

                        <!-- STATUS -->
                        <div class="col-md-6">

                            <label>
                                Status
                            </label>

                            <select
                                name="active"
                                class="form-control">

                                <option
                                    value="1"
                                    <?php

                                    if (isset($terms_conditions)) {

                                        if (
                                            $terms_conditions->active == 1
                                        ) {
                                            echo 'selected';
                                        }
                                    } else {

                                        echo 'selected';
                                    }

                                    ?>>
                                    Active
                                </option>


                                <option
                                    value="0"
                                    <?php

                                    if (
                                        isset($terms_conditions) &&
                                        $terms_conditions->active == 0
                                    ) {
                                        echo 'selected';
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

                        <?php

                        echo isset($terms_conditions)
                            ? 'Update Terms & Conditions'
                            : 'Save Terms & Conditions';

                        ?>

                    </button>


                    <a
                        href="<?php
                                echo base_url(
                                    'index.php/Setup/list_terms_conditions'
                                );
                                ?>"
                        class="btn btn-secondary">
                        Cancel
                    </a>


                </form>

            </div>
        </div>

    </div>
</div>