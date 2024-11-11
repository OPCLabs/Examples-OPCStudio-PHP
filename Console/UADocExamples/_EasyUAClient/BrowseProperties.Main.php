<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to obtain properties under the "Server" node
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
    $NodeElements = $Client->BrowseProperties($EndpointDescriptor, $ServerNodeId->ExpandedText);
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
//nodeElement.NodeId: Server_ServerArray
//nodeElement.NodeId.ExpandedText: nsu=http://opcfoundation.org/UA/ ;i=2254
//nodeElement.DisplayName: ServerArray
//
//nodeElement.NodeId: Server_NamespaceArray
//nodeElement.NodeId.ExpandedText: nsu=http://opcfoundation.org/UA/ ;i=2255
//nodeElement.DisplayName: NamespaceArray
//
//nodeElement.NodeId: Server_ServiceLevel
//nodeElement.NodeId.ExpandedText: nsu=http://opcfoundation.org/UA/ ;i=2267
//nodeElement.DisplayName: ServiceLevel
//
//nodeElement.NodeId: Server_Auditing
//nodeElement.NodeId.ExpandedText: nsu=http://opcfoundation.org/UA/ ;i=2994
//nodeElement.DisplayName: Auditing

//#endregion Example
?>
