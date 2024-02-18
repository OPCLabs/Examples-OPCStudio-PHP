<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to read the DataType attributes of 3 different nodes at
// once. Using the same method, it is also possible to read multiple attributes
// of the same node.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

const UAAttributeId_DataType = 14;

// Instantiate the client object
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");

$ReadArguments1 = new COM("OpcLabs.EasyOpc.UA.OperationModel.UAReadArguments");
$ReadArguments1->EndpointDescriptor->UrlString = 
    //"http://opcua.demo-this.com:51211/UA/SampleServer";
    //"https://opcua.demo-this.com:51212/UA/SampleServer/";
    "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";
$ReadArguments1->NodeDescriptor->NodeId->ExpandedText = "nsu=http://test.org/UA/Data/ ;i=10845";
$ReadArguments1->AttributeId = UAAttributeId_DataType;

$ReadArguments2 = new COM("OpcLabs.EasyOpc.UA.OperationModel.UAReadArguments");
$ReadArguments2->EndpointDescriptor->UrlString = 
    //"http://opcua.demo-this.com:51211/UA/SampleServer";
    //"https://opcua.demo-this.com:51212/UA/SampleServer/";
    "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";
$ReadArguments2->NodeDescriptor->NodeId->ExpandedText = "nsu=http://test.org/UA/Data/ ;i=10853";
$ReadArguments2->AttributeId = UAAttributeId_DataType;

$ReadArguments3 = new COM("OpcLabs.EasyOpc.UA.OperationModel.UAReadArguments");
$ReadArguments3->EndpointDescriptor->UrlString = 
    //"http://opcua.demo-this.com:51211/UA/SampleServer";
    //"https://opcua.demo-this.com:51212/UA/SampleServer/";
    "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";
$ReadArguments3->NodeDescriptor->NodeId->ExpandedText = "nsu=http://test.org/UA/Data/ ;i=10855";
$ReadArguments3->AttributeId = UAAttributeId_DataType;

$arguments[0] = $ReadArguments1;
$arguments[1] = $ReadArguments2;
$arguments[2] = $ReadArguments3;

// Obtain values. By default, the Value attributes of the nodes will be read.
$results = $Client->ReadMultipleValues($arguments);

// Display results
for ($i = 0; $i < count($results); $i++)
{
    $ValueResult = $results[$i];
    printf("\n");
    if ($ValueResult->Succeeded)
    {
        printf("Value: %s\n", $ValueResult->Value);
        printf("Value.ExpandedText: %s\n", $ValueResult->Value->ExpandedText);
        printf("Value.NamespaceUriString: %s\n", $ValueResult->Value->NamespaceUriString);
        printf("Value.NamespaceIndex: %s\n", $ValueResult->Value->NamespaceIndex);
        printf("Value.NumericIdentifier: %s\n", $ValueResult->Value->NumericIdentifier);
    }
    else
        printf("*** Failure: %s\n", $ValueResult->ErrorMessageBrief);
}

// Example output:
//
//
//Value: SByte
//Value.ExpandedText: nsu=http://opcfoundation.org/UA/;i=2
//Value.NamespaceUriString: http://opcfoundation.org/UA/
//Value.NamespaceIndex: 0
//Value.NumericIdentifier: 2
//
//Value: Float
//Value.ExpandedText: nsu=http://opcfoundation.org/UA/;i=10
//Value.NamespaceUriString: http://opcfoundation.org/UA/
//Value.NamespaceIndex: 0
//Value.NumericIdentifier: 10
//
//Value: String
//Value.ExpandedText: nsu=http://opcfoundation.org/UA/;i=12
//Value.NamespaceUriString: http://opcfoundation.org/UA/
//Value.NamespaceIndex: 0
//Value.NumericIdentifier: 12

//#endregion Example
?>
