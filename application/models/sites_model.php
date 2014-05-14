<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class sites_model extends CI_Model {
    
    /*
     * list all sites info
     */
    function get_all_site($data,$order = null, $order_type = 'Asc'){
        $this->db->select('*');
        $this->db->from('sites_mng');
        
        if(!empty($data))
             $this->db->where($data);
        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('sites_mng.site_id', $order_type);
        }
        
        $query = $this->db->get();
//echo $this->db->last_query();//exit;
        return $query->result_array();
    }
    /*
     * Get Site By Id
     */
    public function get_site_by_id($id) {
        $this->db->select('*');
        $this->db->from('sites_mng');
        $this->db->where('site_id', $id);
        $query = $this->db->get();
         if ($query->num_rows > 0) {
            $result = $query->result_array();
            return $result[0];
        }else{
            return array();
        }
    }
    /*
     * Add Site Info
     */
    function add_site($data){
        if(!empty($data)){
            $this->db->where('site_url', $data['site_url']);
            $query = $this->db->get('sites_mng');
            if ($query->num_rows > 0) {
                echo '<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>';
                echo "Site Url already taken";
                echo '</strong></div>';
            } else {
                $insert = $this->db->insert('sites_mng', $data);
//                return $this->db->insert_id();
                return $insert;
            }
        }
   }
   /*
    * Update Site Info
    */
    function update_site($id, $data) {
        $this->db->where('site_id', $id);
        $this->db->update('sites_mng', $data);
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if ($report !== 0) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Delete Site
     * @param int $id - site id
     * @return boolean
     */
    function delete_site($id) {
        $this->db->where('site_id', $id);
        $this->db->delete('sites_mng');
    }
    
    
    
     /*
     * list all sites info
     */
    function get_all_site_pattern($data,$order = null, $order_type = 'Asc'){
        $this->db->select('*');
        $this->db->from('site_pattern');
        
        if(!empty($data))
             $this->db->where($data);
        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('site_pattern.pt_id', $order_type);
        }
        
        $query = $this->db->get();
//echo $this->db->last_query();//exit;
        return $query->result_array();
    }
    /*
     * Get Site By Id
     */
    public function get_site_pattern_by_id($id) {
        $this->db->select('*');
        $this->db->from('site_pattern');
        $this->db->where('pt_id', $id);
        $query = $this->db->get();
         if ($query->num_rows > 0) {
            $result = $query->result_array();
            return $result[0];
        }else{
            return array();
        }
    }
    /*
     * Add Site Info
     */
    function add_site_pattern($data){
        if(!empty($data)){
            
                $insert = $this->db->insert('site_pattern', $data);
//                return $this->db->insert_id();
                return $insert;
            
        }
   }
   /*
    * Update Site Info
    */
    function update_site_pattern($id, $data) {
        $this->db->where('pt_id', $id);
        $this->db->update('site_pattern', $data);
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if ($report !== 0) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Delete Site
     * @param int $id - site id
     * @return boolean
     */
    function delete_site_pattern($id) {
        $this->db->where('pt_id', $id);
        $this->db->delete('site_pattern');
    }
}
?>
