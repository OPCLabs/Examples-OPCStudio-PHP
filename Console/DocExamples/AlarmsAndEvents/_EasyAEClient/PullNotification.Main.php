<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to subscribe to events and obtain the notification events by pulling them.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

$ServerDescriptor = new COM("OpcLabs.EasyOpc.ServerDescriptor");
$ServerDescriptor->ServerClass = "OPCLabs.KitEventServer.2";

$Client = new COM("OpcLabs.EasyOpc.AlarmsAndEvents.EasyAEClient");
// In order to use event pull, you must set a non-zero queue capacity upfront.
$Client->PullNotificationQueueCapacity = 1000;

print "Subscribing events...\n";
$SubscriptionParameters = new COM("OpcLabs.EasyOpc.AlarmsAndEvents.AESubscriptionParameters");
$SubscriptionParameters->NotificationRate = 1000;
$handle = $Client->SubscribeEvents($ServerDescriptor, $SubscriptionParameters, TRUE, NULL);

print "Processing event notifications for 1 minute...\n";
$endTime = time() + 60;
do {
    $EventArgs = $Client->PullNotification(2*1000);
    if (!is_null($EventArgs)) {
        // Handle the notification event
        print $EventArgs->ToString();
        print "\n";
    }
} while (time() < $endTime);

print "Unsubscribing events...\n";
$Client->UnsubscribeEvents($handle);

print "Finished.\n";

//#endregion Example
?>
