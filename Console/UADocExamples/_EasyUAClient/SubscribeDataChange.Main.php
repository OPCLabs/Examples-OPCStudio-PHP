<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to subscribe to changes of a single monitored item and display each change.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

class ClientEvents {
    function DataChangeNotification($Sender, $E)
    {
        // Display the data
        if ($E->Succeeded)
	    printf("%s\n", $E->AttributeData);
        else
	    printf("*** Failure : %s\n", $E->ErrorMessageBrief);
    }
}



// Instantiate the client object and hook events
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");
$ClientEvents = new ClientEvents();
com_event_sink($Client, $ClientEvents, "DEasyUAClientEvents");

printf("Subscribing...\n");
$Client->SubscribeDataChange(
    //"http://opcua.demo-this.com:51211/UA/SampleServer", 
    "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer", 
   "nsu=http://test.org/UA/Data/ ;i=10853", 
    1000);

printf("Processing monitored item changed events for 1 minute...\n");
$startTime = time(); do { com_message_pump(1000); } while (time() < $startTime + 60);

//#endregion Example
?>
