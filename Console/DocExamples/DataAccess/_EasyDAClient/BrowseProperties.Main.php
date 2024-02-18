<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to enumerate all properties of an OPC item. For each property, it displays its Id and description.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

$ServerDescriptor = new COM("OpcLabs.EasyOpc.ServerDescriptor");
$ServerDescriptor->ServerClass = "OPCLabs.KitServer.2";

$NodeDescriptor = new COM("OpcLabs.EasyOpc.DataAccess.DANodeDescriptor");
$NodeDescriptor->ItemID = "Simulation.Random";

$Client = new COM("OpcLabs.EasyOpc.DataAccess.EasyDAClient");

try
{
    $PropertyElements = $Client->BrowseProperties($ServerDescriptor, $NodeDescriptor);
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
    Exit();
}

foreach ($PropertyElements as $PropertyElement)
{
    printf("PropertyElements(\"%s\").Description: %s\n", $PropertyElement->PropertyID->NumericalValue, $PropertyElement->Description);
}

//#endregion Example
?>
