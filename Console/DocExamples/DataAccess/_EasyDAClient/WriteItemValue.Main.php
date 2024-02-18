<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to write a value into a single item.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

$Client = new COM("OpcLabs.EasyOpc.DataAccess.EasyDAClient");

try
{
    $value = $Client->WriteItemValue("", "OPCLabs.KitServer.2", "Simulation.Register_I4", 12345);
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
    Exit();
}

//#endregion Example
?>
