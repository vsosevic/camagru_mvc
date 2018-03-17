window.onload = function() {

	[].forEach.call(document.getElementsByClassName('frame-img'), function(image, i, frameImages) {
		image.addEventListener("click", function() {
			resetAllOutlines();
			changeFrame(image.id);
			image.style.outline = "#000000 solid";
			document.getElementById('take-photo').removeAttribute('disabled');
		});
	});
    // Grab elements, create settings, etc.
	var video = document.getElementById('video');

	// Get access to the camera!
	if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
	    // Not adding `{ audio: true }` since we only want video now
	    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
	        video.src = window.URL.createObjectURL(stream);
	        video.play();
	        // document.getElementById('upload').style.display = 'inline';
	    });
	}

	// Elements for taking the snapshot
	var canvas = document.getElementById('canvas');
	var context = canvas.getContext('2d');
	var frame = document.getElementById('frame');
	var canvasUpload = document.getElementById('canvas-for-upload');
	var contextUpload = canvasUpload.getContext('2d');

    document.getElementById("take-photo").addEventListener("click", function() {
    	context.drawImage(video, 0, 0, 640, 480);
    	context.drawImage(canvasUpload, 0, 0, 640, 480);
        frame_canvas = convertImageToCanvas(frame);
        context.drawImage(frame_canvas, 0, 0, 640, 480);
        new_image = convertCanvasToImage(canvas);

        imageToServerAJAX();	    	
	});
	document.getElementById("upload").addEventListener("change", function(event) {
		video.remove();
		var output = new Image();
		output.src = URL.createObjectURL(event.target.files[0]);
		output.onload = function () {
			contextUpload.drawImage(output, 0, 0, 640, 480);
    	}
	});
	// document.getElementById("save").addEventListener("click", function() {
	// 	console.log("clicked");
	// 	new_image = convertCanvasToImage(canvas);
	// 	imageToServerAJAX();
	// });
}
function changeFrame(frame) {
	document.getElementById('frame').src="files/sources/" + frame + ".png";// Trigger photo take
}
// Converts image to canvas; returns new canvas element
function convertImageToCanvas(image) {
	var canvas = document.createElement("canvas");
	canvas.width = image.width;
	canvas.height = image.height;
	canvas.getContext("2d").drawImage(image, 0, 0);

	return canvas;
}
// Converts canvas to an image
function convertCanvasToImage(canvas) {
	var image = new Image();
	image.src = canvas.toDataURL("image/png");
	return image;
}
function resetAllOutlines() {
	[].forEach.call(document.getElementsByClassName('frame-img'), function(image, i, frameImages) {
		image.style.outline = 'none';
	});
}
function imageToServerAJAX() {
	var xmlhttp = new XMLHttpRequest();
    	var data;
    	xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            	var jsonResponse =  JSON.parse(this.responseText);
            	//creating div with a link to an image and link to a del btn
            	var divImageAndDel = document.createElement("div");
            	divImageAndDel.className = 'div-image-and-del';
            	//a link to an image
            	var savedImageLink = document.createElement("A");
            	savedImageLink.href = "gallery/image/" + jsonResponse.imageID;
            	var savedImage = document.createElement("img");
            	savedImage.src = jsonResponse.imagePath;
            	savedImage.className = 'user-images';
            	savedImageLink.appendChild(savedImage);
            	//link to a del btn
            	var deleteLink = document.createElement("A");
            	deleteLink.href = "image/delete/" + jsonResponse.imageID;
            	var deleteImage = document.createElement("img");
            	deleteImage.src = 'files/sources/del.png';
            	deleteImage.className = 'delete-image';
            	deleteLink.appendChild(deleteImage);
            	//adding all to a side section
            	var sideCamera = document.getElementById('side-camera');
            	divImageAndDel.appendChild(savedImageLink);
            	divImageAndDel.appendChild(deleteLink);
            	sideCamera.insertBefore(divImageAndDel, sideCamera.childNodes[0]);

            	//the same but on jQuery:

            	// $('.side-camera').prepend(
	            // 	$('<div>').attr('class', 'div-image-and-del').append(
	            // 		$('<a>').attr({href: "image-page.php?imageID=" + jsonResponse.imageID}).append(
		           //  		$('<img>').attr({src: jsonResponse.imagePath, class: "user-images"}))).append(
		           //  	$('<a>').attr({href: "delete.php?imageID=" + jsonResponse.imageID}).append(
		           //  		$('<img>').attr({src: "files/sources/del.png", class: "delete-image"})))
            	// );
            }
    	};
		new_image.onload = function() {
        	data = new FormData();
        	data.append('image', new_image.src);
	        xmlhttp.open("POST", "/save-image", true);
	        xmlhttp.send(data);
		}
}