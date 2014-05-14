<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script src="<?php echo base_url(); ?>files/jquery-1.10.1.min.js" type="text/javascript"></script>
<script>
    
    function frm_submit(frm) {
       var msg = '';
       if(frm.q_text.value==''){
           alert("Question Text is requird!");
           return false;
       }
      
       return true;
    }

</script>
<style type="text/css">
.cdInlineAskQuestionPostBox {
	-moz-border-bottom-colors: none;
	-moz-border-left-colors: none;
	-moz-border-right-colors: none;
	-moz-border-top-colors: none;
	border-color: #BBBBBB #D0D0D0 #D0D0D0;
	border-image: none;
	border-radius: 3px;
	border-style: solid;
	border-width: 1px;
	font-size: 12px;
	line-height: 1.3em;
	margin-bottom: 5px;
	margin-top: 5px;
	min-height: 2.6em;
	padding: 3px 0 3px 5px;
	resize: none;
	width: 585px;
}
</style>

<div style="margin: 0px auto;">
  <form name="ask_question" id="ask_question" action="<?php echo site_url() . 'question/add_question_iframe' ?>" method="get" onsubmit="return frm_submit(this);">
    <input type="hidden" name="p_id" id="p_id" value="<?php echo $p_id ?>" />
    <input type="hidden" name="p_title" id="p_title" value="<?php echo $p_title ?>" />
    <input type="hidden" name="p_link" id="p_link" value="<?php echo $p_link ?>" />
    <div id="form_field"> <span class="cdInlineAskInputBox"> </span>
      <input maxlength="150" type="text" name="q_text" id="q_text" class="cdInlineAskQuestionPostBox" placeholder="Have a question? Ask the owners here." value="" />
      <input type="submit" name="ask_sub" id="ask_sub" value="Submit" />
    </div>
  </form>
</div>
