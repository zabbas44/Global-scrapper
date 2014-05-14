<link href="<?php echo base_url(); ?>files/data-tables/DT_bootstrap.css" rel="stylesheet" type="text/css">

<script src="<?php echo base_url(); ?>files/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo base_url(); ?>files/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      
<script src="<?php echo base_url(); ?>files/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>files/data-tables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>files/data-tables/DT_bootstrap.js"></script>
<script src="<?php echo base_url(); ?>files/js/data_listing_table.js"></script>




<div class="container top">

      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("admin"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <?php echo ucfirst("Sites");?>
        </li>
      </ul>

      <div class="page-header users-header">
        <h2>
          <?php echo ucfirst("Sites");?>
          <a  href="<?php echo site_url("admin/site/add");?>" class="btn btn-success">Add New Site</a>
        </h2>
      </div>
      
      <div class="row">
        <div class="span12 columns">
          <div class="welldd">
            <?php
      //flash messages
      if(isset($flash_message)){
        if($flash_message == TRUE)
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Well done!</strong> new Site created with success.';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
          echo '</div>';          
        }
      }
      ?>
            

          </div>

            <table id="user_list" class="table table-striped table-bordered table-hover table-full-width">
            <thead>
              <tr>
                <th class="header">#</th>
                <th class="yellow header headerSortDown">Name</th>
                <th class="yellow header headerSortDown">Site Url</th>
                <th class="yellow header headerSortDown">Pattern</th>
                <th class="green header">Status</th>
                <th class="green header">Date</th>
                <th class="red header">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 0;
              foreach($sites as $row)
              {
                  $i++;
                  $status = ($row['site_status']==1)?"Active":"InActive";
                echo '<tr>';
                echo '<td>'.$i.'</td>';
                echo '<td>'.ucfirst($row['site_name']).'</td>';
                echo '<td>'.$row['site_url'].'</td>';
                echo '<td><a href="'.site_url("admin").'/site/patterns/'.$row['site_id'].'" class="btn btn-info">Pattern</a></td>';
                echo '<td>'.$status.'</td>';
                echo '<td>'.$row['site_date'].'</td>';
                echo '<td class="crud-actions">
                  <a href="'.site_url("admin").'/sites/update/'.$row['site_id'].'" class="btn btn-info">view & edit</a>  
                  <a href="'.site_url("admin").'/sites/delete/'.$row['site_id'].'" class="btn btn-danger">delete</a>
                </td>';
                echo '</tr>';
              }
              ?>      
            </tbody>
          </table>

          

      </div>
    </div>