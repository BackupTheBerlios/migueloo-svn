
//Pop-it menu- By Dynamic Drive
//For full source code and more DHTML scripts, visit http://www.dynamicdrive.com
//This credit MUST stay intact for use

var linkset=new Array()
//SPECIFY MENU SETS AND THEIR LINKS. FOLLOW SYNTAX LAID OUT

//linkset[0]='<div class="menuitems"><a href="http://www.precios10.com">Ordenadores</a>'
//linkset[0]+='<a href="http://www.cambiabanners.com">Intercambio de banners</a>'
//linkset[0]+='<a href="http://www.iaupa.com">Recursos web</a></div>'

linkset='';

//linkset[1]='<div class="menuitems"><a href="http://msnbc.com">MSNBC</a></div>'
//linkset[1]+='<div class="menuitems"><a href="http://cnn.com">CNN</a></div>'
//linkset[1]+='<div class="menuitems"><a href="http://abcnews.com">ABC News</a></div>'
//linkset[1]+='<div class="menuitems"><a href="http://www.washingtonpost.com">Washington Post</a></div>'

////No need to edit beyond here

var ie4=document.all&&navigator.userAgent.indexOf("Opera")==-1
var ns6=document.getElementById&&!document.all
var ns4=document.layers

function cleanref()
{
	//Como tabla
	//linkset = '<div class="menuitems" style="overflow:visible"><table><tr>'
	//Por columnas
	//linkset = '<div class="menuitems" style="overflow:visible">'
	//linkset = '<div class="menuitems">'
	//Por filas
	//linkset = ''
	
	linkset='<table width="100%" border="0" cellspacing="1" cellpadding="0" class="mainInterfaceWidth"><tr>'
}

function addref(href, name, superior)
{
	//Por columnas	
	//linkset += '<a href="' + href + '" onmouseover="highlightmenu(event,' + "'on'," + superior + ')"' + 'onmouseout="highlightmenu(event,' + "'off'," + superior + ')">' + name + '</a>'
	linkset += '<td class="menuitems" align="center" onmouseover="highlightmenu(event,' + "'on'," + superior + ')"' + 'onmouseout="highlightmenu(event,' + "'off'," + superior + ')"><a href="' + href + '">' + name + '</a></td>'

	//Por filas
	//linkset += '<div class="menuitems" ><a href="' + href + '" onmouseover="highlightmenu(event,' + "'on'," + superior + ')"' + 'onmouseout="highlightmenu(event,' + "'off'," + superior + ')">' + name + '</a></div>'
	//Como tabla
	//linkset += '<td><a href="' + href + '" onmouseover="highlightmenu(event,' + "'on'," + superior + ')"' + 'onmouseout="highlightmenu(event,' + "'off'," + superior + ')">' + name + '</a></td>'
	// linkset += '<td><a href="' + href + '">' + name + '</a></td>'
}
	

function closeref()
{
	//Por filas
	//linkset += '</div>'
	//Como tabla
	//linkset += '</tr></table></div>'
	linkset += '</tr></table>'
}

function showmenu(e,which,superior){

if (!document.all&&!document.getElementById&&!document.layers)
return

clearhidemenu()

if (superior)
{
	menuobj=ie4? document.all.superior : ns6? document.getElementById("superior") : ns4? document.popmenu : ""
}
else
{
	menuobj=ie4? document.all.inferior : ns6? document.getElementById("inferior") : ns4? document.popmenu : ""
}
menuobj.thestyle=(ie4||ns6)? menuobj.style : menuobj

if (ie4||ns6)
{
//	for (i=0; i<texts.length;i++)
//	{
		//innerH +='<div class="menuitems"><a href="www.polar.es">' + texts[i] + '</a></div>'
		menuobj.innerHTML=which
//	}
//menuobj.innerHTML=which
}
else{
menuobj.document.write('<layer name=gui bgColor=#E6E6E6 width=165 onmouseover="clearhidemenu()" onmouseout="hidemenu()">'+which+'</layer>')
menuobj.document.close()
}

/*
menuobj.contentwidth=(ie4||ns6)? menuobj.offsetWidth : menuobj.document.gui.document.width
menuobj.contentheight=(ie4||ns6)? menuobj.offsetHeight : menuobj.document.gui.document.height
eventX=ie4? event.clientX : ns6? e.clientX : e.x
eventY=ie4? event.clientY : ns6? e.clientY : e.y


//Find out how close the mouse is to the corner of the window

var rightedge=ie4? document.body.clientWidth-eventX : window.innerWidth-eventX
var bottomedge=ie4? document.body.clientHeight-eventY : window.innerHeight-eventY

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<menuobj.contentwidth)
//move the horizontal position of the menu to the left by it's width
menuobj.thestyle.left=ie4? document.body.scrollLeft+eventX-menuobj.contentwidth : ns6? window.pageXOffset+eventX-menuobj.contentwidth : eventX-menuobj.contentwidth
else
//position the horizontal position of the menu where the mouse was clicked
menuobj.thestyle.left=ie4? document.body.scrollLeft+eventX : ns6? window.pageXOffset+eventX : eventX

//same concept with the vertical position
if (bottomedge<menuobj.contentheight)
menuobj.thestyle.top=ie4? document.body.scrollTop+eventY-menuobj.contentheight : ns6? window.pageYOffset+eventY-menuobj.contentheight : eventY-menuobj.contentheight
else
menuobj.thestyle.top=ie4? document.body.scrollTop+event.clientY : ns6? window.pageYOffset+eventY : eventY
*/
menuobj.thestyle.visibility="visible"
return false
}

function contains_ns6(a, b) {
//Determines if 1 element in contained in another- by Brainjar.com
while (b.parentNode)
if ((b = b.parentNode) == a)
return true;
return false;
}

function hidemenu(){
	if (window.menuobj)
		menuobj.thestyle.visibility=(ie4||ns6)? "hidden" : "hide"
}

function dynamichide(e){
if (ie4&&!menuobj.contains(e.toElement))
hidemenu()
else if (ns6&&e.currentTarget!= e.relatedTarget&& !contains_ns6(e.currentTarget, e.relatedTarget))
hidemenu()
}

function delayhidemenu(){
if (ie4||ns6||ns4)
delayhide=setTimeout("hidemenu()",200)
}

function clearhidemenu(){
if (window.delayhide)
clearTimeout(delayhide)
}

function highlightmenu(e,state,superior){
if (document.all)
source_el=event.srcElement
else if (document.getElementById)
source_el=e.target
if (source_el.className=="menuitems"){
source_el.id=(state=="on")? "mouseoverstyle" : ""
}
else{
if (superior==1)
{
	popupname="superior"
}
else
{
	popupname="inferior"
}
while(source_el.id!=popupname){
source_el=document.getElementById? source_el.parentNode : source_el.parentElement
if (source_el.className=="menuitems"){
source_el.id=(state=="on")? "mouseoverstyle" : ""
}
}
}
}

if (ie4||ns6)
document.onclick=hidemenu


