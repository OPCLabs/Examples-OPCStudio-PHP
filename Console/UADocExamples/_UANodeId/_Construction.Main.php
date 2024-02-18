<?php
// $Header: $
// Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows different ways of constructing OPC UA node IDs.
//
// A node ID specifies a namespace (either by an URI or by an index), and an identifier.
// The identifier can be numeric (an integer), string, GUID, or opaque.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

const UANodeClass_All = 255;


// A node ID can be specified in string form (so-called expanded text).
// The code below specifies a namespace URI (nsu=...), and an integer identifier (i=...).
// Assigning an expanded text to a node ID parses the value being assigned and sets all corresponding
// properties accordingly.
$NodeId1 = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$NodeId1->ExpandedText = "nsu=http://test.org/UA/Data/ ;i=10853";
printf("%s\n", $NodeId1);


// Similarly, with a string identifier (s=...).
$NodeId2 = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$NodeId2->ExpandedText = "nsu=http://test.org/UA/Data/ ;s=someIdentifier";
printf("%s\n", $NodeId2);


// Actually, "s=" can be omitted (not recommended, though)
$NodeId3 = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$NodeId3->ExpandedText = "nsu=http://test.org/UA/Data/ ;someIdentifier";
printf("%s\n", $NodeId3);
// Notice that the output is normalized - the "s=" is added again.


// Similarly, with a GUID identifier (g=...)
$NodeId4 = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$NodeId4->ExpandedText = "nsu=http://test.org/UA/Data/ ;g=BAEAF004-1E43-4A06-9EF0-E52010D5CD10";
printf("%s\n", $NodeId4);
// Notice that the output is normalized - uppercase letters in the GUI are converted to lowercase, etc.


// Similarly, with an opaque identifier (b=..., in Base64 encoding).
$NodeId5 = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$NodeId5->ExpandedText = "nsu=http://test.org/UA/Data/ ;b=AP8=";
printf("%s\n", $NodeId5);


// Namespace index can be used instead of namespace URI. The server is allowed to change the namespace
// indices between sessions (except for namespace 0), and for this reason, you should avoid the use of
// namespace indices, and rather use the namespace URIs whenever possible.
$NodeId6 = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$NodeId6->ExpandedText = "ns=2;i=10853";
printf("%s\n", $NodeId6);


// Namespace index can be also specified together with namespace URI. This is still safe, but may be
// a bit quicker to perform, because the client can just verify the namespace URI instead of looking
// it up.
$NodeId7 = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$NodeId7->ExpandedText = "nsu=http://test.org/UA/Data/ ;ns=2;i=10853";
printf("%s\n", $NodeId7);


// When neither namespace URI nor namespace index are given, the node ID is assumed to be in namespace
// with index 0 and URI "http://opcfoundation.org/UA/", which is reserved by OPC UA standard. There are
// many standard nodes that live in this reserved namespace, but no nodes specific to your servers will
// be in the reserved namespace, and hence the need to specify the namespace with server-specific nodes.
$NodeId8 = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$NodeId8->ExpandedText = "i=2254";
printf("%s\n", $NodeId8);


// If you attempt to pass in a string that does not conform to the syntax rules,
// a UANodeIdFormatException is thrown.
$NodeId9 = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
try
{
    $NodeId9->ExpandedText = "nsu=http://test.org/UA/Data/ ;i=notAnInteger";
    printf("%s\n", $NodeId9);
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
}


// There is a parser object that can be used to parse the expanded texts of node IDs.
$NodeIdParser10 = new COM("OpcLabs.EasyOpc.UA.AddressSpace.Parsing.UANodeIdParser");
$NodeId10 = $NodeIdParser10->Parse("nsu=http://test.org/UA/Data/ ;i=10853", False);
printf("%s\n", $NodeId10);


// The parser can be used if you want to parse the expanded text of the node ID but do not want
// exceptions be thrown.
$NodeId11 = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$NodeIdParser11 = new COM("OpcLabs.EasyOpc.UA.AddressSpace.Parsing.UANodeIdParser");
$StringParsingError = $NodeIdParser11->TryParse("nsu=http://test.org/UA/Data/ ;i=notAnInteger", False, $NodeId11);
if (is_null($StringParsingError))
    printf("%s\n", $NodeId11);
