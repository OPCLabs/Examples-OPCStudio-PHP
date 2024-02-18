<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to call a single method, and pass arguments to and from it.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

$inputs[0] = false;
$inputs[1] = 1;
$inputs[2] = 2;
$inputs[3] = 3;
$inputs[4] = 4;
$inputs[5] = 5;
$inputs[6] = 6;
$inputs[7] = 7;
$inputs[8] = 8;
$inputs[9] = 9;
$inputs[10] = 10;

$typeCodes[0] = 3;    // TypeCode.Boolean
$typeCodes[1] = 5;    // TypeCode.SByte
$typeCodes[2] = 6;    // TypeCode.Byte
$typeCodes[3] = 7;    // TypeCode.Int16
$typeCodes[4] = 8;    // TypeCode.UInt16
$typeCodes[5] = 9;    // TypeCode.Int32
$typeCodes[6] = 10;   // TypeCode.UInt32
$typeCodes[7] = 11;   // TypeCode.Int64
$typeCodes[8] = 12;   // TypeCode.UInt64
$typeCodes[9] = 13;   // TypeCode.Single
$typeCodes[10] = 14;  // TypeCode.Double

// Instantiate the client object
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");

// Perform the operation
try
{
    $outputs = $Client->CallMethod(
        //"http://opcua.demo-this.com:51211/UA/SampleServer", 
        "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer", 
        "nsu=http://test.org/UA/Data/ ;i=10755", 
        "nsu=http://test.org/UA/Data/ ;i=10756", 
        $inputs, 
        $typeCodes);
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
    Exit();
}

// Display results
for ($i = 0; $i < count($outputs); $i++)
{
    printf("outputs[%d]: %s\n", $i, $outputs[$i]);
}

//#endregion Example
?>
