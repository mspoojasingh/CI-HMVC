<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common_model extends CI_Model
{
    private $foo;
    private $filter;
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        
    }
    public function setFilter($values){
        $this->filter = $values;
    }
    public function getFilter(){
        return $this->filter;
    }

    public function set($key, $value){
        $this->foo = '';
        if($key=='all'){
            foreach($value as $k=>$v){
                $this->foo[$k] = $v;
            }
        }
        else
            $this->foo[$key] = $value;
    }

    public function get(){
        /**
        * Where Condition
        * @param: select will be string or array value
        * @param: where will be array or string value
        * @param: order by is an array value
        * @param: group by is a string value
        * @param: offset
        * @param: limit
        * @param: data will be 1 (single data row) or 0 (all data)
        * @return: return array data
        */
        if(isset($this->foo['select']))
            $this->db->select($this->foo['select']);      
        if(isset($this->foo['where']) && $this->foo['where']!='')
                $this->db->where($this->foo['where'], FALSE);
        if(isset($this->foo['where_in']) && !empty($this->foo['where_in'])){
            foreach ($this->foo['where_in'] as $k=>$v)
                $this->db->where_in($k,$v);
        }

        if(isset($this->foo['order_by']) && !empty($this->foo['order_by'])){ 
            foreach($this->foo['order_by'] as $key=>$value)
                $this->db->order_by($key, $value);
        }
        if(isset($this->foo['group_by']) && $this->foo['group_by']!='')
            $this->db->group_by($this->foo['group_by']);

        if(isset($this->foo['offset']) && isset($this->foo['limit']) && $this->foo['limit']!='')
            $this->db->limit($this->foo['limit'], $this->foo['offset']);
        
        $query = $this->db->get($this->foo['table']);

        if(isset($this->foo['return']) && $this->foo['return']==1)
            $data = $query->row_array();
        else
            $data = $query->result_array();
        unset($this->foo);
        return $data;
    }

    /**
    * Get count of records
    * @return: Count of Records  
    */
    public function getNum(){
        
        $this->db->from($this->foo['table']);
        if(isset($this->foo['where']) && $this->foo['where']!='')
            $this->db->where($this->foo['where'], FALSE);
        $query = $this->db->get();
        $data = $query->num_rows();
        unset($this->foo);
        return $data;
    }

    /**
    * Insert data in database
    * @param: An array of data
    * @return: Last Insert ID
    */
     public function insert(){
         if(isset($this->foo['insert']) && !empty($this->foo['insert'])){            
            $this->db->insert($this->foo['table'], $this->foo['insert']);
            $data = $this->db->insert_id();
         }else
             $data = 0;
        unset($this->foo);
        return $data;
     }

    /**
    * Update data in database
    * @param: An array of where condition
    * @param: An array of data
    * @return: Update row status
    */
    public function update(){
        if(isset($this->foo['where']) && !empty($this->foo['where']) && isset($this->foo['update']) && !empty($this->foo['update'])){
            $this->db->where($this->foo['where']);
            $this->db->update($this->foo['table'], $this->foo['update']);
            $data = $this->db->affected_rows();
            if($data==0)
                $data = "NOT";
        }else
            $data = 0;
        unset($this->foo);
        return $data;
    }

    /**
    * Delete data in database
    * @param: An array of where condition
    * @return: delete status
    */
    public function delete(){
        if(isset($this->foo['where']) && !empty($this->foo['where'])){
            $this->db->where($this->foo['where']);
        }if(isset($this->foo['or_where']) && !empty($this->foo['or_where'])){
            $this->db->or_where($this->foo['or_where']);
        }
        if(isset($this->foo['where_in']) && !empty($this->foo['where_in'])){
            foreach ($this->foo['where_in'] as $k=>$v)
                $this->db->where_in($k,$v);
        }
        if($this->db->delete($this->foo['table']))
            $data = 1;
        else
            $data = 0;
         
        unset($this->foo);
        return $data;       
    }

    /* Custom query function */
    public function customQry(){
        if($this->foo['query']!=''){
            $qry = str_replace('%cis_table', $this->db->dbprefix($this->foo['table']), $this->foo['query']);
            $query = $this->db->query($qry, $this->foo['where']);
            if(isset($this->foo['return']) && $this->foo['return']=='1'){
                $data = $query->row_array();
            }
            else{
                $data = $query->result_array();
            }
            unset($this->foo);
            return $data;   
        }
    }

    //join function
    /*
    * select : parameters with comma seprators
    * from : table name
    * join : Join is an array of table and on condition
    * where : Where is an array of where condition
    */
    function join(){
        if(isset($this->foo['select']))
            $this->db->select($this->foo['select'], FALSE);

        $this->db->from($this->db->dbprefix($this->foo['table']));

        if(isset($this->foo['join']))
            foreach($this->foo['join'] as $join_table => $on_condition){
                if(isset($this->foo['join_type']) && $this->foo['join_type']!='')
                    $this->db->join($this->db->dbprefix($join_table), $on_condition, $this->foo['join_type']);
                else
                    $this->db->join($this->db->dbprefix($join_table), $on_condition);
            }

        if(isset($this->foo['where']))
            $this->db->where($this->foo['where']);

        if(isset($this->foo['where_or']))
            $this->db->or_where($this->foo['where_or'], FALSE);

        if(isset($this->foo['order_by']))
            foreach ($this->foo['order_by'] as $order_key => $order_value)
                $this->db->order_by($order_key, $order_value);

        if(isset($this->foo['group_by']))
            foreach ($this->foo['group_by'] as $group_key => $group_value)
                $this->db->group_by($group_key, $group_value);

        if(isset($this->foo['offset']) && isset($this->foo['limit']) && $this->foo['limit']!='')
            $this->db->limit($this->foo['limit'], $this->foo['offset']);
        
        $query = $this->db->get();
        //die($this->db->last_query());
        if(isset($this->foo['return']) && $this->foo['return']=='1')
            $data = $query->row_array();
        else
            $data = $query->result_array();
        
        unset($this->foo);
        return $data;
    }
    function setPaginationConfig($base_url='',$total_rows = 0,$per_page = 10,$uri_segment= 2){
        $config['per_page'] = $per_page;
        $config['base_url'] = site_url($base_url);
        $config['use_page_numbers'] = true;
        $config['full_tag_open'] = '<ul class="pagination" style="display: inline-flex;">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = $config['last_tag_open'] = $config['next_tag_open'] = $config['prev_tag_open'] = $config['num_tag_open'] = '<li class="first">';
        $config['first_tag_close'] = $config['last_tag_close'] = $config['next_tag_close'] = $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
        $config['prev_link'] = '&lt;';
        $config['num_links'] = 2;
        $config['next_link'] = '&gt;';
        $config['first_link'] = '&lsaquo;&lsaquo;';
        $config['last_link'] = '&rsaquo;&rsaquo;';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['uri_segment'] = $uri_segment;
        $config['total_rows'] = $total_rows;
        $this->pagination->initialize($config);
        return TRUE;
    }
    
}   
    
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
