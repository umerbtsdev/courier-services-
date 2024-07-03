<?php

$client = new SoapClient("http://webapp.tcscourier.com:8089/Sentiments-OMS-API/SentimentsOMS.asmx?wsdl");
$parameters['consignmentNo'] = '9120008';
$parameters['bookingDate'] = '2018-03-05';
$parameters['customerAccountNo'] = '1156';
$parameters['CUS_NAM'] = 'Saba Masood';
$parameters['CUS_ADDR1'] = 'House 14, Street 2, Airforce';
$parameters['CUS_ADDR2'] ='';
$parameters['CUS_ADDR3'] = 'Karachi';
$parameters['CUS_PHN'] = '+923352420896';
$parameters['CUS_Email'] = 'hania.masood1@gmail.com';
$parameters['CNSGEE_ADDR1'] = 'House 14, Street 2, Airforce';
$parameters['CNSGEE_ADDR2'] = '';
$parameters['CNSGEE_ADDR3'] = 'Karachi';
$parameters['CNSGEE_PHN'] = '+923352420896';
$parameters['serviceNo'] = 'O';
$parameters['prod_No'] = 'S';
$parameters['origin'] = 'KHI';
$parameters['des'] = 'KHI';          
$parameters['bookingstaff_No'] = '7238';  
$parameters['route_No'] = '1'; 
$parameters['amount_Cal'] = '0.00'; 
$parameters['ot_srvs_amt'] = '0.00';  
$parameters['handlingCharges'] = '0.00';  
$parameters['othercharges'] = '0.00';  
$parameters['amount'] = '0.00';   
$parameters['partner_Amt'] = '0.00';   
$parameters['part_Comm'] = '0.00';   
$parameters['handlingInstruction'] = '';   
$parameters['excise'] = '0.00';             
$parameters['cnsg_val'] = '0.00';            
$parameters['insurance_Amt'] = '0.00';            

$consignment_data = $client->InsertTrackData($parameters);

var_dump($consignment_data);