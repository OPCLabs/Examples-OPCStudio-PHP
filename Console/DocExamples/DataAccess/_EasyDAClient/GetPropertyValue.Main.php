<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to get a value of a single OPC property.
//
// Note that some properties may not have a useful value initially (e.g. until the item is activated in a group), which also the
// case with Timestamp property as implemented by the demo server. This behavior is server-dependent, and normal. You can run 
// IEasyDAClient.ReadItemValue.Main.vbs shortly before this example, in order to obtain better property values. Your code may 
// also subscribe to the item in order to assure that it remains active.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

const Timestamp = 4;

$Client = new COM("OpcLabs.EasyOpc.DataAccess.EasyDAClient");

try
{
    $value = $Client->GetPropertyValue("", "OPCLabs.KitServer.2", "Simulation.Random", Timestamp);
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
    Exit();
}

printf("%s\n", $value);

//#endregion Example
?>
