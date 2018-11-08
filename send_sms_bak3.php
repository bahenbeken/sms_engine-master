<?php
require_once('lib/connection.php'); 
require_once('lib/api_sms_class_masking_json.php'); // class  
ob_start();
$apikey      = 'ed3ba2b2da009db572ee5d5bd78cf07a'; // api key 
$ipserver    = 'http://45.32.118.255'; // url server sms 
$callbackurl = ''; // url callback get status sms 
//$callbackurl = 'http://your_url_for_get_auto_update_status_sms'; // url callback get status sms 


/* send sms  */
$senddata = array(
    'apikey' => $apikey,  
    'callbackurl' => $callbackurl, 
    'datapacket'=>array()
);

$sqlSelect = "SELECT a.`id`, 'retailer_order' AS order_from, 'orderretailtable' AS table_order, b.`telephone` AS detination, 'system' AS `sent_from`,
CONCAT('ORDER ', b.`name`, ', Kode: ', a.code_booking, '|', GROUP_CONCAT(CONCAT(d.`name`,'|qty: ', c.qty,'', e.name),'||'))
    AS message
FROM `orderretailtable` a 
JOIN `retailtable` b ON b.`id`=a.`id_retail` 
JOIN `orderretailtranstable` c ON c.`id_order`=a.`id`
JOIN `sanitasDist`.`itemtable` d ON d.`id`=c.id_item
JOIN `sanitasDist`.`uomtable` e ON e.`id`=c.id_uom
WHERE a.`sms_flag`='new'
GROUP BY c.id_order

UNION ALL

SELECT a.`id`, 'retailer_order' AS order_from, 'orderretailtable' AS table_order, b.`telephone` AS detination, 'system' AS `sent_from`,
CONCAT('ORDER ', b.`name`,', Kode: ', a.code_booking, '|', GROUP_CONCAT(CONCAT(d.`name`,'|qty: ', c.qty,'', e.name),'||'))
    AS message
FROM `orderretailtable` a 
JOIN `distributortable` b ON b.`id`=a.`id_distributor`
JOIN `orderretailtranstable` c ON c.`id_order`=a.`id`
JOIN `sanitasDist`.`itemtable` d ON d.`id`=c.id_item
JOIN `sanitasDist`.`uomtable` e ON e.`id`=c.id_uom
WHERE a.`sms_flag`='new'
GROUP BY c.id_order

UNION ALL

SELECT a.`id`, 'retailer_order_update' AS order_from, 'orderretailtableupdate' AS table_order, b.`telephone` AS detination, 'system' AS `sent_from`,
CONCAT('UPDATE ORDER ', b.`name`,', Kode: ', a.code_booking, '|', GROUP_CONCAT(CONCAT(d.`name`,'|qty: ', c.qty,'', e.name),'||'))
    AS message
FROM `orderretailtableupdate` a 
JOIN `retailtable` b ON b.`id`=a.`id_retail` 
JOIN `orderretailtranstableupdate` c ON c.`id_order`=a.`id`
JOIN `sanitasDist`.`itemtable` d ON d.`id`=c.id_item
JOIN `sanitasDist`.`uomtable` e ON e.`id`=c.id_uom
WHERE a.`sms_flag`='new'
GROUP BY c.id_order

UNION ALL

SELECT a.`id`, 'retailer_order_update' AS order_from, 'orderretailtableupdate' AS table_order, b.`telephone` AS detination, 'system' AS `sent_from`,
CONCAT('UPDATE ORDER ', b.`name`, ', Kode: ', a.code_booking, '|', GROUP_CONCAT(CONCAT(d.`name`,'|qty: ', c.qty,'', e.name),'||'))
    AS message
FROM `orderretailtableupdate` a 
JOIN `distributortable` b ON b.`id`=a.`id_distributor`
JOIN `orderretailtranstableupdate` c ON c.`id_order`=a.`id`
JOIN `sanitasDist`.`itemtable` d ON d.`id`=c.id_item
JOIN `sanitasDist`.`uomtable` e ON e.`id`=c.id_uom
WHERE a.`sms_flag`='new'
GROUP BY c.id_order

UNION ALL

SELECT a.`id`, 'customer_order' AS order_from, 'ordertable' AS table_order, b.`telephone` AS detination, 'system' AS `sent_from`,
CONCAT('ORDER ', b.`name`, ', Kode: ', a.code_booking, '|', GROUP_CONCAT(CONCAT(d.`name`,'|qty: ', c.qty,'', e.name),'||'))
    AS message
