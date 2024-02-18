<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to read the Value attributes of 3 different nodes at once. Using the same method, it is also possible 
// to read multiple attributes of the same node.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

// Instantiate the client object
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");

$ReadArguments1 = new COM("OpcLabs.EasyOpc.UA.OperationModel.UAReadArguments");
$ReadArguments1->EndpointDescriptor->UrlString = 
    //"http://opcua.demo-this.com:51211/UA/SampleServer";
    //"https://opcua.demo-this.com:51212/UA/SampleServer/";
    "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";
$ReadArguments1->NodeDescriptor->NodeId->ExpandedText = "nsu=http://test.org/UA/Data/ ;i=10845";

$ReadArguments2 = new COM("OpcLabs.EasyOpc.UA.OperationModel.UAReadArguments");
$ReadArguments2->EndpointDescriptor->UrlString = "
    //"http://opcua.demo-this.com:51211/UA/SampleServer";
    //"https://opcua.demo-this.com:51212/UA/SampleServer/";
    "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";
$ReadArguments2->NodeDescriptor->NodeId->ExpandedText = "nsu=http://test.org/UA/Data/ ;i=10853";

$ReadArguments3 = new COM("OpcLabs.EasyOpc.UA.OperationModel.UAReadArguments");
$ReadArguments3->EndpointDescriptor->UrlString = 
    //"http://opcua.demo-this.com:51211/UA/SampleServer";
    //"https://opcua.demo-this.com:51212/UA/SampleServer/";
    "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";
$ReadArguments3->NodeDescriptor->NodeId->ExpandedText = "nsu=http://test.org/UA/Data/ ;i=10855";

$arguments[0] = $ReadArguments1;
$arguments[1] = $ReadArguments2;
$arguments[2] = $ReadArguments3;

// Obtain values. By default, the Value attributes of the nodes will be read.
$results = $Client->ReadMultipleValues($arguments);

// Display results
for ($i = 0; $i < count($results); $i++)
{
    $ValueResult = $results[$i];
    if ($ValueResult->Succeeded)
        printf("Value: %s\n", $ValueResult->Value);
    else
        printf("*** Failure: %s\n", $ValueResult->ErrorMessageBrief);
}

// Example output:
//
//Value: 8
//Value: -8.06803E+21
//Value: Strawberry Pig Banana Snake Mango Purple Grape Monkey Purple? Blueberry Lemon^            

//#endregion Example
?>
