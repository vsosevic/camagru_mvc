window.onload = function () {
	document.getElementById("like").addEventListener("click", function() {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById('number-of-likes').innerHTML=this.responseText;
				revert('like');
				revert('unlike');
			};
		};
		xmlhttp.open("GET", "like.php?imageID=" + getRequestValue("imageID") +"&like=1", true);
		xmlhttp.send();

	});
	document.getElementById("unlike").addEventListener("click", function() {
		var xmlhttp1 = new XMLHttpRequest();
		xmlhttp1.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById('number-of-likes').innerHTML=this.responseText;
				revert('like');
				revert('unlike');
			};
		};
		xmlhttp1.open("GET", "like.php?imageID=" + getRequestValue("imageID") +"&like=0", true);
		xmlhttp1.send();
	});
	function revert(id) {
		var x = document.getElementById(id);
		if (x.style.display === 'none') {
			x.style.display = 'inline';
		} else {
			x.style.display = 'none';
		}
	}
	// revert('unlike');
}

function getRequestValue(keyName) {
	var arr = window.location.search.replace("?", "").split("&"); 
	for (i = 0; i < arr.length; i++) {
		var key = arr[i].split("=")[0]; 
		var value = arr[i].split("=")[1]; 
		if (key == keyName) {
			return value;
		}
	}
}
