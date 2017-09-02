const request = require("tinyreq");
const cheerio = require("cheerio");
const fs = require('fs');
var csvWriter = require('csv-write-stream')

var writer = csvWriter({sendHeaders: false});


// Set the name of the output file here
writer.pipe(fs.createWriteStream('vertientesData.csv'))

var provs = ['alm','cad','cor','gra','hul','jae','mal','sev','and','hus','ter','zar','ast','bal','lpa','scr','can','alb','ciu',
'cue','gua','tol','avi','bur','leo','pal','sal','seg','sor','vad','zam','bar','gir','lle','tar','ceu','ala','gip','biz','bad','cac',
'aco','lug','our','pon','rio','mad','mur','nav','por','ali','cas','val'];


var urls = [];
for (var a=0; a<provs.length; a++) {
	for (i=1; i <= 39; i++) {
		var no = String("0" + i).slice(-2);
		urls.push("http://retocima.webcindario.com/"+provs[a]+no+".htm");
	}
}

var eliminatedURLS = [
	"http://retocima.webcindario.com/gra20e.htm",
	"http://retocima.webcindario.com/ter10e.htm",
	"http://retocima.webcindario.com/can17e.htm",
	"http://retocima.webcindario.com/alb05e.htm",
	"http://retocima.webcindario.com/val06e.htm",
	"http://retocima.webcindario.com/mur06e.htm",
	"http://retocima.webcindario.com/mad02e.htm",
	"http://retocima.webcindario.com/zam02e.htm",
	"http://retocima.webcindario.com/bur10e.htm",
	"http://retocima.webcindario.com/leo06e.htm",
	"http://retocima.webcindario.com/ciudadreal.htm"
]


for (var c=0; c<urls.length; c++) {
	makeRequest(urls[c],c);
}

for (var x=0; x<eliminatedURLS.length; x++) {
	makeRequest(eliminatedURLS[x],x,true);
}



function makeRequest(url,urlnum,eliminated = false){

	request(url, function (err, body) {
		if (err) return;

	    let $ = cheerio.load(body);


	    // Get the cima and it's vertientes
	    var cima = $(".cima").eq(0).text().split(" ")[0];
	    if (eliminated) cima = cima + "e";
	    var vertientes = [];
	    var verts = $('.vertiente:contains("vertiente :")');
	    for (var i=0; i < verts.length; i++) {
	    	vertientes.push($(verts[i]).text().replace("vertiente :","").trim().replace(/\s+/g," "));
	    }

		// Get the GPS coordinates
	    var coords = {
	    	"longitude" : "",
		    "latitude" : "",
	    }
	    var gpsfoundin = $('td.reg12:contains("GPS:")')[0];
	    var gps = $(gpsfoundin).text().replace("GPS:","").trim().split(" ");
	    if (gps.length === 2) {
		    coords = {
		    	"longitude" : gps[0].trim().replace(",","."),
		    	"latitude" : gps[1].trim().replace(",","."),
		    }	
	    } 

	    // Get the info boxes inicio/final/dudas
	    var infos = [];
	    var indices = $('td.indicaciones').length;
	    for (var j=0; j<indices; j++) {
	    	if ($('td.indicaciones').eq(j).text().trim().length > 0) {
	    		var info = {}
	    		if ($('td.indicaciones').eq(j).text().trim().split(':')[1])
	    		info.inicio = $('td.indicaciones').eq(j).text().trim().split(':')[1].replace("INICIO","").replace("FINAL","").replace("DUDAS","").trim().replace(/\s+/g," ");
	    		if($('td.indicaciones').eq(j).text().trim().split(':')[2])
	    		info.dudas = $('td.indicaciones').eq(j).text().trim().split(':')[2].replace("INICIO","").replace("FINAL","").replace("DUDAS","").trim().replace(/\s+/g," ");
	    		if($('td.indicaciones').eq(j).text().trim().split(':')[3])
	    		info.final = $('td.indicaciones').eq(j).text().trim().split(':')[3].replace("INICIO","").replace("FINAL","").replace("DUDAS","").trim().replace(/\s+/g," ");
	    		infos.push(info);
	    	}
	    }

	    // Get the links. Cannot parse them into the correct vertiente
	    var links = $('a').length;
	    var enlaces = [];

	    for (var l=0; l<links; l++) {
	    	if($('a').eq(l).attr('href') && $('a').eq(l).attr('href').indexOf('http') !== -1) {
	    		if ($('a').eq(l).attr('href').indexOf('javascript') !== -1) {
	    			var regExp = /\'([^)]+)\'/;
					var matches = regExp.exec($('a').eq(l).attr('href'));
					enlaces.push(matches[1]);
	    		} else {
	    			enlaces.push($('a').eq(l).attr('href'));
	    		}
	    	} 
	    }

	    // Iframes cannot parse them into the correct vertiente
	    var iframe = $('iframe').length;
	    var iframes = [];
	    for (var f=0; f<iframe; f++) {
	    	iframes.push($('iframe').eq(f).attr('src'))
	    }


	    // Get the observations if any
	    observations = [];
	    var obvs = $('div.amarilloneg').length;
	    for (var o = 0; o <obvs; o++) {
	    	observations.push($('div.amarilloneg').eq(o).text().replace("Obs.:","").trim().replace(/\s+/g," "));
	    }
	    
	    // Write the vertientes csv
	    vertientes.forEach(function(vert,i){
	    	writer.write({
	    		cima: cima, 
	    		vert: i, 
	    		inicio: infos[i].inicio, 
	    		dudas: infos[i].dudas, 
	    		final: infos[i].final,
	    		observations: observations[i],
	    		longitude: coords.longitude,
	    		latitude: coords.latitude,
	    		iframe: iframes[i],
	    	});
	    	console.log("Completed Number " + urlnum);
	    })

	    // Write the cimas ltlng csv
    	/*writer.write({
    		cima: cima, 
    		vert: vertientes[0], 
    		longitude: coords.longitude,
    		latitude: coords.latitude,
    	});
    	console.log("Completed Number " + urlnum);*/

    	/*enlaces.forEach(function(enlace){
    		writer.write({
	    		cima: cima, 
	    		enlace: enlace,
	    	});
	    	console.log("Completed A link for cima " +urlnum);
    	});*/
	});
	

}
