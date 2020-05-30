 // Validate the landing  Page Signup Model form
        $("#Signup_form_Model").validate({
            rules: {
                
                username: {
                    required: true,
                    maxlength: 255
                },
                emailaddress: {
                    required: true,
                    maxlength: 50
                },
                password: {
                    required: true,
                    minlength: 5
                },
                cpassword: {
                    required: true,
                    minlength: 5,
                    equalTo : "#password"
                },
                address: {
                    required: true,
                    maxlength: 255
                },
                contact: {
                    required: true,
                    maxlength: 255
                }   

            }
        });


 // Validate the landing  Page Signup Model form
        $("#Login_form_Model").validate({
            rules: {
                
                User_Email: {
                    required: true,
                    maxlength: 255
                },
                User_password: {
                    required: true,
                    maxlength: 50
                }

            }
        });


         // Validate the landing  Page Contact  form
        $("#Send_Email_user").validate({
            rules: {
                
                Customer_email: {
                    required: true,
                    maxlength: 50
                },
                Subject: {
                    required: true,
                    maxlength: 50
                },
                textarea_Des: {
                    required: true,
                    maxlength: 255
                }

            }
        });