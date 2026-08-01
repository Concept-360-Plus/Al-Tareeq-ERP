<?php
class Production_model extends CI_Model
{
    function get_wo_details()
    {
        $query=$this->db->query("select * from project_work_order order by created_date desc");
        return $query->result();
    }	

    function get_production_tr_by_id_item($id)
    {
        $query = $this->db->query("select *  from project_production_transaction where ptrans_id =$id");

        return $query->result();
    }
    function transaction_production($id)
    {
        // $query = $this->db->query("SELECT pp.*, pt.* FROM project_production pp JOIN project_production_transaction pt ON pp.production_id = pt.production_master_id AND pp.production_id=$id ORDER BY pp.completion_date DESC");
        $query = $this->db->query("SELECT pp.*, pt.* FROM project_production pp JOIN project_production_transaction pt ON pp.production_id = pt.production_master_id AND pp.production_id=$id group by pp.production_id ORDER BY pp.completion_date DESC");
        return $query->result();
    }
    function get_production_list()
    {
        // $query=$this->db->query("select * from project_work_order order by work_order_date desc");
        $query=$this->db->query("select wo.*, pm.* from project_work_order wo,project_master pm where wo.project_id = pm.project_id order by work_order_date desc");
        return $query->result();
    }	
    function get_production_list_records()
    {
        // $query = $this->db->query("SELECT pp.*, pt.* FROM project_production pp JOIN project_production_transaction pt ON pp.production_id = pt.production_master_id ORDER BY pp.completion_date DESC");
        // $query = $this->db->query("SELECT pp.*, pt.*, pm.*, wo.* FROM project_production pp, project_production_transaction pt,project_work_order wo, project_master pm where pp.production_id = pt.production_master_id and pp.work_id = wo.work_id and wo.project_id = pm.project_id ORDER BY pp.completion_date DESC");
        $query = $this->db->query("SELECT pp.*, pt.*, pm.*, wo.* FROM project_production pp, project_production_transaction pt,project_work_order wo, project_master pm where pp.production_id = pt.production_master_id and pp.work_id = wo.work_id and wo.project_id = pm.project_id group by pp.production_id ORDER BY pp.completion_date DESC");
        return $query->result();
    }	


