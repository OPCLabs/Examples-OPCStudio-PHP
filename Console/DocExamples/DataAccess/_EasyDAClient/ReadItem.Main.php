<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to read a single item, and display its value, timestamp and quality.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

$Client = new COM("OpcLabs.EasyOpc.DataAccess.EasyDAClient");

try
{
    $Vtq = $Client->ReadItem("", "OPCLabs.KitServer.2", "Simulation.Random");
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
    Exit();
}

printf("Vtq: %s\n", $Vtq);

//#endregion Example
?>
