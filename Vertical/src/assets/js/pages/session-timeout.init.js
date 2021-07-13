/*
Template Name: Fonik - Responsive Bootstrap 4 Admin Dashboard
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Session Timeout
*/


$.sessionTimeout({
	keepAliveUrl: 'pages-blank.html',
	logoutButton:'Logout',
	logoutUrl: 'pages-login.html',
	redirUrl: 'pages-lock-screen.html',
	warnAfter: 3000,
	redirAfter: 30000,
	countdownMessage: 'Redirecting in {timer} seconds.'
});

