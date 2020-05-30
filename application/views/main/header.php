<?php
	$user_name = $this->session->userdata('user_id');
?>
<header class="main-header">
<nav  class="navbar navbar-default">
	<div style="  background-image:url(<?php echo base_url().'assets/img/heade3.png'?>); " class="row header_row">
	    <div class="col-md-6 col-xs-12">
	       <a href="<?php echo base_url('/');?>homepage ">
	      <i class="fa fa-globe"> </i> <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'] ;?>
	     </a>
	    </div>
	    <div class="col-md-6 col-xs-12 ">
	    	<span class="pull-right">
	    			    		
		        <a class=" link-setting-header" href="<?php echo base_url('homepage'); ?>">
		                <i class="fa fa-dashboard" aria-hidden="true"></i> Dashboard
		        </a>
		        <a class=" link-setting-header" href="javscript:void(0)">
		                <i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo date('d-m-Y'); ?> 	
		        </a>
		    	<a class="text-center link-setting-header" href="<?php echo base_url('profile');?>">
		             <?php echo img(array('width'=>'18','height'=>'18','class'=>'img-circle','alt'=>'User Image','src'=>'uploads/users/'.$this->db->get_where('mp_users', array('id' =>$user_name['id']))->result_array()[0]['cus_picture'])); ?>
		                  <?php echo $user_name['name']; ?>
		        </a> 
		        <a class="pull-right link-setting-header" href="<?php echo base_url('homepage/sign_out');?>">
		                <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
		        </a>
	        </span>
    	</div>
	</div>
	<div class="stellarnav">
		<?php
		$SideMenu_records = fetch_users_access_control_menu($user_name['id']);
		if($SideMenu_records != NULL)
		{
		?>	
		<ul>
			<?php
			foreach ($SideMenu_records as  $obj_SideMenu_records) 
			{
			?>	
				<li>
					<a href="">
						<i class="<?php echo $obj_SideMenu_records['icon']; ?> icon-settings" aria-hidden="true" >
						</i>
						<span class="text-center link-settting" > 
							<?php echo $obj_SideMenu_records['name']; ?>
						</span>
					</a>
					<ul>
						<?php
						//DEFINES TO FETCH THE ROLES ASSIGNED TO USER SUB MENU DATA mp_menulist TABLE
						$SideSubMenu_records = fetch_users_access_control_sub_menu($user_name['id'],$obj_SideMenu_records['main_id']);
					
						if($SideSubMenu_records != NULL)
						{
							foreach ($SideSubMenu_records as $obj_SideSubMenu_records) 
							{   
						?>
							<li>
								<a href="<?php echo base_url($obj_SideSubMenu_records['link']);?>">
									<i class="sub-icon-settings fa fa-circle-o"></i>
									<?php echo $obj_SideSubMenu_records['title']; ?>
								</a>
							</li>
						<?php 
							}
						}
						?>		
					</ul>
				</li>	
			<?php 
			}
			?>	
		</ul>
		<?php 
		}
	    ?>
	</div>
</nav>
</header>