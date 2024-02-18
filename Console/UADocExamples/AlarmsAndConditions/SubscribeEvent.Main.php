<?php
// $Header: $
// Copyright [c] CODE Consulting and Development, s.r.o., Plzen. All rights reserved.

//#region Example
// This example shows how to subscribe to event notifications and display each incoming event.
//
// Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .


class ClientEvents {
    function EventNotification($Sender, $E)
    {
        // Display the event
        if ($E->Succeeded) {
            printf("%s\n", $E);
        }
        else {
            printf(" *** Failure: %s\n", $E->ErrorMessageBrief);
        }
    }
}

const UAObjectIds_Server = "nsu=http://opcfoundation.org/UA/;i=2253";

$EndpointDescriptor = "opc.tcp://opcua.demo-this.com:62544/Quickstarts/AlarmConditionServer";

// Instantiate the client object and hook events
$Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");
$ClientEvents = new ClientEvents();
com_event_sink($Client, $ClientEvents, "DEasyUAClientEvents");

printf("Subscribing...\n");
$Client->SubscribeEvent($EndpointDescriptor, UAObjectIds_Server, 1000);

printf("Processing event notifications for 30 seconds...\n");
$startTime = time(); do { com_message_pump(1000); } while (time() < $startTime + 30);

printf("Unsubscribing...\n");
$Client->UnsubscribeAllMonitoredItems;

printf("Waiting for 5 seconds...\n");
$startTime = time(); do { com_message_pump(1000); } while (time() < $startTime + 5);



