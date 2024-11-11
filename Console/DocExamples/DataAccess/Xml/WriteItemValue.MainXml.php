<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to write a value into a single OPC XML-DA item.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.

$ItemValueArguments1 = new COM("OpcLabs.EasyOpc.DataAccess.OperationModel.DAItemValueArguments");
$ItemValueArguments1->ServerDescriptor->UrlString = "http://opcxml.demo-this.com/XmlDaSampleServer/Service.asmx";
$ItemValueArguments1->ItemDescriptor->ItemID = "Static/Analog Types/Int";
$ItemValueArguments1->Value = 12345;

$arguments[0] = $ItemValueArguments1;

// Instantiate the client object.
$Client = new COM("OpcLabs.EasyOpc.DataAccess.EasyDAClient");

$results = $Client->WriteMultipleItemValues($arguments);

$OperationResult = $results[0];
if ($OperationResult->Succeeded)
    printf("Result: success\n");
else
    printf("Result: %s\n", $OperationResult->ErrorMessageBrief);

//#endregion Example
?>
