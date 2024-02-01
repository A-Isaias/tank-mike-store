$(function () {

	'use strict';

	// Switch Between Login & Signup
	$('.login-page h1 span').click(function () {

		$(this).addClass('selected').siblings().removeClass('selected');

		$('.login-page form').hide();

		$('.' + $(this).data('class')).fadeIn(100);

	});

	// Add Asterisk On Required Field
	$('input').each(function () {

		if ($(this).attr('required') === 'required') {

			$(this).after('<span class="asterisk">*</span>');

		}

	});

	// Confirmation Message On Button
	$('.confirm').click(function () {

		return confirm('Are You Sure?');

	});

	$('.live').keyup(function () {

		$($(this).data('class')).text($(this).val());

	});

});

document.addEventListener('DOMContentLoaded', function () {
	let formReset = document.querySelector('#search-reset');

	if (formReset )
	{
		formReset.addEventListener('click', function () {
			resetSearch(formReset);
	  });
	}
});

function resetSearch(_self)
{
	console.log(_self.dataset.href);
	window.location.href = _self.dataset.href;
}