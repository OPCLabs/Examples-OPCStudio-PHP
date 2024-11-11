<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to read the attributes of 4 OPC-UA nodes specified by browse paths at once, and display the results.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.

$BrowsePathParser = new COM("OpcLabs.EasyOpc.UA.Navigation.Parsing.UABrowsePathParser");
$BrowsePathParser->DefaultNamespaceUriString = "http://test.org/UA/Data/";

$ReadArguments1 = new COM("OpcLabs.EasyOpc.UA.OperationModel.UAReadArguments");
$ReadArguments1->EndpointDescriptor->UrlString = 
    //"http://opcua.demo-this.com:51211/UA/SampleServer";
    //"https://opcua.demo-this.com:51212/UA/SampleServer/";
    "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";
$ReadArguments1->NodeDescriptor->BrowsePath = $BrowsePathParser->Parse("[ObjectsFolder]/Data/Dynamic/Scalar/FloatValue");

$ReadArguments2 = new COM("OpcLabs.EasyOpc.UA.OperationModel.UAReadArguments");
$ReadArguments2->EndpointDescriptor->UrlString = 
    //"http://opcua.demo-this.com:51211/UA/SampleServer";
    //"https://opcua.demo-this.com:51212/UA/SampleServer/";
    "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";
$ReadArguments2->NodeDescriptor->BrowsePath = $BrowsePathParser->Parse("[ObjectsFolder]/Data/Dynamic/Scalar/SByteValue");

$ReadArguments3 = new COM("OpcLabs.EasyOpc.UA.OperationModel.UAReadArguments");
$ReadArguments3->EndpointDescriptor->UrlString = 
    //"http://opcua.demo-this.com:51211/UA/SampleServer";
    //"https://opcua.demo-this.com:51212/UA/SampleServer/";
    "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";
$ReadArguments3->NodeDescriptor->BrowsePath = $BrowsePathParser->Parse("[ObjectsFolder]/Data/Static/Array/UInt16Value");

$ReadArguments4 = new COM("OpcLabs.EasyOpc.UA.OperationModel.UAReadArguments");
$ReadArguments4->EndpointDescriptor->UrlString = 
    //"http://opcua.demo-this.com:51211/UA/SampleServer";
    //"https://opcua.demo-this.com:51212/UA/SampleServer/";
    "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";
$ReadArguments4->NodeDescriptor->BrowsePath = $BrowsePathParser->Parse("[ObjectsFolder]/Data/Static/UserScalar/Int32Value");

$arguments[0] = $ReadArguments1;
$arguments[1] = $ReadArguments2;
$arguments[2] = $ReadArguments3;
$arguments[3] = $ReadArguments4;

// Instantiate the client object
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");

// Perform the operation
$results = $Client->ReadMultiple($arguments);

// Display results
for ($i = 0; $i < count($results); $i++)
{
    $attributeDataResult = $results[$i];
    if ($attributeDataResult->Succeeded)
        printf("results[%d].AttributeData: %s\n", $i, $attributeDataResult->AttributeData);
    else
        printf("results[%d]: *** Failure: %s\n", $i, $attributeDataResult->ErrorMessageBrief);
}

//#endregion Example
?>
