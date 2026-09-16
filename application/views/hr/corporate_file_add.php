<style>
    .select2Width {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 240px !important;
        min-width: 240px !important;
    }

    .file-row td {
        vertical-align: middle;
    }
</style>

<div class="x_panel">

    <div class="x_title">
        <h2>Add Corporate File</h2>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form
            id="main"
            method="post"
            action="<?php echo base_url('index.php/Hr/add_corporate_file_data'); ?>"
            autocomplete="off"
            enctype="multipart/form-data">

            <div class="form-group row">

                <label class="col-md-3 col-form-label">
                    Document Name
                    <span class="text-danger">*</span>
                </label>

                <div class="col-md-4">

                    <input
                        type="text"
                        name="doc_name"
                        id="doc_name"
                        class="form-control form-control-sm"
                        placeholder="Enter document name"
                        required>

                </div>

            </div>


            <div class="form-group row">

                <label class="col-md-3 col-form-label">
                    Licence/Card No
                    <span class="text-danger">*</span>
                </label>

                <div class="col-md-4">

                    <input
                        type="text"
                        name="card_no"
                        id="card_no"
                        class="form-control form-control-sm"
                        placeholder="Enter card number"
                        required>

                </div>

            </div>


            <div class="form-group row">
                <label class="col-md-3 col-form-label">
                    Expiry Date <span class="text-danger">*</span>
                </label>

                <div class="col-md-4">
                    <input
                        type="date"
                        class="form-control form-control-sm"
                        name="exp_date"
                        id="exp_date"
                        value="<?php echo date('Y-m-d'); ?>"
                        required>
                </div>
            </div>


            <div class="form-group row">

                <label class="col-md-3 col-form-label">

                    Upload Files

                    <br>

                    <small>
                        jpeg, jpg, png, doc, pdf
                        <br>
                        Maximum 15 MB per file
                    </small>

                </label>


                <div class="col-md-6">

                    <table
                        class="table table-bordered table-hover"
                        id="tab_logic">

                        <tbody id="file_rows">

                            <tr class="file-row">

                                <td style="width:40px;">
                                    1
                                </td>

                                <td>

                                    <input
                                        type="file"
                                        name="documents[]"
                                        class="form-control form-control-sm"
                                        accept=".jpeg,.jpg,.png,.doc,.pdf">

                                </td>

                                <td style="width:100px;">

                                    <button
                                        type="button"
                                        id="add_row"
                                        class="btn btn-sm btn-success"
                                        title="Add File">
                                        <i class="fa fa-plus"></i>
                                    </button>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>


            <div class="form-group row">

                <label class="col-md-3 col-form-label">
                    Remarks
                </label>

                <div class="col-md-4">

                    <textarea
                        id="remark"
                        name="remark"
                        rows="3"
                        class="form-control form-control-sm"
                        placeholder="Enter remark"></textarea>

                </div>

            </div>


            <div class="form-group row">

                <div class="col-md-3"></div>

                <div class="col-md-4">

                    <button
                        type="submit"
                        class="btn btn-primary btn-sm">
                        Submit
                    </button>

                    <a
                        href="<?php echo base_url('index.php/Hr/view_corporate_file_list'); ?>"
                        class="btn btn-secondary btn-sm">
                        Cancel
                    </a>

                </div>

            </div>

        </form>

    </div>
</div>


<script>
    $(document).ready(function() {

        let fileIndex = 1;

        $('#add_row').on('click', function() {

            fileIndex++;

            let row = `
            <tr class="file-row">

                <td style="width:40px;">
                    ${fileIndex}
                </td>

                <td>

                    <input
                        type="file"
                        name="documents[]"
                        class="form-control form-control-sm"
                        accept=".jpeg,.jpg,.png,.doc,.pdf"
                    >

                </td>

                <td style="width:100px;">

                    <button
                        type="button"
                        class="btn btn-sm btn-danger remove-row"
                        title="Remove"
                    >
                        <i class="fa fa-trash"></i>
                    </button>

                </td>

            </tr>
        `;

            $('#file_rows').append(row);

        });


        $(document).on('click', '.remove-row', function() {

            $(this).closest('tr').remove();

            // Renumber rows
            $('#file_rows .file-row').each(function(index) {

                $(this)
                    .find('td:first')
                    .text(index + 1);

            });

            fileIndex =
                $('#file_rows .file-row').length;

        });

    });
</script>