(:
    Creates a tree structure of all vehicles of US army
:)
declare function local:print($vehicle as element()) as element()
{
 element { fn:replace($vehicle/type/text(), " ", "_") } 
 {
    element cost { doc("vehicles.xml")//vehicle[type = $vehicle/type]/cost },
    if ($vehicle/drones) then
        element helpers {
            for $drone in $vehicle/drones/vehicle
            return local:print($drone)
        }
    else ()
 }
};
<vehicles>
{
for $vehicle in doc("data.xml")//army[@id="Heroes"]/vehicles/vehicle
return
 local:print($vehicle)
}
</vehicles>