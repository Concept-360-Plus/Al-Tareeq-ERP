<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="pull-right">
                    <a href="<?= base_url('index.php/Setup/add_raw_material') ?>"
                       class="btn btn-success btn-sm">
                        <i class="fa fa-plus"></i>Add Raw Material
                    </a>
                </div>
      <div class="x_content">
<table id="rawMaterialTable" class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Material Code</th>
              <th>Material Name</th>
              <th>Unit</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $i=1; foreach($all_raw_materials as $material){ ?>
              <tr>
                <th scope="row"><?php echo $i; ?></th>
                <td><?php echo $material->material_code; ?></td>
                <td><?php echo $material->material_name; ?></td>
                <td><?php echo $material->unit; ?></td>
                <td>
                    <a href='<?php echo base_url().'index.php/Setup/edit_raw_material/'.$material->material_id; ?>' title='Edit' class="btn btn-primary btn-sm">Edit</a>

                    &nbsp;&nbsp;&nbsp;&nbsp;

                    <a href='<?php echo base_url().'index.php/Setup/delete_raw_material/'.$material->material_id; ?>'
   title='Delete'
   onclick="return confirm('Are you sure you want to delete this raw material?');" class="btn btn-danger btn-sm">
   Delete
</a>
                </td>
              </tr>
            <?php $i++; } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function() {
    $('#rawMaterialTable').DataTable({
        "pageLength": 10
    });
});
</script>