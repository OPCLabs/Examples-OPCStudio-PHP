<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to let the user browse for an OPC-UA node.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.

$UAElementType_Host = 1;

$BrowseDialog = new COM("OpcLabs.EasyOpc.UA.Forms.Browsing.UABrowseDialog");
$BrowseDialog->InputsOutputs->CurrentNodeDescriptor->EndpointDescriptor->Host = "opcua.demo-this.com";
$BrowseDialog->Mode->AnchorElementType = $UAElementType_Host;

printf("%d\n", $BrowseDialog->ShowDialog);

// Display results
printf("%s\n", $BrowseDialog->Outputs->CurrentNodeElement->NodeElement);

//#endregion Example
?>
