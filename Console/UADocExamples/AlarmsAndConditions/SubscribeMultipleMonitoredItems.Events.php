<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to subscribe to multiple events.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .

const UAAttributeId_NodeId = 1;
const UAAttributeId_EventNotifier = 12;

const UAFilterOperator_Equals = 1;
const UAFilterOperator_GreaterThanOrEqual = 5;

class ClientEvents {
    function EventNotification($Sender, $E)
    {
        // Display the event
        printf("%s\n", $E);
    }
}

$EndpointDescriptor = "opc.tcp://opcua.demo-this.com:62544/Quickstarts/AlarmConditionServer";

// set MonitoredItemArguments1
// Event filter: The severity is >= 500.
$Operand11 = UABaseEventObject_Operands_Severity();
$Operand12 = new COM("OpcLabs.EasyOpc.UA.Filtering.UALiteralOperand");
$Operand12->Value = 500;
$WhereClause1 = new COM("OpcLabs.EasyOpc.UA.Filtering.UAContentFilterElement");
$WhereClause1->FilterOperator = UAFilterOperator_GreaterThanOrEqual;
$WhereClause1->FilterOperands->Add($Operand11);
$WhereClause1->FilterOperands->Add($Operand12);

$EventFilter1 = new COM("OpcLabs.EasyOpc.UA.UAEventFilter");
$EventFilter1->SelectClauses = UABaseEventObject_AllFields();
$EventFilter1->WhereClause = $WhereClause1;

$ServerNodeId1 = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$ServerNodeId1->StandardName = "Server";

$MonitoringParameters1 = new COM("OpcLabs.EasyOpc.UA.UAMonitoringParameters");
$MonitoringParameters1->EventFilter = $EventFilter1;
$MonitoringParameters1->QueueSize = 1000;
$MonitoringParameters1->SamplingInterval = 1000;

$MonitoredItemArguments1 = new COM("OpcLabs.EasyOpc.UA.OperationModel.EasyUAMonitoredItemArguments");
$MonitoredItemArguments1->AttributeId = UAAttributeId_EventNotifier;
$MonitoredItemArguments1->EndpointDescriptor->UrlString = $EndpointDescriptor;
$MonitoredItemArguments1->MonitoringParameters = $MonitoringParameters1;
$MonitoredItemArguments1->NodeDescriptor->NodeId = $ServerNodeId1;
$MonitoredItemArguments1->State = "firstState";

// set MonitoredItemArguments2
// Event filter: The event comes from a specified source node.
$Operand21 = UABaseEventObject_Operands_SourceNode();
$SourceNodeId = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$SourceNodeId->ExpandedText = "nsu=http://opcfoundation.org/Quickstarts/AlarmCondition ;ns=2;s=1:Metals/SouthMotor";
$Operand22 = new COM("OpcLabs.EasyOpc.UA.Filtering.UALiteralOperand");
$Operand22->Value = $SourceNodeId;
$WhereClause2 = new COM("OpcLabs.EasyOpc.UA.Filtering.UAContentFilterElement");
$WhereClause2->FilterOperator = UAFilterOperator_Equals;
$WhereClause2->FilterOperands->Add($Operand21);
$WhereClause2->FilterOperands->Add($Operand22);

$EventFilter2 = new COM("OpcLabs.EasyOpc.UA.UAEventFilter");
$EventFilter2->SelectClauses = UABaseEventObject_AllFields();
$EventFilter2->WhereClause = $WhereClause2;

$ServerNodeId2 = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$ServerNodeId2->StandardName = "Server";

$MonitoringParameters2 = new COM("OpcLabs.EasyOpc.UA.UAMonitoringParameters");
$MonitoringParameters2->EventFilter = $EventFilter2;
$MonitoringParameters2->QueueSize = 1000;
$MonitoringParameters2->SamplingInterval = 2000;

$MonitoredItemArguments2 = new COM("OpcLabs.EasyOpc.UA.OperationModel.EasyUAMonitoredItemArguments");
$MonitoredItemArguments2->AttributeId = UAAttributeId_EventNotifier;
$MonitoredItemArguments2->EndpointDescriptor->UrlString = $EndpointDescriptor;
$MonitoredItemArguments2->MonitoringParameters = $MonitoringParameters2;
$MonitoredItemArguments2->NodeDescriptor->NodeId = $ServerNodeId2;
$MonitoredItemArguments2->State = "secondState";

// Instantiate the client object and hook events
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");
$ClientEvents = new ClientEvents();
com_event_sink($Client, $ClientEvents, "DEasyUAClientEvents");

$arguments[0] = $MonitoredItemArguments1;
$arguments[1] = $MonitoredItemArguments2;

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

