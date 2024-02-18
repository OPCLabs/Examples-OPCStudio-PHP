<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to read 4 items at once, and display their values, timestamps and qualities.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

$ReadItemArguments1 = new COM("OpcLabs.EasyOpc.DataAccess.OperationModel.DAReadItemArguments");
$ReadItemArguments1->ServerDescriptor->ServerClass = "OPCLabs.KitServer.2";
$ReadItemArguments1->ItemDescriptor->ItemID = "Simulation.Random";

$ReadItemArguments2 = new COM("OpcLabs.EasyOpc.DataAccess.OperationModel.DAReadItemArguments");
$ReadItemArguments2->ServerDescriptor->ServerClass = "OPCLabs.KitServer.2";
$ReadItemArguments2->ItemDescriptor->ItemID = "Trends.Ramp (1 min)";

$ReadItemArguments3 = new COM("OpcLabs.EasyOpc.DataAccess.OperationModel.DAReadItemArguments");
$ReadItemArguments3->ServerDescriptor->ServerClass = "OPCLabs.KitServer.2";
$ReadItemArguments3->ItemDescriptor->ItemID = "Trends.Sine (1 min)";

$ReadItemArguments4 = new COM("OpcLabs.EasyOpc.DataAccess.OperationModel.DAReadItemArguments");
$ReadItemArguments4->ServerDescriptor->ServerClass = "OPCLabs.KitServer.2";
$ReadItemArguments4->ItemDescriptor->ItemID = "Simulation.Register_I4";

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
