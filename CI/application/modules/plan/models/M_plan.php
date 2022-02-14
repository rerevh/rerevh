<?php 
/**
 * 
 */
class M_plan extends CI_Model
{
	
	function __construct()
	{
		# code...
		parent::__construct();
	}

	function save_activity($budget=null){
		$getKeyFocusId=$this->db->get_where('tb_key_focus',['group_id'=>post('group_id')])->row_array();
		$idKeyFocus=$getKeyFocusId['id_key'];
		$code=$this->b_model->getCodeActivity(post('project_location'),post('id_project'),post('group_id'),$idKeyFocus,post('deliverables'));
		$index=substr($code,-4);
		return
		$this->db->insert('tb_detail_monthly',[
			'kode_kegiatan'		=>$code,
			'project_location'	=>post('project_location'),
			'id_project'		=>post('id_project'),
			'fund_id'			=>post('fund_id'),
			'id_group'			=>post('group_id'),
			'id_key_focus'		=>$idKeyFocus,
			'deliverables'		=>post('deliverables'),
			'activity'			=>post('activity'),
			'year'				=>post('year'),
			'month'				=>post('month'),
			'budget_status'		=>post('budget_stt'),
			'create_by'			=>$this->id_user,
			'create_date'		=>date("Y-m-d H:i:s"),
			'budget_estimaton'	=>str_replace(',','.',str_replace('.','',post('budget_es'))),
			'code_result'		=>substr(post('kode_kegiatan'),0,4),
			'code_group'		=>substr(post('kode_kegiatan'),4,3),
			'code_deliverables'	=>substr(post('kode_kegiatan'),7,3),
			'code_unik'			=>substr(post('kode_kegiatan'),11,3),
			'level_of_ta'		=>post('level_of_ta'),
			'isFavorite'		=>post('add_to_favorite'),
			'index_activity'	=>$index
		]);
	}

	function update_activity(){
		$getKeyFocusId=$this->db->get_where('tb_key_focus',['group_id'=>post('group_id')])->row_array();
		$idKeyFocus=$getKeyFocusId['id_key'];
		$getCurrentActivity = $this->getRowActivity(get_url_decode(post('IdEdit')));
		if(
			$getCurrentActivity['project_location'] != post('project_location') ||
			$getCurrentActivity['id_project'] != post('id_project') ||
			$getCurrentActivity['fund_id'] != post('fund_id') ||
			$getCurrentActivity['id_group'] != post('group_id') ||
			$getCurrentActivity['id_key_focus'] != $idKeyFocus ||
			$getCurrentActivity['deliverables'] != post('deliverables')
		){
			$this->code=$this->b_model->getCodeActivity(post('project_location'),post('id_project'),post('group_id'),$idKeyFocus,post('deliverables'));
		} else {
			$this->code=get_url_decode(post('IdEdit'));
		}
		$index=substr($this->code,-4);
		$this->db->where('kode_kegiatan',get_url_decode(post('IdEdit')));
		return
		$this->db->update('tb_detail_monthly',[
			'kode_kegiatan'		=>$this->code,
			'project_location'	=>post('project_location'),
			'id_project'		=>post('id_project'),
			'fund_id'			=>post('fund_id'),
			'id_group'			=>post('group_id'),
			'id_key_focus'		=>$idKeyFocus,
			'deliverables'		=>post('deliverables'),
			'activity'			=>post('activity'),
			'year'				=>post('year'),
			'month'				=>post('month'),
			'create_by'			=>$this->id_user,
			'create_date'		=>date("Y-m-d H:i:s"),
			'budget_estimaton'	=>str_replace(',','.',str_replace('.','',post('budget_es'))),
			'code_result'		=>substr(post('kode_kegiatan'),0,4),
			'code_group'		=>substr(post('kode_kegiatan'),4,3),
			'code_deliverables'	=>substr(post('kode_kegiatan'),7,3),
			'code_unik'			=>substr(post('kode_kegiatan'),11,3),
			'level_of_ta'		=>post('level_of_ta'),
			'isFavorite'		=>post('add_to_favorite'),
			'index_activity'	=>$index
		]);
	}

	function getListPo($kode){
		$this->db->where('code_activity',$kode);
		return $this->db->get('tb_purchase_request_activity');
	}
	function detele_actifity($id){
		$this->db->where('kode_kegiatan',$id);
		return $this->db->delete('tb_detail_monthly');
	}

	function getKeyFocus($id=null){
		$this->db->select('id_key as id, key_name as val');
		$this->db->from('tb_key_focus');
		if($id!=null){
			$this->db->where('group_id',$id);
		}
		return $this->db->get();
	}

	function getKeyFocusGroup($group=null){
		return $this->db->select('*')
			->from('tb_key_focus')
            ->where('group_id', $group)
            ->get()->result();
	}

	function getKeyActivities($group=null){
		return $this->db->select('*')
		->from('tb_deliverable as dl')
		->join('tb_key_focus as f','f.id_key=dl.id_key')
		->join('tb_group as g','g.id_group=f.id_key')
		//->where('g.mapping_id_units',$group)
		->get()->result();
	}

