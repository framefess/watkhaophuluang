<?php
require 'connectmysql.php';
require 'sessionlogin.php';
$p = isset($_GET['p']) ? $_GET['p'] : 1;
$b_id = isset($_GET['bid']) ? $_GET['bid'] : "";
$sql = "SELECT * FROM borrow where id in ($b_id)";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $borrower = $result->fetch_assoc();
}
$monthThai = date("m", strtotime($borrower["date"]));
function monthThai($month)
{
    switch ($month) {
        case '01':
            $month = "มกราคม";
            break;
        case '02':
            $month = "กุมภาพันธ์";
            break;
        case '03':
            $month = "มีนาคม";
            break;
        case '04':
            $month = "เมษายน";
            break;
        case '05':
            $month = "พฤษภาคม";
            break;
        case '06':
            $month = "มิถุนายน";
            break;
        case '07':
            $month = "กรกฎาคม";
            break;
        case '08':
            $month = "สิงหาคม";
            break;
        case '09':
            $month = "กันยายน";
            break;
        case '10':
            $month = "ตุลาคม";
            break;
        case '11':
            $month = "พฤศจิกายน";
            break;
        case '12':
            $month = "ธันวาคม";
            break;
    }
    return $month;
}

// โหลด mPDF อัตโนมัติ
require_once __DIR__ . '/vendor/autoload.php';

//custom font
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];
$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/font',
    ]),
    'fontdata' => $fontData + [
        'sarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
            'BI' => "THSarabunNew BoldItalic.ttf",
        ]
    ],
    'format' => [210, 297],
    'default_font' => 'sarabun'
]);

$mpdf->SetFont('sarabun');

$mpdf->AddPageByArray([
    'margin-left' => 10,
    'margin-right' => 10,
    'margin-top' => 65,
    'margin-bottom' => 7,
    'margin-header' => 9,
    'margin-footer' => 10

]);

$style = '<style>
.header{
    font-family: "sarabun";
    font-size: 20pt;
    font-weight:bold;
    padding:0px;
    margin:0px;
    position:relative;
}
.container{
    font-family: "sarabun";
    font-size: 16pt;
}
h1{
    text-align: center;
}
p {
    margin:0px;
}
hc {
    position:absolute;
}
table, th, td {
    border: 1px solid black;
    text-align:center;
    border-collapse: collapse;
    padding:3px 0px 0px 0px;
    
  }
  .hc2{
    font-size:15pt;
    width:80%;
    margin:auto;
    font-weight:normal;
  }
</style>';

