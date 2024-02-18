<!--$$Header: $-->
<!-- Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved. -->

<!--#region Example-->
<!-- This example shows how to read the attributes of 4 OPC-UA nodes at once, and display the results. -->
<!---->
<!-- Find all latest examples here : https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .-->
<html>
<body>
<?php

    $ReadArguments1 = new COM("OpcLabs.EasyOpc.UA.OperationModel.UAReadArguments");
    $ReadArguments1->EndpointDescriptor->UrlString = 
        //"http://opcua.demo-this.com:51211/UA/SampleServer";
        //"https://opcua.demo-this.com:51212/UA/SampleServer/";
        "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";
    $ReadArguments1->NodeDescriptor->NodeId->ExpandedText = "nsu=http://test.org/UA/Data/ ;i=10853";

    $ReadArguments2 = new COM("OpcLabs.EasyOpc.UA.OperationModel.UAReadArguments");
    $ReadArguments2->EndpointDescriptor->UrlString = 
        //"http://opcua.demo-this.com:51211/UA/SampleServer";
        //"https://opcua.demo-this.com:51212/UA/SampleServer/";
        "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";
    $ReadArguments2->NodeDescriptor->NodeId->ExpandedText = "nsu=http://test.org/UA/Data/ ;i=10845";

    $ReadArguments3 = new COM("OpcLabs.EasyOpc.UA.OperationModel.UAReadArguments");
    $ReadArguments3->EndpointDescriptor->UrlString = 
        //"http://opcua.demo-this.com:51211/UA/SampleServer";
        //"https://opcua.demo-this.com:51212/UA/SampleServer/";
        "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";
    $ReadArguments3->NodeDescriptor->NodeId->ExpandedText = "nsu=http://test.org/UA/Data/ ;i=10304";

    $ReadArguments4 = new COM("OpcLabs.EasyOpc.UA.OperationModel.UAReadArguments");
    $ReadArguments4->EndpointDescriptor->UrlString = 
        //"http://opcua.demo-this.com:51211/UA/SampleServer";
        //"https://opcua.demo-this.com:51212/UA/SampleServer/";
        "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer";
    $ReadArguments4->NodeDescriptor->NodeId->ExpandedText = "nsu=http://test.org/UA/Data/ ;i=10389";

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
        printf("results[%d].AttributeData: %s<br>", $i, $results[$i]->AttributeData);
    }

?>
</body>
</html>
<!--#endregion Example-->
