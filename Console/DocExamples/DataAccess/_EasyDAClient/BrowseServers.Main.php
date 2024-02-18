<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to obtain all ProgIDs of all OPC Data Access servers on the local machine.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

$Client = new COM("OpcLabs.EasyOpc.DataAccess.EasyDAClient");

try
{
    $ServerElements = $Client->BrowseServers("");
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
    Exit();
}

foreach ($ServerElements as $ServerElement)
{
    printf("ServerElements(\"%s\").ProgId: %s\n", $ServerElement->ClsidString, $ServerElement->ProgId);
}

//#endregion Example
?>
