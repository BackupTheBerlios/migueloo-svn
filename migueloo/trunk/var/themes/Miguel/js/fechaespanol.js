function damefecha()
{
	var hoy = new Date();
	var day = hoy.getDay();
	var month = hoy.getMonth();
	//var year = hoy.getYear();
	var ano = hoy.getFullYear(); //esto es porque en netscape daba problemas el de arriba
	var date = hoy.getDate();
	var dia,  mes, ano, actual;
	

	if(day == 0) dia="domingo"; if(day == 1) dia="lunes";	if(day == 2) dia="martes";
	if(day == 3) dia="miércoles"; if(day == 4) dia="jueves"; if(day == 5) dia = "viernes";
	if(day == 6) dia = "sábado";
	
	if(month == 0) mes = 'enero'; if(month == 1) mes = 'febrero';
	if(month == 2) mes = 'marzo'; if(month == 3) mes = 'abril';
	if(month == 4) mes = 'mayo'; if(month == 5) mes = 'junio';
	if(month == 6 ) mes = 'julio'; if(month == 7) mes = 'agosto';
	if(month == 8) mes = 'septiembre'; if(month == 9) mes = 'octubre';
	if(month == 10) mes = 'noviembre'; if(month == 11) mes = 'diciembre';
	//if(year <= 99) ano=1900 + year;
	//else ano=year;

	actual= dia + " "+ date + " de "+ mes + " de "+ ano;
	document.write(actual);
}