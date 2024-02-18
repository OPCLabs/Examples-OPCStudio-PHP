<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example demonstrates how to place the client certificate
// in the platform-specific (Windows, Linux, ...) certificate store.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .


// Obtain the application interface.
$Application = new COM("OpcLabs.EasyOpc.UA.Application.EasyUAApplication");

// Set the application certificate store path, which determines the location of the client certificate.
// Note that this only works once in each host process.
$Application->ApplicationParameters->ApplicationManifest->InstanceOwnStorePath = "CurrentUser\My";

// Do something - invoke an OPC read, to trigger creation of the certificate.
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");
try
{
    $value = $Client->ReadValue(
        //"http://opcua.demo-this.com:51211/UA/SampleServer", 
        "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer", 
        "nsu=http://test.org/UA/Data/ ;i=10853");
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
}

// The certificate will be located or created in the specified platform-specific certificate store.
// On Windows, when viewed by the certmgr.msc tool, it will be under
// Certificates - Current User -> Personal -> Certificates.

printf("Finished.\n");

//#endregion Example
?>
