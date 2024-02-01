document.addEventListener('DOMContentLoaded', function () {
	let formReset = document.querySelector('#search-reset');
	formReset.addEventListener('click', function () {
		resetSearch(formReset);
  });
});

function resetSearch(_self)
{
	console.log(_self.dataset.href);
	window.location.href = _self.dataset.href;
}