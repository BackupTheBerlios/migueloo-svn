var ventana;

function newWin (url,w,h,pX,pY)
{
	var str;
	
	str = "width="+ w + ",height=" + h  + ",left=" + pX  + ",top=" + pY 
        + ",menubar=0,toolbar=0,directories=0,location=0,status=0,scrollbars=1,resizable=0";
	
	ventana = window.open(url,'winpopup',str);
}

function verPropiedades(objeto) {
     var result = "Propiedades del objeto "+objeto;
     var i=1;
     for (curProperty in eval(objeto)) {  
       propr = objeto+curProperty;
       result += "\n      "+(i++)+". " +curProperty; 
     } 

    window.alert(result);
    
}

//verPropiedades(top);

function ponerIframe(url){
	//parent.ifrmdocumento.document.location.href=url;
	//document.getElementById('myFrame').location.href=url;
	document.frames['myFrame'].location=url;
}

function eliminarIframe(dato)
{
	document.getElementById('myFrame').innerHTML = "desapareció el iframe y los datos pasados desde el iframe son: "+dato;
}

function saltar()
{
var padre= window.parent
padre.document.getElementById('div_i').innerHTML = "Aquí coloco lo que quiera"
}