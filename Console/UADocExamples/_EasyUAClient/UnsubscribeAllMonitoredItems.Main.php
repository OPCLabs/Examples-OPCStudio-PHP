<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to unsubscribe from changes of all items.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.

class ClientEvents {
    function DataChangeNotification($Sender, $E)
    {
        // Display the data
        if ($E->Succeeded)
            printf("%s: %s\n", $E->Arguments->NodeDescriptor, $E->AttributeData);
        else
            printf("%s *** Failure: %s\n", $E->Arguments->NodeDescriptor, $E->ErrorMessageBrief);
    }
}

$EndpointDescriptor = 
    //"http://opcua.demo-this.com:51211/UA/SampleServer";
    //"https://opcua.demo-this.com:51212/UA/SampleServer/";
    "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";

// Instantiate the client object and hook events
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");
$ClientEvents = new ClientEvents();
com_event_sink($Client, $ClientEvents, "DEasyUAClientEvents");

printf("Subscribing...\n");
$MonitoringParameters = new COM("OpcLabs.EasyOpc.UA.UAMonitoringParameters");
$MonitoringParameters->SamplingInterval = 1000;
$MonitoredItemArguments1 = new COM("OpcLabs.EasyOpc.UA.OperationModel.EasyUAMonitoredItemArguments");
$MonitoredItemArguments1->EndpointDescriptor->UrlString = $EndpointDescriptor;
$MonitoredItemArguments1->NodeDescriptor->NodeId->ExpandedText = "nsu=http://test.org/UA/Data/ ;i=10845";
$MonitoredItemArguments1->MonitoringParameters = $MonitoringParameters;
$MonitoredItemArguments2 = new COM("OpcLabs.EasyOpc.UA.OperationModel.EasyUAMonitoredItemArguments");
$MonitoredItemArguments2->EndpointDescriptor->UrlString = $EndpointDescriptor;
$MonitoredItemArguments2->NodeDescriptor->NodeId->ExpandedText = "nsu=http://test.org/UA/Data/ ;i=10853";
$MonitoredItemArguments2->MonitoringParameters = $MonitoringParameters;
$MonitoredItemArguments3 = new COM("OpcLabs.EasyOpc.UA.OperationModel.EasyUAMonitoredItemArguments");
$MonitoredItemArguments3->EndpointDescriptor->UrlString = $EndpointDescriptor;
$MonitoredItemArguments3->NodeDescriptor->NodeId->ExpandedText = "nsu=http://test.org/UA/Data/ ;i=10855";
$MonitoredItemArguments3->MonitoringParameters = $MonitoringParameters;
$arguments[0] = $MonitoredItemArguments1;
$arguments[1] = $MonitoredItemArguments2;
$arguments[2] = $MonitoredItemArguments3;
$handleArray = $Client->SubscribeMultipleMonitoredItems($arguments);

for ($i = 0; $i < count($handleArray); $i++)
{
    printf("handleArray[%d]: %d\n", $i, $handleArray[$i]);
}

printf("Processing monitored item changed events for 10 seconds...\n");
$startTime = time(); do { com_message_pump(1000); } while (time() < $startTime + 10);

printf("Unsubscribing...\n");
$Client->UnsubscribeAllMonitoredItems;

printf("Waiting for 5 seconds...\n");
$startTime = time(); do { com_message_pump(1000); } while (time() < $startTime + 5);

//#endregion Example
?>
