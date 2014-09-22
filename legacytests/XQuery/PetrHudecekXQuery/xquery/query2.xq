(:
    Prints the total power of all armies
:)

for $army in doc("data.xml")//army
return 
    element army {
    element name{ string ($army/attribute::id) },
    element power {
       sum(
       for $vehicle in $army//vehicle
       return doc("vehicles.xml")//vehicle[type=$vehicle/type]/power/text()
        )
   }
   }
