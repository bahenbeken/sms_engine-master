<?php
require_once('lib/connection.php'); 
require_once('lib/api_sms_class_masking_json.php'); // class  
ob_start();
$apikey      = '01cedd4f16ce8469b44cd39abb1abac7'; // api key 
$ipserver    = 'http://45.76.156.114'; // url server sms 
$callbackurl = ''; // url callback get status sms 
//$callbackurl = 'http://your_url_for_get_auto_update_status_sms'; // url callback get status sms 


/* send sms  */
$senddata = array(
    'apikey' => $apikey,  
    'callbackurl' => $callbackurl, 
    'datapacket'=>array()
);

$sqlSelect = "SELECT a.`id`, 'retailer_order' AS order_from, 'orderretailtable' AS table_order, b.`telephone` AS detination, 'system' AS `sent_from`,
CONCAT('Kode Booking: ', a.code_booking, '|', GROUP_CONCAT(CONCAT(d.`name`,'|qty: ', c.qty,'', e.name),'||'))
    AS message
FROM `orderretailtable` a 
JOIN `retailtable` b ON b.`id`=a.`id_retail` 
JOIN `orderretailtranstable` c ON c.`id_order`=a.`id`
JOIN `sanitasdist`.`itemtable` d ON d.`id`=c.id_item
JOIN `sanitasdist`.`uomtable` e ON e.`id`=c.id_uom
WHERE a.`sms_flag`='new'
GROUP BY c.id_order

UNION ALL

SELECT a.`id`, 'retailer_order' AS order_from, 'orderretailtable' AS table_order, b.`telephone` AS detination, 'system' AS `sent_from`,
CONCAT('Kode Booking: ', a.code_booking, '|', GROUP_CONCAT(CONCAT(d.`name`,'|qty: ', c.qty,'', e.name),'||'))
    AS message
FROM `orderretailtable` a 
JOIN `distributortable` b ON b.`id`=a.`id_distributor`
JOIN `orderretailtranstable` c ON c.`id_order`=a.`id`
JOIN `sanitasdist`.`itemtable` d ON d.`id`=c.id_item
JOIN `sanitasdist`.`uomtable` e ON e.`id`=c.id_uom
WHERE a.`sms_flag`='new'
GROUP BY c.id_order

UNION ALL

SELECT a.`id`, 'retailer_order' AS order_from, 'orderretailtable' AS table_order, z.`handphone` AS detination, 'system' AS `sent_from`,
CONCAT('Kode Booking: ', a.code_booking, '|', GROUP_CONCAT(CONCAT(d.`name`,'|qty: ', c.qty,'', e.name),'||'))
    AS message
FROM `orderretailtable` a 
JOIN `distributortable` b ON b.`id`=a.`id_distributor`
JOIN `orderretailtranstable` c ON c.`id_order`=a.`id`
JOIN `sanitasdist`.`itemtable` d ON d.`id`=c.id_item
JOIN `sanitasdist`.`uomtable` e ON e.`id`=c.id_uom
LEFT JOIN `usertable` z ON z.id_region=b.id_region
WHERE a.`sms_flag`='new'
GROUP BY c.id_order

UNION ALL

SELECT a.`id`, 'retailer_order_update' AS order_from, 'orderretailtableupdate' AS table_order, b.`telephone` AS detination, 'system' AS `sent_from`,
CONCAT('Kode Booking: ', a.code_booking, '|', GROUP_CONCAT(CONCAT(d.`name`,'|qty: ', c.qty,'', e.name),'||'))
    AS message
FROM `orderretailtableupdate` a 
JOIN `retailtable` b ON b.`id`=a.`id_retail` 
JOIN `orderretailtranstableupdate` c ON c.`id_order`=a.`id`
JOIN `sanitasdist`.`itemtable` d ON d.`id`=c.id_item
JOIN `sanitasdist`.`uomtable` e ON e.`id`=c.id_uom
WHERE a.`sms_flag`='new'
GROUP BY c.id_order

UNION ALL

SELECT a.`id`, 'retailer_order_update' AS order_from, 'orderretailtableupdate' AS table_order, b.`telephone` AS detination, 'system' AS `sent_from`,
CONCAT('Kode Booking: ', a.code_booking, '|', GROUP_CONCAT(CONCAT(d.`name`,'|qty: ', c.qty,'', e.name),'||'))
    AS message
