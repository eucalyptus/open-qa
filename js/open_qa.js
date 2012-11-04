
//PHP INFINITI SCROLL from https://github.com/tournasdim/PHP-infinite-scrolling
$(document).ready(function() {
        
	$("div#reservoir").append( "<p id='last'></p>" );
	is_ok_to_check = 1;

	$(window).scroll(function() {
		if( is_ok_to_check == 0 ){
			return;
		}    		
		var distanceTop = $('#last').offset().top - $(window).height();	
		if($(window).scrollTop() > distanceTop){	
    			is_ok_to_check = 0;
			$('div#loadMore').show();
			
			$.ajax({
				dataType : "html" ,
				url: "open_qa-loadMore.php?lastIndex="+ $("div#testBlock:last").attr('title')  ,	
				success: function(html) {
					
					if(html){
						$("div#reservoir").append(html);
				//		console.log("Measure--------- " +distanceTop);
				//		console.log("Measure--------- " +$(window).scrollTop());
				//		console.log("Append html--------- " +$("div#testBlock:first").attr('title'));
				//		console.log("Append html--------- " +$("div#testBlock:last").attr('title'));
						$("#last").remove();
						$("div#reservoir").append( "<p id='last'></p>" );
						$('div#loadMore').hide();
						lastPostFunc($("div#testBlock:last").attr('title'));
						setTimeout(function() {
            						is_ok_to_check = 1;
        					}, 800 );
					}else{		
						$('div#loadMore').replaceWith("<center><h1 style='color:red'>You have reached the end of Internet.</h1></center>");
    					}
				}
			});
		}
	
		if( isMobile.any() ){
			$("#tree").hide();
			$("#myscreen").hide();
			$("#empty_field").hide();
		};
	});

	$('.top-menu').on('click', function(event){
		$('.top-menu').each(function(index) {
            		if(this.className.indexOf('active', 0) > -1){
                    		$("#"+this.id).removeClass("active");
                		return;
            		}
        	});
	
		if( this.id == "home"){
			if( $(window).width() >= 900 ) {
				$('div#tree').fadeIn(500).removeClass("hide").addClass("show");
			}
			printOnScreen("Welcome to Open QA");
		}else if( this.id == "about"){
			$('div#myscreen').hide();
			$('div#mycontact').hide();
			$('div#tree').fadeOut(500).addClass("hide");
			$('div#myabout').fadeIn(500).removeClass("hide").addClass("show");
		}else if( this.id == "contact"){
			if( $(window).width() >= 900 ) {
				$('div#tree').fadeIn(500).removeClass("hide").addClass("show");
			}
			$('div#myscreen').hide();
			$('div#myabout').hide();
			$('div#mycontact').fadeIn("slow").removeClass("hide").addClass("show");
		};

		$("#"+this.id).addClass("active");

	
		if( isMobile.any() ){
			$("#tree").hide();
			$("#myscreen").hide();
			$("#empty_field").hide();
		};
	});

	$(window).resize(function() {
		$('.top-menu').each(function(index) {
                        if(this.className.indexOf('active', 0) > -1){
                                $("#"+this.id).removeClass("active");
                                return;
                        }
                });
		$("#home").addClass("active");
		printOnScreen("Screen is being adjusted.");
		if( $(window).width() < 900 ) {
			$("#myscreen").hide();
			$("#empty_field").hide();
			$("#tree").hide();
		} else {
			$("#myscreen").show();
			$("#empty_field").show();
			$("#tree").show();
		}

		if( isMobile.any() ){
			$("#tree").hide();
			$("#myscreen").hide();
			$("#empty_field").hide();
		};
	});

	if( isMobile.any() ){
		$("#tree").hide();
		$("#myscreen").hide();
		$("#empty_field").hide();
	};
});


function lastPostFunc(this_date){
	if( $(window).width() >= 900 ) {
		$('div#tree').fadeIn(500).removeClass("hide").addClass("show");
	}
	$('div#myabout').hide();
	$('div#mycontact').hide();
	$('div#myscreen').show();
	document.getElementById("myscreen").innerHTML = "Displaying Additional Tests on "+this_date;
};


function printOnScreen(this_info){
        if( $(window).width() >= 900 ) {
                $('div#tree').fadeIn(500).removeClass("hide").addClass("show");
        }
	$('div#myabout').hide();
	$('div#mycontact').hide();
	$('div#myscreen').show();
//	$('div#myscreen').innerHTML = this_info;
	document.getElementById("myscreen").innerHTML = this_info;
};


var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }	
};
