<style>
    .profile-user-img:hover 
    {
        background-color: #eee;
        cursor: pointer;
        opacity: 0.5;
    }
    
    .passwordset 
    {
        cursor: pointer;
    }
</style>
<div class="content-wrapper">
    <?php
    if($User_profile != NULL)
    {
    ?>
        <section class="content">
            <div class="row">
                <ol class="profile-bread-set breadcrumb pull-left">
                    <li>
                        <a href="<?php echo base_url('homepage'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="active">Profile</li>
                </ol>
            </div> 
            <div class="row">
                <h4  class="purchase-heading text-center" >
                    <i class="fa fa-user" aria-hidden="true"></i>  
                    User Profile
                    <small>Profile of a current logged in User</small>
                </h4>
                <br>
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            
                            <h3 class="box-title">About Me</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-md-2">
                                <strong onclick="show_modal_page('<?php echo base_url(); ?>profile/popup/picture_model')" >
                                    <?php echo img(array('class'=>'profile-user-img img-responsive','alt'=>'<?php echo $User_profile[0]->user_name; ?>','src'=>'uploads/users/'.$User_profile[0]->cus_picture)); ?> 
                                </strong>
                                <h4 class="text-muted username-bg">
                                    <i class="fa fa-user margin-r-5"></i> 
                                    <?php echo $User_profile[0]->user_name; ?>
                                </h4>
                                <!---#passwordModel -->
                                <p class=" passwordset " onclick="show_modal_page('<?php echo base_url();?>profile/popup/password_model')" >  
                                    <i class="fa fa-key" aria-hidden="true" /></i>
                                    <u> Change Password </u> 
                                </p>
                            </div>
                            <div class="col-md-10">
                                <strong><i class="fa fa-book margin-r-5"></i> Email</strong>
                                <p class="text-muted">
                                    <?php echo $User_profile[0]->user_email; ?>
                                </p>
                                <hr>

                                <strong><i class="fa fa-map-marker margin-r-5"></i> Address</strong>
                                <p class="text-muted">
                                    <?php echo $User_profile[0]->user_address; ?>
                                </p>
                                <hr>

                                <strong><i class="fa fa-phone margin-r-5"></i> Contact 1</strong>
                                <p class="text-muted">
                                    <?php echo $User_profile[0]->user_contact_1; ?>
                                </p>
                                <hr>

                                <strong><i class="fa fa-phone margin-r-5"></i> Contact 2 </strong>
                                <p class="text-muted">
                                    <?php echo $User_profile[0]->user_contact_2; ?>
                                </p>
                                <hr>

                                <strong><i class="fa fa-calendar margin-r-5"></i> Added Date</strong>
                                <p class="text-muted">
                                    <?php echo $User_profile[0]->user_date; ?>
                                </p>
                                <hr>

                                <strong><i class="fa fa-pencil margin-r-5"></i> Description </strong>
                                <p class="text-muted">
                                    <?php echo $User_profile[0]->user_description; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php
    }
    ?>
</div>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends--> 