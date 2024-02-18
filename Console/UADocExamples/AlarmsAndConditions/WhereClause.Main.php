<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to specify criteria for event notifications.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

const UAAttributeId_NodeId = 1;
const UAAttributeId_EventNotifier = 12;

const UAFilterOperator_Equals = 1;
const UAFilterOperator_GreaterThanOrEqual = 5;
const UAFilterOperator_Or = 12;

const UAObjectIds_Server = 'nsu=http://opcfoundation.org/UA/;i=2253';

class ClientEvents {
    function EventNotification($Sender, $E)
    {
        // Display the event
        printf("%s\n", $E);
    }
}

$EndpointDescriptor = "opc.tcp://opcua.demo-this.com:62544/Quickstarts/AlarmConditionServer";

// Instantiate the client object and hook events
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");
$ClientEvents = new ClientEvents();
com_event_sink($Client, $ClientEvents, "DEasyUAClientEvents");

$WhereClause = new COM("OpcLabs.EasyOpc.UA.Filtering.UAContentFilterElement");

// Either the severity is >= 500, or the event comes from a specified source node
$Operand1 = UABaseEventObject_Operands_Severity();
$Operand2 = new COM("OpcLabs.EasyOpc.UA.Filtering.UALiteralOperand");
$Operand2->Value = 500;
$Element1 = new COM("OpcLabs.EasyOpc.UA.Filtering.UAContentFilterElement");
$Element1->FilterOperator = UAFilterOperator_GreaterThanOrEqual;
$Element1->FilterOperands->Add($Operand1);
$Element1->FilterOperands->Add($Operand2);
$Operand3 = UABaseEventObject_Operands_SourceNode();
$SourceNodeId = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$SourceNodeId->ExpandedText = "nsu=http://opcfoundation.org/Quickstarts/AlarmCondition;ns=2;s=1:Metals/SouthMotor";
$Operand4 = new COM("OpcLabs.EasyOpc.UA.Filtering.UALiteralOperand");
$Operand4->Value = $SourceNodeId;
$Element2 = new COM("OpcLabs.EasyOpc.UA.Filtering.UAContentFilterElement");
$Element2->FilterOperator = UAFilterOperator_Equals;
$Element2->FilterOperands->Add($Operand3);
$Element2->FilterOperands->Add($Operand4);
$WhereClause->FilterOperator = UAFilterOperator_Or;
$WhereClause->FilterOperands->Add($Element1);
$WhereClause->FilterOperands->Add($Element2);

$EventFilter = new COM("OpcLabs.EasyOpc.UA.UAEventFilter");
$EventFilter->SelectClauses = UABaseEventObject_AllFields();
$EventFilter->WhereClause = $WhereClause;

$MonitoringParameters = new COM("OpcLabs.EasyOpc.UA.UAMonitoringParameters");
$MonitoringParameters->SamplingInterval = 1000;
$MonitoringParameters->EventFilter = $EventFilter;
$MonitoringParameters->QueueSize = 1000;

$MonitoredItemArguments = new COM("OpcLabs.EasyOpc.UA.OperationModel.EasyUAMonitoredItemArguments");
$MonitoredItemArguments->EndpointDescriptor->UrlString = $EndpointDescriptor;
$MonitoredItemArguments->NodeDescriptor->NodeId->StandardName = "Server";
$MonitoredItemArguments->MonitoringParameters = $MonitoringParameters;
//$MonitoredItemArguments->SubscriptionParameters->PublishingInterval = 0;
$MonitoredItemArguments->AttributeId = UAAttributeId_EventNotifier;

$arguments[0] = $MonitoredItemArguments;

printf("Subscribing...\n");
$Client->SubscribeMultipleMonitoredItems($arguments);

printf("Processing monitored item changed events for 30 seconds...\n");
$startTime = time(); do { com_message_pump(1000); } while (time() < $startTime + 30);

printf("Unsubscribing...\n");
$Client->UnsubscribeAllMonitoredItems;

