<?php
$term_type = strtoupper($term_type ?? '');

$type_name = '';

if ($term_type == 'PAYMENT') {
    $type_name = 'Payment';
} elseif ($term_type == 'DELIVERY') {
    $type_name = 'Delivery';
} elseif ($term_type == 'GENERAL') {
    $type_name = 'General';
}
?>

<div class="modal-dialog modal-lg">

    <div class="modal-content">

        <!-- HEADER -->
        <div class="modal-header">

            <h4 class="modal-title">
                Add New <?php echo $type_name; ?> Term
            </h4>

            <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>


        <!-- BODY -->
        <div class="modal-body">

            <form id="addTermForm">

                <input
                    type="hidden"
                    name="term_type"
                    id="new_term_type"
                    value="<?php echo htmlspecialchars(
                                $term_type,
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>">


                <div class="form-group">

                    <label for="new_terms_name">
                        Terms &amp; Conditions Name
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="terms_name"
                        id="new_terms_name"
                        class="form-control"
                        maxlength="150"
                        placeholder="Enter term name"
                        required>

                </div>


                <div class="form-group">

                    <label for="new_terms_description">
                        Description
                    </label>

                    <textarea
                        name="terms_description"
                        id="new_terms_description"
                        class="form-control"
                        rows="6"
                        placeholder="Enter terms and conditions details..."></textarea>

                </div>

            </form>

        </div>


        <!-- FOOTER -->
        <div class="modal-footer">

            <button
                type="button"
                class="btn btn-default"
                data-dismiss="modal">
                Cancel
            </button>

            <button
                type="button"
                class="btn btn-success"
                id="saveNewTermBtn">
                <i class="fa fa-save"></i>
                Save
            </button>

        </div>

    </div>

</div>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    $(document).ready(function() {
        if (document.getElementById('new_terms_description')) {
            CKEDITOR.replace('new_terms_description');
        }
    });
</script>