<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// Shows how to subscribe to complex data with OPC UA Complex Data plug-in.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.

class ClientEvents {
    function DataChangeNotification($Sender, $E)
    {
        // Display value
        if ($E->Succeeded)
	    printf("Value: %s\n", $E->AttributeData->Value);
        else
	    printf("*** Failure : %s\n", $E->ErrorMessageBrief);
        // For processing the internals of the data, refer to examples for GenericData and DataType classes.
    }
}

// Define which server and node we will work with.
$EndpointDescriptor = 
    //"http://opcua.demo-this.com:51211/UA/SampleServer";
    //"https://opcua.demo-this.com:51212/UA/SampleServer/";
    "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";
$NodeDescriptor = "nsu=http://test.org/UA/Data/ ;i=10867";  // [ObjectsFolder]/Data.Dynamic.Scalar.StructureValue

// Instantiate the client object and hook events
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");
$ClientEvents = new ClientEvents();
com_event_sink($Client, $ClientEvents, "DEasyUAClientEvents");

// Subscribe to a node which returns complex data. This is done in the same way as regular subscribes - just
// the data returned is different.
printf("Subscribing...\n");
$Client->SubscribeDataChange($EndpointDescriptor, $NodeDescriptor, 1000);

printf("Processing data change events for 20 seconds...\n");
$startTime = time(); do { com_message_pump(1000); } while (time() < $startTime + 20);

printf("Unsubscribing...\n");
$Client->UnsubscribeAllMonitoredItems;

printf("Waiting for 5 seconds...\n");
$startTime = time(); do { com_message_pump(1000); } while (time() < $startTime + 5);

//#endregion Example
?>
