<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to read value of a single node, and display it.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

// Instantiate the client object
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");

// Perform the operation
try
{
    $value = $Client->ReadValue(
        //"http://opcua.demo-this.com:51211/UA/SampleServer", 
        "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer", 
        "nsu=http://test.org/UA/Data/ ;i=10853");
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
    Exit();
}


// Display results
printf("Value: %s\n", $value);

//#endregion Example
?>
