	$( document ).ready(function() {
	
			$("#btn_checkout").click(function() {
				    var isbnCO = $('#isbn_checkout').val();
				    var cardID = $('#card_id_checkout').val();
				    $.ajax({
				        type: "POST",
				        url: "LibCheckOut.php",
				        data: { isbnCO: isbnCO, cardID: cardID },				        
						success: function(data) {													            
				        	  $('#checkoutdiv').empty().append(data);
				        	   }				       
			 });
		 });
		 
		 $("#btn_checkin").click(function() {
				    var detailCI = $('#details_checkin').val();
				    $.ajax({
				        type: "POST",
				        url: "LibCheckin.php",
				        data: { detailCI: detailCI },			        
						success: function(data) {
							$('#checkindiv').empty().append(data);				                
				        	   }				       
			 });
		 });
		 
		 
		 $("#btn_cin").click(function() {
				    var isbnselected = $('#selectisbn').val();
				    $.ajax({
				        type: "POST",
				        url: "LibCheckin2.php",
				        data: { isbnselected: isbnselected },				        
						success: function(data) {													            
				        	  $('#checkindiv').empty().append(data);
				        	   }				       
			 });
		 });
		 
		  
		 $("#btn_search").click(function() {
				    var detailSearch = $('#details_search').val();
				    $.ajax({
				        type: "POST",
				        url: "LibSearch.php",
				        data: { detailSearch: detailSearch },				        
						success: function(data) {													            
				        	  $("#searchdiv").empty().append(data);
				        	   }				       
			 });
		 });
		 
		 
		 $("#btn_finec").click(function() {
				    var isbnfine = $('#isbn_fine').val();
				    var cardfine = $('#fine_card').val();
				    var option1 = $('#option').val();
				    $.ajax({
				        type: "POST",
				        url: "LibFines1.php",
				        data: { isbnfine: isbnfine, cardfine: cardfine, option1: option1 },				        
						success: function(data) {													            
				        	  $('#finediv').empty().append(data);
				        	   }			       
			 });
		 });
		  
		 $("#btn_fine2").click(function() {
				    var isbnselected1 = $('#selectisbnforfine').val();
				    var cardfine1 = $('#fine_card').val();
				    $.ajax({
				        type: "POST",
				        url: "LibFines2.php",
				        data: { isbnselected1: isbnselected1, cardfine1: cardfine1},				        
						success: function(data) {													            
				        	  $('#finediv').empty().append(data);
				        	   }				       
			 });
		 });
		 
		 $("#btn_borrow").click(function() {
				    var firname = $('#firstname').val();
				    var ssnn = $('#bssn').val();
				    var stad = $('#streetad').val();
				    var eid = $('#emailid').val();
				    var ph = $('#phoneno').val();
				    $.ajax({
				        type: "POST",
				        url: "LibBorrower.php",
				        data: { firname: firname, eid: eid, ssnn: ssnn, stad: stad, ph: ph},				        
						success: function(data) {													            
				        	  $('#borrowdiv').empty().append(data);
				        	   }				       
			 });
		 });
	});