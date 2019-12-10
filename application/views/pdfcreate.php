<?php
ob_start();
require_once(APPPATH."/third_party/html2pdf/html2pdf.class.php");

$content = ob_get_clean();

$printdate = date("Y-m-d");
$printtime = date("H:i");

$content = "<table cellpadding='0' cellspacing='0' style='width: 200mm;'>
                <tr>
                    <td align='center' style='width: 198mm; padding: 0px 2px; font-size: 14pt;'><u>Stock Opname Rack $frRack s.d $toRack</u></td>
                </tr>
                <tr>
                    <td align='center' style='font-size: 9pt;'>[ Nomor : $stonbr ]</td>
                </tr>
            </table>
            <br>
            <table cellpadding='0' cellspacing='0' style='width: 200mm;'>
                <tr>
                    <td align='right' style='width: 180mm; padding: 0.8px 2px; font-size: 8pt;'>Tanggal Cetak</td>
                    <td align='center' style='width: 2mm; padding: 0.8px; font-size: 8pt;'>:</td>
                    <td align='left' style='padding: 0.8px; font-size: 8pt;'>$printdate</td>
                </tr>
                <tr>
                    <td align='right' style='width: 180mm; padding: 0.8px 2px; font-size: 8pt;'>Jam Cetak</td>
                    <td align='center' style='width: 2mm; padding: 0.8px; font-size: 8pt;'>:</td>
                    <td align='left' style='padding: 0.8px; font-size: 8pt;'>$printtime</td>
                </tr>
            </table> ";

foreach ($racklist as $rack) {
    $content .= "<h4 style='margin-bottom: 2px;'>&nbsp;&nbsp;&nbsp; $rack[rack_code]</h4>";

    $content .= "<table cellpadding='0' cellspacing='0' style='border: 0px; margin: 6px;'>
                    <tr>
                        <th align='center' style='width: 4mm; padding: 7px 3px; font-size: 8pt; border-top: 1px solid #000; border-bottom: 1px solid #000;'>#</th>
                        <th style='width: 12mm; padding: 7px 3px; font-size: 8pt; border-top: 1px solid #000; border-bottom: 1px solid #000;'>Bin</th>
                        <th style='width: 28mm; padding: 7px 3px; font-size: 8pt; border-top: 1px solid #000; border-bottom: 1px solid #000;'>Kd Item</th>
                        <th style='width: 70mm; padding: 7px 3px; font-size: 8pt; border-top: 1px solid #000; border-bottom: 1px solid #000;'>Deskripsi</th>
                        <th style='width: 20mm; padding: 7px 3px; font-size: 8pt; border-top: 1px solid #000; border-bottom: 1px solid #000;'>Kategori</th>
                        <th style='width: 7mm; padding: 7px 3px; font-size: 8pt; border-top: 1px solid #000; border-bottom: 1px solid #000;'>UoM</th>
                        <th align='center' style='width: 12mm; padding: 7px 3px; font-size: 8pt; border-top: 1px solid #000; border-bottom: 1px solid #000;'>Qty eStock</th>
                        <th align='center' style='width: 8mm; padding: 7px 3px; font-size: 8pt; border-top: 1px solid #000; border-bottom: 1px solid #000;'>Qty Fisik</th>
                        <th align='center' style='width: 8mm; padding: 7px 3px; font-size: 8pt; border-top: 1px solid #000; border-bottom: 1px solid #000;'>Qty NG</th>

                    </tr> ";
                
    $i = 1;
    foreach ($rack[detail] as $detail) {
        $content .= "<tr>
                        <td align='center' style='width: 4mm; padding: 5px 3px; font-size: 8pt; border-bottom: 1px dotted #000;'> $i </td>
                        <td style='width: 12mm; padding: 5px 3px; font-size: 8pt; border-bottom: 1px dotted #000;'> $detail[bin_code]</td>
                        <td style='width: 28mm; padding: 5px 3px; font-size: 8pt; border-bottom: 1px dotted #000;'> $detail[item_code]</td>
                        <td style='width: 70mm; padding: 5px 3px; font-size: 8pt; border-bottom: 1px dotted #000;'>$detail[description]</td>
                        <td style='width: 20mm; padding: 5px 3px; font-size: 8pt; border-bottom: 1px dotted #000;'>$detail[category]</td>
                        <td align='center' style='width: 7mm; padding: 5px 3px; font-size: 8pt; border-bottom: 1px dotted #000;'>$detail[uom]</td>
                        <td align='right' style='width: 12mm; padding: 5px 3px; font-size: 8pt; border-bottom: 1px dotted #000;'>$detail[qty]</td>
                        <td align='center' style='width: 8mm; padding: 5px 3px; font-size: 8pt; border-bottom: 1px dotted #000;'> ...... </td>
                        <td align='center' style='width: 8mm; padding: 5px 3px; font-size: 8pt; border-bottom: 1px dotted #000;'> ...... </td>
                     </tr>";
        $i++;
    }

    $content .= "</table>";
}

$content .= "<br><br>
             <div style='margin-left: 30px;'><h4>Tim Opname :</h4></div>
             <table cellpadding='0' cellspacing='0' style='margin-left: 20px; width: 115mm;'>
                <tr>
                    <th align='center' style='width: 6mm; border: 0.6px solid; padding: 6px 2px; font-size: 9pt;'>No</th>
                    <th align='center' style='width: 45mm; border: 0.6px solid; padding: 6px 2px; font-size: 9pt;'>Nama</th>
                    <th align='center' style='width: 35mm; border: 0.6px solid; padding: 6px 2px; font-size: 9pt;'>Tanda Tangan</th>
                    <th align='center' style='width: 25mm; border: 0.6px solid; padding: 6px 2px; font-size: 9pt;'>Tanggal</th>
                </tr>
                <tr>
                    <td align='center' style='border: 0.6px solid; padding: 13px 2px; font-size: 9pt;'>1</td>
                    <td style='border: 0.6px solid; padding: 13px 2px; font-size: 9pt;'></td>
                    <td style='border: 0.6px solid; padding: 13px 2px; font-size: 9pt;'></td>
                    <td style='border: 0.6px solid; padding: 13px 2px; font-size: 9pt;'></td>
                </tr>
                <tr>
                    <td align='center' style='border: 0.6px solid; padding: 13px 2px; font-size: 9pt;'>2</td>
                    <td style='border: 0.6px solid; padding: 13px 2px; font-size: 9pt;'></td>
                    <td style='border: 0.6px solid; padding: 13px 2px; font-size: 9pt;'></td>
                    <td style='border: 0.6px solid; padding: 13px 2px; font-size: 9pt;'></td>
                </tr>
                <tr>
                    <td align='center' style='border: 0.6px solid; padding: 13px 2px; font-size: 9pt;'>3</td>
                    <td style='border: 0.6px solid; padding: 13px 2px; font-size: 9pt;'></td>
                    <td style='border: 0.6px solid; padding: 13px 2px; font-size: 9pt;'></td>
                    <td style='border: 0.6px solid; padding: 13px 2px; font-size: 9pt;'></td>
                </tr>
             </table>";

ob_end_clean();

$filename="itemstockopname.pdf";

try {
    $html2pdf = new HTML2PDF('P', 'A4','fr', false, 'ISO-8859-15',array(2, 10, 2, 10)); //setting ukuran kertas dan margin pada dokumen anda
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output($filename);

}
catch(HTML2PDF_exception $e) { echo $e; }

?>