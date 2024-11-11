<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to select fields for event notifications.
//
// Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .
// OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .
// Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own
// a commercial license in order to use Online Forums, and we reply to every post.

const UAAttributeId_NodeId = 1;
const UAAttributeId_EventNotifier = 12;

class ClientEvents {
    function EventNotification($Sender, $E)
    {
        printf("\n");

        // Display the event
        if (is_null($E->EventData)) {
            printf("%s\n", $E);
            return;
        }

        printf("All fields:\n");

        foreach ($E->EventData->FieldResults as $Pair)
        {
            $AttributeField = $Pair->Key;
            $ValueResult = $Pair->Value;
            printf("  %s -> %s\n", $AttributeField, $ValueResult);
        }

        // Extracting specific fields using an event type ID and a simple relative path
        printf("Source name: %s\n", $E->EventData->FieldResults->Item(UABaseEventObject_Operands_SourceName()->ToUAAttributeField()));
        printf("Message: %s\n", $E->EventData->FieldResults->Item(UABaseEventObject_Operands_Message()->ToUAAttributeField()));
    }
}

const UAObjectIds_Server = "nsu=http://opcfoundation.org/UA/;i=2253";

$EndpointDescriptor = "opc.tcp://opcua.demo-this.com:62544/Quickstarts/AlarmConditionServer";

// Instantiate the client object and hook events
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");
$ClientEvents = new ClientEvents();
com_event_sink($Client, $ClientEvents, "DEasyUAClientEvents");

printf("Subscribing...\n");

$SelectClauses = new COM("OpcLabs.EasyOpc.UA.UAAttributeFieldCollection");
// Select specific fields using an event type ID and a simple relative path
$SelectClauses->Add(UABaseEventObject_Operands_NodeId()->ToUAAttributeField());
$SelectClauses->Add(UABaseEventObject_Operands_SourceNode()->ToUAAttributeField());
$SelectClauses->Add(UABaseEventObject_Operands_SourceName()->ToUAAttributeField());
$SelectClauses->Add(UABaseEventObject_Operands_Time()->ToUAAttributeField());
$SelectClauses->Add(UABaseEventObject_Operands_Message()->ToUAAttributeField());
$SelectClauses->Add(UABaseEventObject_Operands_Severity()->ToUAAttributeField());

$EventFilter = new COM("OpcLabs.EasyOpc.UA.UAEventFilter");
$EventFilter->SelectClauses = $SelectClauses;

$MonitoringParameters = new COM("OpcLabs.EasyOpc.UA.UAMonitoringParameters");
$MonitoringParameters->EventFilter = $EventFilter;
$MonitoringParameters->QueueSize = 1000;
$MonitoringParameters->SamplingInterval = 1000;

$MonitoredItemArguments = new COM("OpcLabs.EasyOpc.UA.OperationModel.EasyUAMonitoredItemArguments");
$MonitoredItemArguments->EndpointDescriptor->UrlString = $EndpointDescriptor;
$MonitoredItemArguments->NodeDescriptor->NodeId->StandardName = "Server";
$MonitoredItemArguments->MonitoringParameters = $MonitoringParameters;
// $MonitoredItemArguments->SubscriptionParameters->PublishingInterval = 0;
$MonitoredItemArguments->AttributeId = UAAttributeId_EventNotifier;

$Arguments[0] = $MonitoredItemArguments;

$Client->SubscribeMultipleMonitoredItems($Arguments);

printf("Processing event notifications for 30 seconds...\n");
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

function UABaseEventObject_Operands_SourceNode() {
  return UAFilterElements_SimpleAttribute(ObjectTypeIds_BaseEventType(), "/SourceNode");
}

function UABaseEventObject_Operands_SourceName() {
  return UAFilterElements_SimpleAttribute(ObjectTypeIds_BaseEventType(), "/SourceName");
}

