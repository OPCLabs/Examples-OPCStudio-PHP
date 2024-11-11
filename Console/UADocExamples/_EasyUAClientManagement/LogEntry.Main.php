<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example demonstrates the loggable entries originating in the OPC-UA client engine and the EasyUAClient component.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.

class ClientManagementEvents {
    // Event handler for the LogEntry event. It simply prints out the event.
    function LogEntry($Sender, $E)
    {
	printf("%s\n", $E);
    }
}



// The management object allows access to static behavior - here, the shared LogEntry event.
$ClientManagement = new COM("OpcLabs.EasyOpc.UA.EasyUAClientManagement");
$ClientManagementEvents = new ClientManagementEvents();
com_event_sink($ClientManagement, $ClientManagementEvents, "DEasyUAClientManagementEvents");

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
    Exit();
}


printf("Processing log entry events for 1 minute...");
$startTime = time(); do { com_message_pump(1000); } while (time() < $startTime + 60);

//#endregion Example
?>
