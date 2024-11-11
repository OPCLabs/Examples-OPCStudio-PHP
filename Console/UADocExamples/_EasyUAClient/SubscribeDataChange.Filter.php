<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to subscribe to changes of a monitored item
// with data change filter.
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
            printf("%s\n", $E->AttributeData);
        else
            printf(" *** Failure: %s\n", $E->ErrorMessageBrief);
    }
}

const UADataChangeFilter_StatusValue = 1;

$EndpointDescriptor = new COM("OpcLabs.EasyOpc.UA.UAEndpointDescriptor");
$EndpointDescriptor->UrlString = 
    //"http://opcua.demo-this.com:51211/UA/SampleServer";
    //"https://opcua.demo-this.com:51212/UA/SampleServer/";
    "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";


// Instantiate the client object and hook events
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");
$ClientEvents = new ClientEvents();
com_event_sink($Client, $ClientEvents, "DEasyUAClientEvents");

// Prepare the arguments.
// Report a notification if either the StatusCode or the value change.
$DataChangeFilter = new COM("OpcLabs.EasyOpc.UA.UADataChangeFilter");
$DataChangeFilter->Trigger = UADataChangeFilter_StatusValue;
$MonitoringParameters = new COM("OpcLabs.EasyOpc.UA.UAMonitoringParameters");
$MonitoringParameters->DataChangeFilter = $DataChangeFilter;
$MonitoringParameters->SamplingInterval = 100;
$MonitoredItemArguments1 = new COM("OpcLabs.EasyOpc.UA.OperationModel.EasyUAMonitoredItemArguments");
$MonitoredItemArguments1->EndpointDescriptor->UrlString = $EndpointDescriptor;
$MonitoredItemArguments1->NodeDescriptor->NodeId->ExpandedText = "nsu=http://test.org/UA/Data/ ;i=10853";
$MonitoredItemArguments1->MonitoringParameters = $MonitoringParameters;
$arguments[0] = $MonitoredItemArguments1;

printf("Subscribing...\n");
$Client->SubscribeMultipleMonitoredItems($arguments);

printf("Processing monitored item changed events for 20 seconds...\n");
$startTime = time(); do { com_message_pump(1000); } while (time() < $startTime + 20);

printf("Unsubscribing...\n");
$Client->UnsubscribeAllMonitoredItems;

printf("Waiting for 5 seconds...\n");
$startTime = time(); do { com_message_pump(1000); } while (time() < $startTime + 5);

//#endregion Example
?>
