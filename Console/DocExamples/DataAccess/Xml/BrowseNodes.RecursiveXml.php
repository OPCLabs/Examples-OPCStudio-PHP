<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to recursively browse the nodes in the OPC XML-DA address space.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.

$beginTime = microtime(true);
$branchCount = 0;
$leafCount = 0;

$ServerDescriptor = new COM("OpcLabs.EasyOpc.ServerDescriptor");
$ServerDescriptor->UrlString = "http://opcxml.demo-this.com/XmlDaSampleServer/Service.asmx";

$NodeDescriptor = new COM("OpcLabs.EasyOpc.DataAccess.DANodeDescriptor");
$NodeDescriptor->ItemID = "";

// Instantiate the client object.
$Client = new COM("OpcLabs.EasyOpc.DataAccess.EasyDAClient");

try
{
    BrowseFromNode($Client, $ServerDescriptor, $NodeDescriptor);
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
    Exit();
}

$endTime = microtime(true);

printf("\n");
printf("Browsing has taken (milliseconds): : %f\n", ($endTime - $beginTime) * 1000);
printf("Branch count: %d\n", $branchCount);
printf("Leaf count: %d\n", $leafCount);


function BrowseFromNode($Client, $ServerDescriptor, $ParentNodeDescriptor) : void
{
    global $branchCount, $leafCount;

    // Obtain all node elements under ParentNodeDescriptor
    $BrowseParameters = new COM("OpcLabs.EasyOpc.DataAccess.DABrowseParameters"); // no filtering whatsoever
    $NodeElementCollection = $Client->BrowseNodes($ServerDescriptor, $ParentNodeDescriptor,$BrowseParameters);
    // Remark: that BrowseNodes(...) may also throw OpcException; a production code should contain handling for 
    //it, here omitted for brevity.

    foreach ($NodeElementCollection as $NodeElement)
    {
        printf("%s\n", $NodeElement);

        // If the node is a branch, browse recursively into it.
        if ($NodeElement->IsBranch)
        {
            $branchCount = $branchCount + 1;
            BrowseFromNode($Client, $ServerDescriptor, $NodeElement->ToDANodeDescriptor());
        }
        else
        {
            $leafCount = $leafCount + 1;
        }
    }
}

//#endregion Example
?>
