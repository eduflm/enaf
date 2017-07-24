function expandeMenu() {
	if (document.getElementById('menu-topo').style.height == "35vh") {
		document.getElementById('menu-topo').style.height = "15vh";
		document.getElementById('botoes').style.visibility = "hidden";
		document.getElementById('botoes').style.opacity = "0";
	}else{
		document.getElementById('menu-topo').style.height = "35vh";
		document.getElementById('botoes').style.visibility = "visible";
		document.getElementById('botoes').style.opacity = "1";
	}
	

}