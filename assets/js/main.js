var datePickerOptions = {
    format: 'dd MM yyyy',
    todayHighlight: true,
    autoclose: true,
    todayBtn: true
};

$('.datepicker').datepicker(datePickerOptions);

$('body').on('show.bs.modal', '.modal', function () {
	$('.modal').not($(this)).modal('hide');
});

$('body').on('hidden.bs.modal', '.modal', function () {
	$(this).find('form').trigger("reset")
	.end().find('option, input').removeClass('d-none text-primary text-danger');
});

$('body').on('change', '#js-trans-type', function(e) {
	changeAmountColor($(this));
});


// TODO: Need validations for future
$('body').on('submit', 'form.modal-content', function(e) {
	e.preventDefault();

	self = this;
	var url = this.getAttribute('action');

	$.ajax({
		type: 'POST',
		url: url,
		data: $(this).serializeArray(),
		
		beforeSend: function(data) {
			$(self).find('.loading').show();
		}
	}).done(function(data, textStatus, jqXHR) {
		window.location.reload(data);
	}).fail(function(jqXHR, textStatus) {
		//alert("error");
		window.location.reload(jqXHR.responseText);
	}).always(function(data) {
		$(self).find('.loading').hide();
	});
});


var transactionClone = $('.modal-transaction').clone();
$('.card-body').find('> .row').on('click', function() {
	var transID = $(this)[0].dataset.trans;
	var catID = $(this).find('#js-cat')[0].dataset.cat;
	var price = $(this).find('#js-price')[0].innerText.split(' ')[0];
	var note  = $(this).find('#js-note')[0].innerText;
	var date  = new Date(Number($(this)[0].dataset.date) * 1000);
	var walletID = $(this)[0].dataset.wallet;

	transactionClone.modal('show');
	transactionClone.find('.datepicker').datepicker(datePickerOptions);

var cloneForm = transactionClone.find('form').eq(0);
cloneForm.attr('action', cloneForm[0].dataset.editUrl);

	transactionClone.find('#js-trans-type option[value='+ catID +'], #js-trans-wallet option[value='+ walletID +']').prop('selected', true)
	.end().find('#js-trans-amount').val(price)
	.end().find('#js-trans-note').val(note)
	.end().find('#js-trans-id').val(transID)
	.end().find('#js-trans-date').datepicker('setDate', new Date(date.getFullYear(), date.getMonth(), date.getDate()))
	.end().find('.btn.btn-success').text('Edit');

	changeAmountColor(transactionClone.find('#js-trans-type'));
});


function changeAmountColor(elem) {
	var transType = Number(elem.find('option:selected')[0].dataset.transType);
	elem.find('option').first().addClass('d-none');

	var transClass = (transType) ? 'text-primary' : 'text-danger';
	elem.parents('.modal').eq(0).find('#js-trans-amount').removeClass('text-primary text-danger').addClass(transClass);
}