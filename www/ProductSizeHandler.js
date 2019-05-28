var ProductSizeHandler = function () {
	this.init = function () {
		var localCache = [];
		var _this = this;
		var boxWrapper;
		$('.product').mouseenter(function () {
			var product_element = $(this);
			boxWrapper = $('<span class="custome-wrapper-size"></span>');
			var allreadyInited = $(this).find('.custome-wrapper-size');
			if (allreadyInited.length) {
				allreadyInited.show();
			} else {
				var product = $(this).find('a').attr('href');
				product = product.replace("/", "");
				var product_key = product;
				if (typeof localCache[product_key] !== 'undefined') {
					boxWrapper.append(localCache[product_key]);
				} else {
					$.ajax({
						url: "http://brixton.amjid.eu?product=" + product,
						cache: true
					})
						.done(function (data) {
							console.log(data);
							try {
								data = JSON.parse(data);
							} catch (e) {

							}
							data.forEach(function (item) {
								boxWrapper.append(_this.createSpan(item));
							});
							localCache[product_key]  = boxWrapper;
							product_element.find('.flags.flags-default').append(boxWrapper);
						});
				}
			}
		})
			.mouseleave(function () {
				console.log("Mouste out now");
				$(this).find('.custome-wrapper-size').hide();
			});
	};
	this.createSpan = function (size) {
		return $('<span class="flag flag-action">' + size + '</span>');
	}
};

$(document).ready(function () {
	if ($('.product').length) {
		var productSizeHandler = new ProductSizeHandler();
		productSizeHandler.init();
	}
});