else    
    printf("*** Failure: %s\n", $StringParsingError->Message);


// You can also use the parser if you have node IDs where you want the default namespace be different
// from the standard "http://opcfoundation.org/UA/".
$NodeIdParser12 = new COM("OpcLabs.EasyOpc.UA.AddressSpace.Parsing.UANodeIdParser");
$NodeIdParser12->DefaultNamespaceUriString = "http://test.org/UA/Data/";
$NodeId12 = $NodeIdParser12->Parse("i=10853", False);
printf("%s\n", $NodeId12);


// You can create a "null" node ID. Such node ID does not actually identify any valid node in OPC UA, but
// is useful as a placeholder or as a starting point for further modifications of its properties.
$NodeId14 = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
printf("%s\n", $NodeId14);


// Properties of a node ID can be modified individually. The advantage of this approach is that you do
// not have to care about syntax of the node ID expanded text.
$NodeId15 = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$NodeId15->NamespaceUriString = "http://test.org/UA/Data/";
$NodeId15->Identifier = 10853;
printf("%s\n", $NodeId15);


// If you know the type of the identifier upfront, it is safer to use typed properties that correspond
// to specific types of identifier. Here, with an integer identifier.
$NodeId17 = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$NodeId17->NamespaceUriString = "http://test.org/UA/Data/";
$NodeId17->NumericIdentifier = 10853;
printf("%s\n", $NodeId17);


// Similarly, with a string identifier.
$NodeId18 = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$NodeId18->NamespaceUriString = "http://test.org/UA/Data/";
$NodeId18->StringIdentifier = "someIdentifier";
printf("%s\n", $NodeId18);


// If you have GUID in its string form, the node ID object can parse it for you.
$NodeId20 = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$NodeId20->NamespaceUriString = "http://test.org/UA/Data/";
$NodeId20->GuidIdentifierString = "BAEAF004-1E43-4A06-9EF0-E52010D5CD10";
printf("%s\n", $NodeId20);


// And, with an opaque identifier.
$NodeId21 = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$NodeId21->NamespaceUriString = "http://test.org/UA/Data/";
$OpaqueIdentifier21[0] = 0x00;
$OpaqueIdentifier21[1] = 0xFF;
$NodeId21->OpaqueIdentifier = $OpaqueIdentifier21;
printf("%s\n", $NodeId21);


// We have built-in a list of all standard nodes specified by OPC UA. You can simply refer to these node IDs in your code.
// You can refer to any standard node using its name (in a string form).
// Note that assigning a non-existing standard name is not allowed, and throws ArgumentException.
$NodeId26 = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$NodeId26->StandardName = "TypesFolder";
printf("%s\n", $NodeId26);
// When the UANodeId equals to one of the standard nodes, it is output in the shortened form - as the standard name only.


// When you browse for nodes in the OPC UA server, every returned node element contains a node ID that
// you can use further.
$Client27 = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");
$EndpointDescriptor = new COM("OpcLabs.EasyOpc.UA.UAEndpointDescriptor");
$EndpointDescriptor->UrlString = "http://opcua.demo-this.com:51211/UA/SampleServer";
// Browse from the Server node.
$ServerNodeId = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$ServerNodeId->StandardName = "Server";
$ServerNodeDescriptor = new COM("OpcLabs.EasyOpc.UA.UANodeDescriptor");
$ServerNodeDescriptor->NodeId = $ServerNodeId;
// Browse all References.
$ReferencesNodeId = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$ReferencesNodeId->StandardName = "References";

$BrowseParameters = new COM("OpcLabs.EasyOpc.UA.UABrowseParameters");
$BrowseParameters->NodeClasses = UANodeClass_All;  // this is the default, anyway
$BrowseParameters->ReferenceTypeIds->Add($ReferencesNodeId);

try
{
    $NodeElements27 = $Client27->Browse($EndpointDescriptor, $ServerNodeDescriptor, $BrowseParameters);
    if ($NodeElements27->Count != 0) {
        $NodeId27 = $NodeElements27[0]->NodeId;
        printf("%s\n", $NodeId27);
    }
}
catch (com_exception $e)
{
    printf("*** Failure: %s\n", $e->getMessage());
    exit();
}

//#endregion Example
?>
