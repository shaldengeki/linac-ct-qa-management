function calAvg(x,y,z,avg){
	
	//alert("Call Nothing");
	//alert(q1+q2+q3+average);
	//alert(x+y+z);
	var a=document.getElementsByName(x)[0].value;
	var b=document.getElementsByName(y)[0].value;
	var c=document.getElementsByName(z)[0].value;
	a=parseFloat(a);
	b=parseFloat(b);
	c=parseFloat(c);
	var t=(a+b+c)/3;
	//alert("test");
	document.getElementsByName(avg)[0].value=t;
}

function calM(avg,des){

	//alert(document.getElementsByName(avg)[0].value);
	var a=document.getElementsByName(avg)[0].value;
	a=parseFloat(a);
	//alert(a);
	var tpcf=document.getElementsByName('tpcf')[0].value;
	var m=a*tpcf*1.010*0.995;
	document.getElementsByName(des)[0].value=m;

}

function calMeasured(avg,avg1,avg2,des){


	var x=document.getElementsByName(avg)[0].value;
	var y=document.getElementsByName(avg1)[0].value;
	var z=document.getElementsByName(avg2)[0].value;
	
	x=parseFloat(x);
	var result=0.000;
	if(isNaN(y)){
	
		z=parseFloat(z);
		result=x/z;
	}
	else{
		
		y=parseFloat(y);
		result=x/y;
	
	}
	//alert("the result of measured is "+ result);
	document.getElementsByName(des)[0].value=result;
}

function calMeasuredFinal(avg1,avg2,des){

	var x=document.getElementsByName(avg1)[0].value;
	var y=document.getElementsByName(avg2)[0].value;
	x=parseFloat(x);
	y=parseFloat(y);
	var result=x/y;
	document.getElementsByName(des)[0].value=result;
	
}


function calM6(avg,des){


var a=document.getElementsByName(avg)[0].value;
a=parseFloat(a);
var tpcf=document.getElementsByName('tpcf')[0].value;
var m=a*tpcf*1.001*0.995;
document.getElementsByName(des)[0].value=m;

}


function calM18(avg,des){


var a=document.getElementsByName(avg)[0].value;
a=parseFloat(a);
var tpcf=document.getElementsByName('tpcf')[0].value;
var m=a*tpcf*1.004*0.995;
document.getElementsByName(des)[0].value=m;

}

function calMc(des){

	var aArray=new Array(20.5,20.8,21.0,21.6,21.8);
	var bArray=new Array(20.0,20.3,20.4,21.0,21.2);
	var chamber=document.getElementsByName('chamber')[0].value;
	var electrometer=document.getElementsByName('electrometer')[0].value;
	var str1=chamber.substring(14,17);
	var str2=electrometer.substring(15,18);
	//alert(des.substring(2,4));
	
	var index=parseInt(des.substring(2,4));
	index=(index-1)%5;
	//alert(index);
	//alert(str1+str2);
	var mc=-9999;
	if(str1=="944")
	{
		if(str2=="614")
			mc=aArray[index]/10;
		else
			mc=aArray[index];
	
	}
	else{
		if(str1=="269")
		{
			if(str2=="614")
			{
				mc=bArray[index]/10;
			}
			else{
				mc=bArray[index];
			}
		}
		else{
		
			mc=0;
		}

	}
	document.getElementsByName(des)[0].value=mc;
}


function calDw1(m,des,dwa){
	
	var x=document.getElementsByName(m)[0].value;
	x=parseFloat(x);
	var electrometer=document.getElementsByName('electrometer')[0].value;
	var str1=electrometer.substring(15,18);
	var m1=0.000;
	if(str1=="614"){
		m1=x*0.991*5.180/10
	}
	else{
		m1=x*0.991*5.180/100
	}
	
	document.getElementsByName(des)[0].value=m1;
	document.getElementsByName(dwa)[0].value=0.85;
}


function calDw2(m,des,dwa){
	
	var x=document.getElementsByName(m)[0].value;
	x=parseFloat(x);
	var electrometer=document.getElementsByName('electrometer')[0].value;
	var str1=electrometer.substring(15,18);
	var measured=0.000;
	if(str1=="614"){
		measured=x*0.965*5.180/10
	}
	else{
		measured=x*0.965*5.180/100
	}
	
	document.getElementsByName(des)[0].value=measured;
	document.getElementsByName(dwa)[0].value=0.9;
}

function calDif(m,mc,des){


  var a=document.getElementsByName(m)[0].value;
  a=parseFloat(a);

  var b=document.getElementsByName(mc)[0].value;
  b=parseFloat(b);

	if(a==0){
	
		document.getElementsByName(des)[0].value="NULL";
	
	}
	else{
		var dif=((a-b)/b)*100;
		document.getElementsByName(des)[0].value=dif;
	}

}







