<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to obtain all nodes under the "Simulation" branch of the address space. For each node, it displays
// whether the node is a branch or a leaf.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.

$ServerDescriptor = new COM("OpcLabs.EasyOpc.ServerDescriptor");
$ServerDescriptor->ServerClass = "OPCLabs.KitServer.2";

$NodeDescriptor = new COM("OpcLabs.EasyOpc.DataAccess.DANodeDescriptor");
$NodeDescriptor->ItemID = "Simulation";

$BrowseParameters = new COM("OpcLabs.EasyOpc.DataAccess.DABrowseParameters");

$Client = new COM("OpcLabs.EasyOpc.DataAccess.EasyDAClient");

try
{
    $NodeElements = $Client->BrowseNodes($ServerDescriptor, $NodeDescriptor, $BrowseParameters);
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
    Exit();
}

foreach ($NodeElements as $NodeElement)
{
    printf("NodeElements(\"%s\"):\n", $NodeElement->Name);
    printf("    .IsBranch: %s\n", $NodeElement->IsBranch ? 'true' : 'false');
    printf("    .IsLeaf: %s\n", $NodeElement->IsLeaf ? 'true' : 'false');
}

//#endregion Example
?>
