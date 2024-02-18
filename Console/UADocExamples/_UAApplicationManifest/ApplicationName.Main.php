<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example demonstrates how to set the application name for the client certificate.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

class ClientManagementEvents {
    // Event handler for the LogEntry event.
    // Print the loggable entry containing client certificate parameters.
    function LogEntry($Sender, $E)
    {
        if ($E->EventId == 161)
            printf("%s\n", $E);
    }
}

// The management object allows access to static behavior - here, the
// shared LogEntry event.
$ClientManagement = new COM("OpcLabs.EasyOpc.UA.EasyUAClientManagement");
$ClientManagementEvents = new ClientManagementEvents();
com_event_sink($ClientManagement, $ClientManagementEvents, "DEasyUAClientManagementEvents");

// Obtain the application interface.
$Application = new COM("OpcLabs.EasyOpc.UA.Application.EasyUAApplication");

// Set the application name, which determines the subject of the client certificate.
// Note that this only works once in each host process.
$Application->ApplicationParameters->ApplicationManifest->ApplicationName = "QuickOPC - PHP example application";

// Do something - invoke an OPC read, to trigger some loggable entries.
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

// The certificate will be located or created in a directory similar to:
// C:\ProgramData\OPC Foundation\CertificateStores\MachineDefault\certs
// and its subject will be as given by the application name.

printf("Processing log entry events for 10 seconds...");
$startTime = time(); do { com_message_pump(1000); } while (time() < $startTime + 10);

printf("Finished.\n");

//#endregion Example
?>
