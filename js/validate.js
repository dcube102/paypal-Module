  jQuery(function() {
    jQuery( "#tabs" ).tabs();
  });

  jQuery(document).ready(function(){
	jQuery("#paypal-form").validate({
	  rules: {
	 	fname:{
	  		required: true,
	  		lettersonly: true
	  	},
	  	lname:{
	  		required: true,
	  		lettersonly: true
	  	},
	  	amount:{
		    required: true,
		    number:true
	  	},
	  	zip:{
	  		required: true,
	  		number: true
	  	},
	 	creditCardNumber: {
		    required: true,
		    number:true,
		    minlength: 16,
			maxlength: 16
	    },
	    cvv2Number: {
		    required: true,
		    number:true,
		    minlength: 3,
			maxlength: 3
	    }
	  },
	messages: {
		fname:{
			required: "Please Enter fname.",
			lettersonly: "Please Enter letters only"
		},
		fname:{
			required: "Please Enter fname.",
			lettersonly: "Please Enter letters only"
		},
		amount:{
			required: "Please Enter Amount.",
		    number:"Please enter correct amount"
		},
		zip:{
			required: "Please Enter fname.",
			lettersonly: "Please Enter letters only"
		},
		creditCardNumber: {
		    required: "Please Enter Credit Card Number.",
		    number: "Please enter Numeric value",
		    minlength: "Please enter Correct Number",
			maxlength: "Please enter Correct Number"
	    },
	    cvv2Number: {
		    required: "Please enter CVV Number.",
		    number: "Please enter Numeric value",
		    minlength: "Please enter Correct Number",
			maxlength: "Please enter Correct Number"
	    }
	  }
	});
});
