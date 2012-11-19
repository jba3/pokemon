function setGame(){
//	alert('test');
	var frm = document.getElementById("frmSetGame");
	var sel = document.getElementById("selNewGame");

	if (sel.options[sel.selectedIndex].value == ""){
		return false;
	}else{
		frm.submit();
	}
}

function showRowByClass(className){
	if ($(className).length > 0){
		$(className).toggle();
	}else{
		alert('No other encounters for this pokemon');
	}
}
