<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// Parses a relative OPC-UA browse path and displays its elements.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.


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
