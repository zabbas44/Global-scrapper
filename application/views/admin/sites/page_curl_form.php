
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
            <?php echo ucfirst("Page Request Form"); ?>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            <?php echo ucfirst("Page Scrap Form"); ?>
        </h2>
    </div>
    <div class="page-content">
        <div class="center-page-content">
            <div class="panel panel-default">
                <div class="panel-heading center-align"><strong>Page Scrap Form</strong></div>
                <div class="panel-body">
                    <span id="itemRow">
                        <?php echo validation_errors(); ?>
                    </span>
                    <form name="sites_frm" id="site_frm" method="POST" action="<?php echo base_url() . 'sites/get_scrap_data' ?>" enctype="multipart/form-data" >
                           <table width="100%" border="0" id="table_Row">
                               <input type="hidden" name="site_id" id="site_id" value="<?php echo $site['site_id'];?>" />
                            <tr id="row_2">
                                <td>
                                    <span id="itemRow">
                                        <div class="input-group">
                                            <span class="input-group-addon">@</span>
                                            <input class="form-control" type="text" id="url" name="url" value="<?php echo set_value('url'); ?>" placeholder="Url">
                                        </div>
                                    </span>
                                    <br/>
                                    <span id="url_pointer"></span>
                                </td>
                            </tr>
<!--                            <tr id="row_5">
                                <td>
                                    <span id="itemRow">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <input type="checkbox" value="1" <?php echo set_checkbox('anchor', '1'); ?> name="anchor"> Anchor 
                                                <input type="checkbox" value="1" <?php echo set_checkbox('inner_text', '1'); ?> checked="" name="inner_text"> Inner Text 
                                                <input type="checkbox" value="1" <?php echo set_checkbox('outer_text', '1'); ?> name="outer_text"> Outer Text 
                                                <input type="checkbox" value="1" <?php echo set_checkbox('image', '1'); ?> name="image"> Image  
                                            </span>
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
                                               <input type="radio" value="1" checked="" <?php echo set_radio('is_active', '1',TRUE); ?> name="is_active"> Active
                                               <input type="radio" value="2" <?php echo set_radio('is_active', '2'); ?> name="is_active"> InActive 
                                            </span>
                                        </div>
                                        
                                            <br />
                                    </span>
                                    <br/>

                                </td>
                            </tr>-->
    
                        </table>
                        <input type="submit" style="float: right;margin-left: 5px;" class="btn btn-success" value="Submit" />
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
</script>