<link rel="stylesheet" href="<?php echo base_url(); ?>files/css/style.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>files/css/bootstrap.css" />
<script src="<?php echo base_url(); ?>files/js/email.js"></script>
<div class="container top">
<ul class="breadcrumb">
  <li> <a href="<?php echo site_url("question"); ?>"> <?php echo ucfirst($this->uri->segment(1)); ?> </a> 
    <!--          <span class="divider">/</span>--> 
  </li>
  <li class="active"> <?php echo ucfirst("Answer Question"); ?> </li>
</ul>
<div class="page-header users-header">
  <h2> <?php echo ucfirst("Answer Question "); ?> </h2>
</div>
<?php
        $q_id = '';
        $ans_id = '';
        $q_text = '';
        $ans_text = '';
        $ans_status = 1;
        if(is_array($site))
            extract($site);
        if(is_array($ans))
            extract($ans);
        
    ?>
<div class="page-content">
  <div class="center-page-content">
    <div class="panel panel-default">
      <div class="panel-heading center-align"><strong>Answer Question</strong></div>
      <div class="panel-body"> <span id="itemRow"> <?php echo validation_errors(); ?> </span>
        <form name="sites_frm" id="site_frm" method="POST" action="<?php echo base_url() . 'question/save_question_answer' ?>" enctype="multipart/form-data" >
          <input type="hidden" name="q_id" id="q_id" value="<?php echo $q_id;?>" />
          <input type="hidden" name="ans_id" id="ans_id" value="<?php echo $ans_id;?>" />
          <table width="100%" border="0" id="table_Row">
            <tr id="row_4">
              <td><span id="itemRow">
                <div class="input-group"> <span class="input-group-addon"><b>Question</b></span>
                  <input class="form-control" type="text" id="question" name="question" value="<?php echo $q_text;?>" placeholder="Enter Question">
                </div>
                </span> <br/>
                <span id="url_pointer"></span></td>
            </tr>
            <tr id="row_3">
              <td><span id="itemRow">
                <div class="input-group"> <span class="input-group-addon"><b>Answer</b></span>
                  <textarea cols="10" rows="5" class="form-control"  id="ans_text" name="ans_text" ><?php echo $ans_text;?></textarea>
                </div>
                </span> <br/></td>
            </tr>
            <tr id="row_5">
              <td><span id="itemRow">
                <div class="input-group"> <span class="input-group-addon" >
                  <input type="radio" value="1" <?php echo ($ans_status==1)?'checked=""':'';?> name="is_active">
                  Active
                  <input type="radio" value="2" <?php echo ($ans_status==2)?'checked=""':'';?> name="is_active">
                  InActive </span> </div>
                <br />
                </span> <br/></td>
            </tr>
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