window.onscroll = function() {
	comButton = document.querySelectorAll(".test");
	var posY = window.pageYOffset,
		winSize = window.innerHeight,
		pageSize = document.documentElement.scrollHeight,
		imgs = document.querySelectorAll('.image'),
		lastImg = imgs[imgs.length - 1];
	if (posY + winSize > pageSize - 50)
	{
		var xhr = new XMLHttpRequest(),
			imgPath = lastImg.src.split("/");

		xhr.open('POST', url() + 'Usergallery/infiniteScroll', true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send('img_path=' + "public/copies/" + imgPath[imgPath.length - 1]);

		xhr.onload = function()
		{
			if (xhr.readyState === xhr.DONE)
			{
				if (xhr.status === 200 || xhr.status === 0)
				{
					var string = xhr.responseText.substring(0, xhr.responseText.indexOf("|")),
						json,
						container = document.getElementById('gallery_container'),
						br = document.createElement("br"),
						com_div = document.createElement("div"),
						imgDiv = document.querySelector(".img-thumbnail"),
						cloneDiv = imgDiv.cloneNode(true),
						i = 0;
					if (!string || string.indexOf('null') === 0 || string.indexOf('<!DOCTYPE') === 0)
						return ;
					json = JSON.parse(string);
					cloneDiv.removeChild(cloneDiv.lastChild);

					if (json.image_path)
					{
						//Create div
						cloneDiv.childNodes[1].innerHTML = json.owner;
						cloneDiv.childNodes[2].firstChild.src = '../' + json.image_path;
						if (json.liked === 'yes')
							cloneDiv.childNodes[3].src = '../public/resources/colored_heart.png';
						else
							cloneDiv.childNodes[3].src = '../public/resources/empty_heart.png';
						cloneDiv.childNodes[3].id = json.image_path;
						cloneDiv.childNodes[5].innerHTML = json.countLikes + ' like' + (json.countLikes > 1 ? 's' : '');
						com_div.className = "com_container";
						while (json.comments[i])
						{
							com_div.appendChild(document.createElement('p'));
							com_div.childNodes[i].innerHTML = '<b>' + json.comments[i].login + ': </b>' + ' ' + json.comments[i].img_comment;
							i++;
						}

						//Add event listener
						if (document.addEventListener)
						{
							if (typeof cloneDiv.childNodes[7] !== 'undefined') {
								cloneDiv.childNodes[7].addEventListener("click", comment);
								cloneDiv.childNodes[7].params = [xhr, cloneDiv.childNodes[2].firstChild, cloneDiv.childNodes[7]];
							}
							cloneDiv.childNodes[5].addEventListener("click", getUser);
							cloneDiv.childNodes[5].params = [xhr, cloneDiv.childNodes[3]];
							cloneDiv.childNodes[3].addEventListener("click", function() {
								if (this.src.indexOf("empty") !== -1) {
									like(this, xhr);
								} else {
									unlike(this, xhr);
								}
							});
						}
						//Put div on page
						cloneDiv.appendChild(com_div);
						container.appendChild(cloneDiv);
						container.appendChild(br);
					}
				}
			}
		}
	}
};