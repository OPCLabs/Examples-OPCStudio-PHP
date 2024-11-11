<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// Parses an absolute  OPC-UA browse path and displays its starting node and elements.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.


$BrowsePathParser = new COM("OpcLabs.EasyOpc.UA.Navigation.Parsing.UABrowsePathParser");

try
{
    $BrowsePath = $BrowsePathParser->Parse("[ObjectsFolder]/Data/Static/UserScalar");
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
    exit();
}

// Display results
printf("StartingNodeId: %s\n", $BrowsePath->StartingNodeId);

printf("Elements:\n");

for ($i = 0; $i < $BrowsePath->Elements->Count; $i++)
{
    printf("%s\n", $BrowsePath->Elements[$i]);
}

// Example output:
// StartingNodeId: ObjectsFolder
// Elements:
// /Data
// /Static
// /UserScalar

//#endregion Example
?>
