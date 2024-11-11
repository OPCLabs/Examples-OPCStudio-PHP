<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to subscribe to all dataset messages on an OPC-UA PubSub connection with UDP UADP mapping.
//
// In order to produce network messages for this example, run the UADemoPublisher tool. For documentation, see
// https://kb.opclabs.com/UADemoPublisher_Basics . In some cases, you may have to specify the interface name to be used.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.

class SubscriberEvents {
    function DataSetMessage($Sender, $E)
    {
        // Display the dataset.
		if ($E->Succeeded) {
			// An event with null DataSetData just indicates a successful connection.
			printf("\n");
			printf("Dataset data: %s\n", $E->DataSetData);
			foreach ($E->DataSetData->FieldDataDictionary as $Pair)
				printf("%s\n", $Pair);
		}
		else {
			printf("\n");
			printf("*** Failure: %s\n", $E->ErrorMessageBrief);
		}
    }
}



// Define the PubSub connection we will work with.
$SubscribeDataSetArguments = new COM("OpcLabs.EasyOpc.UA.PubSub.OperationModel.EasyUASubscribeDataSetArguments");
$ConnectionDescriptor = $SubscribeDataSetArguments->DataSetSubscriptionDescriptor->ConnectionDescriptor;
$ConnectionDescriptor->ResourceAddress->ResourceDescriptor->UrlString = "opc.udp://239.0.0.1";
// In some cases you may have to set the interface (network adapter) name that needs to be used, similarly to
// the statement below. Your actual interface name may differ, of course.
//$ConnectionDescriptor->ResourceAddress->InterfaceName = "Ethernet";

// Instantiate the subscriber object and hook events.
$Subscriber = new COM("OpcLabs.EasyOpc.UA.PubSub.EasyUASubscriber");
$SubscriberEvents = new SubscriberEvents();
com_event_sink($Subscriber, $SubscriberEvents, "DEasyUASubscriberEvents");

printf("Subscribing...\n");
$Subscriber->SubscribeDataSet($SubscribeDataSetArguments);

printf("Processing dataset message events for 20 seconds...");
$startTime = time(); 
do { 
	com_message_pump(1000); 
} while (time() < $startTime + 20);

printf("Unsubscribing...\n");
$Subscriber->UnsubscribeAllDataSets;

printf("Waiting for 1 second...");
// Unsubscribe operation is asynchronous, messages may still come for a short while.
$startTime = time(); 
do { 
	com_message_pump(1000); 
} while (time() < $startTime + 1);

printf("Finished.\n");



// Example output:
//
//Subscribing...
//Processing dataset message events for 20 seconds...
//
////Dataset data: Good; Data; publisher="32", writer=1, class=eae79794-1af7-4f96-8401-4096cd1d8908, fields: 4
//[#0, True {System.Boolean} @0001-01-01T00:00:00.000 @@0001-01-01T00:00:00.000; Good]
//[#1, 7945 {System.Int32} @0001-01-01T00:00:00.000 @@0001-01-01T00:00:00.000; Good]
//[#2, 5246 {System.Int32} @0001-01-01T00:00:00.000 @@0001-01-01T00:00:00.000; Good]
//[#3, 9/30/2019 11:19:14 AM {System.DateTime} @0001-01-01T00:00:00.000 @@0001-01-01T00:00:00.000; Good]
//
//Dataset data: Good; Data; publisher="32", writer=3, class=96976b7b-0db7-46c3-a715-0979884b55ae, fields: 100
//[#0, 45 {System.Int64} @0001-01-01T00:00:00.000 @@0001-01-01T00:00:00.000; Good]
//[#1, 145 {System.Int64} @0001-01-01T00:00:00.000 @@0001-01-01T00:00:00.000; Good]
//[#2, 245 {System.Int64} @0001-01-01T00:00:00.000 @@0001-01-01T00:00:00.000; Good]
//[#3, 345 {System.Int64} @0001-01-01T00:00:00.000 @@0001-01-01T00:00:00.000; Good]
//[#4, 445 {System.Int64} @0001-01-01T00:00:00.000 @@0001-01-01T00:00:00.000; Good]
//[#5, 545 {System.Int64} @0001-01-01T00:00:00.000 @@0001-01-01T00:00:00.000; Good]
//[#6, 645 {System.Int64} @0001-01-01T00:00:00.000 @@0001-01-01T00:00:00.000; Good]
//[#7, 745 {System.Int64} @0001-01-01T00:00:00.000 @@0001-01-01T00:00:00.000; Good]
//[#8, 845 {System.Int64} @0001-01-01T00:00:00.000 @@0001-01-01T00:00:00.000; Good]
//[#9, 945 {System.Int64} @0001-01-01T00:00:00.000 @@0001-01-01T00:00:00.000; Good]
//[#10, 1045 {System.Int64} @0001-01-01T00:00:00.000 @@0001-01-01T00:00:00.000; Good]
//...

//#endregion Example
?>
