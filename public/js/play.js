var idnum=0;
	var numRows=2;

	for (var i = 0; i < 1; i++)
	{
		var drumRow = drumTable.insertRow(i);
		var bassRow = bassTable.insertRow(i);
		var leadRow = leadTable.insertRow(i);
		for (var j = 0; j<numRows; j++)
		{
			var cell=drumRow.insertCell(j);
			cell.addEventListener('click',drumHandle);
			cell.id=idnum;
			cell.setAttribute("class", "sound");

			cell=bassRow.insertCell(j);
			cell.addEventListener('click',bassHandle);
			cell.id=idnum+2;
			cell.setAttribute("class", "sound");

			cell=leadRow.insertCell(j);
			cell.addEventListener('click',leadHandle);
			cell.id=idnum+4;
			idnum++;
			cell.setAttribute("class", "sound");
		}
	}

	var x = 0;
	var timeFrame = 4800;
	var rate=100;
	timer.setAttribute("max",4800);
	fun2();
	setInterval(fun2,timeFrame);
	setInterval(updateTime,rate);
	var currentDrum=null;
	var currentBass=null;
	var currentLead=null;
	function drumHandle()
	{

		if((this.className).indexOf("drumFlash")!=-1)
		{
			console.log("removed");
			this.className=this.className.replace(/drumFlash/,'');
			pauseit(this.id);
			currentDrum=null;
		}
		else
		{
			console.log("added");
			this.className+=" drumFlash";
			if(currentDrum!=null)
			{
				console.log("Stopping already playing drums");
				var old = document.getElementById(currentDrum);
				old.setAttribute("class","");
			}
			checkAndPlay(this.id,currentDrum);
			currentDrum=this.id;

		}
	}

	function bassHandle()
	{
		if((this.className).indexOf("bassFlash")!=-1)
		{
			console.log("removed");
			this.className=this.className.replace(/bassFlash/,'');
			pauseit(this.id);
			currentBass=null;
		}
		else
		{
			console.log("added");
			this.className+=" bassFlash";
			if(currentBass!=null)
			{
				console.log("Stopping already playing bass");
				var old = document.getElementById(currentBass);
				old.setAttribute("class","");
			}

			checkAndPlay(this.id,currentBass);
			currentBass=this.id;

		}
	}
	function leadHandle()
	{
		if((this.className).indexOf("leadFlash")!=-1)
		{
			console.log("removed");
			this.className=this.className.replace(/leadFlash/,'');
		// pauseit(this.id);
		currentLead=null;
		}
		else
		{
			console.log("added");
			this.className+=" leadFlash";
			if(currentLead!=null)
			{
				console.log("Stopping already playing sound");
				var old = document.getElementById(currentLead);
				old.setAttribute("class","");
			}

			// checkAndPlay(this.id,currentLead);
			currentLead=this.id;
		}
	}
	function fun2()
	{
		x = new Date();
		timer.value=0;

	}
	function updateTime()
	{
		timer.value+=100;
	}

	function checkAndPlay(noteID,oldNote)
	{
		var d = new Date();
		var diff = d-x;
		console.log((timeFrame-diff)/1000);
		setTimeout(function(){play(noteID); if(oldNote!=null){pauseit(oldNote);}},timeFrame-diff);
		// play(noteID);
	}