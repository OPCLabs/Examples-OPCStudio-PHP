<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to obtain application URLs of all OPC Unified Architecture servers on the specified host.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.

// Instantiate the client object
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");

// Obtain collection of server elements
try
{
    $DiscoveryElementCollection = $Client->DiscoverLocalServers("opcua.demo-this.com");
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
}

// Display results
foreach ($DiscoveryElementCollection as $DiscoveryElement)
{
    printf("DiscoveryElementCollection[\"%s\"].ApplicationUriString: %s\n", 
        $DiscoveryElement->DiscoveryUriString, $DiscoveryElement->ApplicationUriString);
}

//#endregion Example
?>
