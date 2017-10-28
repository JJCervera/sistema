<link rel="stylesheet" type="text/css" href="EstiloActa.css">

<?php 


$action='Generar';
switch ($action)
{
    case 'Generar':
        // limpio todos los valores antes de guardarlos
        // por ls dudas venga algo raro
        $IdReasignacion=$_GET['Id_Reasignacion'];
	    break;
    default :
}

?>
<?php
// incluyo archivo configuracion conexion.php para reutilizar sus variables de configuración JJC
include ('conexion.php');

$link = mysqli_connect($hostname, $username, $password);
mysqli_select_db($link, $db);
$tildes = $link->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
$consulta = mysqli_query($link, "
	SELECT 
		A.Cue AS cue,
		A.Nombre_Establecimiento AS nEscuela,
		A.Domicilio as dEscuela,
		(SELECT Nombre FROM departamento AS B WHERE B.Id_Departamento=A.Id_Departamento) AS nDepartamento,
		(SELECT Nombre FROM localidades AS C WHERE C.Id_Localidad=A.Id_Localidad) AS nLocalidad,
		E.Apellido_Nombre AS nDire,
		E.Cuil AS direCuil  
	FROM dato_establecimiento AS A 
	  JOIN autoridades_escolares AS E ON (E.Cue=A.Cue AND E.Id_Cargo=1)"); 

$resultado= mysqli_fetch_array($consulta);
$cue = $resultado['cue'];
$nEscuela = $resultado['nEscuela'];
$dEscuela = $resultado['dEscuela'];
$nDepartamento = $resultado['nDepartamento'];
$nLocalidad = $resultado['nLocalidad'];
$nDire = $resultado['nDire'];
$direCuil = $resultado['direCuil'];


$consulta = mysqli_query($link, "
    SELECT 
	A.Id_Reasignacion,
	A.NroSerie as nSerie,
	A.Fecha_Reasignacion AS fecha,
	A.Nuevo_Titular as nAlumno,
	A.Dni_Nuevo_Tit as dniAlumno,
	B.Id_Modelo,
	B.Id_Marca,
	(SELECT Nombre FROM marca AS C WHERE C.Id_Marca=B.Id_Marca) AS nMarca,
	(SELECT Descripcion FROM modelo as D WHERE D.Id_Modelo=B.Id_Modelo) AS nModelo 
    FROM 
	reasignacion_equipo AS A 
      LEFT OUTER JOIN equipos AS B ON B.NroSerie=A.NroSerie 
    WHERE A.Id_Reasignacion=$IdReasignacion"); 

$resultado= mysqli_fetch_array($consulta);

//if ($resultado){
$nSerie = $resultado['nSerie'];
$fecha = $resultado['fecha'];
$nAlumno = $resultado['nAlumno'];
$dniAlumno = $resultado['dniAlumno'];
$nMarca = $resultado['nMarca'];
$nModelo = $resultado['nModelo'];

//armo mejor vista de fecha
$FReasi = strtotime($fecha);
switch ((date("m", $FReasi))) {
    case 1:
	$FechaMes = 'Enero';
	break;
    case 2:
	$FechaMes = 'Febrero';
	break;
    case 3:
	$FechaMes = 'Marzo';
	break;
    case 4:
	$FechaMes = 'Abril';
	break;
    case 5:
	$FechaMes = 'Mayo';
	break;
    case 6:
	$FechaMes = 'Junio';
	break;
    case 7:
	$FechaMes = 'Julio';
	break;
    case 8:
	$FechaMes = 'Agosto';
	break;
    case 9:
	$FechaMes = 'Septiembre';
	break;
    case 10:
	$FechaMes = 'Octubre';
	break;
    case 11:
	$FechaMes = 'Noviembre';
	break;
    case 12:
	$FechaMes = 'Diciembre';
	break;
    default:
	$FechaMes = '_______________';
}



//echo $Direccion = $resultado['Domicilio'];
//}else{
//echo "No hay Resultados";
//}
mysqli_free_result($consulta);
mysqli_close($link);
?>
<link href="EstiloActa.css" rel="stylesheet" type="text/css" />
<style type="text/css" media="print">
<!--
.Estilo1 {
	font-size: 20px;
	font-weight: bold;
}
.Estilo2 {font-size: 18}
.Estilo3 {font-size: 16px}
.Estilo4 {
	font-weight: bold;
	color: #0000CC;
	background-color: #CC99FF;
	border: thin solid #CCFF33;
	font-family: Arial, Helvetica, sans-serif;
	cursor: crosshair;
	filter: Light;
	display: none;
}
-->
</style>

<script type="text/javascript">
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>

<div id="muestra">
<p align="center" class="Estilo1">Acta de Reasignación del Programa</p>
<p align="center" class="Estilo1">Conectar Igualdad Misiones</p>
<p align="center" class="Estilo1">&nbsp;  </p>
<p class="estiloActa">En la Ciudad de <?php echo $nLocalidad?>, Departamento de <?php echo $nDepartamento?>, Provincia de Misiones, a los <?php echo date("d",$FReasi)?> días del mes de <?php echo $FechaMes?> de <?php echo date("Y",$FReasi)?>, reunidos en el establecimiento educativo <?php echo $nEscuela?>, a cargo de la autoridad educativa representada en este acto por el/la Sr/Sra: <?php echo $nDire?>, con n&uacute;mero de DNI/CUIL: <?php echo $direCuil?>, procede a entregar al alumno/a o docente <b><?php echo $nAlumno?></b>, con DNI/CUIL: <b><?php echo $dniAlumno?></b>, la netbook marca <?php echo $nMarca?>, modelo <?php echo $nModelo?>, con n&uacute;mero de serie: <b><?php echo $nSerie?></b>, en buen estado y funcionando, y este/a lo recibe en conformidad.<br/>
  No habiendo nada más que agregar, se cierra la presente acta, firmando en conformidad los que intervinieron en ella.
<span class="Estilo2"><br/>
<br/><br/>&nbsp;</span>

<center>
    <table width=100% border=0 cellspacing=50>
        <tr width=50% align=center>
	    <td>__________________</td>
	    <td rowspan>__________________</td>
	    <td>__________________</td>
        </tr>
        <tr width=50% align=center>
	    <td><c>Director/a</c></td>
	    <td rowspan>R.T.E.</td>
	    <td><c>Alumno/Docente</c></td>
        </tr>
    </table>
</center> 
<div>
</div>
<p align="center" class="estiloActa Estilo3">
  <input name="IMPRIMIR EL ACTA" type="button" class="Estilo4"  onclick="printDiv('muestra')"
value="Imprimir"/>
  &nbsp;
  <input name="button" type="button" class="Estilo4" onclick="history.back(-1)" value="Volver" />
</div>
</p>
</div>
