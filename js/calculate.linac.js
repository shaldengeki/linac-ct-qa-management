
function calAvg(x){
	
	//alert("Call Nothing");
	//alert(q1+q2+q3+average);
	alert(x);
	var a=document.getElementsByName(x)[0].value;
	var b=document.getElementsByName("q2_1")[0].value;
	var c=document.getElementsByName("q3_1")[0].value;
	a=parseFloat(a);
	b=parseFloat(b);
	c=parseFloat(c);
	var t=(a+b+c)/3;
	//alert();
	document.getElementsByName("avg1")[0].value=t;
}


function test(){
	
	alert("Just for test");	
	
}


function calTPCF(){
	
	var t=document.getElementsByName("temperature")[0].value;
	var p=document.getElementsByName("pressure")[0].value;
	t=parseFloat(t);
	p=parseFloat(p);
	var tpcf=(273.2+t)/(273.2+22.0)*760/p;
	document.getElementsByName("tpcf")[0].value=tpcf;
	//alert("TPCF IS"+tpcf);
	//document.write();
	
}


