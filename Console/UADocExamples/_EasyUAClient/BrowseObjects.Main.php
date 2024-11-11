<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to obtain objects under the "Server" node
// in the address space.
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

// Instantiate the client object
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");

// Obtain variables under "Server" node
$ServerNodeId = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$ServerNodeId->StandardName = "Server";

try
{
    $NodeElements = $Client->BrowseObjects($EndpointDescriptor, $ServerNodeId->ExpandedText);
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
    exit();
}

// Display results
foreach ($NodeElements as $NodeElement)
{
    printf("\n");
    printf("nodeElement.NodeId: %s\n", $NodeElement->NodeId);
    printf("nodeElement.NodeId.ExpandedText: %s\n", $NodeElement->NodeId->ExpandedText);
    printf("nodeElement.DisplayName: %s\n", $NodeElement->DisplayName);
}

// Example output:
//
//nodeElement.NodeId: Server_ServerCapabilities
//nodeElement.NodeId.ExpandedText: nsu=http://opcfoundation.org/UA/ ;i=2268
//nodeElement.DisplayName: ServerCapabilities
//
//nodeElement.NodeId: Server_ServerDiagnostics
//nodeElement.NodeId.ExpandedText: nsu=http://opcfoundation.org/UA/ ;i=2274
//nodeElement.DisplayName: ServerDiagnostics
//
//nodeElement.NodeId: Server_VendorServerInfo
//nodeElement.NodeId.ExpandedText: nsu=http://opcfoundation.org/UA/ ;i=2295
//nodeElement.DisplayName: VendorServerInfo
//
//nodeElement.NodeId: Server_ServerRedundancy
//nodeElement.NodeId.ExpandedText: nsu=http://opcfoundation.org/UA/ ;i=2296
//nodeElement.DisplayName: ServerRedundancy
//
//nodeElement.NodeId: Server_Namespaces
//nodeElement.NodeId.ExpandedText: nsu=http://opcfoundation.org/UA/ ;i=11715
//nodeElement.DisplayName: Namespaces

//#endregion Example
?>