// Example output (truncated):
//Subscribing...
//Processing monitored item changed events for 30 seconds...
//[firstState] Success
//[secondState] Success
//[firstState] Success; Refresh; RefreshInitiated
//[firstState] Success; Refresh; (10 field results) [EastTank] 500! "The alarm was acknoweledged." @10/14/2019 4:00:13 PM
//[firstState] Success; Refresh; (10 field results) [EastTank] 500! "The alarm was acknoweledged." @10/14/2019 4:00:17 PM
//[firstState] Success; Refresh; (10 field results) [NorthMotor] 500! "The alarm was acknoweledged." @10/14/2019 4:00:02 PM
//[firstState] Success; Refresh; (10 field results) [NorthMotor] 500! "The alarm was acknoweledged." @10/14/2019 4:00:16 PM
//[firstState] Success; Refresh; (10 field results) [SouthMotor] 700! "The alarm was acknoweledged." @10/14/2019 4:00:21 PM
//[firstState] Success; Refresh; (10 field results) [SouthMotor] 500! "The alarm was acknoweledged." @10/14/2019 4:00:03 PM
//[firstState] Success; Refresh; RefreshComplete
//[firstState] Success; (10 field results) [Internal] 500! "Raising Events" @11/8/2019 7:48:08 PM
//[firstState] Success; (10 field results) [Internal] 500! "Events Raised" @11/8/2019 7:48:08 PM
//[secondState] Success; Refresh; RefreshInitiated
//[secondState] Success; Refresh; (10 field results) [SouthMotor] 100! "The dialog was activated" @9/10/2019 8:08:25 PM
//[secondState] Success; Refresh; (10 field results) [SouthMotor] 100! "The alarm is active." @11/8/2019 7:48:07 PM
//[secondState] Success; Refresh; (10 field results) [SouthMotor] 700! "The alarm was acknoweledged." @10/14/2019 4:00:21 PM
//[secondState] Success; Refresh; (10 field results) [SouthMotor] 500! "The alarm was acknoweledged." @10/14/2019 4:00:03 PM
//[secondState] Success; Refresh; (10 field results) [SouthMotor] 100! "The alarm severity has increased." @9/10/2019 8:09:02 PM
//[secondState] Success; Refresh; (10 field results) [SouthMotor] 100! "The alarm severity has increased." @9/10/2019 8:09:59 PM
//[secondState] Success; Refresh; RefreshComplete
//[firstState] Success; (10 field results) [Internal] 500! "Raising Events" @11/8/2019 7:48:09 PM
//[firstState] Success; (10 field results) [Internal] 500! "Events Raised" @11/8/2019 7:48:09 PM
//[firstState] Success; (10 field results) [Internal] 500! "Raising Events" @11/8/2019 7:48:10 PM
//[firstState] Success; (10 field results) [Internal] 500! "Events Raised" @11/8/2019 7:48:10 PM
//[firstState] Success; (10 field results) [Internal] 500! "Raising Events" @11/8/2019 7:48:11 PM
//[firstState] Success; (10 field results) [Internal] 500! "Events Raised" @11/8/2019 7:48:11 PM
//[firstState] Success; (10 field results) [Internal] 500! "Raising Events" @11/8/2019 7:48:12 PM
//[firstState] Success; (10 field results) [Internal] 500! "Events Raised" @11/8/2019 7:48:12 PM
//[firstState] Success; (10 field results) [EastTank] 500! "The alarm severity has increased." @11/8/2019 7:48:13 PM
//[firstState] Success; (10 field results) [Internal] 500! "Raising Events" @11/8/2019 7:48:13 PM
//[firstState] Success; (10 field results) [Internal] 500! "Events Raised" @11/8/2019 7:48:13 PM
//[firstState] Success; (10 field results) [Internal] 500! "Raising Events" @11/8/2019 7:48:14 PM
//[firstState] Success; (10 field results) [Internal] 500! "Events Raised" @11/8/2019 7:48:14 PM
//[firstState] Success; (10 field results) [Internal] 500! "Raising Events" @11/8/2019 7:48:15 PM
//[firstState] Success; (10 field results) [Internal] 500! "Events Raised" @11/8/2019 7:48:15 PM
//[firstState] Success; (10 field results) [Internal] 500! "Raising Events" @11/8/2019 7:48:16 PM
//[firstState] Success; (10 field results) [Internal] 500! "Events Raised" @11/8/2019 7:48:16 PM
//[firstState] Success; (10 field results) [Internal] 500! "Raising Events" @11/8/2019 7:48:17 PM
//[firstState] Success; (10 field results) [Internal] 500! "Events Raised" @11/8/2019 7:48:17 PM
//[firstState] Success; (10 field results) [Internal] 500! "Raising Events" @11/8/2019 7:48:18 PM
//[firstState] Success; (10 field results) [Internal] 500! "Events Raised" @11/8/2019 7:48:18 PM
//[secondState] Success; (10 field results) [SouthMotor] 300! "The alarm severity has increased." @11/8/2019 7:48:18 PM
//...


//#endregion Example
?>
