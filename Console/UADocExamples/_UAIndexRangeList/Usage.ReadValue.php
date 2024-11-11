<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to read a range of values from an array.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.

$EndpointDescriptor = 
    //"http://opcua.demo-this.com:51211/UA/SampleServer";
    //"https://opcua.demo-this.com:51212/UA/SampleServer/";
    "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";

// Instantiate the client object
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");

// Prepare the arguments, indicating that just the elements 2 to 4 should be returned.
$IndexRangeList = new COM("OpcLabs.EasyOpc.UA.UAIndexRangeList");
$IndexRange = new COM("OpcLabs.EasyOpc.UA.UAIndexRange");
$IndexRange->Minimum = 2;
$IndexRange->Maximum = 4;
$IndexRangeList->Add($IndexRange);

$ReadArguments1 = new COM("OpcLabs.EasyOpc.UA.OperationModel.UAReadArguments");
$ReadArguments1->EndpointDescriptor->UrlString = $EndpointDescriptor;
$ReadArguments1->NodeDescriptor->NodeId->ExpandedText = "nsu=http://test.org/UA/Data/ ;ns=2;i=10305";
$ReadArguments1->IndexRangeList = $IndexRangeList;

$arguments[0] = $ReadArguments1;

// Obtain value.
$results = $Client->ReadMultipleValues($arguments);

$ValueResult = $results[0];

if (!$ValueResult->Succeeded) {
    printf("*** Failure: %s\n", $ValueResult->ErrorMessageBrief);
    Exit();
}

// Display results
$ArrayValue = $ValueResult->Value;
for ($i = 0; $i <= 2; $i++)
{
    printf("arrayValue[%d]: %s\n", $i, $ArrayValue[$i]);
}

// Example output:
//arrayValue[0]: 180410224
//arrayValue[1]: 1919239969
//arrayValue[2]: 1700185172

//#endregion Example
?>
