<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Question_model extends CI_Model {
    /*
     * list all Questions of All Products
     */

    function get_all_question($data, $order = null, $order_type = 'DESC') {
        $this->db->select('*');
        $this->db->from('tbl_product_question');

        if (!empty($data))
            $this->db->where($data);
        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('tbl_product_question.q_id', $order_type);
        }

        $query = $this->db->get();
//echo $this->db->last_query();//exit;
        return $query->result_array();
    }

    /*
     * Get Question By Id
     */

    public function get_question_by_id($id) {
        $this->db->select('*');
        $this->db->from('tbl_product_question');
        $this->db->where('q_id', $id);
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            $result = $query->result_array();
            return $result[0];
        } else {
            return array();
        }
    }

    /*
     * Add Question
     */

    function add_question($data) {
        if (!empty($data)) {
            $insert = $this->db->insert('tbl_product_question', $data);
            return $this->db->insert_id();
//            return $insert;
        }
    }

    /*
     * Update Question Info
     */

    function update_question($id, $data) {
        $this->db->where('q_id', $id);
        $this->db->update('tbl_product_question', $data);
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
     * Delete Question
     * @param int $id - question id
     * @return boolean
     */
    function delete_question($id) {
        $this->db->where('q_id', $id);
        $this->db->delete('tbl_product_question');
    }

    /*
     * list all Question Answer
     */

    function get_all_question_answer($data, $order = null, $order_type = 'DESC') {
        $this->db->select('*');
        $this->db->from('tbl_question_answer');

        if (!empty($data))
            $this->db->where($data);
        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('tbl_question_answer.ans_id', $order_type);
        }

        $query = $this->db->get();
//echo $this->db->last_query();//exit;
        return $query->result_array();
    }

    /*
     * Get Answer By id
     */

    public function get_question_answer_by_id($data) {
        $this->db->select('*');
        $this->db->from('tbl_question_answer');
        if(!empty($data))
            $this->db->where($data);
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            $result = $query->result_array();
            return $result[0];
        } else {
            return array();
        }
    }

    /*
     * Add Answer
     */

    function add_question_answer($data) {
        if (!empty($data)) {
            $this->db->where('q_id_FK', $data['q_id_FK']);
            $query = $this->db->get('tbl_question_answer');
            if ($query->num_rows > 0) {
                $result = $query->result_array();
                unset($data['ans_id']);
                unset($data['q_id_FK']);
                return $this->update_question_answer($result[0]['ans_id'], $data);
            } else {
                $insert = $this->db->insert('tbl_question_answer', $data);
                return $this->db->insert_id();
            }
//            return $insert;
        }
    }

    /*
     * Update Answer
     */

    function update_question_answer($id, $data) {
        $this->db->where('ans_id', $id);
        $this->db->update('tbl_question_answer', $data);
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
    function delete_question_answer($id) {
        $this->db->where('ans_id', $id);
        $this->db->delete('tbl_question_answer');
    }
    
    function get_all_question_by_link($data, $order = null, $order_type = 'DESC') {
        $this->db->select('*');
        $this->db->from('tbl_product_question');
        $this->db->join('tbl_question_answer', 'tbl_product_question.q_id = tbl_question_answer.q_id_FK');

        if (!empty($data))
            $this->db->where($data);
        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('tbl_product_question.q_id', $order_type);
        }

        $query = $this->db->get();
//        echo $this->db->last_query();exit;
        return $query->result_array();
    }

}

?>
