(function ($) {
	'use strict';
	$(document).ready(function () {
		$("#add_fee").click(function (e) {
			e.preventDefault();
			var numFields = $('.fieldset').length;
			$("#fee_fields tbody:last").append(`
				<tr class="fieldset">
					<td>
						<fieldset>
							<input type="text" name="woo-additional-checkout-fees[fields][additional-fee-${numFields+1}][]" value="Additional Fee" class="all-options" />
							<span class="description">Fee Description</span>
						</fieldset>
					</td>
					<td>
						<fieldset>
							<input type="number" name="woo-additional-checkout-fees[fields][additional-fee-${numFields+1}][]" value="10" class="all-options" />
							<span class="description">Fee Price</span>
						</fieldset>
					</td>
					<td>
						<a class="button-secondary button-small delete_fee_option" href="#" title="Delete Fee Option">Delete Fee Option</a>
					</td>
				</tr>
			`);
		});
		$('#fee_fields').on('click', '.delete_fee_option', function (e) {
			e.preventDefault();
			$(this).parent().parent().remove();
		});
	});
})(jQuery);