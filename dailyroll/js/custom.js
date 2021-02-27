// JavaScript Document



	$(window).on('load', function() {
	
		"use strict";
						
		/*----------------------------------------------------*/
		/*	Preloader
		/*----------------------------------------------------*/
		
		$("#loader").delay(100).fadeOut();
		$("#loader-wrapper").delay(100).fadeOut("fast");
				
		$(window).stellar({});
		
	});



	$(window).on('scroll', function() {
		
		"use strict";
		
						
		/*----------------------------------------------------*/
		/*	Navigtion Menu Scroll
		/*----------------------------------------------------*/	
		
		var b = $(window).scrollTop();
		
		if( b > 72 ){		
			$(".navbar").addClass("scroll");
		} else {
			$(".navbar").removeClass("scroll");
		}
				

	});
	
	
	
	$(document).ready(function() {
		
		"use strict";
		

		/*----------------------------------------------------*/
		/*	Header Fixed on Top Transparent Bg
		/*----------------------------------------------------*/
			
		if ($('.navbar').hasClass('def-nav')) {
			$('.header').css("margin-bottom", 0 )
		}
		
		
		/*----------------------------------------------------*/
		/*	Header Fixed on Top Transparent Bg
		/*----------------------------------------------------*/
	
		if ($('.navbar').hasClass('no-bg')) {
			$('.hero-section').addClass('wide-hero')
		}
		
		
		/*----------------------------------------------------*/
		/*	Mobile Menu Toggle
		/*----------------------------------------------------*/
		
		$('.navbar-nav li.nav-link').on('click', function() {				
			$('#navigation-menu').css("height", "1px").removeClass("in").addClass("collapse");
			$('#navigation-menu').removeClass("open");				
		});

		
		/*----------------------------------------------------*/
		/*	OnScroll Animation
		/*----------------------------------------------------*/
		
		$('.animated').appear(function() {

	        var elem = $(this);
	        var animation = elem.data('animation');

	        if ( !elem.hasClass('visible') ) {
	        	var animationDelay = elem.data('animation-delay');
	            if ( animationDelay ) {
	                setTimeout(function(){
	                    elem.addClass( animation + " visible" );
	                }, animationDelay);

	            } else {
	                elem.addClass( animation + " visible" );
	            }
	        }
						
		});

		
		/*----------------------------------------------------*/
		/*	Animated Scroll To Anchor
		/*----------------------------------------------------*/
		
		$('.header a[href^="#"], .page a.btn[href^="#"], .page a.internal-link[href^="#"]').on('click', function (e) {
			
			e.preventDefault();

			var target = this.hash,
				$target = jQuery(target);

			$('html, body').stop().animate({
				'scrollTop': $target.offset().top - 60 // - 200px (nav-height)
			}, 'slow', 'easeInSine', function () {
				window.location.hash = '1' + target;
			});
			
		});
		
		
		/*----------------------------------------------------*/
		/*	ScrollUp
		/*----------------------------------------------------*/
		
		$.scrollUp = function (options) {

			// Defaults
			var defaults = {
				scrollName: 'scrollUp', // Element ID
				topDistance: 600, // Distance from top before showing element (px)
				topSpeed: 800, // Speed back to top (ms)
				animation: 'fade', // Fade, slide, none
				animationInSpeed: 200, // Animation in speed (ms)
				animationOutSpeed: 200, // Animation out speed (ms)
				scrollText: '', // Text for element
				scrollImg: false, // Set true to use image
				activeOverlay: false // Set CSS color to display scrollUp active point, e.g '#00FFFF'
			};

			var o = $.extend({}, defaults, options),
				scrollId = '#' + o.scrollName;

			// Create element
			$('<a/>', {
				id: o.scrollName,
				href: '#top',
				title: o.scrollText
			}).appendTo('body');
			
			// If not using an image display text
			if (!o.scrollImg) {
				$(scrollId).text(o.scrollText);
			}

			// Minium CSS to make the magic happen
			$(scrollId).css({'display':'none','position': 'fixed','z-index': '2147483647'});

			// Active point overlay
			if (o.activeOverlay) {
				$("body").append("<div id='"+ o.scrollName +"-active'></div>");
				$(scrollId+"-active").css({ 'position': 'absolute', 'top': o.topDistance+'px', 'width': '100%', 'border-top': '1px dotted '+o.activeOverlay, 'z-index': '2147483647' });
			}

			// Scroll function
			$(window).on('scroll', function(){	
				switch (o.animation) {
					case "fade":
						$( ($(window).scrollTop() > o.topDistance) ? $(scrollId).fadeIn(o.animationInSpeed) : $(scrollId).fadeOut(o.animationOutSpeed) );
						break;
					case "slide":
						$( ($(window).scrollTop() > o.topDistance) ? $(scrollId).slideDown(o.animationInSpeed) : $(scrollId).slideUp(o.animationOutSpeed) );
						break;
					default:
						$( ($(window).scrollTop() > o.topDistance) ? $(scrollId).show(0) : $(scrollId).hide(0) );
				}
			});

			// To the top
			$(scrollId).on('click', function(event){
				$('html, body').animate({scrollTop:0}, o.topSpeed);
				event.preventDefault();
			});

		};
		
		$.scrollUp();
		
		
		/*----------------------------------------------------*/
		/*	Video Background
		/*----------------------------------------------------*/
		
		$('.video-play').vide("images/video/video", {
			posterType: "jpg"
		});
		
		
		/*----------------------------------------------------*/
		/*	Video Link Lightbox
		/*----------------------------------------------------*/
		
		$('.video-popup').magnificPopup({
		    type: 'iframe',
		  	  
				iframe: {
					patterns: {
						youtube: {
			   
							index: 'youtube.com',
							src: 'https://www.youtube.com/embed/kuceVNBTJio'
				
								}
							}
						}		  		  
		});
		
				
		/*----------------------------------------------------*/
		/*	Brands Logo Rotator
		/*----------------------------------------------------*/
	
		var owl = $('.brands-logo-holder');
			owl.owlCarousel({
				items: 6,
				loop:true,
				autoplay:true,
				navBy: 1,
				autoplayTimeout: 4000,
				autoplayHoverPause: false,
				smartSpeed: 1500,
				responsive:{
					0:{
						items:2
					},
					479:{
						items:3
					},
					640:{
						items:3
					},
					767:{
						items:3
					},
					768:{
						items:4
					},
					991:{
						items:5
					},				
					1000:{
						items:5
					}
				}
		});
		
		
		/*----------------------------------------------------*/
		/*	Statistic Counter
		/*----------------------------------------------------*/
	
		$('.statistic-number').each(function () {
			$(this).appear(function() {
				$(this).prop('Counter',0).animate({
					Counter: $(this).text()
				}, {
					duration: 4000,
					easing: 'swing',
					step: function (now) {
						$(this).text(Math.ceil(now));
					}
				});
			},{accX: 0, accY: 0});
		});
		
		
		/*----------------------------------------------------*/
		/*	Testimonials Rotator OwlCarousel
		/*----------------------------------------------------*/
	
		var owl = $('.reviews-holder');
			owl.owlCarousel({
				items: 3,
				loop:true,
				autoplay:true,
				navBy: 1,
				autoplayTimeout: 4500,
				autoplayHoverPause: false,
				smartSpeed: 1500,
				responsive:{
					0:{
						items:1
					},
					479:{
						items:1
					},
					600:{
						items:1
					},
					767:{
						items:2
					},
					768:{
						items:2
					},
					991:{
						items:2
					},
					1000:{
						items:3
					}
				}
		});

		
		/*----------------------------------------------------*/
		/*	Testimonials Rotator Slick Carousel
		/*----------------------------------------------------*/
		
		$('#reviews-1 .center').slick({
			centerMode: true,
			autoplay: true,
			centerPadding: '0px',
			speed: 800,
			slidesToShow: 3,
			dots: true,
			responsive: [
				{
					breakpoint: 1199,
					settings: {
					arrows: false,
					centerMode: true,
					centerPadding: '0px',
					slidesToShow: 3
					}
				},
				{
					breakpoint: 991,
					settings: {
					arrows: false,
					centerMode: true,
					centerPadding: '0px',
					slidesToShow: 3
					}
				},
				{
					breakpoint: 800,
					settings: {
					arrows: false,
					centerMode: true,
					centerPadding: '0px',
					slidesToShow: 2
					}
				},
				{
					breakpoint: 648,
					settings: {
					arrows: false,
					centerMode: true,
					centerPadding: '0px',
					slidesToShow: 1
					}
				}
			]
		});


		/*----------------------------------------------------*/
		/*	Screens Carousel OwlCarousel
		/*----------------------------------------------------*/
	
		var owl = $('.screens_carousel');
			owl.owlCarousel({
				items: 4,
				loop:true,
				autoplay:true,
				navBy: 1,
				autoplayTimeout: 3500,
				autoplayHoverPause: false,
				smartSpeed: 1500,
				responsive:{
					0:{
						items:1
					},
					767:{
						items:2
					},
					768:{
						items:3
					},
					991:{
						items:3
					},
					1000:{
						items:4
					},
					1920:{
						items:6
					}
				}
		});


		/*----------------------------------------------------*/
		/*	Screens Carousel Slick
		/*----------------------------------------------------*/
		
		$('.screens-carousel').slick({
			infinite: true,
			autoplay: true,
			centerMode: true,
			dots: true,
			autoplaySpeed: 3500,
			speed: 800,
			slidesToShow: 5,
			slidesToScroll: 1,
			variableWidth: true,
			responsive: [
			    {
			      breakpoint: 769,
			      settings: {
			        slidesToShow: 3
			      }
			    },
			    {
			      breakpoint: 480,
			      settings: {
				    dots: false,
			        slidesToShow: 1,
			        variableWidth: false,
			        fade: true,
					cssEase: 'linear'
			      }
			    }
			]
		});



		/*----------------------------------------------------*/
		/*	Blog Posts Carousel OwlCarousel
		/*----------------------------------------------------*/
	
		var owl = $('.blog-posts-holder');
			owl.owlCarousel({
				items: 2,
				loop:true,
				autoplay:true,
				navBy: 1,
				autoplayTimeout: 4000,
				autoplayHoverPause: false,
				smartSpeed: 1500,
				responsive:{
					0:{
						items:1
					},
					767:{
						items:1
					},
					768:{
						items:2
					},
					991:{
						items:2
					}
				}
		});


		/*----------------------------------------------------*/
		/*	FAQs Form Validation
		/*----------------------------------------------------*/
		
		$(".faqs-form").validate({
			rules:{ 
					name:{
						required: true,
						minlength: 2,
						maxlength: 16,
					},
					email:{
						required: true,
						email: true,
					},
					message:{
						required: true,
						minlength: 2,
						}
					},
					messages:{
							name:{
								required: "Please enter no more than (1) characters"
							}, 
							email:{
								required: "We need your email address to contact you",
								email: "Your email address must be in the format of name@domain.com"
							}, 
							message:{
								required: "Please enter no more than (2) characters"
							},  
						}
		});	

			
			
		/*----------------------------------------------------*/
		/*	Contact Form Validation
		/*----------------------------------------------------*/
		
		$(".contact-form").validate({
			rules:{ 
					name:{
						required: true,
						minlength: 1,
						maxlength: 16,
					},
					email:{
						required: true,
						email: true,
					},
					subject:{
						required: true,
						minlength: 4,
						maxlength: 48,
					},		
					message:{
						required: true,
						minlength: 2,
						}
					},
					messages:{
							name:{
								required: "Please enter no more than (1) characters"
							}, 
							email:{
								required: "We need your email address to contact you",
								email: "Your email address must be in the format of name@domain.com"
							}, 
							message:{
								required: "Please enter no more than (2) characters"
							}, 
						}
		});	
		

		/*----------------------------------------------------*/
		/*	Newsletter Subscribe Form
		/*----------------------------------------------------*/
	
		$('.newsletter-form').ajaxChimp({
        language: 'cm',
        url: 'http://dsathemes.us3.list-manage.com/subscribe/post?u=af1a6c0b23340d7b339c085b4&id=344a494a6e'
            //http://xxx.xxx.list-manage.com/subscribe/post?u=xxx&id=xxx
		});


		$.ajaxChimp.translations.cm = {
			'submit': 'Submitting...',
			0: 'We have sent you a confirmation email',
			1: 'Please enter your email address',
			2: 'An email address must contain a single @',
			3: 'The domain portion of the email address is invalid (the portion after the @: )',
			4: 'The username portion of the email address is invalid (the portion before the @: )',
			5: 'This email address looks fake or invalid. Please enter a real email address'
		};
		
		
	});	