<!--$$Header: $-->
<!-- Copyright (c) CODE Consulting and Development, s.r.o., Plzen. All rights reserved. -->
<html>
<head><title>ReadAndDisplayValue.php</title></head>
<body>
<?php

    // Create EasyOPC-DA component 
    $Client = new COM("OpcLabs.EasyOpc.DataAccess.EasyDAClient");

    // Read item value and display it
    // Note: An exception can be thrown from the statement below in case of failure. See other examples for proper error 
    // handling  practices!
    print $Client->ReadItemValue("", "OPCLabs.KitServer", "Demo.Single");
?>
</body>
</html>
