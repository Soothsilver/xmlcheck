<?php

use asm\plugin\CountedRequirements;
// TODO throw error when the XML file does not refer to the XSD file
/**
 * @ingroup plugins
 * Test for checking XMLSchema homework of XML Technologies lecture.
 * Accepted parameters are defined as class constants (and documented in-place).
 */
class TestXmlSchema extends \asm\plugin\XmlTest
{
	/// @name Names of accepted test parameters
	//@{

	const simpleTypes = 1;	///< minimum number of simple types
	const complexTypes = 2;	///< minimum number of complex types
	const elementRestrictions = 3;	///< minimum number of element restrictions
	const mandatoryAttributes = 4;	///< minimum number of mandatory attributes
	const optionalAttributes = 5;	///< minimum number of optional attributes
	const derivedSimpleType = 6;	///< minimum number of derived simple types
	const textElementsWithAttributes = 7;	///< minimum number of text elements with attributes
	const globalItemUses = 8;	///< minimum number of global item uses
	const localItemUses = 9;	///< minimum number of local item uses
	const references = 10;	///< minimum number of references
	const inheritances = 11;	///< minimum number of inheritances
	const identityRestrictions = 12;	///< minimum number of identity restrictions
	//@}

	/// @name Goal IDs
	//@{
	const goalValidSchema = 'validSchema';	///< XMLSchema is valid
	const goalValidToSchema = 'validToSchema';	///< XML is valid to XMLSchema
	const goalCoveredSchema = 'coveredSchema';	///< XMLSchema contains all required constructs
	/// XML contains uses elements defined in XMLSchema (currently unchecked)
	//const goalUsedSchema = 'usedSchema';
    const goalRefersToSchema = 'refersToSchema';
	//@}
    private $absolutePathToFolder;

    public function __construct($pathToSubmissionFolder)
    {
        $this->absolutePathToFolder = $pathToSubmissionFolder;
    }
	/**
	 * Checks whether XMLSchema is valid XML
	 * @param DOMDocument $schemaDom source XMLSchema
	 */
	protected function checkXmlSchema (DOMDocument $schemaDom)
	{
		$this->useLibxmlErrors();
		$schemaDom->validate();

		$this->reachGoalOnNoLibxmlErrors(self::goalValidSchema, self::sourceSchema);
	}

	/**
	 * Checks whether XML is valid to XMLSchema.
	 * @param DOMDocument $xmlDom source XML
	 * @param string $schemaString source XMLSchema
	 */
	protected function checkValidityToXmlSchema (DOMDocument $xmlDom, $schemaString)
	{
		$this->useLibxmlErrors();
       // var_dump($schemaString);
        try {
		    $isValid = $xmlDom->schemaValidateSource($schemaString);
        }
        catch (Exception $ex)
        {
            if ($this->reachGoalOnNoLibxmlErrors(self::goalValidToSchema, null))
            {
                $this->addError("An error occured while validating the document. This should not have happened. " . $ex->getMessage());
            }
            return;
        }
		$this->reachGoalOnNoLibxmlErrors(self::goalValidToSchema, null);
	}

