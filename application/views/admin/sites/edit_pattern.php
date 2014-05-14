
<link rel="stylesheet" href="<?php echo base_url(); ?>files/css/style.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>files/css/bootstrap.css" />
<script src="<?php echo base_url(); ?>files/js/email.js"></script>
<div class="container top">

    <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("admin"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider"></span>
        </li>
        <li >
            <a href="<?php echo site_url("sites"); ?>">
                <?php echo ucfirst($site['site_name']);?>
            </a>
          <span class="divider"></span>
        </li>
        <li class="active">
            <?php echo ucfirst("Edit Pattern"); ?>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            <?php echo ucfirst("Edit Site Pattern"); ?>
        </h2>
    </div>
    <div class="page-content">
        <div class="center-page-content">
            <div class="panel panel-default">
                <div class="panel-heading center-align"><strong>Edit Site Pattern</strong></div>
                <div class="panel-body">
                    <span id="itemRow">
                        <?php echo validation_errors(); ?>
                    </span>
                    <form name="sites_frm" id="site_frm" method="POST" action="<?php echo base_url() . 'admin/site/update_save_pattern' ?>" enctype="multipart/form-data" >
                        <input type="hidden" name="site_id" id="site_id" value="<?php echo $site['site_id'];?>" />
                         <input type="hidden" name="pt_id" id="pt_id" value="<?php echo $site_patterns['pt_id'];?>" />
                        <table width="100%" border="0" id="table_Row">
                            
                            <tr id="row_1">
                                <td>
                                    <span id="itemRow">
                                        <div class="input-group">
                                            <span class="input-group-addon"><b>Name</b></span>
                                            <input class="form-control" type="text" id="name" name="name" value="<?php echo $site_patterns['pt_fld_name'];?>" placeholder="Pattern Name">
                                        </div>
                                    </span>
                                    <br/>   
                                </td>
                            </tr>
                            <tr id="row_2">
                                <td>
                                    <span id="itemRow">
                                        <div class="input-group">
                                            <span class="input-group-addon"><b>Pattern</b></span>
                                            <input class="form-control" type="text" id="url" name="url" value="<?php echo $site_patterns['pt_fld_value'];?>" placeholder="Pattern List">
                                        </div>
                                    </span>
                                    <br/>
                                    <span id="url_pointer"></span>
                                </td>
                            </tr>
                            <tr id="row_5">
                                <td>
                                    <span id="itemRow">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <input type="checkbox" value="1" <?php echo ($site_patterns['is_anchor']==1)?'checked=""':'';?>  name="anchor"> Anchor 
                                                <input type="checkbox" value="1" <?php echo ($site_patterns['is_inner_text']==1)?'checked=""':'';?>  name="inner_text"> Inner Text 
                                                <input type="checkbox" value="1" <?php echo ($site_patterns['is_outer_text']==1)?'checked=""':'';?>  name="outer_text"> Outer Text 
                                                <input type="checkbox" value="1" <?php echo ($site_patterns['is_image']==1)?'checked=""':'';?> name="image"> Image  
                                                <input type="checkbox" value="1" <?php echo ($site_patterns['is_table']==1)?'checked=""':'';?> name="is_table" id="is_table"> Is Table  
                                                
                                            </span>
                                        </div>
                                        <br />
                                        <?php
                                        if(!empty($site_patterns['pt_fld_options'])){
                                         $options = json_decode($site_patterns['pt_fld_options'],true);
                                         extract($options);
                                        }else{
                                            $total_colums = '';
                                            $req_colum = '';
                                        }
                                         
                                         ?>
                                        <div id="is_table_tr" class="input-group-addon" style="display: none;">
                                                <span id="itemRow">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><b>Total Colum</b></span>
                                                        <input class="form-control" type="text" id="total_colums" name="total_colums" value="<?php echo (isset($total_colums))?$total_colums:""; ?>" placeholder="Total Colums in Row">
                                                    </div>
                                                </span>
                                                <br/>
                                                <span id="itemRow">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><b>Required Colum Number</b></span>
                                                        <input class="form-control" type="text" id="req_colum" name="req_colum" value="<?php echo (isset($req_colum))?$req_colum:""; ?>" placeholder="Required Colum Number">
                                                    </div>
                                                </span>
                                                <br/>
                                            </div>
                                        <br />
                                    </span>
                                    <br/>

                                </td>
                            </tr>
                            <tr id="row_4">
                                <td>
                                    <span id="itemRow">
                                        <div class="input-group">
                                            <span class="input-group-addon" >
                                                <input type="radio" value="1"  <?php echo ($site_patterns['pt_status']==1)?'checked=""':'';?>  name="is_active"> Active
                                               <input type="radio" value="2" <?php echo ($site_patterns['pt_status']==2)?'checked=""':'';?>  name="is_active"> InActive 
                                            </span>
                                        </div>
                                        
                                            <br />
                                    </span>
                                    <br/>

                                </td>
                            </tr>
<!--                            <tr id="row_4">
                                <td>
                                    <span style="float: right;" onclick="addRow(this.form);" class="btn btn-success">Add Row </span>
                                    <br/>
                                    <br/>

                                </td>
                            </tr>-->
<!--                            <tr id="row_5">
                                <td>
                                    <span id="itemRow">
                                        <div class="input-group">
                                            <span class="input-group-addon" > <input style="float: left;" class="input-sm" type="text" id="fld_name_1" name="fld_name" placeholder="Name"></span>
                                            <span class="input-group-addon" style="width: 100px;"> <input class="form-control" type="text" id="fld_pattern_1" name="fld_pattern" placeholder="Pattern"></span>
                                        </div>
                                        <span class="input-group-addon"><input type="checkbox" value="1" <?php echo set_checkbox('anchor', '1'); ?> name="anchor"> Anchor <input type="checkbox" value="1" <?php echo set_checkbox('inner_text', '1'); ?> checked="" name="inner_text"> Inner Text <input type="checkbox" value="1" <?php echo set_checkbox('outer_text', '1'); ?> name="outer_text"> Outer Text <input type="checkbox" value="1" <?php echo set_checkbox('image', '1'); ?> name="image"> Image  </span>
                                            <br />
                                    </span>
                                    <br/>

                                </td>
                            </tr>-->
    
                        </table>
                        <input type="submit" style="float: right;margin-left: 5px;" class="btn btn-success" value="Submit" /> &nbsp;&nbsp;&nbsp;
                         <input type="button" onclick="javascript:history.back(-1);" style="float: right;" class="btn btn-success" value="Cancel" />
                    </form>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>"/>
<script>
    var rowNum = 6;
    function addRow(frm) {
        rowNum++;
        var row = '<tr id="row_' + rowNum + '"><td><span id="itemRow"><div class="input-group"><span class="input-group-addon" > <input style="float: left;" class="input-sm" type="text" id="fld_name_' + rowNum + '" name="fld_name" placeholder="Name"></span><span class="input-group-addon" style="width: 400px;"><input style="float: left;" class="form-control" type="text" id="fld_pattern_' + rowNum + '" name="fld_pattern" placeholder="Pattern"></span><span style="width: 50px;" onclick="removeRow(' + rowNum + ');" class="input-group-addon btn-danger">Remove</span></div></span><span class="input-group-addon"><input type="checkbox" name="anchor"> Anchor <input type="checkbox" checked="" name="inner_text"> Inner Text <input type="checkbox" name="outer_text"> Outer Text <input type="checkbox" name="image"> Image </span><br/></td></tr>';
        jQuery('#table_Row').append(row);
    }
    function removeRow(rnum) {
        jQuery('#row_' + rnum).remove();
    }
    $(document).ready(function (){
        $('#is_table').click (function(){
          var thisCheck = $(this);
          if ( $('#is_table').is(':checked') ) {
            $("#is_table_tr").slideDown('fast');
          }
          else
            $("#is_table_tr").slideUp('fast');
        });
        $(function(){
            if ( $('#is_table').is(':checked') ) {
            $("#is_table_tr").slideDown('fast');
          }
          else
            $("#is_table_tr").slideUp('fast');
        });
    });
</script>