<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to write data (a value, timestamps and status code) into 3 nodes at once, test for success of each 
// write and display the exception message in case of failure.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

$GoodOrSuccess = 0;

// Instantiate the client object
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");

$StatusCode = new COM("OpcLabs.EasyOpc.UA.UAStatusCode");
$StatusCode->Severity = $GoodOrSuccess;

$WriteArguments1 = new COM("OpcLabs.EasyOpc.UA.OperationModel.UAWriteArguments");
$WriteArguments1->EndpointDescriptor->UrlString = 
    //"http://opcua.demo-this.com:51211/UA/SampleServer";
    //"https://opcua.demo-this.com:51212/UA/SampleServer/";
    "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";
$WriteArguments1->NodeDescriptor->NodeId->ExpandedText = "nsu=http://test.org/UA/Data/ ;i=10221";
$AttributeData1 = new COM("OpcLabs.EasyOpc.UA.UAAttributeData");
$AttributeData1->Value = 23456;
$AttributeData1->StatusCode = $StatusCode;
$AttributeData1->SourceTimestamp = (time() - 25569)/86400.0;	// works in PHP v5.6, does not work in PHP 7.3.10
$WriteArguments1->AttributeData = $AttributeData1;

$WriteArguments2 = new COM("OpcLabs.EasyOpc.UA.OperationModel.UAWriteArguments");
$WriteArguments2->EndpointDescriptor->UrlString = 
    //"http://opcua.demo-this.com:51211/UA/SampleServer";
    //"https://opcua.demo-this.com:51212/UA/SampleServer/";
    "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";
$WriteArguments2->NodeDescriptor->NodeId->ExpandedText = "nsu=http://test.org/UA/Data/ ;i=10226";
$AttributeData2 = new COM("OpcLabs.EasyOpc.UA.UAAttributeData");
$AttributeData2->Value = 2.3456789;
$AttributeData2->StatusCode = $StatusCode;
$AttributeData2->SourceTimestamp = (time() - 25569)/86400.0;	// works in PHP v5.6, does not work in PHP 7.3.10
$WriteArguments2->AttributeData = $AttributeData2;

$WriteArguments3 = new COM("OpcLabs.EasyOpc.UA.OperationModel.UAWriteArguments");
$WriteArguments3->EndpointDescriptor->UrlString = 
    //"http://opcua.demo-this.com:51211/UA/SampleServer";
    //"https://opcua.demo-this.com:51212/UA/SampleServer/";
    "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";
$WriteArguments3->NodeDescriptor->NodeId->ExpandedText = "nsu=http://test.org/UA/Data/ ;i=10227";
$AttributeData3 = new COM("OpcLabs.EasyOpc.UA.UAAttributeData");
$AttributeData3->Value = "ABC";
$AttributeData3->StatusCode = $StatusCode;
$AttributeData3->SourceTimestamp = (time() - 25569)/86400.0;	// works in PHP v5.6, does not work in PHP 7.3.10
$WriteArguments3->AttributeData = $AttributeData3;

$arguments[0] = $WriteArguments1;
$arguments[1] = $WriteArguments2;
$arguments[2] = $WriteArguments3;

// Modify data of nodes' attributes
$results = $Client->WriteMultiple($arguments);

// Display results
for ($i = 0; $i < count($results); $i++)
{
    $WriteResult = $results[$i];
    // The target server may not support this, and in such case failures will occur.
    if ($WriteResult->Succeeded)
        printf("Result %d success\n", $i);
    else
        printf("Result %d: %s \n", $i, $WriteResult->Exception->GetBaseException()->Message);
}

//#endregion Example
?>
