<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Sites extends CI_Controller {
    /**
     * Responsable for auto load the model
     * @return void
     */

    /**
     * Check if the user is logged in, if he's not, 
     * send him to the login page
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('users_model');
        $this->load->model('sites_model');
        if ($this->session->userdata('is_logged_in')) {
            
        } else {
            redirect('admin/login');
        }
    }

    /*
     * List All Sites Info
     */

    function index() {
        $data = array();
        //load the view
        $data['sites'] = $this->sites_model->get_all_site($data);
        $data['main_content'] = 'admin/sites/list';
        $this->load->view('includes/template', $data);
    }

    function printr($arr) {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
        exit;
    }

    function add_site() {
        $data = array();
        //load the view
        $data['main_content'] = 'admin/sites/add';
        $this->load->view('includes/template', $data);
    }

    function save_site() {
//        $this->printr($this->input->post());
        $data = array();
        $data['main_content'] = 'admin/sites/add';

        $this->load->library('form_validation');

        // field name, error message, validation rules
        $this->form_validation->set_rules('name', 'Site Name', 'trim|required');
        $this->form_validation->set_rules('url', 'Site Url', 'trim|required');
        $this->form_validation->set_rules('desc', 'Site Url', 'trim');
//        $this->form_validation->set_rules('fld_name', 'Fields Name Required', 'trim|required');
//        $this->form_validation->set_rules('fld_pattern', 'Fields Url Required', 'trim|required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('includes/template', $data);
        } else {
            $data_val = array();
            $data_val['site_name'] = $this->input->post('name');
            $data_val['site_url'] = $this->input->post('url');
            $data_val['site_desc'] = $this->input->post('desc');
            $data_val['site_status'] = $this->input->post('is_active');
            $data_val['is_paginate'] = $this->input->post('is_paginate');
            $data_val['total_products'] = $this->input->post('total_products');
            $data_val['link_pattern'] = $this->input->post('link_pattern');
            $data_val['site_date'] = date('Y-m-d');
            $data_val['site_date_update'] = date('Y-m-d');

//            $this->printr($this->input->post());
            if ($query = $this->sites_model->add_site($data_val)) {
                redirect('admin/sites');
            } else {
                $this->load->view('includes/template', $data);
            }
        }
    }

    function update_site() {
        $id = $this->uri->segment(4);
        if (!empty($id)) {
            $data = array();
            $data['site'] = $this->sites_model->get_site_by_id($id);
            $data['main_content'] = 'admin/sites/edit';
            $this->load->view('includes/template', $data);
        }
        else
            redirect('admin/sites');
    }

    function update_save_site() {
//        $this->printr($this->input->post());
        $id = $this->input->post('site_id');
        $data = array();
        $data['main_content'] = 'admin/sites/edit';
        $data['site'] = $this->sites_model->get_site_by_id($id);
        $this->load->library('form_validation');

        // field name, error message, validation rules
        $this->form_validation->set_rules('name', 'Site Name', 'trim|required');
        $this->form_validation->set_rules('url', 'Site Url', 'trim|required');
        $this->form_validation->set_rules('desc', 'Site Url', 'trim');
//        $this->form_validation->set_rules('fld_name', 'Fields Name Required', 'trim|required');
//        $this->form_validation->set_rules('fld_pattern', 'Fields Url Required', 'trim|required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('includes/template', $data);
        } else {
            $data_val = array();
//            $data_val['site_id'] = $this->input->post('site_id');
            $data_val['site_name'] = $this->input->post('name');
            $data_val['site_url'] = $this->input->post('url');
            $data_val['site_desc'] = $this->input->post('desc');
            $data_val['site_status'] = $this->input->post('is_active');

            $data_val['is_paginate'] = $this->input->post('is_paginate');
            $data_val['total_products'] = $this->input->post('total_products');
            $data_val['link_pattern'] = $this->input->post('link_pattern');
//            $data_val['site_date'] = date('Y-m-d');
            $data_val['site_date_update'] = date('Y-m-d');

//            $this->printr($this->input->post());
            if ($query = $this->sites_model->update_site($id, $data_val)) {
                redirect('admin/sites');
            } else {
                $this->load->view('includes/template', $data);
            }
        }
    }

    //update
    /**
     * Delete Site by his id
     * @return void
     */
    public function delete() {
        //product id 
        $id = $this->uri->segment(4);
        $this->sites_model->delete_site($id);
        redirect('admin/sites');
    }

    /* For Site Patterns */

    function pattern() {
        $site_id = $this->uri->segment(4);
        if (!empty($site_id)) {
            $data = array();
            $data['main_content'] = 'admin/sites/pattern_lists';
            $data['site'] = $this->sites_model->get_site_by_id($site_id);
            $pattern_data = array('site_id_FK' => $site_id);
            $data['site_patterns'] = $this->sites_model->get_all_site_pattern($pattern_data);
            $this->load->view('includes/template', $data);
        } else {
            redirect('admin/sites');
        }
    }

    function add_pattern() {
        $data = array();
        $site_id = $this->uri->segment(4);
        if (!empty($site_id)) {
            $data['site'] = $this->sites_model->get_site_by_id($site_id);
            //load the view
            $data['main_content'] = 'admin/sites/add_pattern';
//            $this->printr($data);
            $this->load->view('includes/template', $data);
        }
        else
            redirect('admin/sites');
    }

    function save_pattern() {
//        $this->printr($this->input->post());
        $data = array();
        $data['main_content'] = 'admin/sites/add_pattern';
        $site_id = $this->input->post('site_id');
        $data['site'] = $this->sites_model->get_site_by_id($site_id);
        $this->load->library('form_validation');

        // field name, error message, validation rules
        $this->form_validation->set_rules('name', 'Site Name', 'trim|required');
        $this->form_validation->set_rules('url', 'Site Url', 'trim|required');
//        $this->form_validation->set_rules('desc', 'Site Url', 'trim');
//        $this->form_validation->set_rules('fld_name', 'Fields Name Required', 'trim|required');
//        $this->form_validation->set_rules('fld_pattern', 'Fields Url Required', 'trim|required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('includes/template', $data);
        } else {
            $data_val = array();
            $data_val['site_id_FK'] = $site_id;
            $data_val['pt_fld_name'] = $this->input->post('name');
            $data_val['pt_fld_value'] = $this->input->post('url');
            $data_val['pt_status'] = $this->input->post('is_active');
            $data_val['is_anchor'] = $this->input->post('anchor');
            $data_val['is_inner_text'] = $this->input->post('inner_text');
            $data_val['is_outer_text'] = $this->input->post('outer_text');
            $data_val['is_image'] = $this->input->post('image');
            $data_val['pt_date'] = date('Y-m-d');


//            $this->printr($this->input->post());
            if ($query = $this->sites_model->add_site_pattern($data_val)) {
                redirect("admin/site/patterns/$site_id");
            } else {
                $this->load->view('includes/template', $data);
            }
        }
    }

    function update_pattern() {
        $id = $this->uri->segment(4);
        $site_id = $this->uri->segment(5);
        if (!empty($id)) {
            $data = array();
            $data['site'] = $this->sites_model->get_site_by_id($site_id);
            $data['site_patterns'] = $this->sites_model->get_site_pattern_by_id($id);
            $data['main_content'] = 'admin/sites/edit_pattern';
            $this->load->view('includes/template', $data);
        }
        else
            redirect('admin/site/patterns');
    }

    function update_save_pattern() {
//        $this->printr($this->input->post());
        $site_id = $this->input->post('site_id');
        $id = $this->input->post('pt_id');
        $data = array();
        $data['main_content'] = 'admin/sites/edit_pattern';
        $data['site'] = $this->sites_model->get_site_by_id($site_id);
        $data['site_patterns'] = $this->sites_model->get_site_pattern_by_id($id);
        $data['site'] = $this->sites_model->get_site_by_id($id);
        $this->load->library('form_validation');

        // field name, error message, validation rules
        $this->form_validation->set_rules('name', 'Site Name', 'trim|required');
        $this->form_validation->set_rules('url', 'Site Url', 'trim|required');
//        $this->form_validation->set_rules('desc', 'Site Url', 'trim');
//        $this->form_validation->set_rules('fld_name', 'Fields Name Required', 'trim|required');
//        $this->form_validation->set_rules('fld_pattern', 'Fields Url Required', 'trim|required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('includes/template', $data);
        } else {
            $data_val = array();
//            $data_val['site_id_FK'] = $site_id;
            $data_val['pt_fld_name'] = $this->input->post('name');
            $data_val['pt_fld_value'] = $this->input->post('url');
            $data_val['pt_status'] = $this->input->post('is_active');
            $data_val['is_anchor'] = $this->input->post('anchor');
            $data_val['is_inner_text'] = $this->input->post('inner_text');
            $data_val['is_outer_text'] = $this->input->post('outer_text');
            $data_val['is_image'] = $this->input->post('image');
            $data_val['pt_date'] = date('Y-m-d');

//            printr($this->input->post());
            if ($query = $this->sites_model->update_site_pattern($id, $data_val)) {
                redirect("admin/site/patterns/$site_id");
            } else {
                $this->load->view('includes/template', $data);
            }
        }
    }

    //update
    /**
     * Delete Site by his id
     * @return void
     */
    public function delete_pattern() {
        //product id 
        $id = $this->uri->segment(4);
        $site_id = $this->uri->segment(5);
        $this->sites_model->delete_site_pattern($id);
        redirect("admin/site/patterns/$site_id");
    }

    //get All Pages of the sites.

    function page_scrap_form() {
        $data = array();
        $site_id = $this->uri->segment(4);
        if (!empty($site_id)) {
            $data['site'] = $this->sites_model->get_site_by_id($site_id);
            //load the view
            $data['main_content'] = 'admin/sites/page_curl_form';
//            $this->printr($data);
            $this->load->view('includes/template', $data);
        }
        else
            redirect('admin/sites');
    }

    function get_scrap_data() {
        $data = array();
        $site_id = $this->input->post('site_id');
        $url = $this->input->post('url');
//        $url = 'http://www.ebay.com/sch/allcategories/all-categories';
//        $html = str_get_html($html);
        $site_data = array('site_id_FK' => $site_id);
        $site_patterns = $this->sites_model->get_all_site_pattern($site_data);


        
       

//      printr($site_patterns);
        $html = simple_curl_request($url);
        $main_arr = array();
        $i = 0;
        if (!empty($html)) {
            $pattern_size = sizeof($site_patterns);
            $site_pattern_str = '';
            $cat = '';
            foreach ($site_patterns as $key => $pattern) {
//            for ($j = 0;$j<sizeof($site_patterns);$j++ ) {
//                echo $site_patterns[$pattern_size-$j]['pt_fld_name'].'/'.$site_patterns[$pattern_size-$j+1]['pt_fld_name'].'/'.$site_patterns[$j+2]['pt_fld_name'];
                $is_anchor = $pattern['is_anchor'];
                $is_image = $pattern['is_image'];
                $is_inner_text = $pattern['is_inner_text'];
                $is_outer_text = $pattern['is_outer_text'];
                $title = '';
                $img_src = '';
                $pattern_str = $pattern['pt_fld_value'];
                $pattern_name = str_replace(" ", "_", $pattern['pt_fld_name']);
                $main_arr[$i]['pattern_str'] = $pattern_str;
                $main_arr[$i]['pattern_name'] = $pattern_name;
                $site_pattern_str .= $cat . $pattern_name;
                $cat = ' , ';
                if ($is_image) {
                    $pos = strpos($pattern_str, 'img');
                    if ($pos === false) {
                        $pattern_str = $pattern_str . ' img';
                    }
                }
                if ($is_anchor) {
                    $pos = strpos($pattern_str, 'a');
                    if ($pos === false) {
                        $pattern_str = $pattern_str . ' a';
                    }
                }
                foreach ($html->find($pattern_str) as $div) {
                    $title = '';
                    $img_src = '';
                    $href = '';
                    $l_arr = array();

                    $attr = $div->getAllAttributes();
                    if ($is_image)
                        $img_src = $l_arr[$pattern_name] = $div->src;
                    if ($is_anchor)
                        $href=$l_arr[$pattern_name] = $div->href;
                    if ($is_inner_text)
                        $l_arr[$pattern_name] = $div->plaintext;//innertext;
                    if ($is_outer_text)
                        $l_arr[$pattern_name] = $div->outertext;

                    $title = $l_arr['inner_text'] = $div->innertext;
                    $l_arr['outer_text'] = $div->outertext;
                    $l_arr['plain_text'] = $div->plaintext;
                    $l_arr['href'] = $href;
                    $l_arr['attr'] = $attr;
                    $l_arr['title'] = $title;
                    $l_arr['img_src'] = $img_src;
                    $l_arr['pattern_value'] = $l_arr[$pattern_name];
                    $main_arr[$i][] = $l_arr;
                }
                $i++;
            }
//            echo '<pre>';
//            print_r($main_arr);
//            printr(multiarray_keys($main_arr)); 
            if (!empty($main_arr)) {
                $this->CSV_export_scrapp($site_pattern_str, $main_arr);
            }
        }
    }

    function multiarray_keys($ar) {

        foreach ($ar as $k => $v) {
            $keys[] = $k;
            if (is_array($ar[$k]))
                $keys = array_merge($keys, multiarray_keys($ar[$k]));
        }
        return $keys;
    }

    function CSV_export_scrapp($site_patterns, $mainarr) {

        $fieldseparator = ','; //excel needs comma rather than semi colon
        $download_file = 1; //should the file be downloaded from browser(1) or saved to the server(0)?
        $filename = 'D_scrapper_csv'; //contains name of download file or (depending on $download_file) the path to save csv file without file extension.

        $colums_arr = array('Pattern Name', 'Pattern', 'Title', 'Img Src', 'Inner Text', 'Plin Text', 'Attribute');
        $colums_arr = array();
//        foreach ($site_patterns as $key => $pattern) {
//            $colums_arr[] = $pattern['pt_fld_name'];
//        }
        $lineseparator = "\n";

        //GET COLUMNS::::::
        $csv_output = '';
        $i = 0;
//        $reversed = array_reverse($colums_arr);
//        if (sizeof($colums_arr) > 0) {
//            while ($i < sizeof($colums_arr)) {
//                $csv_output .= $colums_arr[$i] . $fieldseparator . " ";
//                $csv_output .= $site_patterns;
//                $i++;
//
//            }
//        }
        $csv_output .= 'Sr No , '.$site_patterns;
        $csv_output .= "\n";

//echo $csv_output;exit;
        //GET VALUES:::::::::::::::
        $j = 1;
//	while ($rowr = mysql_fetch_row($result,MYSQL_ASSOC)) {
//        foreach ($mainarr as $key => $rowr) {
        $flag = true;
            for ($k = 0; $k < sizeof($mainarr); $k++) {
                for ($k_i = 0; $k_i < sizeof($mainarr[$k]); $k_i++) {
                    $csv_output .= $j . $fieldseparator . " ";
                    for ($j_k_i = 0; $j_k_i < sizeof($mainarr); $j_k_i++) {
                        if(isset($mainarr[$j_k_i][$k_i]['pattern_value']))
                            $csv_output .= $mainarr[$j_k_i][$k_i]['pattern_value'] . $fieldseparator . " ";
                        
                    }
                    $csv_output .= $lineseparator;
                    $j++;
                }
                break;
//		printr($rowr);
                
            }


            //OUTPUT RESULTS::::::::::::::
            if ($download_file) { //DOWNLOAD:
                header("Content-type: application/vnd.ms-excel");
                header("Content-disposition: csv" . date("Y-m-d") . ".csv");
                header("Content-disposition: filename=" . $filename.'_'.rand(1,664). ".csv");
                echo $csv_output;
            } else {//SAVE TO SERVER:
                $fh = @fopen($filename . '.csv', 'w') or die("can't open file");
                @fwrite($fh, $csv_output);
                @fclose($fh);
                if (file_exists($filename . '.csv')) {
                    return (1);
                } else {
                    return(0);
                }
            }

            
        }
    }


?>
