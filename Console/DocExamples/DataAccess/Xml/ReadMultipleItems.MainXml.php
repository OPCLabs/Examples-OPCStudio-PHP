<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to read 4 items from an OPC XML-DA server at once, and display their values, timestamps 
// and qualities.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.

$ReadItemArguments1 = new COM("OpcLabs.EasyOpc.DataAccess.OperationModel.DAReadItemArguments");
$ReadItemArguments1->ServerDescriptor->UrlString = "http://opcxml.demo-this.com/XmlDaSampleServer/Service.asmx";
$ReadItemArguments1->ItemDescriptor->ItemID = "Dynamic/Analog Types/Double";

$ReadItemArguments2 = new COM("OpcLabs.EasyOpc.DataAccess.OperationModel.DAReadItemArguments");
$ReadItemArguments2->ServerDescriptor->UrlString = "http://opcxml.demo-this.com/XmlDaSampleServer/Service.asmx";
$ReadItemArguments2->ItemDescriptor->ItemID = "Dynamic/Analog Types/Double[]";

$ReadItemArguments3 = new COM("OpcLabs.EasyOpc.DataAccess.OperationModel.DAReadItemArguments");
$ReadItemArguments3->ServerDescriptor->UrlString = "http://opcxml.demo-this.com/XmlDaSampleServer/Service.asmx";
$ReadItemArguments3->ItemDescriptor->ItemID = "Dynamic/Analog Types/Int";

$ReadItemArguments4 = new COM("OpcLabs.EasyOpc.DataAccess.OperationModel.DAReadItemArguments");
$ReadItemArguments4->ServerDescriptor->UrlString = "http://opcxml.demo-this.com/XmlDaSampleServer/Service.asmx";
$ReadItemArguments4->ItemDescriptor->ItemID = "SomeUnknownItem";

$arguments[0] = $ReadItemArguments1;
$arguments[1] = $ReadItemArguments2;
$arguments[2] = $ReadItemArguments3;
$arguments[3] = $ReadItemArguments4;

$Client = new COM("OpcLabs.EasyOpc.DataAccess.EasyDAClient");

$results = $Client->ReadMultipleItems($arguments);

for ($i = 0; $i < count($results); $i++)
{
    $VtqResult = $results[$i];
    if ($VtqResult->Succeeded)
        printf("results[%d].Vtq.ToString(): %s\n", $i, $VtqResult->Vtq->ToString);
    else
        printf("results[%d]: *** Failure: %s\n", $i, $VtqResult->ErrorMessageBrief);
}

//#endregion Example
?>