FROM `orderretailtableupdate` a 
JOIN `distributortable` b ON b.`id`=a.`id_distributor`
JOIN `orderretailtranstableupdate` c ON c.`id_order`=a.`id`
JOIN `sanitasdist`.`itemtable` d ON d.`id`=c.id_item
JOIN `sanitasdist`.`uomtable` e ON e.`id`=c.id_uom
WHERE a.`sms_flag`='new'
GROUP BY c.id_order

UNION ALL

SELECT a.`id`, 'retailer_order_update' AS order_from, 'orderretailtableupdate' AS table_order, z.`handphone` AS detination, 'system' AS `sent_from`,
CONCAT('Kode Booking: ', a.code_booking, '|', GROUP_CONCAT(CONCAT(d.`name`,'|qty: ', c.qty,'', e.name),'||'))
    AS message
FROM `orderretailtableupdate` a 
JOIN `distributortable` b ON b.`id`=a.`id_distributor`
JOIN `orderretailtranstableupdate` c ON c.`id_order`=a.`id`
JOIN `sanitasdist`.`itemtable` d ON d.`id`=c.id_item
JOIN `sanitasdist`.`uomtable` e ON e.`id`=c.id_uom
LEFT JOIN `usertable` z ON z.id_region=b.id_region
WHERE a.`sms_flag`='new'
GROUP BY c.id_order

UNION ALL

SELECT a.`id`, 'customer_order' AS order_from, 'ordertable' AS table_order, b.`telephone` AS detination, 'system' AS `sent_from`,
CONCAT('Kode Booking: ', a.code_booking, '|', GROUP_CONCAT(CONCAT(d.`name`,'|qty: ', c.qty,'', e.name),'||'))
    AS message
FROM `ordertable` a 
JOIN `custtable` b ON b.id=a.id_customer
JOIN `ordertranstable` c ON c.`id_order`=a.`id`
JOIN `sanitasdist`.`itemtable` d ON d.`id`=c.id_item
JOIN `sanitasdist`.`uomtable` e ON e.`id`=c.id_uom
WHERE a.`sms_flag`='new'
GROUP BY c.id_order

UNION ALL

SELECT a.`id`, 'customer_order' AS order_from, 'ordertable' AS table_order, b.`telephone` AS detination, 'system' AS `sent_from`,
CONCAT('Kode Booking: ', a.code_booking, '|', GROUP_CONCAT(CONCAT(d.`name`,'|qty: ', c.qty,'', e.name),'||'))
    AS message
FROM `ordertable` a 
JOIN `retailtable` b ON b.id=a.id_retail
JOIN `ordertranstable` c ON c.`id_order`=a.`id`
JOIN `sanitasdist`.`itemtable` d ON d.`id`=c.id_item
JOIN `sanitasdist`.`uomtable` e ON e.`id`=c.id_uom
WHERE a.`sms_flag`='new'
GROUP BY c.id_order

UNION ALL

SELECT a.`id`, 'customer_order' AS order_from, 'ordertable' AS table_order, z.`handphone` AS detination, 'system' AS `sent_from`,
CONCAT('Kode Booking: ', a.code_booking, '|', GROUP_CONCAT(CONCAT(d.`name`,'|qty: ', c.qty,'', e.name),'||'))
    AS message
FROM `ordertable` a 
JOIN `retailtable` b ON b.`id`=a.`id_retail`
JOIN `ordertranstable` c ON c.`id_order`=a.`id`
JOIN `sanitasdist`.`itemtable` d ON d.`id`=c.id_item
JOIN `sanitasdist`.`uomtable` e ON e.`id`=c.id_uom
LEFT JOIN `usertable` z ON z.id_region=b.id_region
WHERE a.`sms_flag`='new'
GROUP BY c.id_order

UNION ALL

SELECT a.`id`, 'customer_order_update' AS order_from, 'ordertableupdate' AS table_order, b.`telephone` AS detination, 'system' AS `sent_from`,
CONCAT('Kode Booking: ', a.code_booking, '|', GROUP_CONCAT(CONCAT(d.`name`,'|qty: ', c.qty,'', e.name),'||'))
    AS message
