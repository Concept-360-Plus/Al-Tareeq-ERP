<?php
$lastMilestone = $last_log['milestone'] ?? '';
$lastStatus    = $last_log['current_status'] ?? 'Not Started';
$lastProgress  = $last_log['progress_percentage'] ?? 0;
?>
<div class="row">
<div class="col-md-12">
<div class="x_panel">
<h4><?= htmlspecialchars($project['project_name']) ?></h4>

<div class="mb-3">
    <strong>Start Date:</strong>
    <?= date('d-m-Y', strtotime($project['start_date'])) ?> |
    <strong>End Date:</strong>
    <?= date('d-m-Y', strtotime($project['end_date'])) ?>
</div>

<form method="post"
      action="<?= base_url('index.php/Project/save_project_progress') ?>"
      enctype="multipart/form-data"
      id="progressForm">

<input type="hidden" name="project_id" value="<?= $project['project_id'] ?>">

<div class="row">
    <div class="col-md-2">
        <label>Date <span class="text-danger">*</span></label>
        <input type="date"
               name="log_date"
               class="form-control"
               value="<?= date('Y-m-d') ?>"
               required>
    </div>

    <div class="col-md-2">
        <label>Start Time <span class="text-danger">*</span></label>
        <input type="time"
               name="start_time"
               class="form-control"
               required>
    </div>

    <div class="col-md-2">
        <label>End Time <span class="text-danger">*</span></label>
        <input type="time"
               name="end_time"
               class="form-control"
               required>
    </div>

    <div class="col-md-2">
        <label>Milestone <span class="text-danger">*</span></label>
        <input type="text"
               name="milestone"
               class="form-control"
               value="<?= htmlspecialchars($lastMilestone) ?>"
               required>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-4">
        <label>Status <span class="text-danger">*</span></label>
        <select name="current_status" class="form-control" required>
            <option value="Not Started" <?= $lastStatus=='Not Started'?'selected':'' ?>>Not Started</option>
            <option value="In Progress" <?= $lastStatus=='In Progress'?'selected':'' ?>>In Progress</option>
            <option value="Completed" <?= $lastStatus=='Completed'?'selected':'' ?>>Completed</option>
        </select>
    </div>

    <div class="col-md-4">
        <label>
            Progress <span class="text-danger">*</span> :
            <!-- <span id="progressValue"><?= $lastProgress ?>%</span> -->
        </label>

        <!--<input type="range"
               name="progress_percentage"
               id="progressRange"
               class="form-range"
               min="0"
               max="100"
               value="<?= $lastProgress ?>"
               required
               oninput="updateProgress(this.value)">

        <div class="progress mt-2" style="height:25px;">
            <div id="progressBar"
                 class="progress-bar progress-bar-striped progress-bar-animated"
                 style="width:<?= $lastProgress ?>%">
                <?= $lastProgress ?>%
            </div>
        </div>-->
        <?php  $row['progress']      = $this->Project_model->get_project_progress_byid($project['project_id']);
       ?>
        <div class="progress mt-2" style="height:25px;">
            <div id="progressBar"
                 class="progress-bar progress-bar-striped progress-bar-animated" readonly
                 style="width:<?= $row['progress'] ?>%">
                <?= $row['progress'] ?>%
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <label>Site Images / Files</label>
    <input type="file"
           id="siteFilesInput"
           multiple
           accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx">
    <div id="selectedFiles" class="mt-2"></div>
</div>
<div class="col-md-8">
<div class="mt-3">
    <label>Remarks</label>
    <textarea name="remarks" class="form-control" colspan="4" rowspan="4" style="height: 125px;
    width: 75%;"></textarea>
</div></div>
<div class="col-md-10">
<div class="mt-3 text-end">
    <button type="submit" class="btn btn-success">
        Save Progress
    </button>
</div>
</form>

<hr>

<h5>Progress History</h5>

