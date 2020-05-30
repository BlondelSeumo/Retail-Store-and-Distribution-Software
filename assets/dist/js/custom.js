
		function barcode_val(url = '')
		{
			var qty = prompt("How many barcodes you want to print ?", "30");

				if (qty == null || qty == "") {
				    
				} 
				else 
				{
				   window.location = url+'/'+qty;
				}
		}

		function confirmation_alert(message,url = '')
		{
			var result = confirm("Do you really want to "+message+" ?");

				if (result) 
				{
				     window.location = url;
				} 
		}

	// validate the Category Add  Model form
		$("#Category_form").validate({
			rules: {
				
				category_name: {
					required: true,
					maxlength: 255
				}
			}
		});
		
		// validate the Category edit  Model form
		$("#Edit_Category_form").validate({
			rules: {
				
				edit_category_name: {
					required: true,
					maxlength: 255
				}
			}
		});	

		// validate the Expense  Model form
		$("#add_expense_form").validate({
			rules: {
				
				bill_total: {
					required: true,
					minlength: 1
				},
				bill_paid: {
					required: true,
					minlength: 1
				},
				date: {
					required: true
				}
			}
		});		

		// validate the Expense  Model form
		$("#edit_expense_form").validate({
			rules: {
				
				bill_total: {
					required: true,
					minlength: 1
				},
				bill_paid: {
					required: true,
					minlength: 1
				},
				date: {
					required: true
				}
			}
		});		
		
		// validate the barcode  Add  Model form
		$("#barcode_form").validate({
			rules: {
				
				brand_name: {
					required: true,
					maxlength: 255
				}
			}
		});

		// validate the barcode  Add  Model form
		$("#edit_barcode").validate({
			rules: {
				brand_name: {
					required: true,
					maxlength: 255
				}
			}
		});		

		// validate the create purchase Model form
		$("#create_purchase_form").validate({
			rules: {
				pur_total: {
					required: true,
					maxlength: 255
				},
				pur_date: {
					required: true
				},
				pur_paid: {
					required: true,
					minlength: 1
				},
				pur_balance: {
					required: true,
					minlength: 1
				}
			}
		});


		// validate the create purchase Model form
		$("#create_supply_form").validate({
			rules: {
				cash_recieved: {
					required: true,
					minlength: 1
				}
			}
		});		


		// validate the create driver Model form
		$("#driver_form").validate({
			rules: {
			driver_name: {
				required: true,
				maxlength: 255
			},
			contact_no: {
				required: true,
				maxlength: 12
			}
			}
		});		

		// validate the create vehicle Model form
		$("#vehicle_form").validate({
			rules: {
			vehicle_name: {
				required: true,
				maxlength: 255
			},
			vehicle_no: {
				required: true,
				maxlength: 255
			}
			}
		});		


		// validate the create brand Model form
		$("#brand_form").validate({
			rules: {
				brand_name: {
					required: true,
					maxlength: 255
				}
			}
		});		


		// validate the create brand Model form
		$("#brand_sector_form").validate({
			rules: {
				brand_sector_name: 
				{
					required: true,
					maxlength: 255
				}
			}
		});		

		// validate the region Model form
		$("#region_form").validate({
			rules: {
				region: 
				{
					required: true,
					maxlength: 255
				}
			}
		});		

		// validate the region Model form
		$("#town_form").validate({
			rules: {
				town_name: 
				{
					required: true,
					maxlength: 255
				}
			}
		});		

		// validate the unit Model form
		$("#unit_form").validate({
			rules: {
				unit_name: 
				{
					required: true,
					maxlength: 255
				},
				symbol: 
				{
					required: true,
					maxlength: 255
				}
			}
		});		


		// validate the unit Model form
		$("#store_form").validate({
			rules: {
				name: 
				{
					required: true,
					maxlength: 255
				},
				code: 
				{
					required: true,
					maxlength: 255
				},
				address: 
				{
					required: true,
					maxlength: 255
				}
			}
		});		

		// validate the unit Model form
		$("#edit_store_form").validate({
			rules: {
				store_name: 
				{
					required: true,
					maxlength: 255
				},
				code: 
				{
					required: true,
					maxlength: 255
				},
				address: 
				{
					required: true,
					maxlength: 255
				}
			}
		});		

		// validate the unit Model form
		$("#open_balance_accounts").validate({
			rules: {
				amount: 
				{
					required: true,
					maxlength: 255
				},
				date: 
				{
					required: true,
					maxlength: 255
				},
				description: 
				{
					required: true,
					maxlength: 255
				}
			}
		});		

		// validate the unit Model form
		$("#journal_voucher").validate({
			rules: {
				description: 
				{
					required: true,
					maxlength: 255
				},
				date: 
				{
					required: true,
					maxlength: 255
				}
			}
		});

		// validate the head form
		$("#chart_of_accounts_form").validate({
			rules: {
				name: 
				{
					required: true,
					maxlength: 255
				}
			}
		});

		// validate the product add Model form
		$("#product_form").validate({
			rules: 
			{
				product_name: {
					required: true,
					maxlength: 255
				},
				formula_name: {
					required: true,
					maxlength: 255
				},
				product_mg: {
					required: true,
					maxlength: 4
				},
				quantity: {
					required: true,
					minlength: 1
				},
				purchase: {
					required: true,
					minlength: 1
				},
				retail: {
					required: true,
					minlength: 1
				},
				whole_sale: {
					required: true,
					minlength: 1
				}
				
			}
		});
		
		
		// Validate the product edit Model form
		$("#update_product_form").validate({
			rules: {
				
				edit_product_name: {
					required: true,
					maxlength: 255
				},
				edit_formula_name: {
					required: true,
					maxlength: 255
				},
				edit_mg: {
					required: true,
					maxlength: 4
				},
				edit_retail: {
					required: true,
					minlength: 1
				},	
				edit_purchase: {
					required: true,
					minlength: 1
				}
			}
		});
		
		
		
		// validate the Customer add Model form
		$("#Customer_form").validate({
			rules: {
				
				customer_name: {
					required: true,
					maxlength: 50
				},
				customer_email: {
					required: true,
					maxlength: 50
				}
			}
		});
		
		
		// Validate the Customer edit Model form
		$("#Edit_Customer_form").validate({
			rules: {
				
				edit_customer_name: {
					required: true,
					maxlength: 50
				},
				edit_customer_email: {
					required: true,
					maxlength: 50
				},
				edit_customer_address: {
					required: true,
					maxlength: 100
				},
				edit_customer_contatc1: {
					required: true,
					minlength: 11
				},
				edit_customer_company: {
					required: true,
					maxlength: 100
				},
				edit_customer_city: {
					required: true,
					maxlength: 100
				},
				edit_customer_country: {
					required: true,
					maxlength: 100
				},
				edit_customer_description: {
					required: true,
					maxlength: 255
				}
				
			}
		});	
		
		
		// Validate the user add Model form
		$("#User_form").validate({
			rules: {
				user_name: {
					required: true,
					maxlength: 50
				},
				user_email: {
					required: true,
					maxlength: 50
				},
				user_password: {
					required: true,
					minlength: 5
				},
				User_cpassword: {
					required: true,
					minlength: 5,
					equalTo : "#user_password"
				}
			}
		});
		
		// Validate the User edit Model form
		$("#Edit_User_form").validate({
			rules: {
				
				Edit_user_name: {
					required: true,
					maxlength: 50
				},
				Edit_user_email: {
					required: true,
					maxlength: 50
				}
			}
		});
		
		// Validate the TodoList add Model form
		$("#Todolist_form").validate({
			rules: {
				
				todolist_name: {
					required: true,
					maxlength: 50
				},
				Todolist_Date: {
					required: true,
					
				}
				
			}
		});
		
		// Validate the TodoList edit Model form
		$("#Edit_Todolist_form").validate({
			rules: {
				
				edit_todo_name: {
					required: true,
					maxlength: 50
				},
				edit_todolist_date: {
					required: true,
					
				}
				
			}
		});		

		// Validate the Supplier Model form
		$("#supplier_form").validate({
			rules: {
				customer_name: {
					required: true,
					maxlength: 50
				},
				customer_email: {
					required: true,
					
				}
				
			}
		});		

		//Validate Bank 
		$("#bank_form").validate({
			rules: {
				bankname: {
					required: true,
					maxlength: 50
				},
				branch: {
					required: true
				},
				branchcode: {
					required: true
				},
				title: {
					required: true
				},
				accountno: {
					required: true
				}
			}
		});	

		// Validate the Supplier payment Model form
		$("#supplier_payment").validate({
			rules: {
				amount: {
					required: true,
					minlength: 1
				},
				description: {
					required: true,
					maxlength: 255
				},
			}
		});		

		// Validate the Supplier payment Model form
		$("#customer_payment").validate({
			rules: {
				amount: {
					required: true,
					minlength: 1
				},
				description: {
					required: true,
					maxlength: 255
				},
			}
		});
		
		// Validate the PharmistList add Model form
		$("#Pharmacist_form").validate({
			rules: {
				
				pharmacist_name: {
					required: true,
					maxlength: 50
				},
				pharmacist_post: {
					required: true,
					maxlength: 100
				}
				
			}
		});
		
			// Validate the edit_PharmistList add Model form
		$("#Edit_Pharmacist_form").validate({
			rules: {
				
				edit_pharmacist_name: {
					required: true,
					maxlength: 50
				},
				edit_pharmacist_post: {
					required: true,
					maxlength: 100
					
				},
				edit_pharmacist_des: {
					required: true,
					maxlength: 100
				},
				edit_pharmacist_facebook: {
					required: true,
					maxlength: 100
				},
				edit_pharmacist_twitter: {
					required: true,
					maxlength: 100
					
				}
,				edit_pharmacist_linked: {
					required: true,
					maxlength: 100
				},
				edit_pharmacist_googleplus: {
					required: true,
					maxlength: 100
				}
				
			}
		});
		
		// Validate the Somewords Add Model form
		$("#SomewordsList_form").validate({
			rules: {
				
				somewords_title: {
					required: true,
					maxlength: 50
				},
				somewords_description: {
					required: true,
					maxlength: 255
				},
				somewords_icon: {
					required: true
					
				}
				
			}
		});
		
		// Validate the Somewords edit Model form
		$("#Edit_Somewords_form").validate({
			rules: {
				
				edit_somewords_title: {
					required: true,
					maxlength: 50
				},
				edit_somewords_des: {
					required: true,
					maxlength: 255
				},
				edit_somewords_icon: {
					required: true
					
				}
				
			}
		});
		
		// Validate the Service Add Model form
		$("#Service_form").validate({
			rules: {
				
				Service_Title: {
					required: true,
					maxlength: 50
				},
				Service_description: {
					required: true,
					maxlength: 255
				},
				Service_Icon: {
					required: true
					
				}
				
			}
		});

		// Validate the Service edit Model form
		$("#Edit_Service_form").validate({
			rules: {
				
				edit_service_title: {
					required: true,
					maxlength: 50
				},
				edit_service_des: {
					required: true,
					maxlength: 255
				},
				edit_service_icon: {
					required: true
					
				}
				
			}
		});
		

		
		// Validate the Testamonial Add Model form
		$("#Testamonial_form").validate({
			rules: {
				
				testamonial_name: {
					required: true,
					maxlength: 50
				},
				testamonial_description: {
					required: true,
					maxlength: 255
				},
				testamonial_picture: {
					required: true
					
				}
				
			}
		});
		
		// Validate the Testamonial edit Model form
		$("#Edit_Testamonial_form").validate({
			rules: {
				
				edit_testamonial_name: {
					required: true,
					maxlength: 50
				},
				edit_testamonial_des: {
					required: true,
					maxlength: 255
				}
				
			}
		});

		// Validate the Delivered Add  Model form
		$("#Deliverd_form").validate({
			rules: {
				
				delivered_to: {
					required: true,
					maxlength: 50
				},delivered_by: {
					required: true,
					maxlength: 50
				},
				delivered_date: {
					required: true
				},
				delivered_description: {
					required: true,
						maxlength: 255
					
				}
				
			}
		});
		
		// Validate the Logo Model form
		$("#logo_form").validate({
			rules: {
				
				
				company_logo: {
					required: true
				}
				
			}
		});
		
		// Validate the Banner Model form
		$("#banner_form").validate({
			rules: {
				
				
				company_thumbnail: {
					required: true
				}
				
			}
		});
		
		// Validate the Layout Form  
		$("#layout_form").validate({
			rules: {
				
				company_name: {
					required: true,
					maxlength: 100
				},
				company_description: {
					required: true,
					maxlength: 255
					
				},
				company_keywords: {
					required: true,
					maxlength: 255
				},
				company_currency: {
					required: true,
					maxlength: 5
				},
				company_language: {
					required: true,
					maxlength: 10
					
				},
				company_stock_limit: {
					required: true,
					minlength: 1
					
				},
				company_expire_time: {
					required: true,
					minlength: 1
					
				}
				
			}
		});
		
		// Validate the Website Form  
		$("#website_form").validate({
			rules: {
				
				front_title1: {
					required: true,
					maxlength: 100
				},
				front_title2: {
					required: true,
					maxlength: 100
					
				},
				front_title3: {
					required: true,
					maxlength: 100
				},
				front_title4: {
					required: true,
					maxlength: 100
				},
				front_title5: {
					required: true,
					maxlength: 100
					
				},
				front_title6: {
					required: true,
					maxlength: 100
					
				},
				front_sub_title1: {
					required: true,
					maxlength: 100
					
				},
				front_sub_title2: {
					required: true,
					maxlength: 100
					
				},
				front_title8: {
					required: true,
					maxlength: 100
					
				},
				front_title9: {
					required: true,
					maxlength: 100
					
				},
				front_title10: {
					required: true,
					maxlength: 100
					
				}
				
			}
		});
		
		// Validate the About Form  Model form
		$("#contact_form1").validate({
			rules: {
				
				contact_title: {
					required: true,
					maxlength: 100
				},
				contact_description: {
					required: true,
					maxlength: 255
					
				},
				phone_number: {
					required: true,
					maxlength: 15,
					minlength: 15
				},
				email_address: {
					required: true
				},
				facebook: {
					required: true,
					maxlength: 100
					
				},
				twitter: {
					required: true,
					maxlength: 100
					
				},
				linkedin: {
					required: true,
					maxlength: 100
					
				},
				googleplus: {
					required: true,
					maxlength: 100
					
				}
				
			}
		});
		
		// Validate the About Form  Model form
		$("#about_form1").validate({
			rules: {
				
				about_title: {
					required: true,
					maxlength: 255
				},
				about_quotation: {
					required: true,
					maxlength: 255
					
				},
				about_name: {
					required: true,
					maxlength: 255
		
				},
				about_title2: {
					required: true,
					maxlength: 255
				},
				about_description: {
					required: true,
					maxlength: 255
					
				},
				about_address: {
					required: true,
					maxlength: 255
					
				}
			}
		});

		// Validate the Admin Picture Model form
		$("#Picture_Model_admin").validate({
			rules: {
				
				customer_picture: {
					required: true,
					maxlength: 255
				}
			}
		});

	

		// Validate the Admin Password Model form
		$("#change_password_Model_Admin").validate({
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

		
		
		// Validate the Forget_form_Model form
		$("#Forget_form_Model").validate({
			rules: {
				
				user_email: {
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
					equalTo : "#New_Password"
				}	

			}
		});
		
		// Validate the Forgetpassword_form 
		$("#Forgetpassword_form").validate({
			rules: {
				
				user_email: {
					required: true,
					maxlength: 255
				},
				user_password: {
					required: true,
					minlength: 5
				},
				user_code: {
					required: true
				}	

			}
		});
		

	// Validate the Email  form
		$("#send_email").validate({
			rules: {
				
				subject: {
					required: true,
					maxlength: 50
				},
				email_desc: {
					required: true,
					maxlength: 255
					
				}
				
			}
		});	

		// Validate the Return item  form
		$("#Return_items_form").validate({
			rules: {
				
				quantity: {
					required: true
				},
				description: {
					required: true,
					maxlength: 255
					
				}
				
			}
		});

		// Validate the  Edit Return item  form
		$("#Edit_Return_items").validate({
			rules: {
				
				edit_quantity: {
					required: true
				},
				edit_description: {
					required: true,
					maxlength: 255
					
				}
				
			}
		});
		
		function printDiv(divName) {
			 var printContents = document.getElementById(divName).innerHTML;
			 var originalContents = document.body.innerHTML;

			 document.body.innerHTML = printContents;

			 window.print();

			 document.body.innerHTML = originalContents;
		}

		//NEW STOCK PRICES AND RETIALS
		function set_stock_charges()
		{
			retail 		 = $('#stock_item_id option:selected').attr('data-retail');
			purchase 	 = $('#stock_item_id option:selected').attr('data-purchase');
			packretail 	 = $('#stock_item_id option:selected').attr('data-packretail');
			packpurchase = $('#stock_item_id option:selected').attr('data-packpurchase');

			$('#cost').val(purchase);

			$('#retial').val(retail);
			
			$('#pack_retail').val(packretail);
			
			$('#pack_cost').val(packpurchase);
			
		} 