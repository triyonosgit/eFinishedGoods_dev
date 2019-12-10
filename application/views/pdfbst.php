<?php
function tgl_indo($tgl){
    $tanggal = substr($tgl,8,2);
    $bulan = getBulan(substr($tgl,5,2));
    $tahun = substr($tgl,0,4);
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

// $tanggal = tgl_indo($reqdate);

$content = ob_get_clean();

$hari = namaHari($weekday);
$format_tanggal = $hari.', '.tgl_indo($tanggal);
$format_requestor = ucwords(strtolower($pemohon));


$content = "<page backtop='36.2mm' backbottom='8mm'>
                <page_header>
                    <table style='width: 210mm; padding: 8px 0px -7px 10px; border-bottom: 0.5px;'>
                        <tr>
                            <td valign='top' rowspan='3' style='width: 145mm; font-size: 10pt;'>
                                <img src='./img/ssmheader.png' style='width:60mm;'>
                            </td>
                            <td valign='bottom' style='padding-top: 0px; padding-bottom: 0px; width: 55mm; font-size: 10pt;'>
                                BUKTI SERAH TERIMA
                            </td>
                        </tr>
                        <tr>
                            <td valign='bottom' style='padding-top: 2px; padding-bottom: -7px; width: 55mm; font-size: 11pt;'>
                                Nomor : $nbr
                            </td>
                        </tr>
                        <tr>
                            <td style='padding: 0px; height: 4mm; font-size: 12pt;'>
                            </td>
                        </tr>
                    </table><br/>
                    <table style='width: 200mm; padding-left: 12px; padding-bottom: 10px;'>
                        <tr>
                            <td style='width: 31mm; font-size: 10pt;'>
                                Hari, Tanggal Input
                            </td>
                            <td style='width: 2mm; font-size: 10pt;'>
                                :
                            </td>
                            <td style='width: 100mm; font-size: 10pt;'>
                                $format_tanggal
                            </td>

                            <td style='width: 20mm; font-size: 10pt;'>
                                Nomor SPK
                            </td>
                            <td style='width: 2mm; font-size: 10pt;'>
                                :
                            </td>
                            <td style='width: 20mm; font-size: 10pt;'>
                                $spknbr
                            </td>
                        </tr>
                        <tr>
                            <td style='width: 31mm; font-size: 10pt;'>
                                Pemohon
                            </td>
                            <td style='width: 2mm; font-size: 10pt;'>
                                :
                            </td>
                            <td style='width: 100mm; font-size: 10pt;'>
                                $format_requestor
                            </td>

                            <td style='width: 20mm; font-size: 10pt;'>
                                Nomor WO
                            </td>
                            <td style='width: 2mm; font-size: 10pt;'>
                                :
                            </td>
                            <td style='width: 20mm; font-size: 10pt;'>
                                $wonbr
                            </td>
                        </tr>
                     </table>
                     <table border='0.5' cellpadding='0' cellspacing='0' style='margin-left:6px;'>
                        <tr>
							<th align='center' style='width: 45mm; font-size: 10pt; padding: 4px 3px;'>Kode Item</th>
                            <th align='center' style='width: 110mm; font-size: 10pt; padding: 4px 5px;'>Deskripsi</th>
                            <th align='center' style='width: 17mm; font-size: 10pt; padding: 4px 0;'>Qty</th>
                            <th align='center' style='width: 17mm; font-size: 10pt; padding: 4px 0;'>UoM</th>
                        </tr>
                    </table>
                </page_header>

                    <table border='0.5' cellpadding='0' cellspacing='0' style='margin-left:6px;'>
                        <tr>
                            <td align='center' style='width: 45mm; font-size: 10pt; padding: 4px 3px;'>$parcode</td>
                            <td style='width: 110mm; font-size: 10pt; padding: 4px 5px;'>$pardesc</td>
                            <td style='width: 17mm; font-size: 10pt; padding: 4px 0;' align='center'>$qty</td>
                            <td style='width: 17mm; font-size: 10pt; padding: 4px 0;' align='center'>$uom</td>
                        </tr>
                    </table><br />

                    <table cellpadding='0' cellspacing='0' style='margin-left:6px;'>
                        <tr>
                            <td valign='top' align='right' height='70' style='width: 30mm; font-size: 10pt; padding: 8px 3px;'>Nomor Pack QC :</td>
                            <td style='width: 0.8mm; font-size: 10pt; padding: 4px 3px;'></td>
                            <td valign='top' border='0.5' style='width: 158mm; font-size: 10pt; padding: 4px;'>$packnbr</td>
                        </tr>
                    </table>
                    <br/>
                    <table cellpadding='0' cellspacing='0' style='margin-left:6px;'>
                        <tr>
                            <td valign='top' align='right' height='30' style='width: 30mm; font-size: 10pt; padding: 8px 3px;'>Keterangan   :</td>
                            <td style='width: 0.8mm; font-size: 10pt; padding: 4px 3px;'></td>
                            <td valign='top' border='0.5' style='width: 158mm; font-size: 10pt; padding: 4px;'>$rmks</td>
                        </tr>
                    </table>
                    <table cellpadding='1' cellspacing='0' style='margin-left:6px; margin-top: 8px;'>
                        <tr>
                            <td style='width: 40mm;'></td>
                            <td align='right' style='width: 50mm; padding-right: 3px; font-size: 8.5pt;'>Putih: Gudang</td>
                            <td align='right' style='width: 50mm; padding-right: 3px; font-size: 8.5pt;'>Merah: Produksi</td>
                            <td align='right' style='width: 50mm; padding-right: 3px; font-size: 8.5pt;'>Kuning: PPIC</td>
                        </tr>
                    </table>
                    <br/><br/>
                ";

        // $content .= "<table border='0.5' cellpadding='0' cellspacing='0' style='margin-left:6px; margin-top: 3px;'>
        //                 <tr>
        //                     <td valign='top' height='50' style='width: 200mm;'>&nbsp;&nbsp;$rmks</td>
        //                 </tr>
        //              </table>
        //              <table border='0' cellpadding='0' cellspacing='0' style='margin-top: 3px;'>
        //                  <tr>
        //                      <td style='width: 40mm;'></td>
        //                      <td align='right' style='width: 50mm; padding-right: 3px; font-size: 8pt;'>Putih: Produksi</td>
        //                      <td align='right' style='width: 50mm; padding-right: 3px; font-size: 8pt;'>Merah: Gudang</td>
        //                      <td align='right' style='width: 50mm; padding-right: 3px; font-size: 8pt;'>Kuning: PPIC</td>
        //                      <td style='width: 10mm;'></td>
        //                  </tr>
        //               </table>
        //               <br/><br/>
        //              ";

/* ////////////////////////////////////////////////////////////////////////////////////////////////////////// */

/* ///// Tanda tangan /////////////////////////////////////////////////////////////////////////////////////// */
$content .= "       <table border='0'>
                        <tr>
                            <td style='width: 65mm; text-align: center; font-size: 10pt'>Mengetahui,</td>
                            <td style='width: 65mm; text-align: center; font-size: 10pt'>Diserahkan oleh,</td>
                            <td style='width: 65mm; text-align: center; font-size: 10pt'>Diterima oleh,</td>
                        </tr>
                        <tr>
                            <td style='text-align: center; font-size: 10pt; padding: 60px 0 0 0'>( ______________ )</td>
                            <td style='text-align: center; font-size: 10pt; padding: 60px 0 0 0'>( ______________ )</td>
                            <td style='text-align: center; font-size: 10pt; padding: 60px 0 0 0'>( ______________ )</td>
                        </tr>
                     </table>
            </page>";
/* ////////////////////////////////////////////////////////////////////////////////////////////////////////// */



ob_end_clean();

$filename="formBST_".$nbr.".pdf";

try {
    $html2pdf = new HTML2PDF('L', 'A5','fr', false, 'ISO-8859-15',array(2, 2, 0, 0)); //setting ukuran kertas dan margin pada dokumen anda
	$html2pdf->setTestTdInOnePage(false);
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output($filename);
	// $html2pdf->Output('/xampp/htdocs/eFinishedGoods/PDFrpt/'.$filename, 'F');

}
catch(HTML2PDF_exception $e) { echo $e; }

?>
