<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to read and display data of an attribute (value, timestamps, and status code).
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.

// Instantiate the client object
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");

// Obtain attribute data. By default, the Value attribute of a node will be read.
try
{
    $AttributeData = $Client->Read(
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
printf("Value: %s\n", $AttributeData->Value);
printf("ServerTimestamp: %s\n", $AttributeData->ServerTimestamp);
printf("SourceTimestamp: %s\n", $AttributeData->SourceTimestamp);
printf("StatusCode: %s\n", $AttributeData->StatusCode);

// Example output:
//
//Value: -2.230064E-31
//ServerTimestamp: 11/6/2011 1:34:30 PM
//SourceTimestamp: 11/6/2011 1:34:30 PM
//StatusCode: Good

//#endregion Example
?>