// Example output (truncated):
//Subscribing...
//Processing event notifications for 30 seconds...
//[] Success
//[] Success; Refresh; RefreshInitiated
//[] Success; Refresh; [EastTank] 100! {DialogConditionType} "The dialog was activated" @9/9/2021 2:22:18 PM (10 fields)
//[] Success; Refresh; [EastTank] 100! {ExclusiveDeviationAlarmType} "The alarm is active." @9/9/2021 4:19:37 PM (10 fields)
//[] Success; Refresh; [EastTank] 500! {NonExclusiveLevelAlarmType} "The alarm severity has increased." @9/9/2021 4:19:35 PM (10 fields)
//[] Success; Refresh; [EastTank] 900! {TripAlarmType} "The alarm severity has increased." @9/9/2021 4:19:29 PM (10 fields)
//[] Success; Refresh; [EastTank] 100! {TripAlarmType} "The alarm severity has increased." @9/9/2021 3:39:03 PM (10 fields)
//[] Success; Refresh; [EastTank] 100! {TripAlarmType} "The alarm severity has increased." @9/9/2021 3:40:03 PM (10 fields)
//[] Success; Refresh; [NorthMotor] 100! {DialogConditionType} "The dialog was activated" @9/9/2021 2:22:18 PM (10 fields)
//[] Success; Refresh; [NorthMotor] 500! {ExclusiveDeviationAlarmType} "The alarm severity has increased." @9/9/2021 4:19:35 PM (10 fields)
//[] Success; Refresh; [NorthMotor] 900! {NonExclusiveLevelAlarmType} "The alarm severity has increased." @9/9/2021 4:19:29 PM (10 fields)
//[] Success; Refresh; [NorthMotor] 100! {TripAlarmType} "The alarm is active." @9/9/2021 4:19:32 PM (10 fields)
//[] Success; Refresh; [NorthMotor] 100! {TripAlarmType} "The alarm severity has increased." @9/9/2021 3:39:08 PM (10 fields)
//[] Success; Refresh; [NorthMotor] 100! {TripAlarmType} "The alarm severity has increased." @9/9/2021 3:40:14 PM (10 fields)
//[] Success; Refresh; [WestTank] 100! {DialogConditionType} "The dialog was activated" @9/9/2021 2:22:18 PM (10 fields)
//[] Success; Refresh; [WestTank] 900! {ExclusiveDeviationAlarmType} "The alarm severity has increased." @9/9/2021 4:19:29 PM (10 fields)
//[] Success; Refresh; [WestTank] 100! {NonExclusiveLevelAlarmType} "The alarm is active." @9/9/2021 4:19:32 PM (10 fields)
//[] Success; Refresh; [WestTank] 100! {TripAlarmType} "The alarm is active." @9/9/2021 4:19:37 PM (10 fields)
//[] Success; Refresh; [WestTank] 100! {TripAlarmType} "The alarm severity has increased." @9/9/2021 3:38:55 PM (10 fields)
//[] Success; Refresh; [WestTank] 100! {TripAlarmType} "The alarm severity has increased." @9/9/2021 3:39:43 PM (10 fields)
//[] Success; Refresh; [SouthMotor] 100! {DialogConditionType} "The dialog was activated" @9/9/2021 2:22:18 PM (10 fields)
//[] Success; Refresh; [SouthMotor] 100! {ExclusiveDeviationAlarmType} "The alarm is active." @9/9/2021 4:19:32 PM (10 fields)
//[] Success; Refresh; [SouthMotor] 100! {NonExclusiveLevelAlarmType} "The alarm is active." @9/9/2021 4:19:37 PM (10 fields)
//[] Success; Refresh; [SouthMotor] 500! {TripAlarmType} "The alarm severity has increased." @9/9/2021 4:19:35 PM (10 fields)
//[] Success; Refresh; [SouthMotor] 100! {TripAlarmType} "The alarm severity has increased." @9/9/2021 3:39:51 PM (10 fields)
//[] Success; Refresh; [SouthMotor] 100! {TripAlarmType} "The alarm severity has increased." @9/9/2021 3:38:57 PM (10 fields)
//[] Success; Refresh; RefreshComplete
//[] Success; [Internal] 500! {SystemEventType} "Raising Events" @9/9/2021 4:19:39 PM (10 fields)
//[] Success; [Internal] 500! {AuditEventType} "Events Raised" @9/9/2021 4:19:39 PM (10 fields)
//[] Success; [EastTank] 100! {TripAlarmType} "The alarm was deactivated by the system." @9/9/2021 4:19:39 PM (10 fields)
//[] Success; [NorthMotor] 100! {NonExclusiveLevelAlarmType} "The alarm was deactivated by the system." @9/9/2021 4:19:39 PM (10 fields)
//[] Success; [WestTank] 100! {ExclusiveDeviationAlarmType} "The alarm was deactivated by the system." @9/9/2021 4:19:39 PM (10 fields)
//[] Success; [Internal] 500! {SystemEventType} "Raising Events" @9/9/2021 4:19:40 PM (10 fields)
//[] Success; [Internal] 500! {AuditEventType} "Events Raised" @9/9/2021 4:19:40 PM (10 fields)
//[] Success; [Internal] 500! {SystemEventType} "Raising Events" @9/9/2021 4:19:41 PM (10 fields)
//[] Success; [Internal] 500! {AuditEventType} "Events Raised" @9/9/2021 4:19:41 PM (10 fields)
//[] Success; [Internal] 500! {SystemEventType} "Raising Events" @9/9/2021 4:19:42 PM (10 fields)
//[] Success; [Internal] 500! {AuditEventType} "Events Raised" @9/9/2021 4:19:42 PM (10 fields)
//[] Success; [Internal] 500! {SystemEventType} "Raising Events" @9/9/2021 4:19:43 PM (10 fields)
//[] Success; [NorthMotor] 300! {TripAlarmType} "The alarm severity has increased." @9/9/2021 4:19:43 PM (10 fields)
//[] Success; [Internal] 500! {AuditEventType} "Events Raised" @9/9/2021 4:19:43 PM (10 fields)
//[] Success; [WestTank] 300! {NonExclusiveLevelAlarmType} "The alarm severity has increased." @9/9/2021 4:19:43 PM (10 fields)
//[] Success; [SouthMotor] 300! {ExclusiveDeviationAlarmType} "The alarm severity has increased." @9/9/2021 4:19:43 PM (10 fields)
//[] Success; [Internal] 500! {SystemEventType} "Raising Events" @9/9/2021 4:19:44 PM (10 fields)
//[] Success; [EastTank] 700! {NonExclusiveLevelAlarmType} "The alarm severity has increased." @9/9/2021 4:19:44 PM (10 fields)
//[] Success; [Internal] 500! {AuditEventType} "Events Raised" @9/9/2021 4:19:44 PM (10 fields)
//[] Success; [NorthMotor] 700! {ExclusiveDeviationAlarmType} "The alarm severity has increased." @9/9/2021 4:19:44 PM (10 fields)
//[] Success; [SouthMotor] 700! {TripAlarmType} "The alarm severity has increased." @9/9/2021 4:19:44 PM (10 fields)
//[] Success; [Internal] 500! {SystemEventType} "Raising Events" @9/9/2021 4:19:45 PM (10 fields)
//[] Success; [EastTank] 300! {ExclusiveDeviationAlarmType} "The alarm severity has increased." @9/9/2021 4:19:45 PM (10 fields)
//[] Success; [Internal] 500! {AuditEventType} "Events Raised" @9/9/2021 4:19:45 PM (10 fields)
//...


//#endregion Example
?>
