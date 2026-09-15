 <link href="<?php echo base_url()."public/assets/dashboard.css"; ?>" rel="stylesheet"/>
 <style>
    @media print {
        .menu_toggle{
            display: none !important;
        }
        .no-print {
            display: none !important;
        }

        .print-hide {
            display: none !important;
        }

        @page {
            margin: 10mm;
        }

        body {
            background: #fff !important;
        }
         .st-header {
            width: 100%;
            height: 140px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }

        .st-header-logo {
            width: 55%;
        }

        .st-header-logo img {
            width: 380px;
            max-width: 100%;
            max-height: 130px;
            height: auto;
            object-fit: cover;
            display: block;
        }

        .st-header-right {
            width: 45%;
            text-align: right;
        }

        .st-header-right img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            display: block;
            margin-left: auto;
        }

        .st-trn {
            font-size: 11px;
            font-weight: bold;
            margin-top: 3px;
        }
        .title_left{ display: none !important; }
        .btn-group { display: none !important; }
        .nav_menu{ display: none !important; }

    }
    @media screen {
        .st-header {
            display: none !important;
        }

       
    }
</style>

<div class="container-fluid">
   
    <div class="st-header">

        <div class="st-header-logo">

            <?php if (!empty($company['company_logo'])) { ?>

                <img
                    src="<?= base_url($company['company_logo']) ?>"
                    alt="Company Logo"
                >

            <?php } ?>

        </div>

        <div class="st-header-right">

            <img
                src="<?= base_url('uploads/company/barcode.png') ?>"
                alt="QR Code"
            >

            <div class="st-trn">
                TRN:
                <?= htmlspecialchars($company['company_trn'] ?? '') ?>
            </div>

        </div>

    </div>


    <!-- Print Button -->
    <div class="text-right" style="margin-bottom:15px;">

    <button type="button" class="btn btn-default no-print"  onclick="window.print();">

    <i class="fa fa-print"></i>
    Print

</button>
        
        <a href="<?= base_url('index.php/Project/get_project_list') ?>"
           class="btn btn-default no-print">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>
    
    <!-- Project Information -->
    <?php $this->load->view('project/report/project_information'); ?>
    <?php 
        $this->load->view('project/report/task_summary'); 
        $this->load->view('project/report/attendance');
        $this->load->view('project/report/material_requests');
       
        $this->load->view('project/report/work_orders');
        //$this->load->view('project/report/outsource');
        //$this->load->view('project/report/progress_history');
        //$this->load->view('project/report/cost_summary');
        
    ?>
    <a href="javascript:void(0);" id="goTop" title="Go to Top">
        <i class="fa fa-chevron-up"></i>
    </a>
    <script>
    $(document).ready(function(){

        $(window).scroll(function(){

            if($(this).scrollTop() > 250){

                $('#goTop').fadeIn();

            }else{

                $('#goTop').fadeOut();

            }

        });

        $('#goTop').click(function(){

            $('html, body').animate({

                scrollTop:0

            },600);

        });

    });
    </script>
    <!-- Task Summary -->
    <!-- Attendance -->
    <!-- Material Requests -->
    <!-- Work Orders -->
    <!-- Outsource -->
    <!-- Progress -->
    <!-- Cost Summary -->