    function add_production_details()
    {
        $prifix = 'PD/' . date('y') . '/';
        $this->load->model('Setup_model');
        $num = $this->Setup_model->get_next_code($prifix, 'p_code', 'project_production', 7) + 1;
        $digit = sprintf("%1$04d", $num);
        $code = $prifix . $digit;

            

        $data = array(
            'work_id' => $this->input->post('work_id'),
            'p_code' => $this->input->post('p_code'),
            'completion_date' => date('Y-m-d', strtotime($this->input->post('completion_date'))),
            'handed_over_to' => $this->input->post('handed_over_to'),
            'wo_status' => $this->input->post('wo_status'),
            'remark' => $this->input->post('remark'),
            'created_by' => $this->session->userdata('user_id'),
            'created_date' => date('Y-m-d'),
        );
        $this->db->insert('project_production', $data);
        $insert_id = $this->db->insert_id();

        //ss for ($c = 0; $c < count($_POST['desc']); $c++) {
        /*if(isset($_POST['desc'])):
                for ($c = 0; $c < count($_POST['desc']); $c++) {
                    $trans_id= $_POST['trans_id'][$c];

                    $data2 = array(
                        'production_master_id' => $insert_id,
                        // 'production_type' => $_POST['product_id'][$c],
                        'product_desc' => $_POST['desc'][$c],
                        'item_remark' => $_POST['item_remark'][$c],
                    );
                    $this->db->insert('project_production_transaction', $data2);
                }

                for ($j = 0; $j < count($_POST["sub_details$trans_id"]); $j++)
                {

                $data = array(
                'trans_id1' => $insert_id,
                'sub_details' => $_POST["sub_details$trans_id"][$j],
                'qty' =>  $_POST["qty"][$j],
                'width' =>  $_POST["width$trans_id"][$j],
                'height' =>  $_POST["height$trans_id"][$j],
                'unit' =>  $_POST["unit$trans_id"][$j],
                'price' =>  $_POST["price$trans_id"][$j],
                'total' =>  $_POST["total$trans_id"][$j],
                'colour_finish' => $_POST['colour_finish'][$j],
                'item_name' => $_POST['item_name'][$j],
                'item_code' => $_POST['item_code'][$j],
                'quantity_released' => $_POST['quantity_released'][$j],
                'completion' => $_POST['completion'][$j],


                );
                $this->db->insert('project_production_transaction1', $data);
            }
        endif;
        */
        $data2 = array(
            'production_master_id' => $insert_id,
            'product_desc' => $this->input->post('remark'),
            'item_remark' => $this->input->post('remark')
        );
        $this->db->insert('project_production_transaction', $data2);
        if ($insert_id) {
            $user_se_id = $this->session->userdata('user_id');
            $page_name = explode('index.php/', $_SERVER['PHP_SELF']);
            $ci = get_instance();
            $ci->load->helper('log');
            $log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'project_production', 'production_id', $insert_id);
        }
        return $insert_id;
    }


    function update_production_details($id)
    {

        $data = array(
            'remark' => $this->input->post('remark'),
            'wo_status' => $this->input->post('wo_status'),
            'completion_date' => date('Y-m-d', strtotime($this->input->post('completion_date'))),

        );
        $this->db->where('production_id', $id);
        $res = $this->db->update('project_production', $data);


        // for ($c = 0; $c < count($_POST['product_id']); $c++) {
        // 	$data2 = array(
        // 		'production_master_id' => $id,
        // 		'production_desc' => $_POST['desc'][$c],
        // 		'production_type' => $_POST['product_id'][$c],
        // 		'tot_quantity' => $_POST['tot_quantity'][$c],
        // 		'quantity_released' => $_POST['quantity_released'][$c],
        // 		'unit' => $_POST['unit'][$c],
        // 		'completion' => $_POST['completion'][$c],

        // 	);
        // 	$this->db->update('project_production_transaction', $data2);
        // }

        if ($id) {
            $user_se_id = $this->session->userdata('user_id');
            $page_name = explode('index.php/', $_SERVER['PHP_SELF']);
            $ci = get_instance();
            $ci->load->helper('log');
            $log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'project_production', 'production_id', $id);

        }
        return $id;
    }

    function delete_production($id)
    {
        $query = $this->db->query(" delete from project_production where production_id=$id");
        $query = $this->db->query(" delete from project_production_transaction where production_master_id=$id");

    }


    function get_project_wo_trans($id)
    {
        $query=$this->db->query("select * from project_work_order_transaction where trans_id = '$id' ");
        // $query=$this->db->query("select * from project_production_transaction where ptrans_id = '$id' ");

        return $query->result();
    }

    function get_project_wo_trans1($id)
    {
        // $query=$this->db->query("select * from project_work_order_transaction1 where trans_id1 = '$id' ");
            $query=$this->db->query("select one.*, three.unit_abbr from (select * from project_work_order_transaction1  where trans_id1='$id' )as one  left join(select * from unit_master)as three on(one.unit=three.unit_id)");
        // $query=$this->db->query("select one.*, two.item_name, two.item_code, three.unit_abbr from (select * from project_work_order_transaction1  where trans_id1='$id' )as one left join(select * from item_master)as two on(one.sub_details=two.item_id) left join(select * from unit_master)as three on(one.unit=three.unit_id)");
        
        return $query->result();
    }

    //////////////////////////// production items //////////////////////

    function get_wo_items_trans1($id)
    {
        
        $query=$this->db->query("select * from project_work_order_transaction where pid='$id'");
        return $query->result();
    }
    function get_wo_items_trans2($id)
    {
        $query=$this->db->query("select one.*, two.unit_abbr from (select * from project_work_order_transaction1  where pid='$id' )as one  left join(select * from unit_master)as two on(one.unit=two.unit_id)");
        // $query=$this->db->query("select * from project_work_order_transaction1  where pid='$id'");
        return $query->result();
    }



    function get_wo_trans($id)
    {
        $query=$this->db->query("select * from project_production_transaction where ptrans_id = '$id' ");
        return $query->result();
    }

    function get_wo_trans1($id)
    {
            $query=$this->db->query("select one.*, three.unit_abbr from (select * from project_production_transaction1  where trans_id1='$id' )as one  left join(select * from unit_master)as three on(one.unit=three.unit_id)");
        
        return $query->result();
    }    

    //approve production
    function qc_approve_production($id,$approve_id)
{

	$data = array(
		'qc_approve_flag' => $approve_id,
		'qc_approved_by' => $this->session->userdata('user_id'),
		'qc_approved_date' => date('Y-m-d H:i:s'),
	);
	$this->db->where('production_id', $id);
	$res = $this->db->update('project_production', $data);


	if ($id) {
		$user_se_id = $this->session->userdata('user_id');
		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
		$ci = get_instance();
		$ci->load->helper('log');
		$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'project_production', 'production_id', $id);
	}
	return $id;
}

function packing_approve_production($id,$approve_id)
{

	$data = array(
		'packing_flag' => $approve_id,
		'packing_by' => $this->session->userdata('user_id'),
		'packing_date' => date('Y-m-d H:i:s'),

	);
	$this->db->where('production_id', $id);
	$res = $this->db->update('project_production', $data);


	if ($id) {
		$user_se_id = $this->session->userdata('user_id');
		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
		$ci = get_instance();
		$ci->load->helper('log');
		$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'project_production', 'production_id', $id);
	}
	return $id;
}

function transport_approve_production($id,$approve_id)
{

	$data = array(
		'transport_flag' => $approve_id,
		'transport_by' => $this->session->userdata('user_id'),
		'transport_date' => date('Y-m-d H:i:s'),

	);
	$this->db->where('production_id', $id);
	$res = $this->db->update('project_production', $data);
	if ($id) {
		$user_se_id = $this->session->userdata('user_id');
		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
		$ci = get_instance();
		$ci->load->helper('log');
		$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'project_production', 'production_id', $id);
	}
	return $id;
}

}
