<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to obtain all method nodes under a given node of the OPC-UA address space. 
// For each node, it displays its browse name and node ID.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

// Instantiate the client object
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");

// Perform the operation
try
{
    $NodeElements = $Client->BrowseMethods(
        //"http://opcua.demo-this.com:51211/UA/SampleServer", 
        "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer", 
        "nsu=http://test.org/UA/Data/ ;i=10755");
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
    Exit();
}


// Display results
foreach ($NodeElements as $NodeElement)
{
    printf("%s: %s\n", $NodeElement->BrowseName, $NodeElement->NodeId);
}

//#endregion Example
?>
