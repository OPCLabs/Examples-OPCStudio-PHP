<!--$$Header: $-->
<!-- Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved. -->

<!--#region Example-->
<!-- This example shows how to read value of a single node, and display it. -->
<!---->
<!-- Find all latest examples here: https://opclabs.doc-that.com/files/onlinedocs/OPCLabs-OpcStudio/Latest/examples.html .-->
<!-- OPC client and subscriber examples in PHP on GitHub: https://github.com/OPCLabs/Examples-QuickOPC-PHP .-->
<!-- Missing some example? Ask us for it on our Online Forums, https://www.opclabs.com/forum/index ! You do not have to own-->
<!-- a commercial license in order to use Online Forums, and we reply to every post.-->
<html>
<body>
<?php

    // Instantiate the client object
    $Client = new COM("OpcLabs.EasyOpc.UA.EasyUAClient");

    // Perform the operation
    $value = $Client->ReadValue(
        //"http://opcua.demo-this.com:51211/UA/SampleServer", 
        "opc.tcp://opcua.demo-this.com:51210/UA/SampleServer", 
        "nsu=http://test.org/UA/Data/ ;i=10853");

    // Display results
    // Read item value and display it
    printf("Value: %s<br>", $value);

?>
</body>
</html>
<!--#endregion Example-->
