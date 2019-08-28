<?php /* Designed and developed by Gilbert Karogo K., a product of umatidocs.com */  

class AdminSimplelenderClientloansController extends MvcAdminController {
    
    var $default_columns = array('id', 'name');
    public $before = ['domenu'];

    public function domenu() {
        $menu_html="";
        $menu_html.="<div class='sl_menu_html'><center>";
        $menu_html.= "<a class='wp-core-ui button-primary' href=".mvc_admin_url(array('controller' => 'admin_simplelender_clientloans', 'action' => '',)).">All Loan Application</a>";
        $menu_html.= " <a class='wp-core-ui button-primary' href=".mvc_admin_url(array('controller' => 'admin_simplelender_clientloans', 'action' => 'add',)).">New Loan Applications</a>";
        $menu_html.= " | <a class='wp-core-ui button-primary' href=".mvc_admin_url(array('controller' => 'admin_simplelender_clientaccounts', 'action' => 'index',)).">All Borrowers</a>";
        

        $menu_html.="</center></div>";

        echo $menu_html;
    }
	
	public function index(){
		do_action("simplelender_welcome_lender");
		$cl_model=$this->model->find();
		//var_dump($cl_model);
		//$this->set('objects',$cl_model );
		$this->set_objects();
	}
	
	public function index_select(){
		switch($this->params['id']){
			case 1:
				$this->set('object',mvc_model("simplelenderClientloan")->find(["conditions"=>["loan_stage"=>1]]));
			break;
			case 2:
				$this->set('object',mvc_model("simplelenderClientloan"));
			
			break;
			case 3:
				$this->set('object',mvc_model("simplelenderClientloan")->find(["conditions"=>["loan_stage"=>1]]));
			
			break;
		}
		
	}
	
    public function add() {
		if (!empty($this->params['data']) && !empty($this->params['data'])) {
			$object = $this->params['data'];
			
			if (empty($object['id'])) {
				$this->model->create($this->params['data']);
				$id = $this->model->insert_id;
				$url = MvcRouter::admin_url(array('controller' => $this->name, 'action' => 'edit', 'id' => $id));
				$this->flash('notice', 'Successfully created!');
				$this->redirect($url);
			}
		}
		
		//$this->set_object();
		$this->set('loan_setting',mvc_model('simplelenderLoansetting'));
		$this->set('client_id',mvc_model('simplelenderClientaccount'));
    }
	
	public function edit() {
		if (!empty($this->params['data'])) {
		  
		  if ($this->model->save($this->params['data'])) {
			$this->flash('notice', 'Successfully saved!');
			$this->refresh();
		  } else {
			$this->flash('error', $this->model->validation_error_html);
		  }
		}
		$this->set_object();
		
		$this->set('loan_setting',mvc_model('simplelenderLoansetting'));
		$this->set('client_id',mvc_model('simplelenderClientaccount'));
	}
	
	public function process() {
		if (!empty($this->params['data']) ) {

		  $Clientloan_data = $this->params['data']['simplelenderClientloan'];
		  $original_loan_stage = mvc_model('simplelenderClientloan')->find_by_id($Clientloan_data['id'])->loan_stage;
		 
		  if ($this->model->save($this->params['data'])) {
			 //change to
		  //approval
		  //decline
		  //repayment
		  //close
		 if($Clientloan_data['loan_stage']!== $original_loan_stage ){
		  switch ( $original_loan_stage) {
		  	case 1://decline
		  		# code...
		  		break;
		  	case 2://decline
		  		# code...
		  		simplelender_class('simplelender_loan_process')->approve_loan($Clientloan_data);
		  		break;
		  	case 3://approval
		  		# code...
		  		break;
		  	case 4://repayment
		  		# code...
		  		break;
		  	case 5://close
		  		# code...
		  		break;
		  	default:
		  		# code...
		  		break;
		  }
		  $simplelenderClientloan=mvc_model('simplelenderClientloan')->find_by_id($Clientloan_data['id']);

		  do_action('simplelender_loan_status_change',[
				'borrower_id'=>$simplelenderClientloan->client_id,
				'borrower_data'=>$simplelenderClientloan,
				'loan_id'=>$Clientloan_data['id'],
				'message'=>'The status of the loan application: '.$Clientloan_data['id'].' has changed.'
				]
			);
		}
			//simplelender_class('simplelender_talk')->notity($tell_them);
			$this->flash('notice', 'Successfully Processed!');			
			$this->refresh();
		  } else {
			$this->flash('error', $this->model->validation_error_html);
		  }
		  
		}
		
		$this->set_object();
		//$this->set('loan_stage',mvc_model('simplelenderClientloanstage'));
	}
	
	public function more_loan_info() {

		$this->set_object();
	}
	
	public function goal_info() {
		
		$this->set_object();
		
	}
	
	public function delete() {
	$this->set_object();
		if (!empty($this->object)) {
		  $this->model->delete($this->params['id']);
		  $this->flash('notice', 'Successfully deleted!');
		} else {
		  $this->flash('warning', 'An Error Message with ID "'.$id.'" couldn\'t be found.');
		}
		$url = MvcRouter::admin_url(array('controller' => $this->name, 'action' => 'index'));
		$this->redirect($url);
	}
    
}

?>