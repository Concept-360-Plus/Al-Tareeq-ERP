<div class="page-content">
    <div class="container-fluid">

        <div class="page-title-box">

            <div class="flash-message-container">

                <?php if ($this->session->flashdata('success')) { ?>

                    <div class="alert alert-success alert-dismissible fade show"
                        role="alert">

                        <strong>Success!</strong>
                        <?= $this->session->flashdata('success'); ?>

                        <button type="button"
                            class="close"
                            data-dismiss="alert"
                            aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                <?php } ?>


                <?php if ($this->session->flashdata('error')) { ?>

                    <div class="alert alert-danger alert-dismissible fade show"
                        role="alert">

                        <strong>Error!</strong>
                        <?= $this->session->flashdata('error'); ?>

                        <button type="button"
                            class="close"
                            data-dismiss="alert"
                            aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                <?php } ?>


                <?php if ($this->session->flashdata('warning')) { ?>

                    <div class="alert alert-warning alert-dismissible fade show"
                        role="alert">

                        <strong>Warning!</strong>
                        <?= $this->session->flashdata('warning'); ?>

                        <button type="button"
                            class="close"
                            data-dismiss="alert"
                            aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                <?php } ?>

            </div>

        </div>


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



                    <!-- TERMS & CONDITIONS DESCRIPTION -->

                    <div class="row">
                        <div class="col-md-12">

                            <label>
                                Terms & Conditions Description
                            </label>

                            <textarea
                                name="terms_description"
                                id="terms_description"
                                rows="10"
                                class="form-control"
                                placeholder="Enter terms and conditions details...">
                                <?php
                                echo isset($terms_conditions)
                                    ? htmlspecialchars(
                                        $terms_conditions->terms_description,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    )
                                    : '';

                                ?>
                            </textarea>

                            <small class="text-muted">
                                Enter the complete terms and conditions. You can use
                                formatting, numbering, bullet points, tables, etc.
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

                            <select name="active" class="form-control">

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

                    <a href="<?php echo base_url('index.php/Setup/list_terms_conditions'); ?>" class="btn btn-secondary">
                        Cancel
                    </a>


                </form>

            </div>

        </div>

    </div>
</div>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    $(document).ready(function() {
        if (document.getElementById('terms_description')) {
            CKEDITOR.replace('terms_description');
        }
    });
</script>