
// validate the Prescription_form form
		$("#prescription_form").validate({
			rules: {
				
				prescription_Picture_name: {
					required: true
					
				},
				shippinaddress: {
					required: true,
					maxlength: 255
				}
				
			}
		});
		
// validate the Category Edit  Model form
		$("#Edit_Category_form").validate({
			rules: {
				
				Edit_Category_Name: {
					required: true,
					maxlength: 255
				},
				Edit_Category_Description: {
					required: true,
					maxlength: 255
				}
				
			}
		});		
		
		
		
		// validate the Online_invoice_form form
		$("#Online_invoice_form").validate({
			rules: {
				
				prescription_image: {
					required: true
				}
				
			}
		});
		
		
		// Validate the Send_Email_user form
		$("#send_email_user").validate({
			rules: {
				
				subject: {
					required: true,
					maxlength: 255
				},
				email_desc: {
					required: true,
					maxlength: 255
				}
				
			}
		});
		
		// Validate the User_Profile form
		$("#User_Profile_form").validate({
			rules: {
				user_name: {
					required: true,
					maxlength: 255
				},
				contact1: {
					required: true,
					maxlength: 15,
					minlength: 11
				}
				
			}
		});
		
		
		
		// Validate the User Password Model form
		$("#change_password_Model_User").validate({
			rules: {
				
				old_password: {
					required: true,
					maxlength: 255
				},
				new_password: {
					required: true,
					minlength: 5
				},
				confirm_password: {
					required: true,
					minlength: 5,
					equalTo : "#new_password"
				}	

			}
		});


			// Validate the User Picture Model form
		$("#Picture_Model_User").validate({
			rules: {
				
				customer_picture: {
					required: true,
					maxlength: 255
				}
			}
		});
		
			// Validate the Forget_form_Model form
		$("#Forget_form_Model_User").validate({
			rules: {
				
				User_Email: {
					required: true,
					maxlength: 255
				},
				New_Password: {
					required: true,
					minlength: 5
				},
				Confirm_Password: {
					required: true,
					minlength: 5,
					equalTo : "#New_Password"
				}	

			}
		});
		
		// Validate the Forgetpassword_form 
		$("#Forgetpassword_form_user").validate({
			rules: {
				
				User_Email: {
					required: true,
					maxlength: 255
				},
				User_password: {
					required: true,
					minlength: 5
				},
				User_code: {
					required: true
				}	

			}
		});
		
		
		
function printDivrr(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}