function UABaseEventObject_Operands_Time() {
  return UAFilterElements_SimpleAttribute(ObjectTypeIds_BaseEventType(), "/Time");
}

function UABaseEventObject_Operands_Message() {
  return UAFilterElements_SimpleAttribute(ObjectTypeIds_BaseEventType(), "/Message");
}

function UABaseEventObject_Operands_Severity() {
  return UAFilterElements_SimpleAttribute(ObjectTypeIds_BaseEventType(), "/Severity");
}


// Example output (truncated):
//Subscribing...
//Processing event notifications for 30 seconds...
//
//[] Success
//
//[] Success; Refresh; RefreshInitiated
//
//All fields:
//  NodeId="BaseEventType", NodeId -> Success; nsu=http://opcfoundation.org/Quickstarts/AlarmCondition ;ns=2;s=1:Colours/EastTank?OnlineState {OpcLabs.EasyOpc.UA.AddressSpace.UANodeId}
//  NodeId="BaseEventType"/EventId -> Success; [16] {95, 68, 22, 205, 114, ...} {System.Byte[]}
//  NodeId="BaseEventType"/EventType -> Success; DialogConditionType {OpcLabs.EasyOpc.UA.AddressSpace.UANodeId}
//  NodeId="BaseEventType"/SourceNode -> Success; nsu=http://opcfoundation.org/Quickstarts/AlarmCondition ;ns=2;s=1:Colours/EastTank {OpcLabs.EasyOpc.UA.AddressSpace.UANodeId}
//  NodeId="BaseEventType"/SourceName -> Success; EastTank {System.String}
//  NodeId="BaseEventType"/Time -> Success; 9/10/2019 8:08:23 PM {System.DateTime}
//  NodeId="BaseEventType"/ReceiveTime -> Success; 9/10/2019 8:08:23 PM {System.DateTime}
//  NodeId="BaseEventType"/LocalTime -> Success; 00:00, DST {OpcLabs.EasyOpc.UA.UATimeZoneData}
//  NodeId="BaseEventType"/Message -> Success; The dialog was activated {System.String}
//  NodeId="BaseEventType"/Severity -> Success; 100 {System.Int32}
//Source name: Success; EastTank {System.String}
//Message: Success; The dialog was activated {System.String}
//
//All fields:
//  NodeId="BaseEventType", NodeId -> Success; nsu=http://opcfoundation.org/Quickstarts/AlarmCondition ;ns=2;s=1:Colours/EastTank?Red {OpcLabs.EasyOpc.UA.AddressSpace.UANodeId}
//  NodeId="BaseEventType"/EventId -> Success; [16] {124, 156, 219, 54, 120, ...} {System.Byte[]}
//  NodeId="BaseEventType"/EventType -> Success; ExclusiveDeviationAlarmType {OpcLabs.EasyOpc.UA.AddressSpace.UANodeId}
//  NodeId="BaseEventType"/SourceNode -> Success; nsu=http://opcfoundation.org/Quickstarts/AlarmCondition ;ns=2;s=1:Colours/EastTank {OpcLabs.EasyOpc.UA.AddressSpace.UANodeId}
//  NodeId="BaseEventType"/SourceName -> Success; EastTank {System.String}
//  NodeId="BaseEventType"/Time -> Success; 10/14/2019 4:00:13 PM {System.DateTime}
//  NodeId="BaseEventType"/ReceiveTime -> Success; 10/14/2019 4:00:13 PM {System.DateTime}
//  NodeId="BaseEventType"/LocalTime -> Success; 00:00, DST {OpcLabs.EasyOpc.UA.UATimeZoneData}
//  NodeId="BaseEventType"/Message -> Success; The alarm was acknoweledged. {System.String}
//  NodeId="BaseEventType"/Severity -> Success; 500 {System.Int32}
//Source name: Success; EastTank {System.String}
//Message: Success; The alarm was acknoweledged. {System.String}
//
//...


//#endregion Example
?>
