<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attributes extends MX_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
        public $content;
        public $redirectroot = "administrator";

        public function __construct(){
            parent::__construct();
		$this->load->model('Common_model');
            $this->load->module("Layout"); //Load Layout module
            $this->load->library('pagination');
		$this->load->helper('url');
            $this->load->library('form_validation');
            
            $tableName = 'manage_attributes';
            if (!$this->db->table_exists($tableName)){
                $this->load->dbforge();
                $attributes = array('ENGINE' => 'InnoDB');
                $fields = array(
                                'id' => array(
                                        'type' => 'INT',
                                        'constraint' => 5,
                                        'unsigned' => TRUE,
                                        'auto_increment' => TRUE
                                ),
                                'title' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '100'
                                ),
                                'slug' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '100',
                                        'default' => '',
                                ),
                                'short_desc' => array(
                                        'type' => 'VARCHAR',
                                        'constraint' => '255'
                                ),
                                'parent_id' => array(
                                        'type' =>'TINYINT',
                                        'constraint' => '2',
                                        'default' => '0',
                                ),
                                'status' => array(
                                        'type' =>'INT',
                                        'constraint' => '11',
                                        'default' => '0',
                                ),
                                'ordering' => array(
                                        'type' =>'INT',
                                        'constraint' => '11',
                                        'default' => '0',
                                ),
                                'is_delete' => array(
                                        'type' =>'TINYINT',
                                        'constraint' => '2',
                                        'default' => '0',
                                ),
                );
                $attributes = array('ENGINE' => 'InnoDB');
                $this->dbforge->add_field($fields,$attributes);
                $this->dbforge->add_key('id', TRUE);
                $attributes = array('ENGINE' => 'InnoDB');
                $this->dbforge->create_table($tableName, FALSE, $attributes);
            } 
            $this->content['module_root'] = $this->redirectroot;
                       
        }
        public function attribute_list($page = 1){
			
            if(isset($_REQUEST['parent_id']) && $_REQUEST['parent_id']!=''){
               $this->Common_model->setFilter(array('parent_id'=>$_REQUEST['parent_id']));
            }
            $filter = $this->Common_model->getFilter();
            $setValues = array('table'=>'manage_attributes');
            if(count($filter)>0){
                foreach ($filter as $key=>$val){
                    $setValues['where'][$key] = $val; 
                }   
            }
            $this->Common_model->set('all',$setValues);
            $config['per_page'] = 10;
            $config['base_url'] = base_url($this->redirectroot.'/attribute-list');
            $config['total_rows'] = $this->Common_model->getNum();
            
            $this->Common_model->setPaginationConfig('base_url',$total_rows = 0,$per_page = 10,$uri_segment= 2);
            $offset  = ($page - 1) * $config['per_page'];
            $limit = $config['per_page'];

            $setValues = array(
                    'table' => 'manage_attributes',
                    'order_by' => array('id'=>'desc'),
                    'where' => array('status'=>'1'),
                    'offset' => $offset,
                    'limit' => $limit
                    ); 
            if(count($filter)>0){
                foreach ($filter as $key=>$val){
                    $setValues['where'][$key] = $val; 
                }
            }
            $this->Common_model->set('all', $setValues);

            $data = $this->Common_model->get();
            $this->content['data'] = $data;
            $setValues = array('table'=>'manage_attributes',
                               'where' => array('parent_id'=>0)
                            );
            $this->Common_model->set('all', $setValues);
            $parentAttributes = $this->Common_model->get();
            $this->content['parentAttributes'] = $parentAttributes;
            if(count($filter)>0){
                $this->content['filter'] = $filter;
            }
            $this->content['per_page'] = $config['per_page'];
            $this->content['views'][] = 'admin/attribute_list';
            //print_r($this->content);die;
            //$this->load->view('attribute_list', $this->content);
            $this->content['module'] = 'Attributes';
            $this->content['view'] = 'attribute_list';
            
            $this->layout->adminTheme($this->content);
        }

	public function attribute_form($id = 0){ 
            $this->form_validation->set_rules('title', 'Title', 'required');
            if ($this->form_validation->run() == TRUE){
                $id = $this->input->post('id', TRUE);
                $title = $this->input->post('title', TRUE);
                $short_desc = $this->input->post('short_desc', TRUE);
                $ordering = $this->input->post('ordering', TRUE);
                $parent_id = $this->input->post('parent_id', TRUE);
                $setValues = array(
                        'table'=>'manage_attributes',
                        'query'=>'SELECT * FROM %cis_table WHERE title=? AND parent_id=?',
                        'where' => array($title,$parent_id),
                        );
                if($id!=0){
                    $setValues = array(
                        'table'=>'manage_attributes',
                        'query'=>'SELECT * FROM %cis_table WHERE title=? AND id!=? AND parent_id=?',
                        'where' => array($title, $id,$parent_id),
                        );
                }
                $this->Common_model->set('all', $setValues);
                $duplicacy = $this->Common_model->customQry();
                if(empty($duplicacy)){ 
                    if($id==0){ 
                        if($parent_id<=0){
                            $is_delete=1;
                        }else{
                            $is_delete=0;
                        }
                        $setValues = array(
                                'table'=>'manage_attributes',
                                'query'=>'SELECT MAX(`ordering`) as ordering FROM %cis_table WHERE parent_id=?',
                                'where' => array($parent_id),
                        );
                        $this->Common_model->set('all', $setValues);
                        $ordering = $this->Common_model->customQry();
                        $ordering = ($ordering[0]['ordering'])+1;
                        $data = array('title'=>$title,'short_desc'=>$short_desc,'ordering'=>$ordering,
                                'parent_id'=>$parent_id,'is_delete'=>$is_delete);
                        $this->Common_model->set('all', array(
                                'table'=>'manage_attributes',
                                'insert' => $data
                                )
                        );                                
                        $status = $this->Common_model->insert();
                    }else{ 
                        $this->Common_model->set('all', array(
                                'table'=>'manage_attributes',
                                'update' => array('title'=>$title,'short_desc'=>$short_desc,'ordering'=>$ordering,'parent_id'=>$parent_id),
                                'where' => array('id'=>$id),
                                )
                        );                                
                        $status = $this->Common_model->update();
                    }
                    if($status && $status!='NOT'){									
                            $this->session->set_flashdata('flag','success');
                            $this->session->set_flashdata('msg','Successfully saved.');
                            redirect($this->redirectroot.'/attribute-form');
                    }
                    else if($status=='NOT'){
                            $this->session->set_flashdata('flag','success');
                            $this->session->set_flashdata('msg','Record not effected.');					
                            redirect($this->redirectroot.'/attribute-form/'.$id);
                    }
                    else{
                            $this->session->set_flashdata('flag','danger');
                            $this->session->set_flashdata('msg','Your data have some issue. Please check.');					
                            redirect($this->redirectroot.'/attribute-form/'.$id);
                    }

                }else{
                        $this->session->set_flashdata('flag','danger');
                        $this->session->set_flashdata('msg','You have same data in your records.');
                        redirect($this->redirectroot.'/attribute-form/'.$id);
                }	

            }
            $this->Common_model->set('all', array(
                                    'table'=>'manage_attributes',
                                    'where' => array('parent_id'=>0),
                                    ));
            $parentAttributes = $this->Common_model->get();
            $AttributeValue = array('title'=>'','short_desc'=>'','ordering'=>'','parent_id'=>'','id'=>'0');
            if($id>0){
                $this->Common_model->set('all', array(
                                        'table'=>'manage_attributes',
                                        'where' => array('id'=>$id),
                                        ));
                $AttributeValue = $this->Common_model->get();
            }
            $this->content['parentAttributes'] = $parentAttributes;
            $this->content['AttributeValue'] = $AttributeValue;
            //$this->content['views'][] = 'admin/attribute_form';
            $this->content['module'] = 'Attributes';
            $this->content['view'] = 'attribute_form';
            
            $this->layout->adminTheme($this->content);
	}
        public function attribute_delete($id){
             $setValues = array('table'=>'manage_attributes',
                               'where' => array('id'=>$id,'is_delete'=>0)
                                );
            $this->Common_model->set('all', $setValues);
            $status = $this->Common_model->delete();
            if($status){                                    
                    $this->session->set_flashdata('flag','success');
                    $this->session->set_flashdata('msg','Successfully Deleted.');
                    redirect($this->redirectroot.'/attribute-list');
            }
            else{
                    $this->session->set_flashdata('flag','danger');
                    $this->session->set_flashdata('msg','Your data have some issue. Please check.');                    
                    redirect($this->redirectroot.'/attribute-form');
            }
            
        }

       
        
        
}