FROM `ordertableupdate` a 
JOIN `custtable` b ON b.id=a.id_customer
JOIN `ordertranstableupdate` c ON c.`id_order`=a.`id`
JOIN `sanitasdist`.`itemtable` d ON d.`id`=c.id_item
JOIN `sanitasdist`.`uomtable` e ON e.`id`=c.id_uom
WHERE a.`sms_flag`='new'
GROUP BY c.id_order

UNION ALL

SELECT a.`id`, 'customer_order_update' AS order_from, 'ordertableupdate' AS table_order, b.`telephone` AS detination, 'system' AS `sent_from`,
CONCAT('Kode Booking: ', a.code_booking, '|', GROUP_CONCAT(CONCAT(d.`name`,'|qty: ', c.qty,'', e.name),'||'))
    AS message
FROM `ordertableupdate` a 
JOIN `retailtable` b ON b.id=a.id_retail
JOIN `ordertranstableupdate` c ON c.`id_order`=a.`id`
JOIN `sanitasdist`.`itemtable` d ON d.`id`=c.id_item
JOIN `sanitasdist`.`uomtable` e ON e.`id`=c.id_uom
WHERE a.`sms_flag`='new'
GROUP BY c.id_order

UNION ALL

SELECT a.`id`, 'customer_order_update' AS order_from, 'ordertableupdate' AS table_order, z.`handphone` AS detination, 'system' AS `sent_from`,
CONCAT('Kode Booking: ', a.code_booking, '|', GROUP_CONCAT(CONCAT(d.`name`,'|qty: ', c.qty,'', e.name),'||'))
    AS message
FROM `ordertableupdate` a 
JOIN `retailtable` b ON b.`id`=a.`id_retail`
JOIN `ordertranstableupdate` c ON c.`id_order`=a.`id`
JOIN `sanitasdist`.`itemtable` d ON d.`id`=c.id_item
JOIN `sanitasdist`.`uomtable` e ON e.`id`=c.id_uom
LEFT JOIN `usertable` z ON z.id_region=b.id_region
WHERE a.`sms_flag`='new'
GROUP BY c.id_order";

$sqlInsert = "INSERT INTO `sms_outbox` (`trans_id`, `order_from`, `table_order`, `destination`, `sent_from`, `message`)
$sqlSelect";
$qInsert = $db['ret']->prepare($sqlInsert);
$qInsert->execute();

$select = $db['ret']->prepare($sqlSelect);
$select->execute();

while($dt = $select->fetch(PDO::FETCH_OBJ)) {
    $tableName = $dt->table_order;
    $update = $db['ret']->prepare("update ".$tableName." set send_status='new' where id='".$dt->id."'");
    $update->execute();
}

$outbox = $db['ret']->prepare("SELECT * FROM `sms_outbox` where send_status='new'");
$outbox->execute();
$arrId = array();
while($data = $outbox->fetch(PDO::FETCH_OBJ)) {
    if(!empty($data->destination)) {
        $arrId[] = $data->id;
        array_push(
            $senddata['datapacket'],array(
                'number' => trim($data->destination),
                'message' => str_replace("|","\n", $data->message),
                'sendingdatetime' => $data->date_time
            )
        );        
    }
}

$sms = new sms_class_masking_json();
$sms->setIp($ipserver);
$sms->setData($senddata);
$responjson = $sms->send();
$output = (array) json_decode($responjson);

$x = -1;
foreach ($output["sending_respon"][0]->datapacket as $dt) {
    $x++;
    $obj = $dt->packet;
    $number = $obj->number;            
    $sendingStatus = $obj->sendingstatus;
    $sendingInfo = $obj->sendingstatustext;
    $outboxId = $arrId[$x];

    $sent = "sent";
    if($sendingStatus > 10) {
        $sent = "failed";
    }

    $updatemsg = $db['ret']->prepare("update sms_outbox set send_status='".$sent."', sending_info='".$sendingInfo."' where id='".$outboxId."'");
    $updatemsg->execute();
    
}
$response = array("status" => "success");
echo json_encode($response);

?>
