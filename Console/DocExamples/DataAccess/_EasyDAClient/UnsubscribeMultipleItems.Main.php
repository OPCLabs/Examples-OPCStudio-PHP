<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to unsubscribe from changes of multiple items.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

class DEasyDAClientEvents {
    function ItemChanged($varSender, $varE)
    {
        if ($varE->Succeeded)
        {
            printf("%s: %s\n", $varE->Arguments->ItemDescriptor->ItemId, $varE->Vtq->ToString());
        }
        else
        {
            printf("*** Failure: %s\n", $varE->ErrorMessageBrief);
        }
    }
}

$ItemSubscriptionArguments1 = new COM("OpcLabs.EasyOpc.DataAccess.OperationModel.EasyDAItemSubscriptionArguments");
$ItemSubscriptionArguments1->ServerDescriptor->ServerClass = "OPCLabs.KitServer.2";
$ItemSubscriptionArguments1->ItemDescriptor->ItemID = "Simulation.Random";
$ItemSubscriptionArguments1->GroupParameters->RequestedUpdateRate = 1000;

$ItemSubscriptionArguments2 = new COM("OpcLabs.EasyOpc.DataAccess.OperationModel.EasyDAItemSubscriptionArguments");
$ItemSubscriptionArguments2->ServerDescriptor->ServerClass = "OPCLabs.KitServer.2";
$ItemSubscriptionArguments2->ItemDescriptor->ItemID = "Trends.Ramp (1 min)";
$ItemSubscriptionArguments2->GroupParameters->RequestedUpdateRate = 1000;

$ItemSubscriptionArguments3 = new COM("OpcLabs.EasyOpc.DataAccess.OperationModel.EasyDAItemSubscriptionArguments");
$ItemSubscriptionArguments3->ServerDescriptor->ServerClass = "OPCLabs.KitServer.2";
$ItemSubscriptionArguments3->ItemDescriptor->ItemID = "Trends.Sine (1 min)";
$ItemSubscriptionArguments3->GroupParameters->RequestedUpdateRate = 1000;

$ItemSubscriptionArguments4 = new COM("OpcLabs.EasyOpc.DataAccess.OperationModel.EasyDAItemSubscriptionArguments");
$ItemSubscriptionArguments4->ServerDescriptor->ServerClass = "OPCLabs.KitServer.2";
$ItemSubscriptionArguments4->ItemDescriptor->ItemID = "Simulation.Register_I4";
$ItemSubscriptionArguments4->GroupParameters->RequestedUpdateRate = 1000;

$arguments[0] = $ItemSubscriptionArguments1;
$arguments[1] = $ItemSubscriptionArguments2;
$arguments[2] = $ItemSubscriptionArguments3;
$arguments[3] = $ItemSubscriptionArguments4;

$Client = new COM("OpcLabs.EasyOpc.DataAccess.EasyDAClient");
$Events = new DEasyDAClientEvents();
com_event_sink($Client, $Events, "DEasyDAClientEvents");

print "Subscribing...\n";
$handleArray = $Client->SubscribeMultipleItems($arguments);

for ($i = 0; $i < count($handleArray); $i++)
{
    printf("handleArray[%d]: %s\n", $i, $handleArray[$i]);
}

print "Processing item changed events for 10 seconds...\n";
$startTime = time(); do { com_message_pump(1000); } while (time() < $startTime + 10);

print "Unsubscribing from two items...\n";
$handles1[0] = $handleArray[1];
$handles1[1] = $handleArray[2];
$Client->UnsubscribeMultipleItems($handles1);

print "Processing item changed events for 10 seconds...\n";
$startTime = time(); do { com_message_pump(1000); } while (time() < $startTime + 10);

print "Unsubscribing from all remaining items...\n";
$Client->UnsubscribeAllItems;

print "Waiting for 5 seconds...\n";
$startTime = time(); do { com_message_pump(1000); } while (time() < $startTime + 5);

//#endregion Example
?>
