<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to subscribe to changes of a single OPC XML-DA item and display the value of the item with each change.
//
// Some related documentation: http://php.net/manual/en/function.com-event-sink.php . Pay attention to the comment that says 
// "Be careful how you use this feature; if you are doing something similar to the example below, then it doesn't really make 
// sense to run it in a web server context.". What they are trying to say is that processing a web request should be 
// a short-lived code, which does not fit well with the idea of being subscribed to events and received them over longer time. 
// It is possible to write such code, but it is only useful when processing the request is allowed to take relatively long. Or, 
// when you are using PHP from command-line, or otherwise - not to serve a web page directly.
// 
// Subscribing to QuickOPC-COM events in the context of PHP Web application, while not imposing the limitations to the request 
// processing time, has to be "worked around", e.g. using the "event pull" mechanism.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.

class DEasyDAClientEvents {
    function ItemChanged($varSender, $varE)
    {
        if ($varE->Succeeded)
        {
	    print $varE->Vtq->ToString();
            print "\n";
        }
        else
        {
            printf("*** Failure: %s\n", $varE->ErrorMessageBrief);
        }
    }
}

$ItemSubscriptionArguments1 = new COM("OpcLabs.EasyOpc.DataAccess.OperationModel.EasyDAItemSubscriptionArguments");
$ItemSubscriptionArguments1->ServerDescriptor->UrlString = "http://opcxml.demo-this.com/XmlDaSampleServer/Service.asmx";
$ItemSubscriptionArguments1->ItemDescriptor->ItemID = "Dynamic/Analog Types/Int";
$ItemSubscriptionArguments1->GroupParameters->RequestedUpdateRate = 1000;

$arguments[0] = $ItemSubscriptionArguments1;

// Instantiate the client object.
$Client = new COM("OpcLabs.EasyOpc.DataAccess.EasyDAClient");
$Events = new DEasyDAClientEvents();
com_event_sink($Client, $Events, "DEasyDAClientEvents");

print "Subscribing...\n";
$handles = $Client->SubscribeMultipleItems($arguments);

print "Processing item changed events for 1 minute...\n";
$startTime = time(); do { com_message_pump(1000); } while (time() < $startTime + 60);

print "Unsubscribing...\n";
$Client->UnsubscribeAllItems;

print "Waiting for 5 seconds...\n";
$startTime = time(); do { com_message_pump(1000); } while (time() < $startTime + 5);

//#endregion Example
?>