<table class="table table-bordered table-sm">
<thead>
<tr>
    <th>Date</th>
    <th>Start</th>
    <th>End</th>
    <th>Milestone</th>
    <th>Status</th>
    <!-- <th>Progress</th> -->
    <th>Files</th>
    <th>Remarks</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
<?php foreach ($logs as $log): ?>
<tr>
    <td><?= date('d-m-Y', strtotime($log['log_date'])) ?></td>
    <td><?= $log['start_time'] ?></td>
    <td><?= $log['end_time'] ?></td>
    <td><?= htmlspecialchars($log['milestone']) ?></td>
    <td>
        <span class="badge
            <?= $log['current_status']=='Completed'?'bg-success':
                ($log['current_status']=='In Progress'?'bg-warning':'bg-secondary') ?>">
            <?= $log['current_status'] ?>
        </span>
    </td>
    <!-- <td><?= $log['progress_percentage'] ?>%</td> -->
    <td>
        <?php if (!empty($log['site_files'])):
            foreach (json_decode($log['site_files'], true) as $file):
                $url = base_url('public/stamp/'.$file);
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        ?>
            <?php if (in_array($ext, ['jpg','jpeg','png'])): ?>
                <a href="<?= $url ?>" target="_blank">
                    <img src="<?= $url ?>" style="width:60px;height:60px;">
                </a>
            <?php else: ?>
                <a href="<?= $url ?>" target="_blank"><?= htmlspecialchars($file) ?></a><br>
            <?php endif; ?>
        <?php endforeach; endif; ?>
    </td>
    <td><?= htmlspecialchars($log['remarks']) ?></td>

<td>
    <button type="button"
            class="btn btn-danger btn-sm delete-log"
            data-id="<?= $log['log_id'] ?>">
        Delete
    </button>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div></div></div>
<script>

let allFiles = [];


/* ==========================================================
   FILE SELECTION
========================================================== */

document.getElementById('siteFilesInput').addEventListener(
    'change',
    function () {

        let newFiles = Array.from(this.files);

        newFiles.forEach(function (newFile) {

            let isDuplicate = allFiles.some(function (existingFile) {

                return existingFile.name === newFile.name &&
                       existingFile.size === newFile.size &&
                       existingFile.lastModified === newFile.lastModified;

            });


            if (isDuplicate) {

                alert(
                    'File already added: ' +
                    newFile.name
                );

            } else {

                allFiles.push(newFile);

            }

        });


        renderFiles();


        /*
         * Reset input so the same file can be selected again
         * after removing it.
         */

        this.value = '';

    }
);


/* ==========================================================
   DISPLAY SELECTED FILES
========================================================== */

function renderFiles()
{

    const list =
        document.getElementById('selectedFiles');


    list.innerHTML = '';


    allFiles.forEach(function (file, i) {

        const d =
            document.createElement('div');


        d.className =
            'mb-1';


        d.innerHTML =
            '<span>' +
            file.name +
            '</span> ' +

            '<button type="button" ' +
            'class="btn btn-xs btn-danger" ' +
            'onclick="removeFile(' + i + ')">' +

            'Remove' +

            '</button>';


        list.appendChild(d);

    });

}


/* ==========================================================
   REMOVE SELECTED FILE
========================================================== */

function removeFile(i)
{

    allFiles.splice(i, 1);

    renderFiles();

}


/* ==========================================================
   SAVE PROJECT PROGRESS
========================================================== */

