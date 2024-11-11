<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to subscribe to events and display the event message with each notification. It also shows how to
// unsubscribe afterwards.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.

class DEasyEAClientEvents {
    function Notification($Sender, $E)
    {
        if (!($E->Succeeded))
        {
            printf("*** Failure: %s\n", $E->ErrorMessageBrief);
            Exit();
        }

        if (!is_null($E->EventData))
        {
            print $E->EventData->Message;
            print "\n";
        }
    }
}

$ServerDescriptor = new COM("OpcLabs.EasyOpc.ServerDescriptor");
$ServerDescriptor->ServerClass = "OPCLabs.KitEventServer.2";

$Client = new COM("OpcLabs.EasyOpc.AlarmsAndEvents.EasyAEClient");
$Events = new DEasyEAClientEvents();
com_event_sink($Client, $Events, "DEasyEAClientEvents");

print "Subscribing events...\n";
$SubscriptionParameters = new COM("OpcLabs.EasyOpc.AlarmsAndEvents.AESubscriptionParameters");
$SubscriptionParameters->NotificationRate = 1000;
$handle = $Client->SubscribeEvents($ServerDescriptor, $SubscriptionParameters, TRUE, NULL);

print "Processing event notifications for 1 minute...\n";
$startTime = time(); do { com_message_pump(1000); } while (time() < $startTime + 60);

print "Unsubscribing events...\n";
$Client->UnsubscribeEvents($handle);

print "Finished.\n";

//#endregion Example
?>
