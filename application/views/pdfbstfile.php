<?php

function tgl_indo($tgl){
    $tanggal = substr($tgl,8,2);
    $bulan = getBulan(substr($tgl,5,2));
    $tahun = substr($tgl,0,4);
    return $tanggal.' '.$bulan.' '.$tahun;
}

function tgl_indo2($tgl) {
    $tanggal = substr($tgl,8,2);
    $bulan = substr(getBulan(substr($tgl,5,2)), 0, 3);
    $tahun = substr($tgl,2,2);
    return $tanggal.' '.$bulan.' '.$tahun;
}

function getBulan($bln){
    switch ($bln){
        case 1:
            return "Januari";
            break;
        case 2:
            return "Februari";
            break;
        case 3:
            return "Maret";
            break;
        case 4:
            return "April";
            break;
        case 5:
            return "Mei";
            break;
        case 6:
            return "Juni";
            break;
        case 7:
            return "Juli";
            break;
        case 8:
            return "Agustus";
            break;
        case 9:
            return "September";
            break;
        case 10:
            return "Oktober";
            break;
        case 11:
            return "November";
            break;
        case 12:
            return "Desember";
            break;
    }
}

function namaHari($wkday){
    switch ($wkday){
        case 0:
            return "Senin";
            break;
        case 1:
            return "Selasa";
            break;
        case 2:
            return "Rabu";
            break;
        case 3:
            return "Kamis";
            break;
        case 4:
            return "Jumat";
            break;
        case 5:
            return "Sabtu";
            break;
        case 6:
            return "Minggu";
            break;
    }
}



ob_start();
require_once(APPPATH."/third_party/html2pdf/html2pdf.class.php");


$format_tanggal = tgl_indo($tanggal);

$content = ob_get_clean();



$content = "<page backtop='27mm' backbottom='8mm'>
                <page_header>
                    <div align='center'>
                        <h3>List BST Tanggal $format_tanggal</h3>
                    </div>
                    <br/>

                    <table border='0.5' cellpadding='0' cellspacing='0' style='margin-left:6px;'>
                        <tr>
                            <th align='center' style='width: 7mm; font-size: 9.5pt; padding: 8px 0; background-color: #8dbdf2;'>#</th>
                            <th align='center' style='width: 14mm; font-size: 9.5pt; padding: 8px 3px; background-color: #8dbdf2;'>BST #</th>
                            <th align='center' style='width: 35mm; font-size: 9.5pt; padding: 8px 3px; background-color: #8dbdf2;'>Parent Code</th>
                            <th align='center' style='width: 70mm; font-size: 9.5pt; padding: 8px 3px; background-color: #8dbdf2;'>Description</th>
                            <th align='center' style='width: 10mm; font-size: 9.5pt; padding: 8px 3px; background-color: #8dbdf2;'>UoM</th>
                            <th align='center' style='width: 8mm; font-size: 9.5pt; padding: 8px 3px; background-color: #8dbdf2;'>Qty</th>
                            <th align='center' style='width: 17mm; font-size: 9.5pt; padding: 8px 3px; background-color: #8dbdf2;'>Price</th>
                            <th align='center' style='width: 20mm; font-size: 9.5pt; padding: 8px 3px; background-color: #8dbdf2;'>Amount</th>
                            <th align='center' style='width: 80mm; font-size: 9.5pt; padding: 8px 3px; background-color: #8dbdf2;'>GSS Description</th>
                        </tr>
                    </table>
                </page_header>
                <page_footer>
                    <div style='margin-left: 12px;'>[[page_cu]]/[[page_nb]]</div>
                </page_footer>

                    <table border='0.5' cellpadding='0' cellspacing='0' style='margin-left:6px;'>
                ";

$i = 1;

$TOTAMOUNT = number_format($totamount, 2);
foreach ($listbst as $li) {
    $SOMINPRICE = number_format($li->SO_MINPRICE, 2);
    $AMOUNT = number_format($li->AMOUNT, 2);


    if ($i%2 == 0) {
        $content .= "   <tr style='background-color: #ebf3fc'>";
    } else {
        $content .= "   <tr>";
    }
        $content .= "
                            <td align='center' style='width: 7mm; font-size: 9pt; padding: 4px 0;'>$i</td>
                            <td align='center' style='width: 14mm; font-size: 9pt; padding: 4px 3px;'>$li->NOBST</td>
                            <td style='width: 35mm; font-size: 9pt; padding: 4px 3px;'>$li->PARENT_CODE</td>
                            <td style='width: 70mm; font-size: 9pt; padding: 4px 3px;'>$li->DESCRIPTION</td>
                            <td align='center' style='width: 10mm; font-size: 9pt; padding: 4px 3px;'>$li->UOM</td>
                            <td align='right' style='width: 8mm; font-size: 9pt; padding: 4px 3px;'>$li->QTY</td>
                            <td align='right' style='width: 17mm; font-size: 9pt; padding: 4px 3px;'>$SOMINPRICE</td>
                            <td align='right' style='width: 20mm; font-size: 9pt; padding: 4px 3px;'>$AMOUNT</td>
                            <td style='width: 80mm; font-size: 9pt; padding: 4px 3px;'>$li->GSS_DESCRIPTION</td>
                        </tr>
                ";
    $i++;
}

    if ($i%2 == 0) {
        $content .= "   <tr style='background-color: #ebf3fc'>
                            <td colspan='7' align='right'>T O T A L :  &nbsp;</td>
                            <td align='right' style='width: 20mm; font-size: 10pt; padding: 4px 2px;'> $TOTAMOUNT</td>
                            <td></td>
                        </tr>";
    } else {
        $content .= "   <tr>
                            <td colspan='7' align='right'>T O T A L :  &nbsp;</td>
                            <td align='right' style='width: 20mm; font-size: 10pt; padding: 4px 2px;'> $TOTAMOUNT</td>
                            <td></td>
                        </tr>";
    }

$content .= "       </table><br/>
             </page>";


/* ////////////////////////////////////////////////////////////////////////////////////////////////////////// */





ob_end_clean();

$filename="BST_".$tanggal.".pdf";

try {
    $html2pdf = new HTML2PDF('L', 'A4','fr', false, 'ISO-8859-15',array(2, 2, 0, 0)); //setting ukuran kertas dan margin pada dokumen anda
    $html2pdf->setTestTdInOnePage(false);
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

    // $html2pdf->Output($filename);
    $html2pdf->Output('/xampp/htdocs/eFinishedGoods/PDFrpt/'.$filename, 'F');

}
catch(HTML2PDF_exception $e) { echo $e; }

?>
