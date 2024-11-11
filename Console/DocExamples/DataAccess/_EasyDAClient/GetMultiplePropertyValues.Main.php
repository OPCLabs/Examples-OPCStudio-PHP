<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to get value of multiple OPC properties, and handle errors.
//
// Note that some properties may not have a useful value initially (e.g. until the item is activated in a group), which also the
// case with Timestamp property as implemented by the demo server. This behavior is server-dependent, and normal. You can run 
// IEasyDAClient.ReadMultipleItemValues.Main.vbs shortly before this example, in order to obtain better property values. Your 
// code may also subscribe to the items in order to assure that they remain active.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.

const Timestamp = 4;
const AccessRights = 5;

// Get the values of Timestamp and AccessRights properties of two items.

$PropertyArguments1 = new COM("OpcLabs.EasyOpc.DataAccess.OperationModel.DAPropertyArguments");
$PropertyArguments1->ServerDescriptor->ServerClass = "OPCLabs.KitServer.2";
$PropertyArguments1->NodeDescriptor->ItemID = "Simulation.Random";
$PropertyArguments1->PropertyDescriptor->PropertyID->NumericalValue = Timestamp;

$PropertyArguments2 = new COM("OpcLabs.EasyOpc.DataAccess.OperationModel.DAPropertyArguments");
$PropertyArguments2->ServerDescriptor->ServerClass = "OPCLabs.KitServer.2";
$PropertyArguments2->NodeDescriptor->ItemID = "Simulation.Random";
$PropertyArguments2->PropertyDescriptor->PropertyID->NumericalValue = AccessRights;

$PropertyArguments3 = new COM("OpcLabs.EasyOpc.DataAccess.OperationModel.DAPropertyArguments");
$PropertyArguments3->ServerDescriptor->ServerClass = "OPCLabs.KitServer.2";
$PropertyArguments3->NodeDescriptor->ItemID = "Trends.Ramp (1 min)";
$PropertyArguments3->PropertyDescriptor->PropertyID->NumericalValue = Timestamp;

$PropertyArguments4 = new COM("OpcLabs.EasyOpc.DataAccess.OperationModel.DAPropertyArguments");
$PropertyArguments4->ServerDescriptor->ServerClass = "OPCLabs.KitServer.2";
$PropertyArguments4->NodeDescriptor->ItemID = "Trends.Ramp (1 min)";
$PropertyArguments4->PropertyDescriptor->PropertyID->NumericalValue = AccessRights;

$arguments[0] = $PropertyArguments1;
$arguments[1] = $PropertyArguments2;
$arguments[2] = $PropertyArguments3;
$arguments[3] = $PropertyArguments4;

$Client = new COM("OpcLabs.EasyOpc.DataAccess.EasyDAClient");

$results = $Client->GetMultiplePropertyValues($arguments);

for ($i = 0; $i < count($results); $i++)
{
    $attributeDataResult = $results[$i];
    if ($results[$i]->Succeeded)
        printf("results[%d].Value: %s\n", $i, $results[$i]->Value);
    else
        printf("results[%d]: *** Failure: %s\n", $i, $results[$i]->ErrorMessageBrief);
}

//#endregion Example
?>
