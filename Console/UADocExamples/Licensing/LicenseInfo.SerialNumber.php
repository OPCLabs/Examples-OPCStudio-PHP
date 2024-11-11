<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to obtain nodes under a given node of the OPC-UA address space. 
// Shows how to obtain the serial number of the active license, and determine whether it is a stock demo or trial license.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.

// Instantiate the client object
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");

// Obtain the serial number from the license info.
$SerialNumber = $Client->LicenseInfo["Multipurpose.SerialNumber"];

// Display the serial number.
printf("SerialNumber: %s\n", $SerialNumber);

// Determine whether we are running as demo or trial.
if ((1111110000 <= $SerialNumber) and ($SerialNumber <= 1111119999))
    printf("This is a stock demo or trial license.\n");
  else
    printf("This is not a stock demo or trial license.\n");

//#endregion Example
?>
