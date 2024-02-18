<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// Shows how to refresh own certificate stores using current trust lists
// for the application from the certificate manager.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

// Define which GDS we will work with.
$GdsEndpointDescriptor = new COM("OpcLabs.EasyOpc.UA.UAEndpointDescriptor");
$GdsEndpointDescriptor->UrlString = "opc.tcp://opcua.demo-this.com:58810/GlobalDiscoveryServer";
$GdsEndpointDescriptor->UserIdentity->UserNameTokenInfo->UserName = "appadmin";
$GdsEndpointDescriptor->UserIdentity->UserNameTokenInfo->Password = "demo";

// Obtain the application interface.
$Application = new COM("OpcLabs.EasyOpc.UA.Application.EasyUAApplication");

// Display which application we are about to work with.
printf("Application URI string: %s\n", $Application->GetApplicationElement->ApplicationUriString);

// Refresh own certificate stores using current trust lists for the application from the certificate manager.
try
{
    $RefreshedTrustLists = $Application->RefreshTrustLists($GdsEndpointDescriptor, true);
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
    exit();
}

// Display results
printf("Refreshed trust lists: %s\n", $RefreshedTrustLists);

//#endregion Example
?>
