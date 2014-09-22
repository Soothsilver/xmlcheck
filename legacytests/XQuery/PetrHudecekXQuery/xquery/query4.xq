(:
    Find the vehicle type that the most vehicles are vulnerable to 
    (i.e. the target of the most weaknesses)
:)
declare function local:weaknessCount($type as xs:string) as xs:integer
{
    count(doc("vehicles.xml")//vehicle[weakness = $type])
};

for $vehicleType in doc("vehicles.xml")//vehicle
where local:weaknessCount($vehicleType/type) = max(for $v in doc("vehicles.xml")//vehicle/type return local:weaknessCount($v))
return $vehicleType/type
