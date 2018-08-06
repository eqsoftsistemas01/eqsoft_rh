<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require('fpdf.php'); #LIBRERIA PROPIA DE FPDF
#CLASE FPDF
class Pdf_p extends FPDF
{
	var $codbar = NULL;
	#FUNCION CONTRUCTORA	
	function __construct($params, $orientation='L', $unit='mm', $size='media')
	{
		#CONTRUCTOR PADRE
		parent::__construct($orientation,$unit,$size);
		$this->encprof = $params['encprof'];
	//	$this->pieprof = $params['pieprof'];
		
	}
	# FUNCION QUE GENERA ARREGLOS PARA LAS CELDAS DINAMICAS
	var $widths;
	var $aligns;

	function SetWidths($w){$this->widths=$w;} function SetAligns($a){$this->aligns=$a;}	
	
	#FUNCION ARREGLOS
	public function Row($data, $n, $b){
		$nb=0;
		for($i=0;$i<count($data); $i++){
			$nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		} 
		$h=4*$nb;
		$this->CheckPageBreak($h);
		for($i=0;$i<count($data);$i++){	
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			$x=$this->GetX(); $y=$this->GetY();
			$this->Rect($x,$y,$w,$h);
			$this->SetFont('Arial','',6);                           #FUENTE
	
			if($b[$i] == $i){
				$alineacion = "C";
			}else{
	            if($b[$i] == 'r'){
	               $alineacion = "R";
	            }else{
	               $alineacion = "J";
	            }
			}
	
			if($n[$i] == $i){
				$this->SetFillColor(196,196,196);               #COLOR DE LA CELDA
				$fill = TRUE;
			}else{
				$fill = FALSE;	
			}	
			$this->MultiCell($w,4,$data[$i],0,$alineacion,$fill);   #BORDE DE LA CELDA
			$this->SetXY($x+$w,$y);
		}
		$this->Ln($h);
	}
	
    #FUNCION SALDO DE PAGINA Y NUEVA PAGINA
	function CheckPageBreak($h){	
		if($this->GetY()+$h>
		$this->PageBreakTrigger){	
			$this->AddPage($this->CurOrientation,'Letter');
		}
	}
		
