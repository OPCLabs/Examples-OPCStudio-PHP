<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to browse objects under the "Objects" node and display event sources.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.


// Start browsing from the "Objects" node
$ObjectNodeId = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$ObjectNodeId->StandardName = "Objects";
try
{
    BrowseFrom($ObjectNodeId);
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
    exit();
}

function BrowseFrom($NodeId) {
    $EndpointDescriptor = "opc.tcp://opcua.demo-this.com:62544/Quickstarts/AlarmConditionServer";

    printf("\n");
    printf("\n");
    printf("Parent node: %s\n", $NodeId);

    // Instantiate the client object
    $Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");

    // Obtain event sources
    $EventSourceNodeElements = $Client->BrowseEventSources($EndpointDescriptor, $NodeId->ExpandedText);

    // Display event sources
    if ($EventSourceNodeElements->Count != 0) {
        printf("\n");
        printf("Event sources:\n");
        foreach ($EventSourceNodeElements as $EventSourceNodeElement)
        {
             printf("%s\n", $EventSourceNodeElement);
        }
     }

    // Obtain objects
    $ObjectNodeElements = $Client->BrowseObjects($EndpointDescriptor, $NodeId->ExpandedText);

    // Recurse
    foreach ($ObjectNodeElements as $ObjectNodeElement)
    {
         BrowseFrom($ObjectNodeElement->NodeId);
    }
}

// Example output (truncated):
//
//
//Parent node: ObjectsFolder
//
//
//Parent node: Server
//
//Event sources:
//Green -> nsu=http://opcfoundation.org/Quickstarts/AlarmCondition ;ns=2;s=0:/Green (Object)
//Yellow -> nsu=http://opcfoundation.org/Quickstarts/AlarmCondition ;ns=2;s=0:/Yellow (Object)
//
//
//Parent node: Server_ServerCapabilities
//...

//#endregion Example
?>
