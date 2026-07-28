<?php
// project_dashboard.php
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title"><br>
          <h2>Project Dashboard</h2>
          <br>
        </div>
        <div class="x_content">
          <div class="row">
            <div class="col-md-3"><div class="alert alert-info"><strong>Project:</strong><br><?= $project['project_name'] ?? '' ?></div></div>
            <div class="col-md-3"><div class="alert alert-success"><strong>Customer:</strong><br><?= $project['customer_name'] ?? '' ?></div></div>
            <div class="col-md-3"><div class="alert alert-warning"><strong>Status:</strong><br><?= $project['status'] ?? '' ?></div></div>
            <div class="col-md-3"><div class="alert alert-primary"><strong>Duration:</strong><br><?= $project['duration'] ?? '' ?> Days</div></div>
          </div>

          <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#items">Items</a></li>
            <li><a data-toggle="tab" href="#materials">Materials</a></li>
            <li><a data-toggle="tab" href="#resources">Resources</a></li>
            <li><a data-toggle="tab" href="#tasks">Tasks</a></li>
            <li><a data-toggle="tab" href="#team">Team</a></li>
            <li><a data-toggle="tab" href="#workorders">Work Orders</a></li>
            <!--<li><a data-toggle="tab" href="#timeline">Timeline</a></li>-->
          </ul>

          <div class="tab-content" style="padding-top:20px;">
            <div id="items" class="tab-pane fade in active show">
              <div class="text-right" style="margin-bottom:10px;">
                  <a href="<?= base_url('index.php/Project/edit_project/'.$project['project_id']); ?>"
                    class="btn btn-primary btn-sm">
                      <i class="fa fa-external-link"></i> Open Items
                  </a>
              </div>
              <table class="table table-bordered">
                <tr><th>#</th><th>Item</th><th>Qty</th></tr>
                <?php if(!empty($project_items)): foreach($project_items as $k=>$r): ?>
                <tr>
                  <td><?= $k+1 ?></td>
                  <td><?= $r['product_name'] ?></td>
                  <td><?= $r['quantity'] ?></td>
                </tr>
                <?php endforeach; endif; ?>
              </table>
            </div>

            <div id="materials" class="tab-pane fade">
              <div class="text-right" style="margin-bottom:10px;">
                  <a href="<?= base_url('index.php/Project/list_material_request?project_id='.$project['project_id']); ?>"
                    class="btn btn-primary btn-sm">
                      <i class="fa fa-external-link"></i> Open Material Request
                  </a>
              </div>
              <table class="table table-bordered">
                <tr><th>#</th><th>Material</th><th>Qty</th><th>Description</th><th>Remarks</th></tr>
                <?php if(!empty($materials)): foreach($materials as $k=>$r): ?>
                <tr><td><?= $k+1 ?></td><td><?= $r['product_name'] ?? '' ?> (<?= $r['mr_code'] ?? '' ?>)</td><td><?= $r['item_qty'] ?? '' ?></td><td><?php echo substr($r['item_desc'] ?? '', 0, 100); ?></td><td><?php echo substr($r['item_remarks'] ?? '', 0, 100); ?></td></tr>
                <?php endforeach; endif; ?>
              </table>
            </div>

            <div id="resources" class="tab-pane fade">
              <div class="text-right" style="margin-bottom:10px;">
                  <a href="<?= base_url('index.php/Project/project_resource_planning/'.$project['project_id']); ?>"
                    class="btn btn-primary btn-sm">
                      <i class="fa fa-external-link"></i> Open Resource Planning
                  </a>
              </div>
              <table class="table table-bordered">
                <tr><th>Machine</th><th>Operator</th></tr>
                <?php if(!empty($resources)): foreach($resources as $r): ?>
                <tr><td><?= $r['machine_name'] ?? '' ?></td><td><?= $r['employee_name'] ?? '' ?></td></tr>
                <?php endforeach; endif; ?>
              </table>
            </div>

            <div id="tasks" class="tab-pane fade">
              <div class="text-right" style="margin-bottom:10px;">
                  <a href="<?= base_url('index.php/Project/list_task/'.$project['project_id']); ?>"
                    class="btn btn-primary btn-sm">
                      <i class="fa fa-external-link"></i> Open Task Planning
                  </a>
              </div>
              <table class="table table-bordered">
                <tr><th>Task</th><th>Status</th></tr>
                <?php if(!empty($tasks)): foreach($tasks as $r): ?>
                <tr><td><?= $r['task_name'] ?? '' ?></td><td><?= $r['status'] ?? '' ?></td></tr>
                <?php endforeach; endif; ?>
              </table>
            </div>

            <div id="team" class="tab-pane fade">
              <div class="text-right" style="margin-bottom:10px;">
                  <a href="<?= base_url('index.php/Project/list_project_manpower/'.$project['project_id']); ?>"
                    class="btn btn-primary btn-sm">
                      <i class="fa fa-external-link"></i> Open Manpower Planning
                  </a>
              </div>
              <table class="table table-bordered">
                <tr><th>Employee</th><th>Designation</th></tr>
                <?php if(!empty($team)): foreach($team as $r): ?>
                <tr><td><?= $r['employee_name'] ?? '' ?></td><td><?= $r['designation_name'] ?? '' ?></td></tr>
                <?php endforeach; endif; ?>
              </table>
            </div>

            <div id="workorders" class="tab-pane fade">
              <div class="text-right" style="margin-bottom:10px;">
                  <a href="<?= base_url('index.php/Project/material_planning/'.$project['project_id']); ?>"
                    class="btn btn-primary btn-sm">
                      <i class="fa fa-external-link"></i> Open  Planning
                  </a>
              </div>
              <table class="table table-bordered">
                <tr><th>WO No</th><th>Status</th></tr>
                <?php if(!empty($work_orders)): foreach($work_orders as $r): ?>
                <tr><td><?= $r['work_order_code'] ?? '' ?></td><td><?= $r['status'] ?? '' ?></td></tr>
                <?php endforeach; endif; ?>
              </table>
            </div>

            <!--<div id="timeline" class="tab-pane fade">
              <?php if(!empty($timeline)): ?>
                <ul>
                <?php foreach($timeline as $t): ?>
                  <li><?= $t['activity'] ?? '' ?> - <?= $t['activity_date'] ?? '' ?></li>
                <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>-->
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