printf("Waiting for 5 seconds...\n");
$startTime = time(); do { com_message_pump(1000); } while (time() < $startTime + 5);


function ObjectTypeIds_BaseEventType() {
    $NodeId = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
    $NodeId->StandardName = "BaseEventType";
    return $NodeId;
}

function UAFilterElements_SimpleAttribute($TypeId, $simpleRelativeBrowsePathString) {
  $BrowsePathParser = new COM("OpcLabs.EasyOpc.UA.Navigation.Parsing.UABrowsePathParser");
  $Operand = new COM("OpcLabs.EasyOpc.UA.Filtering.UASimpleAttributeOperand");
  $Operand->TypeId->NodeId = $TypeId;
  $Operand->QualifiedNames = $BrowsePathParser->ParseRelative($simpleRelativeBrowsePathString)->ToUAQualifiedNameCollection;
  return $Operand;
}

function UABaseEventObject_Operands_NodeId() {
    $Operand = new COM("OpcLabs.EasyOpc.UA.Filtering.UASimpleAttributeOperand");
    $Operand->TypeId->NodeId->StandardName = "BaseEventType";
    $Operand->AttributeId = UAAttributeId_NodeId;
    return $Operand;
}

function UABaseEventObject_Operands_EventId() {
  return UAFilterElements_SimpleAttribute(ObjectTypeIds_BaseEventType(), "/EventId");
}

function UABaseEventObject_Operands_EventType() {
  return UAFilterElements_SimpleAttribute(ObjectTypeIds_BaseEventType(), "/EventType");
}

function UABaseEventObject_Operands_SourceNode() {
  return UAFilterElements_SimpleAttribute(ObjectTypeIds_BaseEventType(), "/SourceNode");
}

function UABaseEventObject_Operands_SourceName() {
  return UAFilterElements_SimpleAttribute(ObjectTypeIds_BaseEventType(), "/SourceName");
}

function UABaseEventObject_Operands_Time() {
  return UAFilterElements_SimpleAttribute(ObjectTypeIds_BaseEventType(), "/Time");
}

function UABaseEventObject_Operands_ReceiveTime() {
  return UAFilterElements_SimpleAttribute(ObjectTypeIds_BaseEventType(), "/ReceiveTime");
}

function UABaseEventObject_Operands_LocalTime() {
  return UAFilterElements_SimpleAttribute(ObjectTypeIds_BaseEventType(), "/LocalTime");
}

function UABaseEventObject_Operands_Message() {
  return UAFilterElements_SimpleAttribute(ObjectTypeIds_BaseEventType(), "/Message");
}

function UABaseEventObject_Operands_Severity() {
  return UAFilterElements_SimpleAttribute(ObjectTypeIds_BaseEventType(), "/Severity");
}

function UABaseEventObject_AllFields() {
    $Fields = new COM("OpcLabs.EasyOpc.UA.UAAttributeFieldCollection");
    $Fields->Add(UABaseEventObject_Operands_NodeId()->ToUAAttributeField);
    $Fields->Add(UABaseEventObject_Operands_EventId()->ToUAAttributeField);
    $Fields->Add(UABaseEventObject_Operands_EventType()->ToUAAttributeField);
    $Fields->Add(UABaseEventObject_Operands_SourceNode()->ToUAAttributeField);
    $Fields->Add(UABaseEventObject_Operands_SourceName()->ToUAAttributeField);
    $Fields->Add(UABaseEventObject_Operands_Time()->ToUAAttributeField);
    $Fields->Add(UABaseEventObject_Operands_ReceiveTime()->ToUAAttributeField);
    $Fields->Add(UABaseEventObject_Operands_LocalTime()->ToUAAttributeField);
    $Fields->Add(UABaseEventObject_Operands_Message()->ToUAAttributeField);
    $Fields->Add(UABaseEventObject_Operands_Severity()->ToUAAttributeField);

    return $Fields;
}

//#endregion Example
?>
