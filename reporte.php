<?php

require('fpdf/fpdf.php');


require 'includes/config/database.php';
$db = conectarDB();

//SQL para consultas Empleados
if (isset($_GET["input"])) {
    // asignar w1 y w2 a dos variables
    $input = $_GET["input"];
    // mostrar $phpVar1 y $phpVar2
    // "<p>Input: " . $input . "</p>";
} else {
    echo "<p>No parameters</p>";
    //$input = null;
}
$where = '';
$columns = ['idDispositivo','numeroSerie','nombreDispositivo','dependencia','dependencia2','fechaEntrega','nombreRecibio'];
$table = "registroequipo";

if ($input != null) {
    $where = "WHERE (";

    $cont = count($columns);
    for ($i = 0; $i < $cont; $i++) {
        $where .= $columns[$i] . " LIKE '%" . $input . "%' OR ";
    }
    $where = substr_replace($where, "", -3); //elimina el ultimo OR del $where
    $where .= ")";
}

$sql = "SELECT " . implode(", ",$columns) . "
FROM $table
$where
ORDER BY fechaEntrega DESC";

//echo "<p>" . $sql . "</p>";

class PDF extends FPDF{
    //header de pdf

    function Header()
    {
        //logo
        $this->Cell(-200);
        $this->Image('build/img/logo.png',80,10,50);
        $this->SetFont('Arial','B',10);
        $this->Ln(40);
    }

    function Footer() {
		// Posición: a 1,5 cm del final
		$this->SetY(-15);

		$this->SetFont('Arial', 'B', 10);
		// Número de página
		$this->Cell(190, 10,utf8_decode('Área de sistemas ' . date('Y')) , 0, 0, 'C', 0);
		$this->Cell(-15, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
	}

    var $widths;
	var $aligns;

	function SetWidths($w) {
		//Set the array of column widths
		$this->widths = $w;
	}

	function SetAligns($a) {
		//Set the array of column alignments
		$this->aligns = $a;
	}

	function Row($data, $setX) //yo modifique el script a  mi conveniencia :D
	{
		//Calculate the height of the row
		$nb = 0;
		for ($i = 0; $i < count($data); $i++) {
			$nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
		}

		$h = 8 * $nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h, $setX);
		//Draw the cells of the row
		for ($i = 0; $i < count($data); $i++) {
			$w = $this->widths[$i];
			$a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
			//Save the current position
			$x = $this->GetX();
			$y = $this->GetY();
			//Draw the border
			$this->Rect($x, $y, $w, $h, 'DF');
			//Print the text
			$this->MultiCell($w, 8, $data[$i], 0, $a);
			//Put the position to the right of the cell
			$this->SetXY($x + $w, $y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function CheckPageBreak($h, $setX) {
		//If the height h would cause an overflow, add a new page immediately
		if ($this->GetY() + $h > $this->PageBreakTrigger) {
			$this->AddPage($this->CurOrientation);
            $this->SetY(35);
			$this->SetX($setX);
            
			//Volver a definir el encabezado de las nuevas paginas
            $this->SetFont('Arial', '', 10);
            $this->SetTextColor(255,255,255);
            $this->SetFillColor(128,25,49);
			$this->Cell(50,11,'Numero de serie',1,0,'C',1);
			$this->Cell(30,11,'Dispositivo',1,0,'C',1);
			//$pdf->SetX(85); 
			$this->MultiCell(30,5.5,'Dependencia a la que pertenece',1,0,'C',1);
			$this->SetY(35);
			$this->SetX(130); 
			$this->MultiCell(30,5.5,utf8_decode('Dependencia donde se prestó'),1,0,'C',1);
			$this->SetY(35);
			$this->SetX(160); 
			$this->Cell(30,11,'Fecha de entrega',1,1,'C',1);

			$this->SetFont('Arial', '', 10);
            $this->SetTextColor(0,0,0);
            $this->SetFillColor(243, 232, 231);
		}

		if ($setX == 100) {
			$this->SetX(100);
		} else {
			$this->SetX($setX);
		}

	}

	function NbLines($w, $txt) {
		//Computes the number of lines a MultiCell of width w will take
		$cw = &$this->CurrentFont['cw'];
		if ($w == 0) {
			$w = $this->w - $this->rMargin - $this->x;
		}

		$wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
		$s = str_replace("\r", '', $txt);
		$nb = strlen($s);
		if ($nb > 0 and $s[$nb - 1] == "\n") {
			$nb--;
		}

		$sep = -1;
		$i = 0;
		$j = 0;
		$l = 0;
		$nl = 1;
		while ($i < $nb) {
			$c = $s[$i];
			if ($c == "\n") {
				$i++;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
				continue;
			}
			if ($c == ' ') {
				$sep = $i;
			}

			$l += $cw[$c];
			if ($l > $wmax) {
				if ($sep == -1) {
					if ($i == $j) {
						$i++;
					}

				} else {
					$i = $sep + 1;
				}

				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
			} else {
				$i++;
			}

		}
		return $nl;
	}
    
}

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','',10);
    $pdf->SetMargins(10,10,10);
    $pdf->SetAutoPageBreak(true, 20); //salto de pagina automatico

    //Encabezado
    $pdf->SetY(35);
    // $pdf->SetX(45); 
    $pdf->SetX(20); 
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFillColor(128,25,49);

    $pdf->Cell(50,11,'Numero de serie',1,0,'C',1);
    $pdf->Cell(30,11,'Dispositivo',1,0,'C',1);
	//$pdf->SetX(85); 
    $pdf->MultiCell(30,5.5,'Dependencia a la que pertenece',1,0,'C',1);
	$pdf->SetY(35);
	$pdf->SetX(130); 
    $pdf->MultiCell(30,5.5,utf8_decode('Dependencia donde se prestó'),1,0,'C',1);
	$pdf->SetY(35);
	$pdf->SetX(160); 
	$pdf->Cell(30,11,'Fecha de entrega',1,1,'C',1);

    $resultado = mysqli_query($db,$sql);

    $pdf->SetTextColor(0,0,0);
    $pdf->SetFillColor(243, 232, 231);

    //El ancho de las celdas
    $pdf->SetWidths(array(50, 30,30,30,30)); //???
    // esto no lo mencione en el video pero también pueden poner la alineación de cada COLUMNA!!!
    $pdf->SetAligns(array('C','C','C','C','C'));

    while($row = $resultado->fetch_assoc()){
        
        $pdf->Row(array($row['numeroSerie'],utf8_decode($row['nombreDispositivo']), utf8_decode($row['dependencia']),utf8_decode($row['dependencia2']),date("d/m/Y", strtotime($row['fechaEntrega'])) ), 20);
   
    }
    
    $pdf->Output();



