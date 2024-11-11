<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to subscribe to OPC XML-DA item changes and obtain the events by pulling them.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.

$ItemSubscriptionArguments1 = new COM("OpcLabs.EasyOpc.DataAccess.OperationModel.EasyDAItemSubscriptionArguments");
$ItemSubscriptionArguments1->ServerDescriptor->UrlString = "http://opcxml.demo-this.com/XmlDaSampleServer/Service.asmx";
$ItemSubscriptionArguments1->ItemDescriptor->ItemID = "Dynamic/Analog Types/Int";
$ItemSubscriptionArguments1->GroupParameters->RequestedUpdateRate = 1000;

$arguments[0] = $ItemSubscriptionArguments1;

// Instantiate the client object.
$Client = new COM("OpcLabs.EasyOpc.DataAccess.EasyDAClient");
// In order to use event pull, you must set a non-zero queue capacity upfront.
$Client->PullItemChangedQueueCapacity = 1000;

print "Subscribing item changes...\n";
$Client->SubscribeMultipleItems($arguments);

print "Processing item changed events for 1 minute...\n";
$endTime = time() + 60;
do {
    $EventArgs = $Client->PullItemChanged(2*1000);
    if (!is_null($EventArgs)) {
        // Handle the notification event
        print $EventArgs->ToString();
        print "\n";
    }
} while (time() < $endTime);

//#endregion Example
?>
