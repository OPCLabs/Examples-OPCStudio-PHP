<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// Attempts to parse a relative OPC-UA browse path and displays its elements.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

$BrowsePathElements = new COM("OpcLabs.EasyOpc.UA.Navigation.UABrowsePathElementCollection");

$BrowsePathParser = new COM("OpcLabs.EasyOpc.UA.Navigation.Parsing.UABrowsePathParser");

$StringParsingError = $BrowsePathParser->TryParseRelative("/Data.Dynamic.Scalar.CycleComplete", $BrowsePathElements);

// Display results
if (!is_null($StringParsingError)) {
    printf("*** Error: %s\n", $StringParsingError);
    exit();
}

printf("StartingNodeId: %s\n", $BrowsePath->StartingNodeId);

printf("Elements:\n");

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