	/**
	 * Checks coverage of required XMLSchema constructs.
	 * @param SimpleXMLElement $schemaXml source XMLSchema
	 * @return bool true on success
	 */
	protected function checkXmlSchemaConstructCoverage (SimpleXMLElement $schemaXml)
	{
		$xsdPrefixes = array_keys($schemaXml->getDocNamespaces(), 'http://www.w3.org/2001/XMLSchema');
		$xsdPrefix = count($xsdPrefixes) ? $xsdPrefixes[0] : 'xsd';
		$schemaXml->registerXPathNamespace('xs', 'http://www.w3.org/2001/XMLSchema');
		return $this->checkUsingXpath($schemaXml, self::goalCoveredSchema, array(
			'data' => array(
				self::simpleTypes => array('used simple types',
					'//xs:element[not(@type=/*//xs:complexType/@name)] | //xs:attribute[not(@type=/*//xs:complexType/@name)]'),
				self::complexTypes => array('used complex types',
					'//xs:element[@type=/*//xs:complexType/@name]'),
				self::elementRestrictions => array('used minOccurs or maxOccurs',
					'//*[@minOccurs or @maxOccurs]'),
				self::mandatoryAttributes => array('defined mandatory attributes',
					'//xs:attribute[@use="required"]'),
				self::optionalAttributes => array('defined optional attributes',
					'//xs:attribute[@use!="required" and @use!="prohibited"]'),
				self::derivedSimpleType => array('defined and used derived simple types',
					'//xs:simpleType[@name=/*//xs:element/@type or @name=/*//xs:attribute/@type] | //xs:element/xs:simpleType'),
				self::textElementsWithAttributes => array('defined complex-type simple-content elements with attributes ',
					'//xs:complexType[@name=/*//xs:element/@type][./xs:simpleContent/*/xs:attribute] | /*/*//xs:complexType[./xs:simpleContent/*/xs:attribute]'),
				self::globalItemUses => array('used globally defined items',
					'/*/*[@name=(/*//xs:element/@type | /*//xs:attribute/@type | /*//xs:element/@ref | /*//xs:group/@ref | /*//xs:attribute/@ref | /*//xs:attributeGroup/@ref)]'),
				self::localItemUses => array('used locally defined items',
					'/*/*//xs:simpleType | /*/*//xs:complexType'),
				self::references => array('used references',
					'//xs:element[@ref=/*/xs:element/@name] | //xs:group[@ref=/*/xs:group/@name] | //xs:attribute[@ref=/*/xs:attribute/@name] | //xs:attributeGroup[@ref=/*/xs:attributeGroup/@name]'),
				self::inheritances => array('used type inheritances',
					'//*[./xs:restriction or ./xs:extension]'),
				self::identityRestrictions => array('used identity restrictions',
					'//xs:unique | //xs:key | //xs:keyref[@refer=../xs:key/@name]'),
			),
			'counts' => $this->params,
		));
	}

	/**
	 * Checks use of defined elements in XML.
	 * @note Currently not implemented (goal is always reached).
	 * @param DOMDocument $xmlDom source XML
	 */
	protected function checkXmlUseOfSchemaDefs (DOMDocument $xmlDom)
	{
		// FIXME implement
	//	$this->reachGoal(self::goalUsedSchema);

/*
		$config = array(
			'data' => array(
				self::simpleTypes => array('used elements or attributes with simple type', 1),
				self::complexTypes => array('used elements with complex type', 1),
				self::elementRestrictions => array('used sub-elements with appearance restrictions', 1),
				self::mandatoryAttributes => array('used mandatory attributes', 1),
				self::optionalAttributes => array('used optional attributes', 1),
				self::derivedSimpleType => array('used elements or attributes with derived simple type', 1),
				self::textElementsWithAttributes => array('used text elements with attributes ', 1),
				self::globalItemUses => array('used items globally defined in schema', 1),
				self::localItemUses => array('used items locally defined in schema', 1),
				self::references => array('used items using references in schema', 1),
				self::inheritances => array('used items with extended or restricted type', 1),
				self::identityRestrictions => array('used items with identity restrictions', 1),
			),
			'counts' => $this->params,
		);
		$reqs = new CountedRequirements($config);
*/
	}
	
