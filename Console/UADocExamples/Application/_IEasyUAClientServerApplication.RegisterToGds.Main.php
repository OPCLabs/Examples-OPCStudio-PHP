<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// Shows how to create an application registration in the GDS, assigning it a new application ID.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.

// Define which GDS we will work with.
$GdsEndpointDescriptor = new COM("OpcLabs.EasyOpc.UA.UAEndpointDescriptor");
$GdsEndpointDescriptor->UrlString = "opc.tcp://opcua.demo-this.com:58810/GlobalDiscoveryServer";
$GdsEndpointDescriptor->UserIdentity->UserNameTokenInfo->UserName = "appadmin";
$GdsEndpointDescriptor->UserIdentity->UserNameTokenInfo->Password = "demo";

// Obtain the application interface.
$Application = new COM("OpcLabs.EasyOpc.UA.Application.EasyUAApplication");

// Display which application we are about to work with.
printf("Application URI string: %s\n", $Application->GetApplicationElement->ApplicationUriString);

// Create an application registration in the GDS, assigning it a new application ID.
try
{
    $ApplicationId = $Application->RegisterToGds($GdsEndpointDescriptor);
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
    exit();
}

// Display results
printf("Application ID: %s\n", $ApplicationId);

//#endregion Example
?>
