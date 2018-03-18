window.onload = function () {
	document.getElementById("like").addEventListener("click", function() {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
                var response = JSON.parse(this.responseText);

                if (!response.error) {
                    document.getElementById('number-of-likes').innerHTML=response.number_of_likes;

                    revert('like');
                    revert('unlike');
                }
			};
		};
		xmlhttp.open("GET", "/image/" + getRequestImageIdValue() + "/like", true);
		xmlhttp.send();

	});
	document.getElementById("unlike").addEventListener("click", function() {
		var xmlhttp1 = new XMLHttpRequest();
		xmlhttp1.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var response = JSON.parse(this.responseText);

                if (!response.error) {
                    document.getElementById('number-of-likes').innerHTML=response.number_of_likes;

                    revert('like');
                    revert('unlike');
                }
			};
		};
		xmlhttp1.open("GET", "/image/" + getRequestImageIdValue() + "/like", true);
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
}

function getRequestImageIdValue() {
    var arr = window.location.pathname.split("/");
    for (i = 0; i < arr.length; i++) {
        if (Number.isInteger( parseInt(arr[i]))) {
            return arr[i];
        }
    }
}
