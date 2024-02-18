<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows different ways of constructing generic data.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

// Create enumeration data with value of 1.
$EnumerationData = new COM("OpcLabs.BaseLib.DataTypeModel.EnumerationData");
$EnumerationData->Value = 1;
printf("%s\n", $EnumerationData);

// Create opaque data from an array of 2 bytes, specifying its size as 15 bits.
$OpaqueData1 = new COM("OpcLabs.BaseLib.DataTypeModel.OpaqueData");
$ByteArray1[0] = 0xAA;
$ByteArray1[1] = 0x55;
$OpaqueData1->SetByteArrayValue($ByteArray1, 15);
printf("%s\n", $OpaqueData1);

// Create opaque data from a bit array.
$OpaqueData2 = new COM("OpcLabs.BaseLib.DataTypeModel.OpaqueData");
$BitArray = $OpaqueData2->Value;
$BitArray->Length = 5;
$BitArray->Set(0, false);
$BitArray->Set(1, true);
$BitArray->Set(2, false);
$BitArray->Set(3, true);
$BitArray->Set(4, false);
printf("%s\n", $OpaqueData2);

// Create primitive data with System.Double value of 180.0.
$PrimitiveData1 = new COM("OpcLabs.BaseLib.DataTypeModel.PrimitiveData");
$PrimitiveData1->Value = 180.0;
printf("%s\n", $PrimitiveData1);

// Create primitive data with System.String value.
$PrimitiveData2 = new COM("OpcLabs.BaseLib.DataTypeModel.PrimitiveData");
$PrimitiveData2->Value = "Temperature is too high!";
printf("%s\n", $PrimitiveData2);

// Create sequence data with two elements, using the Add method.
$SequenceData1 = new COM("OpcLabs.BaseLib.DataTypeModel.SequenceData");
$SequenceData1->Elements->Add($OpaqueData1);
$SequenceData1->Elements->Add($OpaqueData2);
printf("%s\n", $SequenceData1);

// Create structured data with two members, using the Add method.
$StructuredData1 = new COM("OpcLabs.BaseLib.DataTypeModel.StructuredData");
$StructuredData1->Add("Message", $PrimitiveData2);
$StructuredData1->Add("Status", $EnumerationData);
printf("%s\n", $StructuredData1);

//#endregion Example
?>