$mpdf->WriteHTML($style);
// <div class="hc" style="width:85px; text-align:right;float:right;padding-top:20px;font-size:14pt;"> <span> ........</span></div>
$mpdf->SetHTMLHeader('
<div class="header" style="width:100%;font-size:30pt;">
    <div class="hc" style="width:250px;text-align:left;float:left;"><p>วัดเขาภูหลวง</p> <p style="font-size:14pt;">ต.วังน้ำเขียว อ.วังน้ำเขียว จ.นครราชสีมา</p> </div>
    <div class="hc" style="width:250;text-align:center;float:left;margin-left: auto;margin-right: auto;left: 0;right: 0;">ใบยืมสิ่งของ-เครื่องใช้</div>

    <div class="hc" style="width:120px; text-align:right;float:right;padding-top:20px;font-size:14pt;"><span>เลขที่ </span><span> ' . (isset($borrower['id']) ? $borrower['id'] : "..........") . '</span></div>
   
    <div class="hc" style="width:100%;font-size:15pt;font-weight:normal;">
        <p style="text-align: center;">วันที่ ' . (isset($borrower['date']) ? (int) date("d", strtotime($borrower["date"])) : "...............") . ' เดือน ' . (isset($borrower['date']) ? monthThai(date("m", strtotime($borrower["date"]))) : "..................................") . ' พ.ศ. ' . (isset($borrower['date']) ? date("Y", strtotime('+543 year', strtotime($borrower["date"]))) : "..................") . ' </p>
    </div>
    <div class="hc2" >นามผู้ยืม ' . (isset($borrower['name']) ? $borrower['name'] : "<dottab />") . '</div>
    <div class="hc2" >ได้ยืมสิ่งของตามรายการข้างล่างนี้ เพื่อใช้ในงาน ' . (isset($borrower['activework']) ? $borrower['activework'] : "<dottab />") . '</div>
    <div class="hc2"  style="white-space: nowrap;">กำหนดส่ง วันที่ ' . (isset($borrower['date_due']) ? (int) date("d", strtotime($borrower["date_due"])) : "...............") . ' เดือน ' . (isset($borrower['date_due']) ? monthThai(date("m", strtotime($borrower["date_due"]))) : "..................................") . ' พ.ศ. ' . (isset($borrower['date_due']) ? date("Y", strtotime('+543 year', strtotime($borrower["date_due"]))) : "..................") . ' </div>
</div>', '', true);
$mpdf->SetHTMLFooter('
<div class="" style="width:85%;font-size:18pt;margin:auto;position:relative;">
    <table style="width:95%;margin:auto;font-size:14pt;border: none;">
        <tr>
        <td width="50%" style="text-align:left;border: none;">ผู้ยืม ....................................................................................</td>
        <td width="50%" style="text-align:left;border: none;">ผู้ให้ยืม ..................................................................................</td>
        </tr>
    </table>
    <div><p>กฎระเบียบการยืมของ</p></div>
    <div class="header" style="width:100%;">
        <div class="hc" style="width:100%;text-align:left;float:left;padding: 0;margin: 0;">
        <table style="width: 100%;margin:auto;font-size:16pt;border: none;float:left;padding: 0;margin: 0;">
        <tr>
        <td style="text-align:left;border: none;padding: 2px;margin: 0;padding-left:10px;vertical-align: top;">1.จะต้องรักษาสิ่งของที่ยืมไปนี้ให้ดี </br></td>
        <td style="text-align:left;border: none;padding: 2px;margin: 0;padding-left:10px;vertical-align: top;">5.จะต้องน้ำของเข้าเก็บไว้ในที่เดิม</td>
        </tr>
        <tr>
        <td style="text-align:left;border: none;padding: 2px;margin: 0;padding-left:10px;vertical-align: top;">2.จะไม่ให้ผู้อื่นยืมต่อเป็นอันขาด</td>
        <td style="text-align:left;border: none;padding: 2px;margin: 0;padding-left:10px;vertical-align: top;">6.ผู้มายืมต้องส่งมอบคืนด้วยตนเอง</td>
        </tr>
        <tr>
        <td style="text-align:left;border: none;padding: 2px;margin: 0;padding-left:10px;vertical-align: top;">3.จะต้องส่งคืนตามวันเวลาที่กำหนดไว้ </br> 4.ก่อนจะนำส่งคืนต้องทำความสะอาดให้เรียบร้อย</td>
        <td style="text-align:left;border: none;padding: 2px;margin: 0;padding-left:10px;vertical-align: top;">7.หากเกิดการชำรุดสูญหาย </br> จะต้องชดใช้ให้เหมือนเดิมภายใน 14 วัน</td>
        </tr>
        <tr>
        <td style="text-align:left;border: none;padding: 2px;margin: 0;padding-left:10px;vertical-align: top;"></td>
        <td style="text-align:left;border: none;padding: 2px;margin: 0;padding-left:10px;vertical-align: top;">8.ผู้ยืมได้บริจาคเงินบำรุง จำนวน................................บาท</td>
        </tr>
        </table>
        </div>
      
    </div>
</div>',);
$item = 0;
$itemname = array();
$itemquantity = array();
if ($p == 1) {
    $sql = "SELECT * FROM items";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $item = $result->num_rows;
        while ($row = $result->fetch_assoc()) {
            array_push($itemname, $row['name']);
        }
    }
} else if ($p == 2) {
    $sql = "SELECT i.name,b.quantity 
    FROM items i 
    left JOIN borrowdetail b 
    ON i.id = b.id_items  
    where id_borrow in('$b_id')
    GROUP by i.id;";
    echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $item = $result->num_rows;
        while ($row = $result->fetch_assoc()) {
            array_push($itemname, $row['name']);
            array_push($itemquantity, $row['quantity']);
        }
    }
}




