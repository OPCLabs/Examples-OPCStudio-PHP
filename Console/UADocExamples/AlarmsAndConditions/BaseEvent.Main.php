<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to display specific fields of incoming events that are derived from base event type.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.


class ClientEvents {
    function EventNotification($Sender, $E)
    {
        printf("\n");

        // Display the event
        if (is_null($E->EventData)) {
            printf("%s\n", $E);
            return;
        }

        $BaseEventObject = $E->EventData->BaseEvent;
        printf("Source name: %s\n", $BaseEventObject->SourceName);
        printf("Message: %s\n", $BaseEventObject->Message);
        printf("Severity: %s\n", $BaseEventObject->Severity);
    }
}

const UAObjectIds_Server = "nsu=http://opcfoundation.org/UA/;i=2253";

$EndpointDescriptor = "opc.tcp://opcua.demo-this.com:62544/Quickstarts/AlarmConditionServer";

// Instantiate the client object and hook events
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");
$ClientEvents = new ClientEvents();
com_event_sink($Client, $ClientEvents, "DEasyUAClientEvents");

printf("Subscribing...\n");
$Client->SubscribeEvent($EndpointDescriptor, UAObjectIds_Server, 1000);

printf("Processing event notifications for 30 seconds...\n");
$startTime = time(); do { com_message_pump(1000); } while (time() < $startTime + 30);

printf("Unsubscribing...\n");
$Client->UnsubscribeAllMonitoredItems;

printf("Waiting for 5 seconds...\n");
$startTime = time(); do { com_message_pump(1000); } while (time() < $startTime + 5);

//#endregion Example
?>
