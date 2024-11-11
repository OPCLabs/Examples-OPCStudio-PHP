<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to acknowledge an OPC UA event.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.

const UAAttributeId_NodeId = 1;
const UAAttributeId_EventNotifier = 12;

const UAFilterOperator_Equals = 1;

class ClientEvents {
    private $AnEvent = false;
    private $EventId;
    private $NodeId;

    function EventNotification($Sender, $E)
    {
        if (!$E->Succeeded) {
            printf(" *** Failure: %s\n", $E->ErrorMessageBrief);
            return;
        }

        if (!is_null($E->EventData)) {
            $BaseEventObject = $E->EventData->BaseEvent;
            printf("%s\n", $BaseEventObject);

            // Make sure we do not catch the event more than once
           if ($this->AnEvent)
               return;

           $this->NodeId = $BaseEventObject->NodeId;
           $this->EventId = $BaseEventObject->EventId;
           $this->AnEvent = true;
        }
    }

    public function getAnEvent() {
        return $this->AnEvent;
    }

    public function getEventId() {
        return $this->EventId;
    }

    public function getNodeId() {
        return $this->NodeId;
    }
}


// Define which server we will work with.
$EndpointDescriptor = new COM("OpcLabs.EasyOpc.UA.UAEndpointDescriptor");
$EndpointDescriptor->UrlString = "opc.tcp://opcua.demo-this.com:62544/Quickstarts/AlarmConditionServer";

// Event filter: Events with specific node ID.
$Operand1 = UABaseEventObject_Operands_NodeId();
$NodeId = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$NodeId->ExpandedText = "nsu=http://opcfoundation.org/Quickstarts/AlarmCondition ;ns=2;s=1:Colours/EastTank?Yellow";
$Operand2 = new COM("OpcLabs.EasyOpc.UA.Filtering.UALiteralOperand");
$Operand2->Value = $NodeId;
$WhereClause = new COM("OpcLabs.EasyOpc.UA.Filtering.UAContentFilterElement");
$WhereClause->FilterOperator = UAFilterOperator_Equals;
$WhereClause->FilterOperands->Add($Operand1);
$WhereClause->FilterOperands->Add($Operand2);

$EventFilter = new COM("OpcLabs.EasyOpc.UA.UAEventFilter");
$EventFilter->SelectClauses = UABaseEventObject_AllFields();
$EventFilter->WhereClause = $WhereClause;

$ServerNodeId = new COM("OpcLabs.EasyOpc.UA.AddressSpace.UANodeId");
$ServerNodeId->StandardName = "Server";

$MonitoringParameters = new COM("OpcLabs.EasyOpc.UA.UAMonitoringParameters");
$MonitoringParameters->EventFilter = $EventFilter;
$MonitoringParameters->QueueSize = 1000;
$MonitoringParameters->SamplingInterval = 1000;

$MonitoredItemArguments = new COM("OpcLabs.EasyOpc.UA.OperationModel.EasyUAMonitoredItemArguments");
$MonitoredItemArguments->AttributeId = UAAttributeId_EventNotifier;
$MonitoredItemArguments->EndpointDescriptor = $EndpointDescriptor;
$MonitoredItemArguments->MonitoringParameters = $MonitoringParameters;
$MonitoredItemArguments->NodeDescriptor->NodeId = $ServerNodeId;

// Instantiate the client object and hook events
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");
$ClientEvents = new ClientEvents();
com_event_sink($Client, $ClientEvents, "DEasyUAClientEvents");
$AlarmsAndConditionsClient = $Client->AsAlarmsAndConditionsClient;

$arguments[0] = $MonitoredItemArguments;

printf("Subscribing...\n");
$Client->SubscribeMultipleMonitoredItems($arguments);

printf("Waiting for an event for 30 seconds...\n");
$startTime = time(); do { com_message_pump(1000); } while ((time() < $startTime + 30) and !($ClientEvents->getAnEvent()));

if ($ClientEvents->getAnEvent()) {
    printf("Acknowledging an event...\n");
    try
    {
        $NodeDescriptor = new COM("OpcLabs.EasyOpc.UA.UANodeDescriptor");
        $NodeDescriptor->NodeId = $ClientEvents->getNodeId();
        $AlarmsAndConditionsClient->Acknowledge(
           $EndpointDescriptor,
           $NodeDescriptor,
           $ClientEvents->getEventId(),
           "Acknowledged by an automated example code.");
    }
    catch (com_exception $e)
    {
          printf("Failure: %s\n", $e->getMessage());
    }
}
else {
    printf("Event not received.\n");
}

printf("Waiting for 5 seconds...\n");
$startTime = time(); do { com_message_pump(1000); } while (time() < $startTime + 5);

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
