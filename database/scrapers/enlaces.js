const request = require("tinyreq");
const cheerio = require("cheerio");
const fs = require('fs');
var csvWriter = require('csv-write-stream')

var writer = csvWriter({sendHeaders: false});


// Set the name of the output file here
writer.pipe(fs.createWriteStream('enlaces.csv'))

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
	    	vertientes.push([i,$(verts[i]).text().replace("vertiente :","").trim().replace(/\s+/g," ")]);
	    }




	    // Get the links. Cannot parse them into the correct vertiente
	    var links = $('a').length;
	    var enlaces = [];

	    for (var l=0; l<links; l++) {
	    	if($('a').eq(l).attr('href') && $('a').eq(l).attr('href').indexOf('http') !== -1) {
	    		if ($('a').eq(l).attr('href').indexOf('javascript') !== -1) {
	    			var regExp = /\'([^)]+)\'/;
					var matches = regExp.exec($('a').eq(l).attr('href'));
					var link = matches[1];
					var vert = $('a').eq(l).parent().parent().parent().parent().parent().parent().parent().parent().parent().children().eq(0).text().replace("vertiente :","").trim().replace(/\s+/g," ");
	    			enlaces.push([link,vert]);
	    		} else {
	    			var link = $('a').eq(l).attr('href');
	    			var vert = $('a').eq(l).parent().parent().parent().parent().parent().parent().parent().parent().parent().children().eq(0).text().replace("vertiente :","").trim().replace(/\s+/g," ");
	    			enlaces.push([link,vert]);
	    		}
	    	} 
	    }




    	enlaces.forEach(function(enlace){
    		
    		var index;
    		for (var j=0; j<vertientes.length; j++) {
    			if(vertientes[j][1] == enlace[1]) {
    				index = vertientes[j][0];


		    		writer.write({
			    		cima: cima, 
			    		vertienteIndex: index + 1,
			    		enlace: enlace[0],
			    	});
			    	console.log("Completed A link for cima " +urlnum);
    			}
    		}


    		
    	});
	});
	

}
