<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to write a value into a single node, specifying a type code explicitly.
//
// Reasons for specifying the type explicitly might be:
// - The data type in the server has subtypes, and the client therefore needs to pick the subtype to be written.
// - The data type that the reports is incorrect.
// - Writing with an explicitly specified type is more efficient.
//
// TypeCode is easy to use, but it does not cover all possible types. It is also possible
// to specify the .NET Type, using a different overload of the WriteValue method.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

const TypeCode_Int32 = 9;

$EndpointDescriptor = 
    //"http://opcua.demo-this.com:51211/UA/SampleServer";
    //"https://opcua.demo-this.com:51212/UA/SampleServer/";
    "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";

// Prepare the arguments
$WriteValueArguments1 = new COM("OpcLabs.EasyOpc.UA.OperationModel.UAWriteValueArguments");
$WriteValueArguments1->EndpointDescriptor->UrlString = $EndpointDescriptor;
$WriteValueArguments1->NodeDescriptor->NodeId->ExpandedText = "nsu=http://test.org/UA/Data/ ;i=10221";
$WriteValueArguments1->Value = 12345;
$WriteValueArguments1->ValueTypeCode = TypeCode_Int32;    // here is the type explicitly specified

$arguments[0] = $WriteValueArguments1;

// Instantiate the client object
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");

// Modify value of node
$results = $Client->WriteMultipleValues($arguments);

$WriteResult = $results[0];
if (!$WriteResult->Succeeded)
    printf("*** Failure: %s\n", $WriteResult->Exception->GetBaseException()->Message);

//#endregion Example
?>
