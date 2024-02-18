<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to write values into 3 items at once.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

$ItemValueArguments1 = new COM("OpcLabs.EasyOpc.DataAccess.OperationModel.DAItemValueArguments");
$ItemValueArguments1->ServerDescriptor->ServerClass = "OPCLabs.KitServer.2";
$ItemValueArguments1->ItemDescriptor->ItemID = "Simulation.Register_I4";
$ItemValueArguments1->Value = 23456;

$ItemValueArguments2 = new COM("OpcLabs.EasyOpc.DataAccess.OperationModel.DAItemValueArguments");
$ItemValueArguments2->ServerDescriptor->ServerClass = "OPCLabs.KitServer.2";
$ItemValueArguments2->ItemDescriptor->ItemID = "Simulation.Register_R8";
$ItemValueArguments2->Value = 2.34567890;

$ItemValueArguments3 = new COM("OpcLabs.EasyOpc.DataAccess.OperationModel.DAItemValueArguments");
$ItemValueArguments3->ServerDescriptor->ServerClass = "OPCLabs.KitServer.2";
$ItemValueArguments3->ItemDescriptor->ItemID = "Simulation.Register_BSTR";
$ItemValueArguments3->Value = "ABC";

$arguments[0] = $ItemValueArguments1;
$arguments[1] = $ItemValueArguments2;
$arguments[2] = $ItemValueArguments3;

$Client = new COM("OpcLabs.EasyOpc.DataAccess.EasyDAClient");
$results = $Client->WriteMultipleItemValues($arguments);

for ($i = 0; $i < count($results); $i++)
{
    $OperationResult = $results[$i];
    if ($OperationResult->Succeeded)
        printf("Result %d: success\n", $i);
    else
        printf("Result %d: %s\n", $i, $OperationResult->ErrorMessageBrief);
}

//#endregion Example
?>
