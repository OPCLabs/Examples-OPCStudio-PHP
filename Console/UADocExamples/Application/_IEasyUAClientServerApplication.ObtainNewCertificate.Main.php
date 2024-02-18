<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// Shows how to obtain a new application certificate from the certificate manager (GDS),
// and store it for subsequent usage.
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
$ApplicationElement = $Application->GetApplicationElement;
printf("Application URI string: %s\n", $Application->GetApplicationElement->ApplicationUriString);

// Obtain a new application certificate from the certificate manager (GDS), and store it for subsequent usage.
$Arguments = new COM("OpcLabs.EasyOpc.UA.Application.UAObtainCertificateArguments");
$Arguments->Parameters->GdsEndpointDescriptor = $GdsEndpointDescriptor;

try
{
    $Certificate = $Application->ObtainNewCertificate($Arguments);
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
    exit();
}

// Display results
printf("Certificate: %s\n", $Certificate);

//#endregion Example
?>