	function NbLines($w,$txt){
			$cw=&$this->CurrentFont['cw']; if($w==0){$w=$this->w-$this->rMargin-$this->x;}
			$wmax=($w-2*$this->cMargin)*1000/$this->FontSize; $s=str_replace("\r",'',$txt);
			$nb=strlen($s); if($nb>0 and $s[$nb-1]=="\n"){$nb--;} $sep=-1; $i=0; $j=0; $l=0; $nl=1;

			while($i<$nb)
			{	$c=$s[$i]; if($c=="\n"){$i++; $sep=-1; $j=$i; $l=0; $nl++; continue;} if($c==' '){$sep=$i;}$l+=$cw[$c];
				if($l>$wmax){if($sep==-1){if($i==$j){$i++;}}else{$i=$sep+1;}$sep=-1; $j=$i; $l=0; $nl++;}else{$i++;}
			}return $nl;
		}
#----------------------------------------------------------------------------------------------------------------------------------
	#FUNCION DE LA CABECERA		
	function Header(){
		$this->Image('public/img/quitoledbn.jpg',10,10,50,14);
        $this->Line(12,25,196,25);
        $this->SetFont('Arial','B',6);

        $this->text(80, 15, utf8_decode('AV. COLÓN OEE1-80 Y 10 DE AGOSTO'));
        $this->text(75, 18, utf8_decode('Telfs: 02 2565 354 - 0990 046 742 * Quito - Ecuador'));
        $this->text(89, 21, utf8_decode('quitoled@hotmail.com'));
        $this->text(92, 24, utf8_decode('www.quitoled.ec'));

        $this->Rect(165, 12, 30, 10, "D");
        $this->SetFont('Arial','B',12);        
        $this->text(167, 16, 'PROFORMA');
        $this->SetFont('Arial','B',9);
        $nroprof = $this->encprof->nro_proforma;
        $this->text(170, 21, utf8_decode('Nº '.$nroprof));

        $this->SetFont('Arial','B',6);        

		$cliente = $this->encprof->nom_cliente;
		$idcliente = $this->encprof->ident_cliente;
		$direccion = $this->encprof->direccion_cliente; 
		$telf = $this->encprof->telefonos_cliente;
		$fec = $this->encprof->fecha;
		$fecha = str_replace('-', '/', $fec); 
      	$fechaf = date("d/m/Y", strtotime($fecha));

		$this->SetFont('Arial','B',8);
		$this->ln(20); 
		$this->Cell(100,4,utf8_decode("Cliente: $cliente"),0,0,'L');
        $this->Cell(85,4,"Fecha: $fechaf",0,1,'R');
        $this->Cell(185,4,utf8_decode("Dirección: $direccion"),0,1,'L');
        $this->Cell(100,4,utf8_decode("Telefono: $telf"),0,1,'L');
           
        $this->ln(6); 

	}
#----------------------------------------------------------------------------------------------------------------------------------
	#FUNCION FIE DE PÁGINA
    function Footer(){
    	/*
    	$registro = $this->pieprof;
		$subtotaliva=0;
		$subtotalcero=0;
		$subtotaldiva=0;
		$subtotaldcero=0;
		$montoiva=0;
		$descuento=0;
		foreach ($registro as $row) {
			$strnombre = $row->pro_nombre;
			$strcant = $row->cantidad;
			if ($row->pro_grabaiva == 1){
				$subtotaliva+= $row->subtotal;
				$montoiva+= $row->montoiva;    
			}
			else{
				$subtotalcero+= $row->subtotal;
			}
    	}

    	$total = $subtotaliva + $subtotalcero + $montoiva;
		*/
	    $this->SetY(-0.1);
	    $this->SetFont('Arial','B',8);

        $this->text(12, 281, utf8_decode('MATRIZ QUITO'));
        $this->text(98, 290, utf8_decode('Quito - Ecuador'));
        $this->text(80, 287, utf8_decode('quitoled@hotmail.com - www.quitoled.ec'));
        $this->text(75, 284, utf8_decode('Telfs: 02 2565 354 - 0990 046 742 * Quito - Ecuador'));        
        $this->text(80, 281, utf8_decode('AV. COLÓN OEE1-80 Y 10 DE AGOSTO'));

	    $this->Line(12,278,196,278);
	    $this->SetFont('Arial','B',10);
	    $this->Ln(-30);
/*
	    $this->Line(12,269,60,269);
        $this->text(22, 273, utf8_decode('Firma Autorizada'));

        $this->text(12, 240, utf8_decode('NOTA:'));
		$this->text(12, 244, utf8_decode('La validez de la siguiente Proforma tiene 8 días'));
*/        
	    /*
	    $this->SetFont('Arial','B',10);
	    $this->Cell(160,-4,utf8_decode("Total"),0,0,'R');
	    $this->Cell(25,-4,utf8_decode('$'.$total),0,1,'R');

	    $this->Cell(160,-4,utf8_decode("IVA (12%)"),0,0,'R');
	    $this->Cell(25,-4,utf8_decode('$'.$montoiva),0,1,'R');

	    $this->Cell(160,-4,utf8_decode("Subtotal con Descuento IVA (0 %)"),0,0,'R');
	    $this->Cell(25,-4,utf8_decode('$'.$subtotaldcero),0,1,'R');

	    $this->Cell(160,-4,utf8_decode("Subtotal con Descuento IVA (12 %)"),0,0,'R');
	    $this->Cell(25,-4,utf8_decode('$'.$subtotaldiva),0,1,'R');

	    $this->Cell(160,-4,utf8_decode("Descuento"),0,0,'R');
	    $this->Cell(25,-4,utf8_decode('$'.$descuento),0,1,'R');

	    $this->Cell(160,-4,utf8_decode("Subtotal IVA (0 %)"),0,0,'R');
	    $this->Cell(25,-4,utf8_decode('$'.$subtotalcero),0,1,'R');

	    $this->Cell(160,-4,utf8_decode("Subtotal IVA (12 %)"),0,0,'R');
	    $this->Cell(25,-4,utf8_decode('$ '.$subtotaliva),0,1,'R');
	    */

    } 
}
?>
