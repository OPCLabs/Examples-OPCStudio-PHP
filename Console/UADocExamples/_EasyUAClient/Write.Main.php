<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to write data (a value, timestamps and status code) into a single attribute of a node.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

$GoodOrSuccess = 0;

// Instantiate the client object
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");

// Modify data of a node's attribute
$StatusCode = new COM("OpcLabs.EasyOpc.UA.UAStatusCode");
$StatusCode->Severity = $GoodOrSuccess;
$AttributeData = new COM("OpcLabs.EasyOpc.UA.UAAttributeData");
$AttributeData->Value = 12345;
$AttributeData->StatusCode = $StatusCode;
$AttributeData->SourceTimestamp = (time() - 25569)/86400.0;

// Perform the operation
try
{
    $Client->Write(
        //"http://opcua.demo-this.com:51211/UA/SampleServer", 
        "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer", 
        "nsu=http://test.org/UA/Data/ ;i=10221", 
        $AttributeData);
    // The target server may not support this, and in such case a failure will occur.
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
}

//#endregion Example
?>
