<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<link href="<?php echo base_url(); ?>assets/css/admin/global.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/css/admin/amazon.css" rel="stylesheet" type="text/css">


<div style="margin: 0px auto;">
  <div style="font-size: 14px;">
    <?php 
        $str = '<div class="cdInlineAskBoxTitle" style="margin-bottom: 10px">
    Customer Questions &amp; Answers
</div>';
        if(sizeof($questions)>0){
            foreach($questions as $key=>$val){
                $str.='<div class="cdAskQandA" style="margin-bottom: 16px;">
  <div class="cdAskQuestion"> <a href="#"><span style="font-weight:bold">Q: </span>'.$val['q_text'].'</a> </div>
  <div class="cdAskAnswer">
    <div class="cdAskAnswerTag"> <span style="font-weight:bold">A: </span> </div>
    <div class="cdAskAnswerBody">
      
	  '.$val['ans_text'].'
	  
      <span class="cdJSEnabledText"> <span style="display:block" id="long_MxPFMANKBAL8FU">
      
      </span> </span> </div>
  </div>
</div>';
              
            }
        }
        else{
            $str = 'No Question Found';
        }
        ?>
    <?php echo $str; ?> </div>
</div>
