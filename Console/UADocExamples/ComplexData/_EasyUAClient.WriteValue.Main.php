<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// Shows how to write complex data with OPC UA Complex Data plug-in.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

// Define which server and node we will work with.
$EndpointDescriptor = 
    //"http://opcua.demo-this.com:51211/UA/SampleServer";
    //"https://opcua.demo-this.com:51212/UA/SampleServer/";
    "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";
$NodeDescriptor = "nsu=http://test.org/UA/Data/ ;i=10239";  // [ObjectsFolder]/Data.Static.Scalar.StructureValue

// Instantiate the client object
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");

// Read a node which returns complex data.
// We know that this node returns complex data, so we can type cast to UAGenericObject.
printf("Reading...\n");

try
{
    $GenericObject = $Client->ReadValue($EndpointDescriptor, $NodeDescriptor);
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
    Exit();
}

// Modify the data read.
// This node returns one of the two data types, randomly (this is not common, usually the type is fixed). The
// data types are sub-types of one common type which the data type of the node. We therefore use the data type
// ID in the returned UAGenericObject to detect which data type has been returned.

// For processing the internals of the data, refer to examples for GenericData and DataType classes.
// We know how the data is structured, and have hard-coded a logic that modifies certain values inside. It is
// also possible to discover the structure of the data type in the program, and write generic clients that can
// cope with any kind of complex data.
//
// Note that the code below is not fully robust - it will throw an exception if the data is not as expected.

printf("Modifying...\n");
printf("%s\n", $GenericObject->DataTypeId);
$ScalarValueDataType = new COM("OpcLabs.EasyOpc.UA.UANodeDescriptor");
$ScalarValueDataType->NodeId->ExpandedText = "nsu=http://test.org/UA/Data/ ;i=9440"; // ScalarValueDataType
if ($GenericObject->DataTypeId->NodeDescriptor->Match($ScalarValueDataType)) {
    // Negate the byte in the "ByteValue" field.
    $StructuredData = $GenericObject->GenericData->AsStructuredData();
    $ByteValue = $StructuredData->FieldData["ByteValue"]->AsPrimitiveData();
    $ByteValue->Value = ~($ByteValue->Value) & 255;
    printf("%s\n", $ByteValue->Value);
}
else {
    $ArrayValueDataType = new COM("OpcLabs.EasyOpc.UA.UANodeDescriptor");
    $ArrayValueDataType->NodeId->ExpandedText = "nsu=http://test.org/UA/Data/ ;i=9669"; // ArrayValueDataType
    if ($GenericObject->DataTypeId->Nodedescriptor->Match($ArrayValueDataType)) {
        // Negate bytes at indexes 0 and 1 of the array in the "ByteValue" field.
        $StructuredData = $GenericObject->GenericData->AsStructuredData();
        $ByteValue2 = $StructuredData->FieldData["ByteValue"]->AsSequenceData();
        $Element0 = $ByteValue2->Elements[0]->AsPrimitiveData();
        $Element1 = $ByteValue2->Elements[1]->AsPrimitiveData();
        $Element0->Value = ~($Element0->Value) & 255;
        $Element1->Value = ~($Element1->Value) & 255;
        printf("%s\n", $Element0->Value);
        printf("%s\n", $Element1->Value);
    }
}

// Write the modified complex data back to the node.
// The data type ID in the UAGenericObject is borrowed without change from what we have read, so that the server
// knows which data type we are writing. The data type ID not necessary if writing precisely the same data type
// as the node has (not a subtype).
printf("Writing...\n");
try
{
    $Client->WriteValue($EndpointDescriptor, $NodeDescriptor, $GenericObject);
}
catch (com_exception $e)
{
    printf("Failure: %s\n", $e->getMessage());
    Exit();
}

//#endregion Example
?>
