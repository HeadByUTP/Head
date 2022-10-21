$(document).ready(function(){

var actual,siguiente,anterior;

var izquierda,opacidad,escala;
var animacion;


$(document).on("click", ".next",function(){

	if(animacion)return false;
	animacion=true;

	var elmnt = document.getElementById("myDIV");
    // Obtiene el padre de cada elemento en el conjunto actual de elementos coincidentes, 
    // opcionalmente filtrado por un selector.
	actual=$(this).parent();

	siguiente= $(this).parent().next();
    //.eq Un número entero que indica la posición basada en 0 del elemento. 
    //
	$("#progressbar li").eq($("fieldset").index(siguiente)).addClass("active");
    //Mostrar
	siguiente.show();
    //Realiza una animación personalizada de un conjunto de propiedades CSS.
	actual.animate({opacity:0},{
		step:function(now){

			escala=1-(1-now)*.85;
			izquierda=(now*100)+"%";
			opacidad=1+now;
			location.href='#sigue';

			actual.css({
				'transform':'scale('+escala+')',
				'position':'relative'
			});
			siguiente.css({'left':izquierda,'opacity':opacidad});
		},
		duration:1000,
		complete:function(){
			actual.hide();
			animacion=false;
		},
        //Aplicar una ecuación de aceleración a una animación.
		easing:'easeInOutBack'
	});

});


$(document).on("click", ".previous",function(){

	if(animacion)return false;
	animacion=true;

	actual=$(this).parent();
	anterior= $(this).parent().prev();

	$("#progressbar li").eq($("fieldset").index(actual)).removeClass("active");

	anterior.show();
	actual.animate({opacity:0},{
		step:function(now,mx){

			escala=0.8 + (1-now)*0.2;
			izquierda=((1-now)*80)+"%";
			opacidad=1+now;
			location.href='#sigue';

			actual.css({
				'left':izquierda
			});
			anterior.css({'transform':'scale('+escala+')','opacity':opacidad});
		},
		duration:1000,
		complete:function(){
			actual.hide();
			animacion=false;
		},
		easing:'easeInOutBack'
	});

});

});


