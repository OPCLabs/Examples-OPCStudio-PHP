<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// Parses a relative OPC-UA browse path and displays its elements.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .


$BrowsePathParser = new COM("OpcLabs.EasyOpc.UA.Navigation.Parsing.UABrowsePathParser");

try
{
    $BrowsePathElements = $BrowsePathParser->ParseRelative("/Data.Dynamic.Scalar.CycleComplete");
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
    exit();
}

// Display results
for ($i = 0; $i < $BrowsePathElements->Count; $i++)
{
    printf("%s\n", $BrowsePathElements[$i]);
}

// Example output:
// /Data
// .Dynamic
// .Scalar
// .CycleComplete

//#endregion Example
?>
