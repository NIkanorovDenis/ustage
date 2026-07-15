window.onload = () => {

	let tables = document.getElementsByClassName('table'),
    length = tables.length,
    i, wrapper;

	for (i = 0; i < length; i++) {
	    wrapper = document.createElement('div');
	    wrapper.setAttribute('class', 'big-table');
	    tables[i].parentNode.insertBefore(wrapper, tables[i]);
	    wrapper.appendChild(tables[i]);
	}
}