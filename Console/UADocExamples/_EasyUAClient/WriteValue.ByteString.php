<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to write a value into a single node that is of type ByteString.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

$Values[0] = 11;
$Values[1] = 22;
$Values[2] = 33;
$Values[3] = 44;
$Values[4] = 55;

// Instantiate the client object
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");

// Modify value of a node
try
{
    $Client->WriteValue(
        //"http://opcua.demo-this.com:51211/UA/SampleServer", 
        "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer", 
        "nsu=http://test.org/UA/Data/ ;i=10230", 
        $Values);
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
}

//#endregion Example
?>