$td = '';
$col = 2;
// $item = 70;
$rowfix = 25;
$row = $rowfix;
$ind = 0;
if (round(($item / 2)) % $rowfix == 0) {
    $row = $item / ($rowfix * 2) * $rowfix;
} else {
    $row = ceil($item / ($rowfix * 2)) * $rowfix;
}
for ($i = 1; $i < $row + 1; $i++) {
    $td .= "<tr>";
    // for ($c = 0; $c < $col; $c++) {
    //     $td .= "<td>" . ($i + ($c * $rowfix)) . "</td>";
    //     $td .= "<td>" . ($i % 30) . "</td>";
    //     $td .= "<td>" . (1 % 60) . "</td>";
    // }
    $td .= "<td>" . ($i + $ind) . "</td>";
    $td .= '<td style="text-align:left;padding-left:10px;">' .  (isset($itemname[$i + $ind - 1]) ? $itemname[$i + $ind - 1] : "") . "</td>";
    $td .= "<td>" . (isset($itemquantity[$i + $ind - 1]) ? $itemquantity[$i + $ind - 1] : "") . "</td>";
    $td .= "<td>" . ($i + $ind + $rowfix) . "</td>";
    $td .= '<td style="text-align:left;padding-left:10px;">' .  (isset($itemname[$i + $ind + $rowfix - 1]) ? $itemname[$i + $ind + $rowfix - 1] : "") . "</td>";
    $td .= "<td>" . (isset($itemquantity[$i + $ind + $rowfix - 1]) ? $itemquantity[$i + $ind + $rowfix - 1] : "") . "</td>";
    $td .= "</tr>";
    if ($i % $rowfix == 0) {
        $data = '
            <table style="width:90%;margin:auto;font-size:12pt;">
                <thead>
                    <tr>
                        <th width="5%">เลขที่</th>
                        <th>รายการ</th>
                        <th width="10%">จำนวน</th>
                        <th width="5%">เลขที่</th>
                        <th>รายการ</th>
                        <th width="10%">จำนวน</th>
                    </tr>
                </thead>
                <tbody>' . $td . '</tbody>
            </table>';
        $content = '
<div class="container" style="width: 100%">
' . $data . '
</div>
';
        $td = '';
        $mpdf->WriteHTML($content);
        // $mpdf->AddPage();
        if (($i) % $rowfix == 0 and $i != $row) {
            $mpdf->AddPage();
            // $ind = $ind + 60;
        }
        $ind = $ind + $rowfix;
    }
}

// for ($i = 1; $i <= $tdq; $i++) {
//     $td .= '<tr>
//         <td>'.$i.'</td>
//         <td></td>
//         <td></td>
//         <td>'.$i+$tdq .'</td>
//         <td></td>
//         <td></td>
//     </tr>';
// }

// $data = '
// <table style="width:90%;margin:auto;font-size:12pt;">
//     <thead>
//         <tr>
//             <th width="5%">เลขที่</th>
//             <th>รายการ</th>
//             <th width="10%">จำนวน</th>
//             <th width="5%">เลขที่</th>
//             <th>รายการ</th>
//             <th width="10%">จำนวน</th>
//         </tr>
//     </thead>
//     <tbody>' . $td . '</tbody>
// </table>';
// echo $data;

// $content = '
// <div class="container" style="width: 100%">
// ' . $data . '
// </div>
// ';

// echo $content;
// $mpdf->SetHTMLHeader('
// <div class="header" style="width:100%;font-size:30pt;">
//     <div class="hc" style="width:250px;text-align:left;float:left;"><p>วัดเขาภูหลวง</p> <p style="font-size:14pt;">ต.วังน้ำเขียว อ.วังน้ำเขียว จ.นครราชสีมา</p> </div>
//     <div class="hc" style="width:300px;text-align:center;float:left;margin-left: auto;margin-right: auto;left: 0;right: 0;">ใบยืมสิ่งของ-เครื่องใช้</div>

//     <div class="hc" style="width:120px; text-align:right;float:left;padding-top:20px;font-size:14pt;"><span>เลขที่ </span></div>
//     <div class="hc" style="width:85px; text-align:left;float:left;padding-top:20px;font-size:14pt;"> <span> ........</span></div>
//     <div class="hc" style="width:100%;font-size:15pt;font-weight:normal;">
//         <p style="text-align: center;">วันที่ ............... เดือน .................................. พ.ศ. .................. </p>
//     </div>
//     <div class="hc2" >นามผู้ยืม <dottab /></div>
//     <div class="hc2" >ได้ยืมสิ่งของตามรายการข้างล่างนี้ เพื่อใช้ในงาน <dottab /></div>
//     <div class="hc2"  style="white-space: nowrap;">กำหนดส่ง วันที่ ...................... เดือน .................................. พ.ศ. .....................<div>
// </div>', '', true);
// $mpdf->SetHTMLFooter('
// <table width="100%">
//     <tr>
//         <td width="33%">{DATE j-m-Y}</td>
//         <td width="33%" align="center">{PAGENO}/{nbpg}</td>
//         <td width="33%" style="text-align: right;">My document</td>
//     </tr>
// </table>');
// $mpdf->WriteHTML($style);
// $mpdf->WriteHTML($content);
// $mpdf->SetJS('this.print();');
// $mpdf->SetJS('print();');
// $mpdf->Output();
$mpdf->Output('report.pdf', 'I');
