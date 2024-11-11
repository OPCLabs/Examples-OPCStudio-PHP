<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to let the user browse for computers on the network.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.

$Dialog = new COM("OpcLabs.BaseLib.Forms.Browsing.Specialized.ComputerBrowserDialog");
printf("%d\n", $Dialog->ShowDialog);

// Display results
printf("%s\n", $Dialog->SelectedName);

//#endregion Example
?>
