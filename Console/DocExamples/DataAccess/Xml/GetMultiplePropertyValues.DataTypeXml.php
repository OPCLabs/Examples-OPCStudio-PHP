<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to obtain a data type of all OPC XML-DA items under a branch.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

const DABrowseFilter_Leaves = 3;
const DAPropertyIds_DataType = 1;

$ServerDescriptor = new COM("OpcLabs.EasyOpc.ServerDescriptor");
$ServerDescriptor->UrlString = "http://opcxml.demo-this.com/XmlDaSampleServer/Service.asmx";

$NodeDescriptor = new COM("OpcLabs.EasyOpc.DataAccess.DANodeDescriptor");
$NodeDescriptor->ItemID = "Static/Analog Types";

$BrowseParameters = new COM("OpcLabs.EasyOpc.DataAccess.DABrowseParameters");
$BrowseParameters->BrowseFilter = DABrowseFilter_Leaves;

$Client = new COM("OpcLabs.EasyOpc.DataAccess.EasyDAClient");

// Browse for all leaves under the "Static/Analog Types" branch
$NodeElementCollection = $Client->BrowseNodes($ServerDescriptor, $NodeDescriptor, $BrowseParameters)->ToList();

$PropertyArgumentArray = array();
for ($i = 0; $i < $NodeElementCollection->Count(); $i++)
{
    if (!($NodeElementCollection[$i]->IsHint)) // filter out hint leafs that do not represent real OPC items (rare)
    {
        $PropertyArguments = new COM("OpcLabs.EasyOpc.DataAccess.OperationModel.DAPropertyArguments");
        $PropertyArguments->ServerDescriptor = $ServerDescriptor;
        $PropertyArguments->NodeDescriptor = $NodeElementCollection[$i]->ToDANodeDescriptor();
        $PropertyArguments->PropertyDescriptor->PropertyId->InternalValue = DAPropertyIds_DataType;
        $PropertyArgumentArray[] = $PropertyArguments;
    }
}

// Get the value of DataType property; it is a 16-bit signed integer
$valueResultArray = $Client->GetMultiplePropertyValues($PropertyArgumentArray);

for ($i = 0; $i < count($valueResultArray); $i++)
{
    // Check if there has been an error getting the property value
    $valueResult = $valueResultArray[$i];
    if (!is_null($valueResult->Exception))
    {
        printf("[%s]: *** Failure: %s\n", $PropertyArgumentArray[$i]->NodeDescriptor->NodeId, $valueResults->Exception->Message);
        continue;
    }
    // Convert the data type to VarType
    $VarType = new COM("OpcLabs.BaseLib.ComInterop.VarType");
    $VarType->InternalValue = $valueResult->Value;

    // Display the obtained data type
    printf("[%s]: %s\n", $PropertyArgumentArray[$i]->NodeDescriptor->NodeId, $VarType);
}

//#endregion Example
?>
