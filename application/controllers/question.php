<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Question extends CI_Controller {
    /**
     * Responsable for auto load the model
     * @return void
     */

    /**
     * Check if the user is logged in, if he's not, 
     * send him to the login page
     * @return void
     */
    public $replace_arr = array('&nbsp;');

    public function __construct() {
        parent::__construct();
        $this->load->model('question_model');
    }

    /*
     * List All Question Answer of the product
     */

    function index() {
        $data = array();
        //load the view
        $p_title     = $this->input->get('p_title');
        $product_id     = $this->input->get('p_id');
        $product_link   = $this->input->get('p_link');
        $data = array();
        //load the view
        $data['sites'] = $this->question_model->get_all_question($data);
        $data['main_content'] = 'admin/question/list';
        $this->load->view('includes/template', $data);
        
    }
    

    function printr($arr) {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
        exit;
    }
    
    
    function add_question() {
        $data = array();
        //load the view
        $data['main_content'] = 'admin/question/add';
        $this->load->view('includes/template', $data);
    }

    function save_question() {
//        $this->printr($this->input->post());
        $data = array();
        $data['main_content'] = 'admin/question/add';

        $this->load->library('form_validation');

        // field name, error message, validation rules
        $this->form_validation->set_rules('pro_name', 'Product Name', 'trim|required');
        $this->form_validation->set_rules('pro_id', 'Product ID', 'trim|required');
        $this->form_validation->set_rules('pro_link', 'Product Link', 'trim|required');
        $this->form_validation->set_rules('question', 'Question Text', 'trim|required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('includes/template', $data);
        } else {
            $data_val = array();
            $data_val['q_product_title'] = $this->input->post('pro_name');
            $data_val['q_product_id'] = $this->input->post('pro_id');
            $data_val['q_product_url'] = $this->input->post('pro_link');
            $data_val['q_text'] = $this->input->post('question');
            $data_val['q_status'] = $this->input->post('is_active');
            $data_val['q_date'] = date('Y-m-d');
            $data_val['q_time'] = date('H:i:s');

//            $this->printr($this->input->post());
            if ($query = $this->question_model->add_question($data_val)) {
                redirect('question');
            } else {
                $this->load->view('includes/template', $data);
            }
        }
    }

    function update_question() {
        $id = $this->uri->segment(3);
        if (!empty($id)) {
            $data = array();
            $data['site'] = $this->question_model->get_question_by_id($id);
            $data['main_content'] = 'admin/question/edit';
            $this->load->view('includes/template', $data);
        }
        else
            redirect('admin/sites');
    }

    function update_save_question() {
//        $this->printr($this->input->post());
        $id = $this->input->post('q_id');
        $data = array();
        $data['main_content'] = 'admin/question/edit';
        $data['site'] = $this->question_model->get_question_by_id($id);
        $this->load->library('form_validation');

        // field name, error message, validation rules
        $this->load->library('form_validation');

        // field name, error message, validation rules
        $this->form_validation->set_rules('pro_name', 'Product Name', 'trim|required');
        $this->form_validation->set_rules('pro_id', 'Product ID', 'trim|required');
        $this->form_validation->set_rules('pro_link', 'Product Link', 'trim|required');
        $this->form_validation->set_rules('question', 'Question Text', 'trim|required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('includes/template', $data);
        } else {
            $data_val = array();
            $data_val['q_product_title'] = $this->input->post('pro_name');
            $data_val['q_product_id'] = $this->input->post('pro_id');
            $data_val['q_product_url'] = $this->input->post('pro_link');
            $data_val['q_text'] = $this->input->post('question');
            $data_val['q_status'] = $this->input->post('is_active');
            $data_val['q_date'] = date('Y-m-d');
            $data_val['q_time'] = date('H:i:s');

//            $this->printr($this->input->post());
            if ($query = $this->question_model->update_question($id, $data_val)) {
                redirect('question');
            } else {
                $this->load->view('includes/template', $data);
            }
        }
    }

    //update
    /**
     * Delete Question by his id
     * @return void
     */
    public function delete() {
        //product id 
        $id = $this->uri->segment(3);
        $this->question_model->delete_question($id);
        redirect('question');
    }
    
    /*
     * Function Show Question Answer
     * 
     */
    function question_answer(){
        $id = $this->uri->segment(3);
        if (!empty($id)) {
            $data = array();
            $data['site'] = $this->question_model->get_question_by_id($id);
            $ans_data= array('q_id_FK'=>$id);
            $data['ans'] = $this->question_model->get_question_answer_by_id($ans_data);
            $data['main_content'] = 'admin/question/question_answer';
//            printr($data);
            $this->load->view('includes/template', $data);
        }
        else
            redirect('question');
    }
    
    function save_question_answer(){
        $id = $this->input->post('q_id');
        $ans_id = $this->input->post('ans_id');
        $data = array();
        $data['main_content'] = 'admin/question/question_answer';
        $data['site'] = $this->question_model->get_question_by_id($id);
        $this->load->library('form_validation');

        
        // field name, error message, validation rules
        $this->form_validation->set_rules('ans_text', 'Question Answer', 'trim|required');
        $this->form_validation->set_rules('question', 'Question Text', 'trim|required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('includes/template', $data);
        } else {
            $data_val = array();
            $data_val['q_id_FK'] = $id;
            $data_val['ans_text'] = $this->input->post('ans_text');
            $data_val['ans_status'] = $this->input->post('is_active');
            $data_val['ans_date'] = date('Y-m-d');
            $data_val['ans_time'] = date('H:i:s');

//            $this->printr($this->input->post());
            if ($query = $this->question_model->add_question_answer($data_val)) {
                $data_val = array();
                $data_val['is_answer'] = 1;
                $this->question_model->update_question($id, $data_val);
                redirect('question');
            } else {
                $this->load->view('includes/template', $data);
            }
        }
    }
    
    /*
     * Function getQuestionByPage()
     */
    function getQuestionByPage(){
         $data_content = array();
        //load the view
        $p_title     = $this->input->get('p_title');
        $product_id     = $this->input->get('p_id');
        $product_link   = $this->input->get('p_link');
//        echo json_encode($this->input->get());exit;
        $data = array();
        $data['tbl_product_question.q_product_url'] = $product_link;
        $data['tbl_question_answer.ans_status'] = 1;
        //load the view
        $questions = $this->question_model->get_all_question_by_link($data);
        
        $data_content['questions'] = $questions;
        $data_content['p_title'] = $p_title;
        $data_content['p_id']    = $product_id;
        $data_content['p_link']  = $product_link;
        
        $this->load->view('admin/question/view_question_ifram', $data_content);
//        printr($questions);
//        echo json_encode($questions);exit;
       
    }
    function show_form_question(){
        //load the view
        $p_title     = $this->input->get('p_title');
        $product_id     = $this->input->get('p_id');
        $product_link   = $this->input->get('p_link');
        $data_content = array();
        $data_content['p_title'] = $p_title;
        $data_content['p_id']    = $product_id;
        $data_content['p_link']  = $product_link;
        
        $this->load->view('admin/question/add_question_ifram', $data_content);
    }
    
    function add_question_iframe(){
        $p_title       = $this->input->get('p_title');
        $product_id     = $this->input->get('p_id');
        $product_link   = $this->input->get('p_link');
        $q_text         = $this->input->get('q_text');
        $u_name         = $this->input->get('u_name');
        

        $data_val = array();
        $data_val['q_product_title'] = $p_title;
        $data_val['q_product_id'] = $product_id;
        $data_val['q_product_url'] = $product_link;
        $data_val['q_text'] = $q_text;
        $data_val['q_status'] = 1;
        $data_val['user_name'] = $u_name;
        $data_val['q_date'] = date('Y-m-d');
        $data_val['q_time'] = date('H:i:s');

        $data_content = array();

        if ($query = $this->question_model->add_question($data_val)) {
            echo 'Question Save Successfully.';
        } else {
             echo 'Error Occured while Saveing Question.';
        }
        $this->load->library('email');
        
        $config['mailtype'] = 'html';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);

        $this->email->from('mentordeveloper@gmail.com', $u_name);
        $this->email->to('zabbas44@gmail.com'); 
        $this->email->cc('mum.mary786@gmail.com'); 
//        $this->email->bcc('them@their-example.com'); 

        $this->email->subject('New Question Asked?');
        $body = '<table cellspacing="2" cellpadding="4" border="1">
                <tr>
                    <td>Question :</td>
                    <td>'.$q_text.'</td>
                </tr>
                <tr>
                    <td>Product Title</td>
                    <td>'.$p_title.'</td>
                </tr>
                <tr>
                    <td>Product Link</td>
                    <td>'.$product_link.'</td>
                </tr>
                <tr>
                    <td>Product Id</td>
                    <td>'.$product_id.'</td>
                </tr>
                <tr>
                    <td>User Name</td>
                    <td>'.$u_name.'</td>
                </tr>
                </table>';
        $this->email->message($body);	

        $this->email->send();

       // echo $this->email->print_debugger();
        
        
//        $data_content['p_title'] = $p_title;
//        $data_content['p_id']    = $product_id;
//        $data_content['p_link']  = $product_link;
//        
//        $this->load->view('admin/question/add_question_ifram', $data_content);
        
    }

}

?>
