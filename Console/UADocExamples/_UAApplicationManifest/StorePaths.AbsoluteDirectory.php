<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example demonstrates how to configure the location of the certificate stores to directories specified by absolute
// paths.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.


// Obtain the application interface.
$Application = new COM("OpcLabs.EasyOpc.UA.Application.EasyUAApplication");

// Set the application certificate store paths.
// Note that this only works once in each host process.
// If this code is used in a Web application, make sure it is executed at the beginning of every page that can be used to 
// enter your application. You will most likely make it into a subroutine then.
$Application->ApplicationParameters->ApplicationManifest->InstanceIssuerStorePath =
    "C:\\MyCertificateStores\\UA Certificate Authorities";
$Application->ApplicationParameters->ApplicationManifest->InstanceOwnStorePath =
    "C:\\MyCertificateStores\\Machine Default";
$Application->ApplicationParameters->ApplicationManifest->InstanceTrustedStorePath =
    "C:\\MyCertificateStores\\UA Applications";
$Application->ApplicationParameters->ApplicationManifest->RejectedStorePath =
    "C:\\MyCertificateStores\\RejectedCertificates";

// Do something - invoke an OPC read, to trigger creation of the certificate.
// If you are doing server development: Instantiate and start the server here, instead of invoking the client.
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

printf("Finished.\n");

//#endregion Example
?>