	protected function main()
	{
		$this->addGoals(array(
			self::goalValidSchema => 'XMLSchema document is valid XML',
			self::goalValidToSchema => 'XML is valid to XMLSchema schema',
			self::goalCoveredSchema => 'XMLSchema document contains all required constructs',
            self::goalRefersToSchema => 'XML document refers to the XML Schema via xsi:noNamespaceSchemaLocation or xsi:schemaLocation'
//			self::goalUsedSchema => 'XML contains instances of all required XMLSchema definitions',
		));

        $xmlFile = false; $xsdFile = false;
		$this->loadFiles($this->absolutePathToFolder, $xmlFile, $xsdFile);
        if ($this->hasErrors())
        {
            return;
        }

		if ($this->loadXml($xsdFile, false, $schemaDom, $error))
		{
			$this->reachGoal(self::goalValidSchema);
			$isSchemaCovered = $this->checkXmlSchemaConstructCoverage(simplexml_import_dom($schemaDom));

			if ($this->loadXml($xmlFile, false, $xmlDom, $error))
			{

				$this->checkValidityToXmlSchema($xmlDom, $schemaDom->saveXML());
                $this->checkThatXmlRefersToXsd($xmlDom, $xsdFile);

/*
				if ($isSchemaCovered)
				{
					$this->checkXmlUseOfSchemaDefs($xmlDom);
				}
				else
				{
					$this->failGoal(self::goalUsedSchema,
							'XMLSchema document doesn\'t contain all required constructs');
				}
*/
			}
			else
			{
				$this->failGoals(array(self::goalValidToSchema, self::goalRefersToSchema), $error);
			}
		}
		else
		{
			$this->failGoals(array(self::goalValidSchema, self::goalCoveredSchema,
					self::goalValidToSchema, self::goalRefersToSchema), $error);
		}
	}
    private function checkThatXmlRefersToXsd(DOMDocument $xmlDom, $xsdFilename)
    {
        $instanceSchema = "http://www.w3.org/2001/XMLSchema-instance";
        $actualFilename = basename($xsdFilename); // TODO we won't catch it if it's in a subfolder, but oh well, we'll have to deal with that on a different level.
        if ($xmlDom->documentElement)
        {
            $documentElement = $xmlDom->documentElement;
            if ($documentElement->hasAttributeNS($instanceSchema, "schemaLocation"))
            {
                $schemaLocation = trim($documentElement->getAttributeNodeNS($instanceSchema, "schemaLocation")->value);
                $parts = preg_split('/ +/', $schemaLocation);
                if (count($parts) !== 2)
                {
                    return $this->failGoal(self::goalRefersToSchema, "The schemaLocation's attribute value must contain a namespace and a filename separated by a space.");
                }
                if (basename($parts[1]) !== $actualFilename)
                {
                    return $this->failGoal(self::goalRefersToSchema, "The schemaLocation's attribute value's second part is not identical to the XSD filename found.");
                }
            }
            else if ($documentElement->hasAttributeNS($instanceSchema, "noNamespaceSchemaLocation"))
            {
                if (basename($documentElement->getAttributeNodeNS($instanceSchema, "noNamespaceSchemaLocation")->value) !== $actualFilename)
                {
                    return $this->failGoal(self::goalRefersToSchema, "The noNamespaceSchemaLocation's attribute value is not identical to the XSD filename found.");
                }
            }
            else
            {
                return $this->failGoal(self::goalRefersToSchema, "The root element must have either the 'http://www.w3.org/2001/XMLSchema-instance:schemaLocation' or 'http://www.w3.org/2001/XMLSchema-instance:noNamespaceSchemaLocation' attribute that point to the XSD file provided.");
            }
            $this->reachGoal(self::goalRefersToSchema);
        }
    }
     // TODO move elsewhere
    private function endsWith($haystack, $needle)
    {
        return $needle === "" || strtolower(substr($haystack, -strlen($needle))) === strtolower($needle);
    }
    /**
     * Attempts to find an XML and a XSD filename in the given folder and adds an error if it cannot find them.
     * @param $xmlFile The found XML filename.
     * @param $xsdFile The found XSD filename.
     */
    private function loadFiles($fromWhere, &$xmlFile, &$xsdFile)
    {
        $xmlFile = false;
        $xsdFile = false;
        $files = \asm\utils\Filesystem::getFiles($fromWhere);
        foreach ($files as $file)
        {
            if ($this->endsWith(strtolower($file), ".xml"))
            {
                if ($xmlFile === false)
                {
                    $xmlFile = \asm\utils\Filesystem::combinePaths($fromWhere, $file);
                }
                else
                {
                    $this->addError("There are two or more .xml files in your submission. There must only be one.");
                }
            }
            if ($this->endsWith(strtolower($file), ".xsd"))
            {
                if ($xsdFile === false)
                {
                    $xsdFile = \asm\utils\Filesystem::combinePaths($fromWhere, $file);
                }
                else
                {
                    $this->addError("There are two or more .dtd files in your submission. There must only be one.");
                }
            }
        }

        if ($xmlFile === false)
        {
            $this->addError("Your submission must contain an XML file ending with '.xml'.");
        }
        if ($xsdFile === false)
        {
            $this->addError("Your submission must contain an XSD file ending with '.xsd'.");
        }
    }
}

