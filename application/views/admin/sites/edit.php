
<link rel="stylesheet" href="<?php echo base_url(); ?>files/css/style.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>files/css/bootstrap.css" />
<script src="<?php echo base_url(); ?>files/js/email.js"></script>
<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("admin"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a> 
  <!--          <span class="divider">/</span>-->
        </li>
        <li class="active">
            <?php echo ucfirst("Edit Site"); ?>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            <?php echo ucfirst("Edit Site"); ?>
        </h2>
    </div>
    <div class="page-content">
        <div class="center-page-content">
            <div class="panel panel-default">
                <div class="panel-heading center-align"><strong>Edit Site Info</strong></div>
                <div class="panel-body">
                    <span id="itemRow">
                        <?php echo validation_errors(); ?>
                    </span>
                    <form name="sites_frm" id="site_frm" method="POST" action="<?php echo base_url() . 'admin/site/update_save_site' ?>" enctype="multipart/form-data" >
                        <input type="hidden" name="site_id" id="site_id" value="<?php echo $site['site_id'];?>" />
                        <table width="100%" border="0" id="table_Row">
                            
                            <tr id="row_1">
                                <td>
                                    <span id="itemRow">
                                        <div class="input-group">
                                            <span class="input-group-addon"><b>Name</b></span>
                                            <input class="form-control" type="text" id="name" name="name" value="<?php echo $site['site_name'];?>" placeholder="Site Name">
                                        </div>
                                    </span>
                                    <br/>   
                                </td>
                            </tr>
                            <tr id="row_2">
                                <td>
                                    <span id="itemRow">
                                        <div class="input-group">
                                            <span class="input-group-addon"><b>Url</b></span>
                                            <input class="form-control" type="text" id="url" name="url" value="<?php echo $site['site_url'];?>" placeholder="Site URL">
                                        </div>
                                    </span>
                                    <br/>
                                    <span id="url_pointer"></span>
                                </td>
                            </tr>
                            <tr id="row_3">
                                <td>
                                    <span id="itemRow">
                                        <div class="input-group">
                                            <span class="input-group-addon"><b>Description</b></span>
                                            <input class="form-control" type="text" id="desc" name="desc" value="<?php echo $site['site_desc'];?>" placeholder="Site Descrtion">
                                        </div>
                                    </span>
                                    <br/>

                                </td>
                            </tr>
                            <tr id="row_4">
                                <td>
                                    <span id="itemRow">
                                        <div class="input-group">
                                            <span class="input-group-addon" >
                                                <input type="radio" value="1"  <?php echo ($site['site_status']==1)?'checked=""':'';?>  name="is_active"> Active
                                               <input type="radio" value="2" <?php echo ($site['site_status']==2)?'checked=""':'';?>  name="is_active"> InActive 
                                            </span>
                                        </div>
                                        
                                            <br />
                                    </span>
                                    <br/>

                                </td>
                            </tr>
                            <tr id="row_5">
                                <td>
                                    <span id="itemRow">
                                        <div class="input-group">
                                            <span class="input-group-addon" >
                                                <input type="checkbox" onclick="check_uncheck();" value="1" <?php echo ($site['is_paginate']==1)?'checked=""':'';?> id="is_paginate" name="is_paginate"> Pagination
                                               
                                            </span>
                                        </div>
                                        <br />
                                    </span>
                                    <br/>

                                </td>
                            </tr>
                            <tr id="row_6" style="<?php echo ($site['is_paginate']==1)? '':'display:none;';?>">
                                <td>
                                    <span id="itemRow">
                                        <div class="input-group">
                                            <span class="input-group-addon" > <input style="float: left;" value="<?php echo $site['total_products'];?>" class="input-sm" type="text" id="total_products" name="total_products" placeholder="Total Products"></span>
                                            <span class="input-group-addon" style="width: 100px;"> <input  value="<?php echo $site['link_pattern'];?>" class="form-control" type="text" id="link_pattern" name="link_pattern" placeholder="Link Pattern"></span>
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
                        <input type="submit" style="float: right;" class="btn btn-success" value="Submit" />
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
    function check_uncheck(){
        if($("#is_paginate").is(':checked'))
            $("#row_6").show();  // checked
        else
            $("#row_6").hide();  // unchecked
    }
</script>