document.getElementById('progressForm')
.addEventListener('submit', function (e) {

    e.preventDefault();


    const form = this;


    /*
     * Get status
     */

    const statusElement =
        form.querySelector(
            'select[name="current_status"]'
        );


    const status =
        statusElement
            ? statusElement.value
            : '';


    /*
     * Get current project progress.
     *
     * We are no longer using #progressRange
     * because the progress slider was removed.
     */

    const progressElement =
        document.getElementById(
            'progressPercentage'
        );


    const progress =
        progressElement
            ? parseFloat(progressElement.value) || 0
            : 0;


    /* ======================================================
       COMPLETED VALIDATION
    ====================================================== */

    if (
        status === 'Completed' &&
        progress < 100
    ) {

        alert(
            'A project cannot be marked as Completed until progress reaches 100%.'
        );

        return;

    }


    /* ======================================================
       TIME VALIDATION
    ====================================================== */

    const startTimeElement =
        form.querySelector(
            'input[name="start_time"]'
        );


    const endTimeElement =
        form.querySelector(
            'input[name="end_time"]'
        );


    if (
        !startTimeElement ||
        !endTimeElement
    ) {

        alert('Start time and End time are required.');

        return;

    }


    const startTime =
        startTimeElement.value;


    const endTime =
        endTimeElement.value;


    if (!startTime || !endTime) {

        alert(
            'Start time and End time are required.'
        );

        return;

    }


    if (startTime >= endTime) {

        alert(
            'End time must be greater than start time'
        );

        return;

    }


    /* ======================================================
       CREATE FORM DATA
    ====================================================== */

    const fd =
        new FormData(form);


    /*
     * Add selected files
     */

    allFiles.forEach(function (file) {

        fd.append(
            'site_files[]',
            file
        );

    });


    /* ======================================================
       DISABLE BUTTON
    ====================================================== */

    const submitButton =
        form.querySelector(
            'button[type="submit"]'
        );


    if (submitButton) {

        submitButton.disabled = true;

        submitButton.innerHTML =
            '<i class="fa fa-spinner fa-spin"></i> Saving...';

    }


    /* ======================================================
       SAVE USING FETCH
    ====================================================== */

    fetch(
        form.action,
        {
            method: 'POST',
            body: fd
        }
    )

    .then(function (response) {

        /*
         * We don't know whether your controller returns
         * JSON or redirects/HTML, so don't force response.json().
         */

        return response.text();

    })

    .then(function (response) {

        /*
         * Save successful.
         *
         * Reload page to show the new progress log.
         */

        location.reload();

    })

    .catch(function (error) {

        console.error(
            'Save Progress Error:',
            error
        );


        alert(
            'Unable to save project progress.'
        );


        if (submitButton) {

            submitButton.disabled = false;

            submitButton.innerHTML =
                'Save Progress';

        }

    });

});


/* ==========================================================
   STATUS CHANGE
========================================================== */

const statusSelect =
    document.querySelector(
        'select[name="current_status"]'
    );


if (statusSelect) {

    statusSelect.addEventListener(
        'change',
        function () {

            const progressElement =
                document.getElementById(
                    'progressPercentage'
                );


            const progress =
                progressElement
                    ? parseFloat(progressElement.value) || 0
                    : 0;


            if (
                this.value === 'Completed' &&
                progress < 100
            ) {

                alert(
                    'Progress must be 100% before marking as Completed.'
                );


                this.value =
                    'In Progress';

            }

        }
    );

}


/* ==========================================================
   DELETE PROGRESS LOG
========================================================== */

document.addEventListener(
    'click',
    function (e) {

        if (
            e.target.classList.contains(
                'delete-log'
            )
        ) {

            const logId =
                e.target.getAttribute(
                    'data-id'
                );


            if (
                !confirm(
                    'Are you sure you want to delete this entry?'
                )
            ) {

                return;

            }


            fetch(
                '<?= base_url("index.php/Project/delete_progress_log") ?>',
                {
                    method: 'POST',

                    headers: {
                        'Content-Type':
                            'application/x-www-form-urlencoded'
                    },

                    body:
                        'log_id=' +
                        encodeURIComponent(logId)

                }
            )

            .then(function (res) {

                return res.json();

            })

            .then(function (res) {

                if (
                    res.status === 'success'
                ) {

                    alert(
                        'Deleted successfully'
                    );

                    location.reload();

                } else {

                    alert(
                        res.message ||
                        'Delete failed'
                    );

                }

            })

            .catch(function (err) {

                console.error(
                    'Delete Error:',
                    err
                );

                alert(
                    'Unable to delete progress log.'
                );

            });

        }

    }
);

</script>