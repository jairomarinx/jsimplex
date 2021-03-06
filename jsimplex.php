<div class="col-md-12">
	<div class="row">
		<h1>JSimplex: Programa para Resolver problemas de Programación Lineal</h1>
	</div>
	<div class="row">
		<p>Esta página le permite resolver problemas de Programación Lineal usando el método Simplex. Para los problemas que tengan variables artificiales se usará el método de la gran M, y para los problemas que involucren variables enteras se usará el método de ramificar y acotar (branch and bound). <br><br> 
		</p>
	</div>
	<div class="row">
		<form action="" method="post" class="elegant-aero">
		    <label id="h1form">Problema Lineal </label><br>
		    <p><b>Objetivo</b>:&nbsp;&nbsp;&nbsp; Maximizar&nbsp;
			<input id="idoptmaximizar" type="radio" value="V1" checked name="objetivo">&nbsp;&nbsp;&nbsp;&nbsp; 
			Minimizar:&nbsp;&nbsp;&nbsp; <input i="idoptminimizar" type="radio" name="objetivo" value="V2"></p>
		    
		    <label>
		        N&uacute;mero de variables:
		            <input id="idnovariables" type="text" name="txtnovariables" size="2">        
		    </label>
		     
		    <label>
		        N&uacute;mero de Restricciones:
		            <input id="idnorestricciones" type="text" name="txtnorestricciones" size="2">        
		    </label>
		        <br>     
		        <div align="center"><button type="button" class="button" value="Preparar" onclick="preparar()" /><i class="fa fa-cog"></i>   Preparar</button> </div> 
		    </label>    
		</form>
		<br>
		<br>
		<div id="idgridproblema">    
		</div>
		<div id="jmodelo">    
		</div>
		<div id="jsolucion">    
		</div>
		<script type="text/javascript" src="<?php echo base_url()?>js/jsimplex.js"></script>
<script type="text/javascript">
      function preparar()
      {
          var novariables= document.getElementById("idnovariables").value;
          var norestricciones = document.getElementById("idnorestricciones").value;
          var objetivo;
          var s;
          var i,j,k;
          s="";
          
          if (novariables < 2)
          {
              alert("Se requiere como m�nimo dos variables");
              document.getElementById("idnovariables").focus();
              return 0;
          }
          
          if (norestricciones < 1)
          {
              alert("Se requiere como m�nimo una restricci�n");
              document.getElementById("idnorestricciones").focus();
              return 0;
          }
          
          if (document.getElementById("idoptmaximizar").checked == true)
          {
              objetivo=1;
          }
          else
          {
              objetivo=0;
          }    
           s=s+"Introduzca los coeficientes del problema:<br>";       
          s= s+"<table bordercolor='#FFFFFF'>";
          s= s+"<tr>";
          s= s+"<td></td>";
          for (i=1; i<=novariables; i++)
            {
                s= s+"<td class='jcell'>X<sub>"+i+"</sub></td>";
            }
          s= s+"<td></td>";
          s= s+"<td></td>";
          s= s+"</tr>"; 
          
          s= s+"<tr>"; 
          if (objetivo==1)
          {
              s= s+"<td class='jcell'>Max Z = </td>";
          }else
          {
              s= s+"<td class='jcell'>Min Z = </td>";          
          }
          for(j=1; j<=novariables; j++)
          {
              s= s+ "<td><input type='text name='txtx'" +  j + " size='5' onkeypress='return solonumeros(event)' onblur='jmodelo()' maxlength='6' id='txtx" + j + "'  ></td> ";			
          }  
          s= s+"<td></td>";
          s= s+"<td></td>";        
          s= s+"</tr>"; 
          
          for (i=1; i<=norestricciones; i++)
          {
              s= s+"<tr>";
              s= s+"<td class='jcell'> Restricci&oacute;n "+i+" </td>";
              for (j=1; j<=novariables; j++)
                {
                    s= s+"<td><input type='text name='txtr"+i+"x"+j+"' id='txtr"+i+"x"+j+"'  size='5' onkeypress='return solonumeros(event)' onblur='jmodelo()' maxlength='6'  ></td>";
                }
              s= s + "<td> <select size='1' name='cmbr"+i+"' id='cmbr"+i+"'><option selected value='<=''><=</option><option value='>='> >= </option><option value='='> = </option></select></td>";
              s= s + "<td> <input type='text name='txtrhs"+i+"' size='5' onkeypress='return solonumeros(event)' onblur='jmodelo()' maxlength='6' id='txtrhs"+i+"'  ></td>";          
              s= s+"</tr>";
          }       

          
          s= s+"</table>";
          document.getElementById("idgridproblema").innerHTML= s;          
      }
      
