<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to subscribe to changes of a single monitored item, pull events, and display each change.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");
// In order to use event pull, you must set a non-zero queue capacity upfront.
$Client->PullDataChangeNotificationQueueCapacity = 1000;

print "Subscribing...\n";
$Client->SubscribeDataChange(
    //"http://opcua.demo-this.com:51211/UA/SampleServer", 
    "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer", 
    "nsu=http://test.org/UA/Data/ ;i=10853", 
    1000);

print "Processing data change events for 1 minute...\n";
$endTime = time() + 60;
do {
    $EventArgs = $Client->PullDataChangeNotification(2*1000);
    if (!is_null($EventArgs)) {
        // Handle the notification event
        print $EventArgs->ToString();
        print "\n";
    }
} while (time() < $endTime);

//#endregion Example
?>