FROM `ordertable` a 
JOIN `custtable` b ON b.id=a.id_customer
JOIN `ordertranstable` c ON c.`id_order`=a.`id`
JOIN `sanitasDist`.`itemtable` d ON d.`id`=c.id_item
JOIN `sanitasDist`.`uomtable` e ON e.`id`=c.id_uom
WHERE a.`sms_flag`='new'
GROUP BY c.id_order

UNION ALL

SELECT a.`id`, 'customer_order' AS order_from, 'ordertable' AS table_order, b.`telephone` AS detination, 'system' AS `sent_from`,
CONCAT('ORDER ', b.`name`, ', Kode: ', a.code_booking, '|', GROUP_CONCAT(CONCAT(d.`name`,'|qty: ', c.qty,'', e.name),'||'))
    AS message
FROM `ordertable` a 
JOIN `retailtable` b ON b.id=a.id_retail
JOIN `ordertranstable` c ON c.`id_order`=a.`id`
JOIN `sanitasDist`.`itemtable` d ON d.`id`=c.id_item
JOIN `sanitasDist`.`uomtable` e ON e.`id`=c.id_uom
WHERE a.`sms_flag`='new'
GROUP BY c.id_order

UNION ALL

SELECT a.`id`, 'customer_order_update' AS order_from, 'ordertableupdate' AS table_order, b.`telephone` AS detination, 'system' AS `sent_from`,
CONCAT('UPDATE ORDER ', b.`name`,', Kode: ', a.code_booking, '|', GROUP_CONCAT(CONCAT(d.`name`,'|qty: ', c.qty,'', e.name),'||'))
    AS message
FROM `ordertableupdate` a 
JOIN `custtable` b ON b.id=a.id_customer
JOIN `ordertranstableupdate` c ON c.`id_order`=a.`id`
JOIN `sanitasDist`.`itemtable` d ON d.`id`=c.id_item
JOIN `sanitasDist`.`uomtable` e ON e.`id`=c.id_uom
WHERE a.`sms_flag`='new'
GROUP BY c.id_order

UNION ALL

SELECT a.`id`, 'customer_order_update' AS order_from, 'ordertableupdate' AS table_order, b.`telephone` AS detination, 'system' AS `sent_from`,
CONCAT('UPDATE ORDER ', b.`name`,', Kode: ', a.code_booking, '|', GROUP_CONCAT(CONCAT(d.`name`,'|qty: ', c.qty,'', e.name),'||'))
    AS message
FROM `ordertableupdate` a 
JOIN `retailtable` b ON b.id=a.id_retail
JOIN `ordertranstableupdate` c ON c.`id_order`=a.`id`
JOIN `sanitasDist`.`itemtable` d ON d.`id`=c.id_item
JOIN `sanitasDist`.`uomtable` e ON e.`id`=c.id_uom
WHERE a.`sms_flag`='new'
GROUP BY c.id_order";

$sqlInsert = "INSERT INTO `sms_outbox` (`trans_id`, `order_from`, `table_order`, `destination`, `sent_from`, `message`)
$sqlSelect";
$qInsert = $db['ret']->prepare($sqlInsert);
$qInsert->execute();


$select = $db['ret']->prepare($sqlSelect);
$select->execute();

$z = 0;
while($dt = $select->fetch()) {
    $z++;
    $tableName = $dt['table_order'];
    $sqlUpdate = "update ".$tableName." set sms_flag='sent' where id='".$dt['id']."'";
    $update = $db['ret']->prepare($sqlUpdate);
    $sapi = $update->execute();
}


$outbox = $db['ret']->prepare("SELECT * FROM `sms_outbox` where send_status='new'");
$outbox->execute();
$arrId = array();

$y = 0;
while($data = $outbox->fetch(PDO::FETCH_OBJ)) {
    if(!empty($data->destination)) {
        $y++;
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
$w = 0;
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

    if($sent === "sent") {
        $w++;
    }

    $updatemsg = $db['ret']->prepare("update sms_outbox set send_status='".$sent."', sending_info='".$sendingInfo."' where id='".$outboxId."'");
    $updatemsg->execute();
    
}

$response = "total sms to process: ".$x.", total sms to outbox: ".$y.", total sms sent: ".$w;
echo $response;

?>
