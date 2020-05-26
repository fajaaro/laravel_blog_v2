var sr = new ScrollReveal();

function scrollRevealCardPost() {
	sr.reveal('.card-post', {
		// delay : 16,
		// interval : 16,
	});
}

sr.reveal('.btn-social-media', {
	delay : 150,
	interval : 100
});

scrollRevealCardPost();

$(document).ready(function() {
    $(window).on('load', function() {
        $('#loading').fadeOut(500);
    });

	$('.loading-gif').hide();

	$('.form-request-another-verif').on('submit', function(e) {
		e.preventDefault();

		$.ajax({
			url : '/email/resend',
			method : 'post',
			headers : {
				'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
			},
			// ketika sedang mengirim ajax request
			beforeSend : function() {
				$('.loading-gif').show();
			},
			success : function(response) {
				$('.fresh-verification').remove();

				let content = `
				  <div class="alert alert-success fresh-verification" role="alert">
				    A fresh verification link has been sent to your email address.
				  </div>
				`;

				$('.card-verif-email').prepend(content);
			},
			// ketika ajax reqeust selesai
			complete : function() {
				$('.loading-gif').hide();
			},
		});
	});

	// greeting text
	function getGreetingText() {
		let hours = new Date().getHours();

		if (hours >= 3 && hours <= 10) return ['Selamat Pagi', 'Good Morning', 'Bonjour', 'Buenos Días'];
		else if (hours >= 11 && hours <= 14) return ['Selamat Siang', 'Good Afternoon', 'Guten Tag', 'Buenas Tardes'];
		else if (hours >= 15 && hours <= 18) return ['Selamat Sore', 'Good Evening', 'Bona Tarda', 'Guten Abend'];
		else return ['Selamat Malam', 'Good Night', 'Gute Nacht', 'Buenas Noches'];
	}

	// array
	let greetingText = getGreetingText();

	$('.greet').text(`${greetingText[0]},`);
  
	let i = 1;
	setInterval(function() {
		$('.greet').css('display', 'none');

		$('.greet').text(`${greetingText[i]},`);
		$('.greet').fadeIn(1000);

		i++;

		if (i == 4) i = 0;
	}, 3000);

	// social media icon   
	$('.btn-social-media').on('mouseover', function() {
		$(this).css('background', 'none');
	});

	$('.btn-social-media').on('mouseleave', function() {
		$(this).css('background', '#fff');
	});

	$('.nav-logout').on('click', function(e) {
		e.preventDefault();

		$('.logout-form').submit();
	});

  	$('.nav-link-menu').on('click', function() {
  		$('.nav-link-menu').removeClass('active');
  		$(this).addClass('active');
  	});

  	if (window.location.href.indexOf('my-posts') > -1) {
  		$('.nav-link-menu').removeClass('active');
  		$('.my-posts-link').addClass('active');  		
  	}

  	$('.force-delete-button').on('click', function() {
  		swal({
			title: "Are you sure?",
			text: "Once deleted, you will not be able to recover this post!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
		    	swal("Your post has been deleted!", {
		      		icon: "success",
		    	});

		    	window.location.href = $(this).data('href');
		  	} else {
		    	swal("Your post is safe!");
		  	}
		});
  	});

  	$('.btn-delete').on('click', function() {
  		$(this).parent().parent().parent().parent().slideUp().html('');

  		$.ajaxSetup({
            headers: { 
            	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            }
        });

  		$.ajax({
  			url : `/post/${$(this).attr('id')}`,
  			method : 'DELETE',
  			dataType : 'json',
  			beforeSend : function() {
  				$('.loading-gif').show();
  			},
  			success : function(response) {
  				console.log(response);
  			},
  			complete : function() {
  				$('.loading-gif').hide();
  			}
  		});
  	});

  	$('.btn-restore').on('click', function() {
  		$(this).parent().parent().parent().slideUp().html('');

  		$.ajax({
  			url : `/post/${$(this).attr('id')}/restore`,
  			method : 'get',
  			beforeSend : function() {
  				$('.loading-gif').show();
  			},
  			success : function(response) {
  				console.log(response);
  			},
  			complete : function() {
  				$('.loading-gif').hide();
  			}
  		});
  	});

});