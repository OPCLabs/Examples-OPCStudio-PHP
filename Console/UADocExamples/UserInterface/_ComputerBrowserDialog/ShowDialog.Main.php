<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to let the user browse for computers on the network.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

$Dialog = new COM("OpcLabs.BaseLib.Forms.Browsing.Specialized.ComputerBrowserDialog");
printf("%d\n", $Dialog->ShowDialog);

// Display results
printf("%s\n", $Dialog->SelectedName);

//#endregion Example
?>
