<?php

class User extends CI_Controller {

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('users_model');
        
    }

    public $flag_error;
    public $ch;

    /**
     * Check if the user is logged in, if he's not, 
     * send him to the login page
     * @return void
     */
    function index() {
        if ($this->session->userdata('is_logged_in')) {

            redirect('admin/sites');
        } else {
            $this->load->view('admin/login');
        }
    }

    function printr($arr) {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
        exit;
    }

    /**
     * encript the password 
     * @return mixed
     */
    function __encrip_password($password) {
        return md5($password);
    }

    /**
     * check the username and the password with the database
     * @return void
     */
    function validate_credentials() {

        $this->load->model('Users_model');

        $user_name = $this->input->post('user_name');
        $password = $this->__encrip_password($this->input->post('password'));

        $is_valid = $this->Users_model->validate($user_name, $password);

        if ($is_valid) {
            $data = array(
                'user_name' => $user_name,
                'is_logged_in' => true,
            );
            $this->session->set_userdata($data);
            redirect('admin/sites');
        } else { // incorrect username or password
            $data['message_error'] = TRUE;
            $this->load->view('admin/login', $data);
        }
    }

    /**
     * The method just loads the signup view
     * @return void
     */
    function signup() {
        $data = array();
        $data['main_content'] = 'admin/users/signup_form';
        $this->load->view('includes/template', $data);
    }

    /**
     * Create new user and store it in the database
     * @return void
     */
    function create_member() {
        $data = array();
        $data['main_content'] = 'admin/users/signup_form';

        $this->load->library('form_validation');

        // field name, error message, validation rules
        $this->form_validation->set_rules('first_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('includes/template', $data);
        } else {


            if ($query = $this->users_model->create_member()) {
//                $this->load->view('admin/users/signup_successful');
                $data['main_content'] = 'admin/users/signup_successful';
                $this->load->view('includes/template', $data);
            } else {
                $this->load->view('includes/template', $data);
            }
        }
    }

    /**
     * Destroy the session, and logout the user.
     * @return void
     */
    function logout() {
        $this->session->sess_destroy();
        redirect('admin');
    }

    /*
     * List All users
     */

    function list_users() {
        //all the posts sent by the view
        $manufacture_id = "all";
        $search_string = $this->input->post('search_string');
        $order = $this->input->post('order');
        $order_type = $this->input->post('order_type');

        //pagination settings
        $config['per_page'] = 5;
        $config['base_url'] = base_url() . 'admin/user_list';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        //limit end
        $page = $this->uri->segment(3);

        //math to get the initial record to be select in the database
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }
        $filter_session_data   = array();
        //if order type was changed
        if ($order_type) {
            $filter_session_data['order_type'] = $order_type;
        } else {
            //we have something stored in the session? 
            if ($this->session->userdata('order_type')) {
                $order_type = $this->session->userdata('order_type');
            } else {
                //if we have nothing inside session, so it's the default "Asc"
                $order_type = 'Asc';
            }
        }
        //make the data type var avaible to our view
        $data['order_type_selected'] = $order_type;


        //filtered && || paginated
        if ($search_string !== false && $order !== false || $this->uri->segment(3) == true) {

            if ($search_string) {
                $filter_session_data['search_string_selected'] = $search_string;
            } else {
                $search_string = $this->session->userdata('search_string_selected');
            }
            $data['search_string_selected'] = $search_string;

            if ($order) {
                $filter_session_data['order'] = $order;
            } else {
                $order = $this->session->userdata('order');
            }
            $data['order'] = $order;

            //save session data into the session
            $this->session->set_userdata($filter_session_data);


            $data['count_users'] = $this->users_model->count_users($search_string, $order);
            $config['total_rows'] = $data['count_users'];

            //fetch sql data into arrays
//            echo $search_string;
            if ($search_string) {
                if ($order) {
                    $data['users'] = $this->users_model->get_all_users($search_string, $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['users'] = $this->users_model->get_all_users($search_string, '', $order_type, $config['per_page'], $limit_end);
                }
            } else {
                if ($order) {
                    $data['users'] = $this->users_model->get_all_users('', $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['users'] = $this->users_model->get_all_users('', '', $order_type, $config['per_page'], $limit_end);
                }
            }
        } else {

            //clean filter data inside section
            $filter_session_data['manufacture_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['order'] = 'id';

            //fetch sql data into arrays

            $data['count_users'] = $this->users_model->count_users();
            $data['users'] = $this->users_model->get_all_users();
            $config['total_rows'] = $data['count_users'];
        }//!isset($manufacture_id) && !isset($search_string) && !isset($order)
        //initializate the panination helper 
        $this->pagination->initialize($config);

        //load the view
        $data['main_content'] = 'admin/users/list';
        $this->load->view('includes/template', $data);
    }

    /**
     * Update item by his id
     * @return void
     */
    public function update() {
        //product id 
        $id = $this->uri->segment(4);

        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            //form validation
            $this->form_validation->set_rules('first_name', 'Name', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email');
            $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
            $this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            //if the form has passed through the validation
            if ($this->form_validation->run()) {

                $data_to_store = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'email_addres' => $this->input->post('email_address'),
                    'user_name' => $this->input->post('username'),
                    'pass_word' => md5($this->input->post('password')),
                    'pass_orginal' => $this->input->post('password'),
                );

                //if the insert has returned true then we show the flash message
                if ($this->users_model->update_user($id, $data_to_store) == TRUE) {
                    $this->session->set_flashdata('flash_message', 'updated');
                } else {
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                $is_admin = $this->session->userdata('is_admin');
                if ($is_admin == 1)
                    redirect('admin/user_list');
                else
                    redirect('admin/sites');
            }//validation run
        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data
        //product data 
        $data['user'] = $this->users_model->get_user_by_id($id);
//        print_r($data);exit;
        //load the view
        $data['main_content'] = 'admin/users/edit';
        $this->load->view('includes/template', $data);
    }

//update

    public function email_header() {
        //product id 
        $id = $this->uri->segment(4);

        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            //form validation
            $this->form_validation->set_rules('header_title', 'Header Title', 'trim|required');
            if (empty($_FILES['email_header']['name'])) {
                $this->form_validation->set_rules('email_header', 'Header Image', 'required');
            }
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            //if the form has passed through the validation
            if ($this->form_validation->run()) {
                $email_header = $this->do_upload('email_header');
                if (empty($email_header))
                    $email_header = $this->input->post('email_header_hidden');
                $data_to_store = array(
                    'email_header_title' => $this->input->post('header_title'),
                    'email_header' => $email_header,
                );

                //if the insert has returned true then we show the flash message
                if ($this->users_model->update_user($id, $data_to_store) == TRUE) {
                    $this->session->set_flashdata('flash_message', 'updated');
                } else {
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                $is_admin = $this->session->userdata('is_admin');
                if ($is_admin == 1)
                    redirect('admin/user_list');
                else
                    redirect("admin/user_list/email_header/$id");
            }//validation run
        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data
        //product data 
        $data['user'] = $this->users_model->get_user_by_id($id);
//        print_r($data);exit;
        //load the view
        $data['main_content'] = 'admin/users/user_email_header';
        $this->load->view('includes/template', $data);
    }

//update
    /**
     * Delete product by his id
     * @return void
     */
    public function delete() {
        //product id 
        $id = $this->uri->segment(4);
        $this->users_model->delete_user($id);
        redirect('admin/user_list');
    }

//edit

    /* /
     * Affiliate Code Generator
     */

    function affiliate_code() {
        $data = array();
        $data['main_content'] = 'admin/users/scrapper';
        $this->load->view('includes/template', $data);
    }

    /**
     * Function for file uploading
     */
    function do_upload($field_name) {

        $config['upload_path'] = 'uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '100000';

        $this->load->library('upload', $config);
        $file_path = '';
        if (!$this->upload->do_upload($field_name)) {

            $error = array('error' => $this->upload->display_errors());
            $file_path = '';
        } else {
            $data = $this->upload->data();
            $file_path = $config['upload_path'] . '' . $data['file_name'];
        }
        return $file_path;
    }

    /*
     * Email Scrapper Functionalitys
     */

    function scrap_url_data() {
        $url = $this->input->post('url');
        $new_link = $this->input->post('new_link');
        $fld_ids = $this->input->post('fld_ids');
        $fld_urls = $this->input->post('fld_urls');
        $is_mail = $this->input->post('is_mail');
        $fld_urls_affiliate = $this->input->post('fld_urls_affiliate');
        $this->load->library('simple_html_dom');
        
        $lg_id = $this->session->userdata('lg_id');
        $user_info = $this->users_model->get_user_by_id($lg_id);
        $str_start = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>'.$user_info['email_header_title'].'</title>

</head>
<body>
<center>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<table border="0" cellpadding="0" cellspacing="0" width="600">
<tbody>
<tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" style="font-family:Arial,Helvetica,sans-serif" width="600">
<tbody>
<tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" width="600">
<tbody>

<tr style="">
<td colspan="2"><img height="7" src="http://rtm.ebaystatic.com/203/RTMS/Image/mailer_border_123_192013.gif" width="600"></td>
</tr>
<tr style="">
<td width="341">

<a rel="nofollow" href="http://stores.ebay.co.uk/frill-shop?_rdc=1" 
target="_blank">
<img alt="frillshop" border="0"  height="150" src="'.base_url ().$user_info['email_header'].'" 
title="frillshop"></a></td>
<td align="center" 
style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:rgb(102,102,102)" 
width="259"><a rel="nofollow" 
href="http://stores.ebay.co.uk/frill-shop?_rdc=1" target="_blank" 
style="text-decoration: none">
<img alt="eBay rated" border="0" 
height="80" src="'.base_url ().'files/images/ebay.png" title="eBay rated">&nbsp; 
<img alt="paypal" border="0" 
height="80" src="'.base_url ().'files/images/paypal.png" title="paypal"></a></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
</tbody>
</table></td>
</tr>

</tbody>
</table></td>
</tr>';
        $str_end = '<tr>
                        <td height="30" align="center"><span style="font-family:Arial,Helvetica,sans-serif;font-size:10px;color:rgb(170,170,170)">
                                Copyright '.date('Y').' '.$user_info['email_header_title'].' </span></td>
                    </tr>
                    </tbody>
                    </table>
                    </center>
                    </body>
                    </html>';
        $mid = '';
//        if(!empty($user_info['email_header']))
//            $mid = '<tr><td><img src="'.base_url ().$user_info['email_header'].'"></td></tr>';
        
            
        
        $fld_arr = explode(',', $fld_ids);
        $fld_urls_arr = explode(',', $fld_urls);
        $fld_urls_affiliate_arr = explode(',', $fld_urls_affiliate);
        
        $l_arr = array();
        $main_arr = array();
        for($i=0;$i<sizeof($fld_arr);$i++){
            $html = $this->curl_url_data($fld_urls_arr[$i]);
            $html = str_get_html($html);
            $title = '';
            $img_src = '';
            if(!empty($html)){
                foreach ($html->find('span#vi-lkhdr-itmTitl') as $title) {
                    $title = str_replace("Details about &nbsp;", "", $title->innertext);
                }
                foreach ($html->find('div#mainImgHldr img#icImg') as $img) {
                    $img_src = $img->src;
                }
                $l_arr['title'] = $title; 
                $l_arr['img_src'] = $img_src; 
                $l_arr['affiliate_link'] = $fld_urls_affiliate_arr[$i]; 
                $main_arr[] = $l_arr;
            }
        }
        
        $mid.='<tr>
        <td>
            <table bgcolor="#E2E1DD" border="0" cellpadding="0" cellspacing="10" style="table-layout:fixed" width="600">
                <tbody>
                    ';
        $count = 0;
        $flag = true;
        foreach($main_arr as $key=>$row){
            if($flag&&$count==0){
                $mid.='<tr>';
                $flag = false;
            }
            $mid .= '<td height="263" style="background:#ffffff" valign="top">
                        <table border="0" cellpadding="5" cellspacing="0" height="202" style="background-color:rgb(255,255,255);font-family:Arial,Helvetica,sans-serif;font-size:13px;background-repeat:initial initial" width="100%">
                            <tbody>
                                <tr>
                                    <td align="center" height="150" valign="top"><span><a rel="nofollow" href="'.$row['affiliate_link'].'" target="_blank">
                                                <img alt="'.$row['title'].'" border="0" src="'.$row['img_src'].'" height="150" style="max-width: 170px;" title="'.$row['title'].'"></a> </span></td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top"><span>
                                            <a rel="nofollow" href="'.$row['affiliate_link'].'" style="text-decoration:none;color:#333;text-align:left" target="_blank"><span>'.$row['title'].'</span><br>
                                                </a></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>';
//            $mid .='<td><a href="'.$row['affiliate_link'].'"><img src="'.$row['img_src'].'" width="250" height="250" />'.$row['title'].'</a></td>';
            $count++;
            if($count==3){
                $mid.='</tr>';
                $flag = true;
                $count = 0;
            }
        }
        $mid.=' 
                    </tbody>
                </table>
            </td>
        </tr>
    ';
        echo $final = $str_start.$mid.$str_end;
        
    }

    function send_email() {
        $url = $this->input->post('url');
        $new_link = $this->input->post('new_link');
        $fld_ids = $this->input->post('fld_ids');
        $fld_urls = $this->input->post('fld_urls');
        $html_gen = $this->input->post('html_gen');
        $fld_urls_affiliate = $this->input->post('fld_urls_affiliate');
        $this->load->library('simple_html_dom');
        
        $lg_id = $this->session->userdata('lg_id');
        $user_info = $this->users_model->get_user_by_id($lg_id);
        $str_start = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>'.$user_info['email_header_title'].'</title>

</head>
<body>
<center>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<table border="0" cellpadding="0" cellspacing="0" width="600">
<tbody>
<tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" style="font-family:Arial,Helvetica,sans-serif" width="600">
<tbody>
<tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" width="600">
<tbody>

<tr style="">
<td colspan="2"><img height="7" src="http://rtm.ebaystatic.com/203/RTMS/Image/mailer_border_123_192013.gif" width="600"></td>
</tr>
<tr style="">
<td width="341">

<a rel="nofollow" href="http://stores.ebay.co.uk/frill-shop?_rdc=1" 
target="_blank">
<img alt="frillshop" border="0"  height="150" src="'.base_url ().$user_info['email_header'].'" 
title="frillshop"></a></td>
<td align="center" 
style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:rgb(102,102,102)" 
width="259"><a rel="nofollow" 
href="http://stores.ebay.co.uk/frill-shop?_rdc=1" target="_blank" 
style="text-decoration: none">
<img alt="eBay rated" border="0" 
height="80" src="'.base_url ().'files/images/ebay.png" title="eBay rated">&nbsp; 
<img alt="paypal" border="0" 
height="80" src="'.base_url ().'files/images/paypal.png" title="paypal"></a></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
</tbody>
</table></td>
</tr>

</tbody>
</table></td>
</tr>';
        $str_end = '<tr>
                        <td height="30" align="center"><span style="font-family:Arial,Helvetica,sans-serif;font-size:10px;color:rgb(170,170,170)">
                                Copyright '.date('Y').' '.$user_info['email_header_title'].' </span></td>
                    </tr>
                    </tbody>
                    </table>
                    </center>
                    </body>
                    </html>';
        $mid = '';
//        if(!empty($user_info['email_header']))
//            $mid = '<tr><td><img src="'.base_url ().$user_info['email_header'].'"></td></tr>';
        
            
        
        $fld_arr = explode(',', $fld_ids);
        $fld_urls_arr = explode(',', $fld_urls);
        $fld_urls_affiliate_arr = explode(',', $fld_urls_affiliate);
        
        $l_arr = array();
        $main_arr = array();
//        for($i=0;$i<sizeof($fld_arr);$i++){
//            $html = $this->curl_url_data($fld_urls_arr[$i]);
//            $html = str_get_html($html);
//            $title = '';
//            $img_src = '';
//            if(!empty($html)){
//                foreach ($html->find('span#vi-lkhdr-itmTitl') as $title) {
//                    $title = str_replace("Details about &nbsp;", "", $title->innertext);
//                }
//                foreach ($html->find('div#mainImgHldr img#icImg') as $img) {
//                    $img_src = $img->src;
//                }
//                $l_arr['title'] = $title; 
//                $l_arr['img_src'] = $img_src; 
//                $l_arr['affiliate_link'] = $fld_urls_affiliate_arr[$i]; 
//                $main_arr[] = $l_arr;
//            }
//        }
        
        $mid.='<tr>
        <td>
            <table bgcolor="#E2E1DD" border="0" cellpadding="0" cellspacing="10" style="table-layout:fixed" width="600">
                <tbody>
                    ';
        $count = 0;
        $flag = true;
        foreach($main_arr as $key=>$row){
            if($flag&&$count==0){
                $mid.='<tr>';
                $flag = false;
            }
            $mid .= '<td height="263" style="background:#ffffff" valign="top">
                        <table border="0" cellpadding="5" cellspacing="0" height="202" style="background-color:rgb(255,255,255);font-family:Arial,Helvetica,sans-serif;font-size:13px;background-repeat:initial initial" width="100%">
                            <tbody>
                                <tr>
                                    <td align="center" height="150" valign="top"><span><a rel="nofollow" href="'.$row['affiliate_link'].'" target="_blank">
                                                <img alt="'.$row['title'].'" border="0" src="'.$row['img_src'].'" height="150" style="max-width: 170px;" title="'.$row['title'].'"></a> </span></td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top"><span>
                                            <a rel="nofollow" href="'.$row['affiliate_link'].'" style="text-decoration:none;color:#333;text-align:left" target="_blank"><span>'.$row['title'].'</span><br>
                                                </a></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>';
//            $mid .='<td><a href="'.$row['affiliate_link'].'"><img src="'.$row['img_src'].'" width="250" height="250" />'.$row['title'].'</a></td>';
            $count++;
            if($count==3){
                $mid.='</tr>';
                $flag = true;
                $count = 0;
            }
        }
        $mid.=' 
                    </tbody>
                </table>
            </td>
        </tr>
    ';
        $final = $str_start.$mid.$str_end;
        
        $this->load->library('email');
        $config['mailtype'] = 'html';
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);
//        $this->email->from("mentordevelop@gmail.com", "Affiliate Dynamic Scrapper");
//
////        $this->email->to($user_info['email_addres']);
//        $this->email->to('mum.mary786@gmail.com'); 
//        $this->email->subject("Afiliate Dynamic Scrapper Html");
//
//        $this->email->message($final);
//
//        $this->email->send();
//
//        $this->email->clear(TRUE);
        $this->email->from("mentordevelop@gmail.com", "Affiliate Dynamic Scrapper");

        $this->email->to($user_info['email_addres']);
        $this->email->cc('mum.mary786@gmail.com'); 
        $this->email->subject("Afiliate Dynamic Scrapper Html");

        $this->email->message($html_gen);

        $this->email->send();

        $this->email->clear(TRUE);
        
        
    }
    /*
     * Curl url data
     */

    function curl_url_data($url,$data='') {
//        echo $url;
        $ch = curl_init();
        
        $link = $url;
        //url-ify the data for the POST
//        $fields_string = '';
//        foreach ($data as $key => $value) {
//            $fields_string .= $key . '=' . $value . '&';
//        }
//        rtrim($fields_string, '&');

        //set the url, number of POST vars, POST data
        
        curl_setopt($ch, CURLOPT_URL, $link);
        $header = array();
        $header[0]  = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
        //$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        $header[]   = "Cache-Control: private";
        $header[]   = "Connection: keep-alive";
		//$header[]   = "Host: http://localhost/fbombmedia_udirect";
        $header[]   = "Keep-Alive: 300";
        $header[]   = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $header[]   = "Accept-Language: en-US,en;q=0.5";
        $header[]   = "Pragma: "; // browsers keep this blank.

        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    	//curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieJar);
    	//curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieJar);
	
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_POST, count($data));
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

        $html = curl_exec($ch);
        curl_close($ch);
        return $html;
    }

}