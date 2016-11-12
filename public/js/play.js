var idnum = 0;
var numRows = 2;

var drumObject = [] ;
var bassObject = [];
var recordingTime;

for (var i = 0; i < 1; i++)
{
	var drumRow = drumTable.insertRow(i);
	var bassRow = bassTable.insertRow(i);
	for (var j = 0; j < numRows; j++)
	{
		var cell = drumRow.insertCell(j);
		cell.addEventListener('click', drumHandle);
		cell.id = idnum;
		cell.setAttribute("class", "sound");

		cell = bassRow.insertCell(j);
		cell.addEventListener('click', bassHandle);
		cell.id = idnum + 2;
		cell.setAttribute("class", "sound");

		idnum++;
	}
}

var x = 0;
var timeFrame = 4800;
var rate = 100;

timer.setAttribute("max", 4800);
fun2();
setInterval(fun2, timeFrame);
setInterval(updateTime, rate);

var currentDrum = null;
var currentBass = null;

function drumHandle()
{
    // stopping a sound
	if((this.className).indexOf("drumFlash") != -1)
	{
		this.className = "sound";
		pauseit(this.id);
		currentDrum = null;
		drumObject[drumObject.length - 1].endTime = findTimeDifference();
	}
	else
	{
		this.className += " drumFlash";

		// update drum object
		drumObject.push({
			'track' : this.id,
			'startTime' : findTimeDifference()
		});

		if(currentDrum != null)
		{
			var old = document.getElementById(currentDrum);
			old.setAttribute("class", "sound");

			// find last occurrence in array of this track and set the endTime
			drumObject[findLastOccurence(drumObject, currentDrum)].endTime = findTimeDifference();

		}

		checkAndPlay(this.id, currentDrum);
		currentDrum = this.id;
	}
}

function bassHandle()
{
	if((this.className).indexOf("bassFlash")!=-1)
	{
		this.className = "sound";
		pauseit(this.id);
		currentBass = null;
		bassObject[bassObject.length - 1].endTime = findTimeDifference();
	}
	else
	{
		this.className += " bassFlash";

		// update bass object
		bassObject.push({
			'track' : this.id,
			'startTime' : findTimeDifference()
		});

		if(currentBass != null)
		{
			var old = document.getElementById(currentBass);
			old.setAttribute("class", "sound");

			// find last occurrence in array of this track and set the endTime
			bassObject[bassObject.length - 2].endTime = findTimeDifference();
		}
		checkAndPlay(this.id, currentBass);
		currentBass = this.id;
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

function findTimeDifference()
{
	var d = new Date();
	var diff = d - x;
	var something = (timeFrame - diff) / 1000;
	var actual = (d - recordingTime)/1000 + something;
	return actual;
}

function checkAndPlay(noteID,oldNote)
{
	var d = new Date();
	var diff = d - x;
	setTimeout(function() {
		play(noteID);
		if(oldNote != null)
		{
			pauseit(oldNote);
		}
	}, timeFrame - diff);
}

function startTimer()
{
	recordingTime = new Date();
	drumObject = [];
	bassObject = [];
}

function finishRecording()
{
	var finalObject = {};
	finalObject.drums = drumObject;
	finalObject.bass = bassObject;

	var jsonString = JSON.stringify(finalObject);
	
	return jsonString;
}

function findLastOccurence(trackArray, trackId)
{
	for (var i = trackArray.length - 1; i >= 0; i--)
	{
		if(trackId == trackArray[i].track)
		{
			return i;
		}
	}
	return -1;
}