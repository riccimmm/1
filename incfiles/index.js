function insert(unit)
{
	var id ='text';
	var object = document.getElementById(id);
	object.focus();                                
	var ss = object.scrollTop;
	sel1 = object.value.substr(0, object.selectionStart);
	sel2 = object.value.substr(object.selectionEnd);
	sel = object.value.substr(object.selectionStart, object.selectionEnd - object.selectionStart);                                              
	object.value = sel1 + sel + unit + sel2;
	object.selectionStart = sel1.length + unit.length;
	object.selectionEnd = object.selectionStart + sel.length;
	object.scrollTop = ss;                                             
	return false;
}

function show(e)
{
	var width = 520; height = 390;
	var wnd = window.open(e.href, '_blank', 'width='+width+', height='+height+',toolbar=no,menubar=no,scrollbars=no,status=no,resizable=yes');
	if (wnd) { wnd.moveTo((screen.width - width) / 2, (screen.height - height) / 3); wnd.focus(); }
	return false;
}