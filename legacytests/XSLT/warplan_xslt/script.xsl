<?xml version="1.0" encoding="UTF-8"?>
<nero:stylesheet xmlns:nero="http://www.w3.org/1999/XSL/Transform"
    xmlns:xs="http://www.w3.org/2001/XMLSchema"
    version="1.0">
    <nero:output version="4.01" method="html"></nero:output>
    <!-- Utility template. Prints a table of basic information about a soldier. Always prints a name. Will print country if available. Will print rank if available or a "none available" message. -->
    <nero:template name="PrintSoldier">
        <nero:param name="id"></nero:param>
        <nero:param name="role"></nero:param><!-- Role defines the caption of the table -->
        
        <nero:variable name="data" select="//person[@id=$id]"></nero:variable>
        <table border="1" width="400">
            <tr>
                <td colspan="2">
                    <nero:value-of select="$role"></nero:value-of>
                </td>
            </tr>
            <tr>
                <td>Name: </td>
                <td><nero:value-of select="$data/@name"></nero:value-of></td>
            </tr>
            <nero:if test="$data/country">
            <tr>
                <td>Country: </td>
                <td><nero:value-of select="$data/country/@name"></nero:value-of></td>
            </tr>
            </nero:if>
            <tr>
                <td>Rank: </td>
                <td>
                    <nero:choose>
                        <nero:when test="$data/rank"><nero:value-of select="$data/rank/text()"></nero:value-of></nero:when>
                        <nero:otherwise><i>No rank recorded.</i></nero:otherwise>
                    </nero:choose>
                </td>
            </tr>            
        </table>
    </nero:template>
    <!-- Pretty-prints information about a vehicle as a HTML <li> element. -->
    <nero:template match="vehicle" mode="li">
        <li><b><nero:value-of select="type"></nero:value-of></b> (<nero:value-of select="status"></nero:value-of>)</li>
    </nero:template>
    <!-- Determines and returns the numerical power of a vehicle. Each vehicle type has an assigned numerical power. For example, "Strong Tank" has a power of 10.
        In addition, vehicles with the 'Damaged' status have their numerical power cut by half. -->
    <nero:template match="vehicle" mode="power">
        <nero:variable name="type" select="type/text()"></nero:variable>
        <nero:variable name="basepower">
             <nero:choose>
                 <nero:when test="$type = 'Strong Tank'">10</nero:when>
                 <nero:when test="$type = 'Indestructible Tank'">50</nero:when>
                 <nero:when test="$type = 'Aircraft'">20</nero:when>
                 <nero:when test="$type = 'Mine Layer'">-20</nero:when> <!-- Mine Layers suck -->
                 <nero:when test="$type = 'Heavy Tank'">9</nero:when>
                 <nero:when test="$type = 'Medium Tank'">5</nero:when>
                 <nero:when test="$type = 'Light Tank'">2</nero:when>
                 <nero:otherwise>0</nero:otherwise>
             </nero:choose>
        </nero:variable>
        <nero:choose>
            <nero:when test="status/text() = 'Damaged'"><nero:value-of select="$basepower div 2"></nero:value-of></nero:when>
            <nero:otherwise><nero:value-of select="$basepower"></nero:value-of></nero:otherwise>
        </nero:choose>
    </nero:template>
    <!-- Returns the sum of numerical powers of all vehicles starting with the argument and continuing until no more sibling vehicles can be found.
        Call this tempalte on the first vehicle of each army to get the strength of that army. -->
    <nero:template name="SumPower">
        <nero:param name="vehicle"></nero:param>
        <nero:param name="accumulator"></nero:param>
        <nero:variable name="thispower">
            <nero:apply-templates mode="power" select="$vehicle"></nero:apply-templates>
        </nero:variable>
        <nero:variable name="power" select="number($accumulator) + number($thispower)"></nero:variable>
        <nero:choose>
            <nero:when test="$vehicle/following-sibling::vehicle">
                <nero:call-template name="SumPower">
                    <nero:with-param name="vehicle" select="$vehicle/following-sibling::vehicle[1]"></nero:with-param>
                    <nero:with-param name="accumulator" select="number($power)"></nero:with-param>
                </nero:call-template>
            </nero:when>
            <nero:otherwise><nero:value-of select="$power"></nero:value-of></nero:otherwise>
        </nero:choose>
    </nero:template>
    
    <!-- Main -->
    <nero:template match="/">
        <html>
            <head>
                <title>Battle Predicition Report</title>
            </head>
            <body>
                <h1>Battle Prediction Report</h1>
                
                <!-- Print information on report author -->
                <nero:call-template name="PrintSoldier">
                    <nero:with-param name="role">
                        <nero:text>Author of the report</nero:text>
                    </nero:with-param>
                    <nero:with-param name="id" select="/warplan/author/person/@id"></nero:with-param>
                </nero:call-template>
                
                <h2>Armies</h2>
                <!-- Each army will have a printed leader and list of all vehicles. -->
                <nero:for-each select="//army">
                    <h3><nero:value-of select="@id"></nero:value-of></h3>
                    <nero:call-template name="PrintSoldier">
                        <nero:with-param name="role">Leader</nero:with-param>
                        <nero:with-param name="id" select="leader/person_reference/@ref | leader/person/@id"></nero:with-param>
                    </nero:call-template>
                    <ul>
                    <nero:apply-templates select="vehicles/vehicle" mode="li"></nero:apply-templates>
                    </ul>
                </nero:for-each>
                
                <h2>Victory Chances</h2>
                <!-- Power of Heroes: -->
                <nero:variable name="HeroPower">
                    <nero:call-template name="SumPower">
                        <nero:with-param name="vehicle" select="//army[@id='Heroes']/descendant::vehicle[1]"></nero:with-param>
                        <nero:with-param name="accumulator">0</nero:with-param>
                    </nero:call-template>
                </nero:variable>
                <!-- Power of Iraqis: -->
                <nero:variable name="IraqiPower">
                    <nero:call-template name="SumPower">
                        <nero:with-param name="vehicle" select="//army[@id='Iraqis']/descendant::vehicle[1]"></nero:with-param>
                        <nero:with-param name="accumulator">0</nero:with-param>
                    </nero:call-template>
                </nero:variable>
                
                <!-- Output statistics -->
                Heroes' Power: <b><nero:value-of select="$HeroPower" /></b><br />
                Enemy Power: <b><nero:value-of select="$IraqiPower"></nero:value-of></b><br />
                <b>Victory Chance: <nero:value-of select="$HeroPower * 100 div ($HeroPower+$IraqiPower)"></nero:value-of>%</b>
                
                <!-- Some non-computable data from the original document -->                
                <nero:comment>
                    Notes from report author:
                   <nero:copy-of select="//notes"></nero:copy-of>
                </nero:comment>
            </body>
        </html>
    </nero:template>
    
    <!-- Safeguard against accidental use of implicit templates -->
    <nero:template match="*">IMPLICIT TEMPLATE USED !! WARNING !!!</nero:template>
</nero:stylesheet>