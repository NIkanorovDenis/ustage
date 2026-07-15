window.JCCatalogStoreSKU = function(params)
{
	var i;

	if(!params)
		return;

	this.config = {
		'id' : params.ID,
		'showEmptyStore'	: params.SHOW_EMPTY_STORE,
		'useMinAmount'		: params.USE_MIN_AMOUNT,
		'minAmount'			: params.MIN_AMOUNT
	};

	this.messages = params.MESSAGES;
	this.sku = params.SKU;
	this.stores = params.STORES;
	this.obStores = {};

	for (i in this.stores) {
		this.obStores[this.stores[i]] = BX(this.config.id+"_"+this.stores[i]);
	}

	BX.addCustomEvent(window, "onCatalogStoreProductChange", BX.proxy(this.offerOnChange, this));
};

window.JCCatalogStoreSKU.prototype.getClassName = function(name)
{
	switch (name) {
		case 'ожидается':
			return 'c_store_amount__table_theme_ozhidaetsya';

		case 'отсутствует':
			return 'c_store_amount__table_theme_otsutstvuet';

		case 'мало':
			return 'c_store_amount__table_theme_malo';

		case 'достаточно':
			return 'c_store_amount__table_theme_dostatochno';
	}
};

window.JCCatalogStoreSKU.prototype.offerOnChange = function(id)
{
	var curSku = this.sku[id],
		k,
		message,
		table,
		parent;

	for (k in this.obStores)
	{
		message = (!!this.config.useMinAmount) ? this.getStringCount(0) : '0';

		BX.adjust(this.obStores[k], {html: message});

		if (!!curSku[k]) {
			message = (!!this.config.useMinAmount) ? this.getStringCount(curSku[k]) : curSku[k];
			BX.adjust(this.obStores[k],	{html: message});
		}

		parent = BX.findParent(this.obStores[k], {tagName: 'li'});

		if (!!this.config.showEmptyStore || curSku[k] > 0) {
			BX.show(parent);
		} else {
			BX.hide(parent);
		}

		table = BX.findParent(this.obStores[k], {
			className: 'c_store_amount__table',
		});

		BX.removeClass(table, 'c_store_amount__table_theme_ozhidaetsya');
		BX.removeClass(table, 'c_store_amount__table_theme_otsutstvuet');
		BX.removeClass(table, 'c_store_amount__table_theme_malo');
		BX.removeClass(table, 'c_store_amount__table_theme_dostatochno');

		BX.addClass(table, this.getClassName(message));
	}
};

window.JCCatalogStoreSKU.prototype.getStringCount = function(num)
{
  if (num < 0)
    return 'ожидается';
  else if (num == 0)
		return this.messages['ABSENT'];
	else if (num >= this.config.minAmount)
		return this.messages['LOT_OF_GOOD'];
	else
		return this.messages['NOT_MUCH_GOOD'];
};