	function getDeliverableByGroup($idGroup=null){
		return
		$this->db->select("dl.id_deliv as id, dl.deliv as val")
		->from("tb_deliverable as dl")
		->join('tb_key_focus as f','f.id_key=dl.id_key')
		->where("f.group_id",$idGroup)
		->where("dl.deliv NOT IN('Other','other')")
		->get();
	}

	function getDeliverable($id=null){
		$this->db->select('id_deliv as id, deliv as val');
		$this->db->from('tb_deliverable');
		if($id!=null){
			$this->db->where('id_key',$id);
		}
		return $this->db->get();
	}

	function getRowActivity($id=null){
		$this->db->where('kode_kegiatan',$id);
		return $this->db->get('tb_detail_monthly')->row_array();
	}

	function UpdateMonthlyActivityStatus($idActivity=null){
		$this->db->where('kode_kegiatan',get_url_decode($idActivity));
		if(post('status')=='1'){
			return $this->db->update('tb_detail_monthly',[
				'status'=>'1'
			]);
		}elseif(post('status')=='2'){
			return $this->db->update('tb_detail_monthly',[
				'status'=>'2',
				'month_postponse'=>post('month')
			]);
		}elseif(post('status')=='3'){
			return $this->db->update('tb_detail_monthly',[
				'status'=>'3',
				'reason'=>post('reason')
			]);
		}else{
			return false;
		}
	}
	function getDirectFundNumber($key){
		$this->db->select("direct_fund_code");
		$this->db->from('tb_mini_proposal_new');
		$this->db->where('code_activity',get_url_decode($key));
		return $this->db->get()->row_array();
	}

	function delete_directFund($key){
		$this->db->where('direct_fund_code',$key);
		return $this->db->delete('tb_mini_proposal_new');
	}

	function restore_directFund($key,$df=null){
		$this->db->trans_start();
		if($df!=null){
			$this->db->where('direct_fund_code',$key);
			$this->db->delete('tb_mini_proposal_new');
		}		
		$this->db->where('kode_kegiatan',$key);
		$this->db->update('tb_detail_monthly',[
			'status'=>'0'
		]);
		$this->db->trans_complete();
		return $this->db->trans_status();
	}

	function cek_existing_reimplementing_activities_from_favorites($month=null,$year=null,$code_activity=null){
		$counting=$this->db->get_where('tb_detail_monthly',[
					'month'=>$month,
					'year'=>$year,
					'activity_code_references'=>$code_activity
				])->num_rows();
		if($counting > 0){
			return true;
		}else{
			return false;
		}
	}

	function reImplementing($code_activity=null,$activities=null,$month=null,$year=null){
		$this->db->trans_start();
		$recordActivities = $this->getRowActivity($code_activity);
		$code=$this->b_model->getCodeActivity($recordActivities['project_location'],$recordActivities['id_project'],$recordActivities['id_group'],$recordActivities['id_key_focus'],$recordActivities['deliverables']);
		$index=substr($code,-4);
		$this->db->insert('tb_detail_monthly',[
			'kode_kegiatan'		=>$code,
			'project_location'	=>$recordActivities['project_location'],
			'id_project'		=>$recordActivities['id_project'],
			'fund_id'			=>$recordActivities['fund_id'],
			'id_group'			=>$recordActivities['id_group'],
			'id_key_focus'		=>$recordActivities['id_key_focus'],
			'deliverables'		=>$recordActivities['deliverables'],
			'activity'			=>$activities,
			'year'				=>$year,
			'month'				=>$month,
			'budget_status'		=>$recordActivities['budget_status'],
			'create_by'			=>$this->id_user,
			'create_date'		=>date("Y-m-d H:i:s"),
			'budget_estimaton'	=>$recordActivities['budget_estimaton'],
			'code_result'		=>substr($code,0,4),
			'code_group'		=>substr($code,4,3),
			'code_deliverables'	=>substr($code,7,3),
			'code_unik'			=>substr($code,11,3),
			'level_of_ta'		=>$recordActivities['level_of_ta'],
			'activity_code_references'		=>$recordActivities['kode_kegiatan'],
			'index_activity'	=>$index
		]);
		
		$itemsPr=$this->get_items_pr_by_activities($code_activity);
		foreach ($itemsPr as $row) {
			$this->db->insert(
				'tb_purchases_item_temp',
				[
					'code_activity' => $code,
					'item_id' => $row->item_id,
					'spec' => $row->spec,
					'qty' => $row->qty,
					'unit' => $row->unit,
					'unit_price' => $row->unit_price,
					'po' => $row->po,
					'id_specification' => $row->id_specification,
					'created_on' => date('Y-m-d H:i:s'),
					'created_by' => $this->session->us_id
				]
			);
		}
		$this->db->trans_complete();
		if($this->db->trans_status() == true){
			$this->db->trans_commit();
			return true;
		} else {
			$this->db->trans_roolback();
			return false;
		}
		
	}

	function get_items_pr_by_activities($code_activity){
		return
		$this->db->select("a.*")
		->from("tb_purchases_item a ")
		->join("tb_mini_proposal_new b","b.direct_fund_code = a.df_code","left")
		->where("b.code_activity",$code_activity)
		->get()
		->result();
	}
	
	function get_budget_reviewer(){
		return
		$this->db->select("username, email")
		->from("tb_userapp")
		->where("is_budget_reviewer",1)
		->get()
		->result();
	}	
}