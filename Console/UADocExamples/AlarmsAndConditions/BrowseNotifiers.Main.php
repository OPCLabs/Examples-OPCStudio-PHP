<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to browse objects under the "Objects" node and display notifiers.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .


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

    // Obtain notifiers
    $NotifierNodeElements = $Client->BrowseNotifiers($EndpointDescriptor, $NodeId->ExpandedText);

    // Display notifires
    if ($NotifierNodeElements->Count != 0) {
        printf("\n");
        printf("Notifiers:\n");
        foreach ($NotifierNodeElements as $NotifierNodeElement)
        {
             printf("%s\n", $NotifierNodeElement);
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
//Notifiers:
//Green -> nsu=http://opcfoundation.org/Quickstarts/AlarmCondition ;ns=2;s=0:/Green (Object)
//Yellow -> nsu=http://opcfoundation.org/Quickstarts/AlarmCondition ;ns=2;s=0:/Yellow (Object)
//
//
//Parent node: Server_ServerCapabilities
//...

//#endregion Example
?>
