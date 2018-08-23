$(document).ready(function(){
	$('#show').mousedown(function(){
		$('#contraseña').removeAttr('type');
		$('#show').addClass('fa-eye-slash').removeClass('fa-eye');
	});

	$('#show').mouseup(function(){
		$('#contraseña').attr('type','password');
		$('#show').addClass('fa-eye').removeClass('fa-eye-slash');
	});

	$('#show2').mousedown(function(){
		$('#rcontraseña').removeAttr('type');
		$('#show2').addClass('fa-eye-slash').removeClass('fa-eye');
	});

	$('#show2').mouseup(function(){
		$('#rcontraseña').attr('type','password');
		$('#show2').addClass('fa-eye').removeClass('fa-eye-slash');
	});
});