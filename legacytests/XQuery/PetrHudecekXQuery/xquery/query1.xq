(:
    Prints an XHTML table of all vehicle types order by descending numerical power
:)
<html>
<head>
 <title>XHTML table of vehicle types</title>
</head>
<body>
<table border="1">
<tr>
 <th>Name</th>
 <th>Power</th>
 <th>Weakness to</th>
</tr>
{
    for $vehicle in doc("vehicles.xml")//vehicle
    order by $vehicle/power descending
    return
     element tr {
        element td {
            $vehicle/type/text()
        },
        element td {
            $vehicle/power/text()
        },
        element td {
            element ul {
                for $weakness in $vehicle/weakness
                return element li {
                    $weakness/text()
                }
            }
        }
     }
}
</table>
</body>
</html>