function mpdd(avg,avg1,avg2,des){

	var x=document.getElementsByName(avg)[0].value;
	var y=document.getElementsByName(avg1)[0].value;
	var z=document.getElementsByName(avg2)[0].value;
	
	x=parseFloat(x);
	var result=0.000;
	if(isNaN(y)){
	
		z=parseFloat(z);
		result=x/z;
	}
	else{
		
		y=parseFloat(y);
		result=x/y;
	
	}
	
	document.getElementsByName(des)[0].value=result;

}




function rpdd(){


	var array=new Array(0.840,0.863,0.913,0.853,0.862);
	var i=21;

	for(i=21;i<26;i++)
	{
		document.getElementsByName("rpdd"+i)[0].value=array[(i-1)%5];
	}

}
	
function finalCal(){
calTPCF();
calAvg('q1_1','q2_1','q3_1','avg1');
calAvg('q1_2','q2_2','q3_2','avg2');
calAvg('aq1_1','aq2_1','aq3_1','avg3');
calAvg('aq1_2','aq2_2','aq3_2','avg4');
calAvg('bq1_1','bq2_1','bq3_1','avg5');
calAvg('bq1_2','bq2_2','bq3_2','avg6');
calAvg('gating_q1','gating_q2','gating_q3','avg7');
calAvg('edw_q1_1','edw_q2_1','edw_q3_1','avg8');
calAvg('edw_q1_2','edw_q2_2','edw_q3_2','avg9');
calAvg('a_q1_1','a_q2_1','a_q3_1','avg11');
calAvg('a_q1_2','a_q2_2','a_q3_2','avg12');
calAvg('a_q1_3','a_q2_3','a_q3_3','avg13');
calAvg('a_q1_4','a_q2_4','a_q3_4','avg14');
calAvg('a_q1_5','a_q2_5','a_q3_5','avg15');
calAvg('b_q1_1','b_q2_1','b_q3_1','avg16');
calAvg('b_q1_2','b_q2_2','b_q3_2','avg17');
calAvg('b_q1_3','b_q2_3','b_q3_3','avg18');
calAvg('b_q1_4','b_q2_4','b_q3_4','avg19');
calAvg('b_q1_5','b_q2_5','b_q3_5','avg20');
calAvg('c_q1_1','c_q2_1','c_q3_1','avg21');
calAvg('c_q1_2','c_q2_2','c_q3_2','avg22');
calAvg('c_q1_3','c_q2_3','c_q3_3','avg23');
calAvg('c_q1_4','c_q2_4','c_q3_4','avg24');
calAvg('c_q1_5','c_q2_5','c_q3_5','avg25');

calM6('avg1','m1');
calM18('avg2','m2');
calM6('avg3','m3');
calM18('avg4','m4');


calDw1('m1','dw1','dwa1');
calDw2('m2','dw2','dwa2');
calDw1('m3','dw3','dwa3');
calDw2('m4','dw4','dwa4');

calDif('dw1','dwa1','dif1');
calDif('dw2','dwa2','dif2');
calDif('dw3','dwa3','dif3');
calDif('dw4','dwa4','dif4');

calMeasured('avg5','avg3','avg1','measured5');
calMeasured('avg6','avg4','avg2','measured6');

calDif('measured5','reference5','dif5');
calDif('measured5','reference5','dif6');

document.getElementsByName("measured7")[0].value=document.getElementsByName("avg7")[0].value;
calDif('measured7','reference7','dif7');

calMeasuredFinal('avg8','avg5','measured8');
calMeasuredFinal('avg9','avg6','measured9');

calDif('measured8','reference8','dif8');
calDif('measured9','reference9','dif9');

calMc('mc11');
calMc('mc12');
calMc('mc13');
calMc('mc14');
calMc('mc15');
calMc('mc16');
calMc('mc17');
calMc('mc18');
calMc('mc19');
calMc('mc20');


calM('avg11','m11');
calM('avg12','m12');
calM('avg13','m13');
calM('avg14','m14');
calM('avg15','m15');
calM('avg16','m16');
calM('avg17','m17');
calM('avg18','m18');
calM('avg19','m19');
calM('avg20','m20');

calDif('m11','mc11','dif11');
calDif('m12','mc12','dif12');
calDif('m13','mc13','dif13');
calDif('m14','mc14','dif14');
calDif('m15','mc15','dif15');
calDif('m16','mc16','dif16');
calDif('m17','mc17','dif17');
calDif('m18','mc18','dif18');
calDif('m19','mc19','dif19');
calDif('m20','mc20','dif20');


mpdd('avg21','avg16','avg11','mpdd21');
mpdd('avg22','avg17','avg12','mpdd22');
mpdd('avg23','avg18','avg13','mpdd23');
mpdd('avg24','avg19','avg14','mpdd24');
mpdd('avg25','avg20','avg15','mpdd25');


}