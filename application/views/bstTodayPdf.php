<?php
ob_start();
require_once(APPPATH . "/third_party/html2pdf/html2pdf.class.php");

$content = ob_get_clean();

// header
$content = "<page backtop='36.2mm' backbottom='8mm'>
                    <page_header>
                        <table style='width: 297; padding: 8px 0px -7px 10px; border-bottom: 0.5px;'>
                            <tr>
                                <td valign='top' rowspan='3' style='width:190mm; font-size: 10pt;'>
                                    <img src='./img/ssmheader.png' style='width:60mm;'>
                                </td>
                                <td valign='top' rowspan='3' style='width:100mm; font-size: 10pt; padding-top: -10px;'>
                                <h3> BST diproses Hari Ini (Detail)</h3> " . date('d F Y') . "
                                </td>
                            </tr>
                        </table>
                </page_header>
                <page_footer>
                .&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[[page_cu]]/[[page_nb]]
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Generated By eFinishGoods - " . date("d-m-Y h:i") . " WIB
                </page_footer>";
$content .= "   <table border='0.1px' cellpadding='0' cellspacing='0' style='width: 210mm; padding-top: -55px; font-size: 11px; margin-left:10px; margin-right:10px'>
                    <thead>
                        <tr>
                            <th align='center' style='padding: 8px 8px; background-color: #8dbdf2;'>#</th>
                            <th align='center' style='padding: 8px 8px; background-color: #8dbdf2;'>Tanggal</th>
                            <th align='center' style='padding: 8px 8px; background-color: #8dbdf2;'>No. BST</th>
                            <th align='center' style='padding: 8px 8px; background-color: #8dbdf2;'>Parent Code</th>
                            <th align='center' style='padding: 8px 8px; background-color: #8dbdf2;'>Description</th>
                            <th align='center' style='padding: 8px 8px; background-color: #8dbdf2;'>UoM</th>
                            <th align='center' style='padding: 8px 8px; background-color: #8dbdf2;'>Bin</th>
                            <th align='center' style='padding: 8px 8px; background-color: #8dbdf2;'>Qty</th>
                            <th align='center' style='padding: 8px 8px; background-color: #8dbdf2;'>WO</th>
                            <th align='center' style='padding: 8px 8px; background-color: #8dbdf2;'>SPK</th>
                            <th align='center' style='padding: 8px 8px; background-color: #8dbdf2;'>Pack QC</th>
                        </tr>
                    </thead>
                    <tbody>";
$i = 1;
foreach ($IsiReviewPdf as $irf) {
    if ($i % 2 == 0) {
        $content .=            "<tr style='background-color: #ebf3fc'>";
    } else {
        $content .=            "<tr>";
    }
    $content .= "
                            <td style='padding: 4px 8px;'>" . $i++ . "</td>
                            <td style='padding: 4px 8px;'>" . $irf['created_at'] . "</td>
                            <td style='padding: 4px 8px;'>" . $irf['hod_nbr'] . "</td>
                            <td style='padding: 4px 8px; width:35mm'>" . $irf['hod_item'] . "</td>
                            <td style='padding: 4px 8px; width:50mm'>" . $irf['hod_desc'] . "</td>
                            <td style='padding: 4px 8px;'>" . $irf['hod_uom'] . "</td>
                            <td style='padding: 4px 8px;'>" . $irf['bin_code'] . "</td>
                            <td align='right' style='padding: 4px 8px;'>" . number_format($irf['qty']) . "</td>
                            <td style='padding: 4px 8px;'>" . $irf['hod_wo'] . "</td>
                            <td style='padding: 4px 8px;'>" . $irf['hod_spk'] . "</td>
                            <td style='padding: 4px 8px; width:50mm'>" . $irf['hod_packnbr'] . "</td>
                        </tr>";
}

$content .=        "</tbody>
                </table>
            </page>";


ob_end_clean();

$filename = 'Today Bst Detail.pdf';

try {
    $html2pdf = new HTML2PDF('L', 'A4', 'fr', false, 'ISO-8859-15', array(4, 2, 1, 6)); //setting ukuran kertas dan margin pada dokumen anda
    $html2pdf->setTestTdInOnePage(false);
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output($filename);
} catch (HTML2PDF_exception $e) {
    echo $e;
}
