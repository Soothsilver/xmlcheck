(:
    Gets all US-owned vehicle types that cannot be countered by the Iraqi army
:)
distinct-values(for $vehicle in doc("data.xml")//army[@id="Heroes"]//vehicle
where 
    every $iraqiVehicle in doc("data.xml")//army[@id="Iraqis"]//vehicle
    satisfies
        not(doc("vehicles.xml")//vehicle[type=$iraqiVehicle/type]/counters = $vehicle/type)
return
    string($vehicle/type/text())
)
