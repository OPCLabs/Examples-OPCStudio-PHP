<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to obtain nodes under a given node of the OPC-UA address space. 
// For each node, it displays its browse name and node ID.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.

$EndpointDescriptor = new COM("OpcLabs.EasyOpc.UA.UAEndpointDescriptor");
$EndpointDescriptor->UrlString = 
    //"http://opcua.demo-this.com:51211/UA/SampleServer";
    //"https://opcua.demo-this.com:51212/UA/SampleServer/";
    "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";

$NodeDescriptor = new COM("OpcLabs.EasyOpc.UA.UANodeDescriptor");
$BrowsePathParser = new COM("OpcLabs.EasyOpc.UA.Navigation.Parsing.UABrowsePathParser");
$BrowsePathParser->DefaultNamespaceUriString = "http://test.org/UA/Data/";
$NodeDescriptor->BrowsePath = $BrowsePathParser->Parse("[ObjectsFolder]/Data/Static/UserScalar");

$BrowseParameters = new COM("OpcLabs.EasyOpc.UA.UABrowseParameters");
$BrowseParameters->StandardName = "AllForwardReferences";

// Instantiate the client object
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");

// Perform the operation
try
{
    $NodeElements = $Client->Browse($EndpointDescriptor, $NodeDescriptor, $BrowseParameters);
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
    exit();
}

// Display results
foreach ($NodeElements as $NodeElement)
{
    printf("%s: %s\n", $NodeElement->BrowseName, $NodeElement->NodeId);
}

//#endregion Example
?>
