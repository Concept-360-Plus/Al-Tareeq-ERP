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


        <!-- FLASH MESSAGES -->

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


                    <div class="row">


                        <!-- TERM TYPE -->

                        <div class="col-md-6">

                            <label>
                                Term Type
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                name="term_type"
                                class="form-control"
                                required>

                                <option value="">
                                    Select Term Type
                                </option>


                                <option
                                    value="PAYMENT"
                                    <?php

                                    if (
                                        isset($terms_conditions) &&
                                        strtoupper(
                                            $terms_conditions->term_type
                                        ) == 'PAYMENT'
                                    ) {
                                        echo 'selected';
                                    }

                                    ?>>
                                    Payment
                                </option>


                                <option
                                    value="DELIVERY"
                                    <?php

                                    if (
                                        isset($terms_conditions) &&
                                        strtoupper(
                                            $terms_conditions->term_type
                                        ) == 'DELIVERY'
                                    ) {
                                        echo 'selected';
                                    }

                                    ?>>
                                    Delivery
                                </option>


                                <option
                                    value="GENERAL"
                                    <?php

                                    if (
                                        isset($terms_conditions) &&
                                        strtoupper(
                                            $terms_conditions->term_type
                                        ) == 'GENERAL'
                                    ) {
                                        echo 'selected';
                                    }

                                    ?>>
                                    General
                                </option>

                            </select>

                            <small class="text-muted">
                                Select whether this is a Payment, Delivery or General term.
                            </small>

                        </div>


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
                                placeholder="Example: 30 Days Credit Payment"
                                value="<?php

                                        echo isset($terms_conditions)
                                            ? htmlspecialchars(
                                                $terms_conditions->terms_name,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )
                                            : '';

                                        ?>">

                        </div>

                    </div>


                    <br>


                    <!-- DESCRIPTION -->

                    <div class="row">

                        <div class="col-md-12">

                            <label>
                                Terms & Conditions Description
                            </label>

                            <textarea
                                name="terms_description"
                                rows="7"
                                class="form-control"
                                placeholder="Enter terms and conditions details..."><?php

                                                                                    echo isset($terms_conditions)
                                                                                        ? htmlspecialchars(
                                                                                            $terms_conditions->terms_description,
                                                                                            ENT_QUOTES,
                                                                                            'UTF-8'
                                                                                        )
                                                                                        : '';

                                                                                    ?></textarea>

                            <small class="text-muted">
                                Enter the complete terms and conditions applicable to this term type.
                            </small>

                        </div>

                    </div>


                    <br>


                    <!-- STATUS -->

                    <div class="row">

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

                                    if (
                                        !isset($terms_conditions) ||
                                        $terms_conditions->active == 1
                                    ) {
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