function jmodelo()
{
var novariables;
var norestricciones;
var objetivo;
var i; var j;
var aux;
var s;




novariables = document.getElementById("idnovariables").value;
norestricciones = document.getElementById("idnorestricciones").value;	
if (document.getElementById("idoptmaximizar").checked==true)
{
    objetivo = "Max ";
}else
{
    objetivo = "Min     ";
}    

s="<br><font face='Verdana' size='2' color='#000000'>";
s= s + "<table>";
s= s + "<tr>";
s= s + "<td><B>"+objetivo+" Z = </B></td>";

for (i=1; i<= novariables; i++)
	{
	aux = document.getElementById("txtx"+i).value;	
	if (aux!=0)
		{
		if (aux>0)
			{
			if (i==1)
				{
				s= s + "<td>"+(aux==1?"":aux)+"<font color='#0000FF'>X</font><sub>"+i+"</sub></td>";
				}
				else
				{
				s= s + "<td>+" +( aux==1?"":aux) +"<font color='#0000FF'>X</font><sub>"+i+"</sub></td>";
				}			
			}
		else
			{
			s= s + "<td>"+ aux +"<font color='#0000FF'>X</font><sub>"+i+"</sub></td>";
			}
		}
	}
	s= s +"</tr>";
        s= s +"<tr>";
        s= s +"<td>Sujeto a:</td>";
	s= s+"<td></td>";
        for (j=1; j<=novariables+2;j++)
        {
            s= s +"<td></td>";
        }        
        s= s +"</tr>";
	for (j=1; j<=norestricciones; j++)
		{
                s= s +"<tr>";
                s= s +"<td></td>";
		for (i=1; i<=novariables; i++)
			{
			aux = document.getElementById("txtr"+j+"x"+i).value;	
			if (aux!=0)
				{
				if (aux>0)
					{
						if (i==1 )
							{
                                                        if (aux !=1)
                                                            { 
                                                            s= s + "<td>"+aux + "<font color='#0000FF'>X</font><sub>"+i+"</sub></td>";
                                                            }else
                                                            {
                                                            s= s + "<td><font color='#0000FF'>X</font><sub>"+i+"</sub></td>";
                                                            }    
							}
							else
							{
                                                        if (aux!= 1)
                                                            {
                                                            s= s + "<td>+" + aux +"<font color='#0000FF'>X</font><sub>"+i+"</sub></td>";
                                                            }else
                                                            {
                                                            s= s + "<td>+" + "<font color='#0000FF'>X</font><sub>"+i+"</sub></td>";    
                                                            }   
							
							}						
					}
				else
					{
						s= s + "<td>"+ aux +"<font color='#0000FF'>X</font><sub>"+i+"</sub></td>";
					}			
				}else
                                {
                                    s= s + "<td></td>";
                                }
			}
		aux = document.getElementById("cmbr"+j).value;		
		s= s + "<td>" + aux +"</td>" ;
		aux = document.getElementById("txtrhs"+j).value;		
		s= s + "<td>"+aux +"</td>";	
		s= s +"</tr>";
                }	
s= s + "</table>Xi>=0<br><br>Mostrar Iteraciones<input type='checkbox' name='chkiteraciones' checked  value='ON' id='chkiteraciones'><br>";
s= s + "<br>";
s= s+"<div><button  class='pure-button pure-button-primary' onclick='resolver()'><i class='fa fa-th'> </i> Resolver </button></div>";		
document.getElementById('jmodelo').innerHTML=s;
}
function resolver()
{
    var s;
    var n,m;
    var i,j,k;
    var objetivo;
    var generarreporte;
      
    //inicializar ls variables...
    n=0;
    m=0;
    i=0;
    j=0;
    k=0;    
    s="";
    objetivo=0;
    generarreporte=false;
           
    n= parseInt(document.getElementById("idnovariables").value);
    m= parseInt(document.getElementById("idnorestricciones").value);
    
    var a_problema = new Array(m+1);
    for (i=0; i<=m+1; i++)
    {
    a_problema[i] = new Array(n+2);
    }
    
    
    for (i=0; i<=m+1; i++)
        {
        for (j=0; j<=n+2; j++)
            {
            a_problema[i][j]= 0;
             }
        }
   
    //vamos a llenar el arreglo, con los valores digitadores por la persona en la matriz...
    //primero , los coeficientes en la funcion objetivo...
    
    for (i=1; i<=n; i++)
        {
            if (document.getElementById("txtx"+i).value=="")
            {
                a_problema[0][i]= 0;
            }else
            {
                a_problema[0][i]= parseFloat(document.getElementById("txtx"+i).value);
            }        
        }
        
        for (i=1; i<=m; i++)
        {
            for (j=1; j<=n; j++)
                    {
                        if (document.getElementById("txtr"+i+"x"+j).value=="")
                        {
                            a_problema[i][j]= 0;
                        }else
                        {
                            a_problema[i][j]= parseFloat(document.getElementById("txtr"+i+"x"+j).value);
                        }
                        
                    }
            a_problema[i][n+1]= document.getElementById("cmbr"+i).value;
            if (document.getElementById("txtrhs"+i).value=="")
            {
                a_problema[i][n+2]= 0;
            }else
            {
                a_problema[i][n+2]= parseFloat(document.getElementById("txtrhs"+i).value);    
            }   
            
         }
  
  /*
  s=s + "<br><Table border='1'>";
  for (i=0; i<=m; i++)
    {
         s=s + "<tr>";    
        for (j=0; j<=n+2; j++)
        {
             s=s + "<td>" +  a_problema[i][j] + "</td>";
        }
        s=s + "</tr>";   
    }
    s=s + "</table>";   
    */
        
    //inicializar...
    
    var p= new jsimplex("jsolucion");
    
    document.getElementById("jsolucion").innerHTML="";    
    if (document.getElementById("idoptmaximizar").checked==true)
    {
        p.maximizar=true;
    }else
    {
        p.maximizar=false;
    } 
    
    p.documentar = document.getElementById("chkiteraciones").checked;   
    
    p.novariables= n;
    p.norestricciones = m;
    p.problema = a_problema;
    //p.normalizar();    
    //p.calcularzeta();
    //i=p.quienentra();
    //j=p.quiensale(i);
    //p.documentarmatrix();
    //p.gauss(j,i);
    //p.calcularzeta();
    //i=p.quienentra();
    //j=p.quiensale(i);
    //p.documentarmatrix();
    //p.gauss(j,i); 
    //p.calcularzeta();
    // p.documentarmatrix();
    p.solucionar();
     
}      
</script>
  




	</div>
</div>