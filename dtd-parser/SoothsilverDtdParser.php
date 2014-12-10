<?php
/*
 * To-do list for this library:
 * - Add a feature to prevent XML explosion
 * - Remember comments and line feeds inside comments count
 */
namespace Soothsilver\DtdParser;
/**
 * @defgroup SoothsilverDtdParser Soothsilver DTD Parser
 * A standalone DTD parser for PHP.
 * @{
 */

/**
 * @namespace Soothsilver
 * Contains all classes belonging to the standalone DTD parser. This is a supernamespace based on the author's nickname.
 */

/**
 * @namespace Soothsilver\DtdParser
 * Contains all classes belonging to the standalone DTD parser.
 */


/**
 * Represents all information extracted from a Document Type Declaration file, possibly combined with an internal subset.
 */
class DTD
{
    /**
     * List of element types sorted in declaration order. If an ATTLIST declaration preceded the ELEMENT declaration,
     * the position is determined by the ATTLIST declaration.
     * @var Element[]
     */
    public $elements = [];
    /**
     * List of declared parameter entities.
     * @var ParameterEntity[]
     */
    public $parameterEntities = [];
    /**
     * List of declared general entities.
     * @var GeneralEntity[]
     */
    public $generalEntities = [];
    /**
     * List of declared notations.
     * @var Notation[]
     */
    public $notations = [];
    /**
     * List of errors in the DTD document. If this array is not empty, the document violates the XML specification.
     * Even if an error is generated, some information about the document may be available in the DTD object.
     * @var Error[]
     */
    public $errors = [];
    /**
     * List of warnings generated when parsing the document. A warning is generated in some cases when the XML
     * specification allows a processor to generate a warning.
     * @var Error[]
     */
    public $warnings = [];
    /**
     * List of processing instructions encountered while parsing the document. Processing instructions are not executed
     * in any way.
     * @var ProcessingInstruction[]
     */
    public $processingInstructions = [];

    /**
     * Returns a boolean representing the well-formedness and validity of the DTD.
     * @return bool True, if no errors were triggered during parsing; false otherwise.
     */
    public function isWellFormedAndValid()
    {
        return count($this->errors) === 0;
    }

    /**
     * Notice: Parsing external entities is a security problem. User should be given an option to enable or disable it.
     * Since the DTD Parser is now used only in the XMLCheck project where it is not desirable to load external entities,
     * this functionality is not programmed in.
     * @var bool Should external entities be parsed as well?
     */
    private $shouldLoadExternalEntities = false;
    /**
     * @var int The character position in the DTD document where the parser is at.
     */
    private $currentOffset = 0;
    /**
     * @var int The line in the DTD document that is being processed. Lines are counted from 1.
     */
    private $line = 1;
    /**
     * @var Internal\XmlRegexes An internal object which contains regular expressions for some common productions from
     * the XML specification.
     */
    private $xmlRegexes;

    /**
     * Puts a new warning into the warnings list.
     * @param $message The warning message to show to the user.
     * @param $line The line at which the warning triggered.
     */
    private function addWarning($message, $line)
    {
        $this->warnings[] = new Error($message . " (line " . $line . ")");
    }

    /**
     * Puts a new error into the errors list. Calling this function means the DTD document contains a violation of
     * the XML specification.
     * @param $message The error message to show to the user.
     * @param $line The line at which the error triggered.
     */
    private function addFatalError($message, $line)
    {
        $this->errors[] = new Error($message . " (line " . $line . ")");
    }

    /**
     * Checks if the supplied string matches the XML production NAME.
     * @param $name The string to check for being a NAME.
     * @return bool Is the string a valid NAME production?
     */
    private function isNameValid($name)
    {
        return preg_match("#" . $this->xmlRegexes->Name . "#u", $name) === 1;
    }
    /**
     * Checks if the supplied string matches the XML production NMTOKEN.
     * @param $name The string to check for being a NMTOKEN.
     * @return bool Is the string a valid NMTOKEN production?
     */
    private function isNmTokenValid($nmToken)
    {
        return preg_match("#" . $this->xmlRegexes->NmToken . "#u", $nmToken) === 1;
    }

    /**
     * Reads characters from the specified position until it encounters a non-whitespace character, then returns
     * the position of this character. If no such character is found, then it returns false.
     *
     * This also increments the line counter if a newline is encountered.
     * @param string $text The text to search through (haystack).
     * @param int $startAt The position from where to start.
     * @param int $length The length of the text.
     * @return bool|int The position of the first non-whitespace character or false if end of text was reached.
     */
    private function findNonSpace($text, $startAt, $length)
    {
        $index = $startAt;
        while ($index < $length)
        {
            $mbCharacter = substr($text, $index, 1);
            if ($mbCharacter === ' ' || $mbCharacter === "\t")
            {
                $index++;
            }
            else if ($mbCharacter === "\n")
            {
                $this->line++;
                $index++;
            }
            else
            {
                return $index;
            }
        }
        return false;
    }

    /**
     * The string given is split by whitespace into individual words, with the following exceptions:
     * 1. A quote (") open a quoted string which is put into a single token even if it includes whitespaces or apostrophes. This token is ended by the next quote (").
     * 2. The same goes for apostrophe (') except that apostrophe ends the token and quotes inside are not recognized.
     * In both of the cases above, the quotes or apostrophes are put into a single, separate tokens.
     * 3. An opening parenthesis ('(') forces a different mode where tokens are separated by whitespace and the '|' character as in the enumeration or notation attribute type definition in DTD. If two words inside are separated only by whitespace but not by '|', the tokenization fails.
     * Some other caveats apply. Sorry for not detailing them here.
     * @param string $string The string to split into tokens.
     * @param string $tokenizationErrorMessage Out-parameter. If tokenization fails, this is filled with the reason.
     * @return string[]|bool An array of string tokens if tokenization is successful; false otherwise.
     */
    private function tokenize($string, &$tokenizationErrorMessage)
    {
        $length = strlen($string);
        $tokens = [];
        $outerQuote = false;
        $constructingWord = "";
        $afterWhitespace = false;
        $prohibitNonTerminalInsideParentheses = false;
        for ($i = 0; $i < $length; $i++)
        {
            $char = $string[$i];
            switch($char)
            {
                case "\t":
                case "\n":
                case " ":
                    if ($constructingWord !== "" && $outerQuote === false)
                    {
                        $tokens[] = $constructingWord;
                        $constructingWord = "";
                    }
                    else if ($outerQuote !== false)
                    {
                        if ($outerQuote === "(")
                        {
                            if ($constructingWord !== "")
                            {
                                if ($prohibitNonTerminalInsideParentheses)
                                {
                                    // Inside an enum, this was done: "( A B | C)" which is prohibited
                                    $tokenizationErrorMessage = "Inside an enumeration, values must be separated by the '|' character, not by whitespace.";
                                    return false;
                                }
                                $tokens[] = $constructingWord;
                                $constructingWord = "";
                                $prohibitNonTerminalInsideParentheses = true;
                            }
                        }
                        else
                        {
                            $constructingWord .= $char;
                        }
                    }
                    $afterWhitespace = true;
                    break;
                case "|":
                    $afterWhitespace = false;
                    if ($outerQuote === "(")
                    {
                        if ($constructingWord !== "")
                        {
                            if ($prohibitNonTerminalInsideParentheses)
                            {
                                // Inside an enum, this was done: "( A B | C)" which is prohibited
                                $tokenizationErrorMessage = "Inside an enumeration, values must be separated by the '|' character, not by whitespace.";
                                return false;
                            }
                            $tokens[] = $constructingWord;
                            $constructingWord = "";
                        }
                        $tokens[] = "|";
                        $prohibitNonTerminalInsideParentheses = false;
                    }
                    else
                    {
                        $constructingWord .= "|";
                    }
                    break;
                case "(":
                    $afterWhitespace = false;
                    if ($outerQuote === false)
                    {
                        $tokens[] = "(";
                        $outerQuote = "(";
                        $prohibitNonTerminalInsideParentheses = false;
                    }
                    else
                    {
                        $constructingWord .= "(";
                    }
                    break;
                case ")":
                    $afterWhitespace = false;
                    if ($outerQuote === false)
                    {
                        // This character should not be anywhere on its own.
                        $tokenizationErrorMessage = "The ')' character is illegal here.";
                        return false;
                    }
                    else if ($outerQuote === '(')
                    {
                        if ($constructingWord !== "")
                        {
                            $tokens[] = $constructingWord;
                            $constructingWord = "";
                        }
                        $tokens[] = ")";
                        $outerQuote = false;
                    }
                    else
                    {
                        $constructingWord .= ")";
                    }
                    break;
                case "'":
                case '"':
                    if ($outerQuote === false && $afterWhitespace === true)
                    {
                        $tokens[] = $char;
                        $outerQuote = $char;
                    }
                    else if ($outerQuote !== false)
                    {
                        if ($outerQuote === $char)
                        {
                             $tokens[] = $constructingWord;
                             $tokens[] = $char;
                             $constructingWord = "";
                             $outerQuote = false;
                        }
                        else
                        {
                            $constructingWord .= $char;
                        }
                    }
                    else
                    {
                        $tokenizationErrorMessage = "Quotes must only appear after whitespace in this context.";
                        return false;
                    }
                    $afterWhitespace = false;
                    break;
                default:
                    $constructingWord .= $char;
                    $afterWhitespace = false;
                    break;
            }
        }
        if ($constructingWord !== "")
        {
            $tokens[] = $constructingWord;
        }
        return $tokens;
    }

    /**
     * Checks whether the specified haystack begins with the specified needle.
     * @param $haystack The string whose beginning we search. (TODO grammar)
     * @param $needle The beginning we search for.
     * @return bool Does the haystack start with the needle?
     */
    private function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    /**
     * Evaluates all parameter entity references in the specified text according to the specified mode as per the
     * XML specification. Returns the expanded text. Parameter entities are expanded recursively.
     * @param $text The text to scan for parameter entities.
     * @param $peStyle The mode of expansion. Depending on the mode, entities are expanded differently as per the specification.
     * @return string The text with all parameter entities expanded.
     */
    private function evaluatePEReferencesIn($text, $peStyle)
    {
        $matches = [];
        while (preg_match('#(("[^"]*")|(\'[^\']*\')|[^\'"])*%([^;]*);#', $text, $matches, PREG_OFFSET_CAPTURE) === 1)
        {
            $entityBeginsAt = $matches[4][1] - 1;
            $entityEndsBefore = $matches[4][1] + strlen($matches[4][0])+1;
            $entityName = $matches[4][0];
            if (array_key_exists($entityName, $this->parameterEntities))
            {
                $replacementText = $this->parameterEntities[$entityName]->replacementText;
                switch($peStyle)
                {
                    case Internal\PEStyle::IgnoreQuotedText:
                    case Internal\PEStyle::MatchingParentheses: // TODO matching parentheses do not work
                         // The two spaces are mandated by specification to disallow funny stuff
                         $text = substr($text, 0, $entityBeginsAt) . " " . $replacementText . " " . substr($text, $entityEndsBefore);
                        break;
                    case Internal\PEStyle::InEntityDeclaration:
                        // Included in literal.
                        $text = substr($text, 0, $entityBeginsAt) . $replacementText . substr($text, $entityEndsBefore);
                        break;
                    default:
                        trigger_error("Bad peStyle argument.", E_ERROR);
                        break;
                }
            }
            else
            {
                $this->addFatalError("Parameter entity '" . $entityName . "' is used, but not defined.", $this->line);
                return $text;
            }
        }
        return $text;
    }

    private function parseGlobalPEReference($referenceText)
    {
        // TODO what is the meaning of this?
        $this->addFatalError("The parameter entity '" . $referenceText . "' is not yet declared.", $this->line);
    }

    /**
     * Checks whether the three tokens in $tokens starting $index exist, represent matching quotation marks and then
     * returns the middle token.
     * @param array $tokens An array of tokens.
     * @param int $index The index of the token which should represent the first apostrophe or double quote.
     * @return bool|string The token, if parsed correctly; otherwise false. If false is returned, a fatal error is triggered as well.
     */
    private function parseQuotedString($tokens, $index)
    {
        if ($index + 2 >= count($tokens))
        {
            $this->addFatalError("End of declaration reached while trying to parse a quoted string.", $this->line);
            return false;
        }
        $firstQuote = $tokens[$index];
        $middle = $tokens[$index+1];
        $lastQuote = $tokens[$index+2];
        if ($firstQuote !== "'" && $firstQuote !== '"')
        {
            $this->addFatalError("A quotation mark or apostrophe was expected but '" . $firstQuote . "' is present instead.", $this->line);
            return false;
        }
        if ($firstQuote !== $lastQuote)
        {
            $this->addFatalError("Quotes must match at the ends of each quoted string.", $this->line);
            return false;
        }
        return $middle;
    }

    /**
     * Checks whether the three tokens in $tokens starting $index exist, represent matching quotation marks and then
     * returns the middle token.
     *
     * Notice: This is a wrapper around parseQuotedString that does no additional work.
     * @param array $tokens An array of tokens.
     * @param int $index The index of the token which should represent the first apostrophe or double quote.
     * @return bool|string The token, if parsed correctly; otherwise false. If false is returned, a fatal error is triggered as well.
     */
    private function parseExternalIdentifier($tokens, $index)
    {
        $identifier = $this->parseQuotedString($tokens, $index);
        return $identifier;
    }

    /**
     * Parses an element declaration and adds it to the element list. If it fails, it adds an error to the error list.
     * @param string $declaration The !ELEMENT declaration string, starting just after the !ELEMENT text.
     */
    private function parseElement($declaration)
    {
        $declaration = $this->evaluatePEReferencesIn($declaration, Internal\PEStyle::MatchingParentheses);
        $tokens = array_values(array_filter(preg_split("/\s+/", $declaration)));
        if (count($tokens) === 0)
        {
            $this->addFatalError("An <!ELEMENT> declaration must have a type name.", $this->line);
            return;
        }
        $name = $tokens[0];
        if (!$this->isNameValid($name))
        {
            $this->addFatalError("'{$name}' is not a valid element name.'", $this->line);
        }
        $contentspec = false;
        $isMixed = false;
        if (count($tokens) === 1)
        {
            $this->addFatalError("'{$name}' does not have content type specified.", $this->line);
        }
        else if (count($tokens) === 2)
        {
            if ($tokens[1] === "ANY") { $contentspec = "ANY"; }
            else if ($tokens[1] === "EMPTY") { $contentspec = "EMPTY"; }
        }
        if ($contentspec === false)
        {
            array_shift($tokens);
            $contentspec = implode("", $tokens);
            $contentspec = str_replace(" ", "", $contentspec);
            $contentspec = str_replace("\t", "", $contentspec);
            $contentspec = str_replace("\n", "", $contentspec);
            $isMixed = $this->startsWith($contentspec, "(#PCDATA");
            // We should verify the legality of the context regular expression here, but we don't need it.
            // In future versions of the DTDParser, this should probably be done.
        }
        if (array_key_exists($name, $this->elements))
        {
            if ($this->elements[$name]->contentSpecification === Element::CONTENT_SPECIFICATION_NOT_GIVEN)
            {
                $this->elements[$name]->contentSpecification = $contentspec;
                $this->elements[$name]->mixed = $isMixed;
            }
            else
            {
                $this->addFatalError("This element ('{$name}') was already declared.", $this->line);
            }
            return;
        }
        else
        {
            $this->elements[$name] = new Element($name, $contentspec, $isMixed);
        }
    }

    /**
     * Parses an ATTLIST declaration and adds the information to the element list. If it fails, an error will be
     * added to the error list.
     * @param string $markupDeclaration The !ATTLIST declaration string, starting just after the !ATTLIST text.
     */
    private function parseAttlist($markupDeclaration)
    {
        $markupDeclaration = $this->evaluatePEReferencesIn($markupDeclaration, Internal\PEStyle::IgnoreQuotedText);
        $tokens = $this->tokenize($markupDeclaration, $tokenizationError);
        if ($tokens === false)
        {
            $this->addFatalError("ATTLIST declaration could not be tokenized: " . $tokenizationError, $this->line);
            return;
        }
        if (count($tokens) === 0)
        {
            $this->addFatalError("An <!ATTLIST> declaration must have a type name.", $this->line);
            return;
        }
        $elementType = $tokens[0];
        if (!$this->isNameValid($elementType))
        {
            $this->addFatalError("'{$elementType}' is not a valid element name.'", $this->line);
        }
        $tokenId = 1;
        $attributeName = false;
        $attributeType = false;
        $attributeEnumeration = [];
        $attributeDefaultValue = false;
        $attributeDefaultType = false;
        $state = Internal\AttlistMode::NeedName;
        while ($tokenId < count($tokens))
        {
            $token = $tokens[$tokenId];
            if ($state === Internal\AttlistMode::NeedName)
            {
                if (!$this->isNameValid($token)) { $this->addFatalError("'{$token}' is not a valid attribute name.'", $this->line); }
                $attributeName = $token;
                $state = Internal\AttlistMode::NeedAttType;
            }
            else if ($state === Internal\AttlistMode::NeedAttType)
            {
                $state = Internal\AttlistMode::NeedDefaultDecl;
                switch($token)
                {
                    case "CDATA":
                    case "ID":
                    case "IDREF":
                    case "IDREFS":
                    case "ENTITY":
                    case "ENTITIES":
                    case "NMTOKEN":
                    case "NMTOKENS":
                        $attributeType = $token;
                        break;
                    case "(":
                        $attributeType = Attribute::ATTTYPE_ENUMERATION;
                        $state = Internal\AttlistMode::InsideEnumeration_NeedValue;
                        break;
                    case "NOTATION":
                        $attributeType = Attribute::ATTTYPE_NOTATION; // TODO validity checks
                        $state = Internal\AttlistMode::AfterNOTATION;
                        break;
                    default:
                        $this->addFatalError("The attribute '" . $attributeName . "' has a declared type that does not exist.", $this->line);
                        break;
                }
            }
            else if ($state === Internal\AttlistMode::InsideEnumeration_NeedValue)
            {
                if (!$this->isNmTokenValid($token))
                {
                    $this->addFatalError("An enumerated type must only have NMTOKENs as possible values.", $this->line);
                    return;
                }
                $attributeEnumeration[] = $token;
                $state = Internal\AttlistMode::InsideEnumeration_NeedSeparator;
            }
            else if ($state === Internal\AttlistMode::InsideEnumeration_NeedSeparator)
            {
                if ($token === "|")
                {
                    $state = Internal\AttlistMode::InsideEnumeration_NeedValue;
                }
                else if ($token === ")")
                {
                    $state = Internal\AttlistMode::NeedDefaultDecl;
                }
                else
                {
                    $this->addFatalError("In the attribute '{$attributeName}' enumeration, the token '|' or ')' was expected.", $this->line);
                }
            }
            else if ($state === Internal\AttlistMode::AfterNOTATION)
            {
                if ($token === "(")
                {
                    $state = Internal\AttlistMode::InsideEnumeration_NeedValue;
                }
                else
                {
                    $this->addFatalError("The attribute '" . $attributeName . "' is declared NOTATION but misses a notations enumeration.", $this->line);
                }
            }
            else if ($state === Internal\AttlistMode::NeedDefaultDecl)
            {
                switch($token)
                {
                    case "#REQUIRED":
                    case "#IMPLIED":
                        $attributeDefaultValue = "";
                        $attributeDefaultType = $token;
                        break;
                    case "#FIXED":
                        $attributeDefaultType = "#FIXED";
                        if ($tokenId + 3 < count($tokens))
                        {
                            if  (($tokens[$tokenId+1] === "'" && $tokens[$tokenId+3] === "'") ||
                                 ($tokens[$tokenId+1] === '"' && $tokens[$tokenId+3] === '"'))
                            {
                                // Parameter entities should not be expanded here.
                                $attributeDefaultValue = $tokens[$tokenId+2];
                            }
                            else
                            {
                                $this->addFatalError("The attribute '" . $attributeName . "' has an #FIXED declaration.", $this->line);
                            }
                            $tokenId+=3;
                        }
                        else
                        {
                            $this->addFatalError("The attribute '" . $attributeName . "' has a #FIXED declaration, but its default value is not provided.", $this->line);
                        }
                        break;
                    case "'":
                    case '"':
                        $attributeDefaultType = Attribute::DEFAULT_IMPLICIT_DEFAULT;
                        if ($tokenId + 2 < count($tokens))
                        {
                            if  ($tokens[$tokenId+2] === $token)
                            {
                                // Parameter entities should not be expanded here.
                                $attributeDefaultValue = $tokens[$tokenId+1];
                            }
                            else
                            {
                                $this->addFatalError("The attribute '" . $attributeName . "' starts quoting a default value, but does not finish this quotation.", $this->line);
                            }
                            $tokenId += 2;
                        }
                        else
                        {
                            $this->addFatalError("The attribute '" . $attributeName . "' starts a default value declaration, but does not finish it.", $this->line);
                        }
                        break;
                    default:
                        $this->addFatalError("The attribute '" . $attributeName . "' has an invalid DefaultDeclaration.", $this->line);
                        break;
                }
                $attributeCreated = new Attribute($attributeName, $attributeType, $attributeDefaultType, $attributeDefaultValue, $attributeEnumeration);
                if (!array_key_exists($elementType, $this->elements))
                {
                    $this->elements[$elementType] = new Element($elementType, Element::CONTENT_SPECIFICATION_NOT_GIVEN, false);
                }
                if (array_key_exists($attributeName, $this->elements[$elementType]->attributes))
                {
                    // At user option, for interopability, the XML processor may issue a warning.
                    // This processor chooses not to issue it. At any rate, we must keep the previous definition.
                }
                else
                {
                    $this->elements[$elementType]->attributes[$attributeName] = $attributeCreated;
                }
                $attributeName = false;
                $attributeDefaultType = false;
                $attributeDefaultValue = false;
                $attributeEnumeration = false;
                $attributeType = false;
                $state = Internal\AttlistMode::NeedName;
            }
            $tokenId++;
        }

        if ($attributeName !== false)
        {
            $this->addFatalError("An attribute definition inside the ATTLIST was not completed.", $this->line);
        }
    }

    /**
     * Parses a notation declaration and adds it to the notations list. If it fails, an error is added to the error list.
     * @param string $markupDeclaration The !NOTATION declaration string, starting just after the !NOTATION text.
     */
    private function parseNotation($markupDeclaration)
    {
        $markupDeclaration = $this->evaluatePEReferencesIn($markupDeclaration, Internal\PEStyle::IgnoreQuotedText);
        $tokens = $this->tokenize($markupDeclaration, $tokenizationError);
        if ($tokens === false)
        {
            $this->addFatalError("Notation declaration could not be tokenized: " . $tokenizationError, $this->line);
            return;
        }

        if (count($tokens) === 5 || count($tokens) === 8)
        {
            $error = false;
            $name = $tokens[0];
            if (!$this->isNameValid($name))
            {
                $this->addFatalError("'" . $name . "' is not a valid NOTATION name.", $this->line);
                return;
            }
            $externalIDType = $tokens[1];
            $systemId = "";
            $publicId = "";
            if ($tokens[2] !== $tokens[4]) { $error = true; }
            if ($tokens[2] !== "'" && $tokens[2] !== '"') { $error = true; }
            if ($externalIDType !== "PUBLIC" && $externalIDType !== "SYSTEM")
            {
                $this->addFatalError("Notations must be either PUBLIC or SYSTEM.", $this->line);
                return;
            }
            if ($externalIDType === "SYSTEM")
            {
                $systemId = $tokens[3];
            }
            if ($externalIDType === "PUBLIC")
            {
                $publicId = $tokens[3];
            }
            if (count($tokens) === 8)
            {
                if ($tokens[5] !== $tokens[7]) { $error = true; }
                if ($tokens[5] !== "'" && $tokens[5] !== '"') { $error = true; }
                $systemId = $tokens[6];
                if ($externalIDType !== "PUBLIC")
                {
                    $this->addFatalError("A public identifier was provided even thought the notation is not declared PUBLIC.", $this->line);
                    return;
                }
            }
            if ($error)
            {
                $this->addFatalError("External ID's in '" . $markupDeclaration . "' are not properly quoted.", $this->line);
                return;
            }

            $notation = new Notation($name, $systemId, $publicId);
            if (array_key_exists($name, $this->notations))
            {
                $this->addFatalError("Notation '" . $name . "' is already declared.", $this->line);
                return;
            }
            $this->notations[$name] = $notation;
        }
        else
        {
            $this->addFatalError("'" . $markupDeclaration . "' is not a well-formed NOTATION declaration.", $this->line);
        }
    }

    /**
     * Parses an !ENTITY declaration and adds it to the general entities or parameter entities list. If it fails,
     * it adds an error to the error list. If it's a parameter entity, its replacement text is generated at this point
     * by evaluating parameter entity references inside its value.
     * @param string $markupDeclaration An !ENTITY declaration string, starting just after the !ENTITY text.
     */
    private function parseEntityDeclaration($markupDeclaration)
    {
        $tokenizationError = "";
        $markupDeclaration = $this->evaluatePEReferencesIn($markupDeclaration, Internal\PEStyle::IgnoreQuotedText);
        $tokens = $this->tokenize($markupDeclaration, $tokenizationError);
        if ($tokens === false)
        {
            $this->addFatalError("Entity declaration could not be tokenized: " . $tokenizationError, $this->line);
            return;
        }
        if (count($tokens) < 4)
        {
            $this->addFatalError("'" . $markupDeclaration . "' is not a well-formed ENTITY declaration.", $this->line);
            return;
        }
        $tokenId = 0;
        $isParametric = false;
        $isExternal = false;
        $publicIdentifier = false;
        $systemIdentifier = false;
        $notation = false;
        if ($tokens[$tokenId] === "%")
        {
            $isParametric = true;
            $tokenId++;
        }
        $name = $tokens[$tokenId];
        $tokenId++;
        if (!$this->isNameValid($name))
        {
            $this->addFatalError("'" . $name . "' is not a valid ENTITY name.", $this->line);
            return;
        }
        if ($tokens[$tokenId] === "SYSTEM" || $tokens[$tokenId] === "PUBLIC")
        {
            if ($tokens[$tokenId] === "SYSTEM")
            {
                if ($tokenId + 3 <= count($tokens) - 1)
                {
                    if ($tokens[$tokenId + 1] === $tokens[$tokenId + 3])
                    {
                        if ($tokens[$tokenId + 1 ] === "'" || $tokens[$tokenId + 1] === '"')
                        {
                            $systemIdentifier = $tokens[$tokenId + 2];
                        }
                        else
                        {
                            $this->addFatalError("'" . $markupDeclaration . "' is not a well-formed SYSTEM external ENTITY because its SystemId was not properly quoted.", $this->line);
                            return;
                        }
                    }
                    else
                    {
                        $this->addFatalError("'" . $markupDeclaration . "' is not a well-formed SYSTEM external ENTITY because its SystemId quotes do not match.", $this->line);
                        return;
                    }
                }
                else
                {
                    $this->addFatalError("'" . $markupDeclaration . "' is not a well-formed SYSTEM external ENTITY because it could not be properly tokenized.", $this->line);
                    return;
                }
                $tokenId += 4;
            }
            else // Public identifier
            {
                $tokenId++;
                $publicIdentifier = $this->parseExternalIdentifier($tokens, $tokenId);
                if ($publicIdentifier === false) {
                    $this->addFatalError("Parsing the public identifier of '" . $markupDeclaration . "' failed.", $this->line);
                    return;
                }

                $tokenId += 3;
                $systemIdentifier = $this->parseExternalIdentifier($tokens, $tokenId);
                if ($publicIdentifier === false) {
                    $this->addFatalError("Parsing the system identifier of '" . $markupDeclaration . "' failed.", $this->line);
                    return;
                }

                $tokenId += 3;
            }
            $replacementText = "";
            $isExternal = true;
            if ($tokenId < count($tokens))
            {
                if ($tokens[$tokenId] === "NDATA")
                {
                    $tokenId++;
                    if ($tokenId === count($tokens)-1)
                    {
                        $notation = $tokens[$tokenId];
                        $tokenId++;
                        if (!$this->isNameValid($notation))
                        {
                            $this->addFatalError("In a general entity declaration, NDATA was followed by '" . $notation . "' which is not a Name.", $this->line);
                            return;
                        }
                        if (!array_key_exists($notation, $this->notations))
                        {
                            $this->addFatalError("An ENTITY declaration refers to the notation '" . $notation . "' which is not yet declared.", $this->line);
                            return;
                        }
                        if ($isParametric)
                        {
                            $this->addFatalError("Parametric entities may not have an NDATA specifier.", $this->line);
                            return;
                        }
                    }
                    else
                    {
                        $this->addFatalError("In a general entity declaration, the keyword NDATA must be followed by a Name only. It is followed by something else, however.", $this->line);
                        return;
                    }
                }
                else
                {
                    $this->addFatalError("NDATA or end of entity declaration expected", $this->line);
                    return;
                }
            }
            if ($this->shouldLoadExternalEntities)
            {
                if (file_exists($systemIdentifier))
                {
                    $externalContent = file_get_contents($systemIdentifier);
                    if ($externalContent !== false)
                    {
                        // This should probably, at user option, be permitted.
                        $this->addWarning("This DTD parser is not programmed to parse additional external entities.", $this->line);
                    }
                    else
                    {
                        $this->addWarning("An external parameter entity is declared but reading from the file given by system identifier failed.", $this->line);
                    }
                }
                else
                {
                    $this->addWarning("An external parameter entity is declared but its system identifier does not point to a file.", $this->line);
                }
            }
        }
        else if ($tokens[$tokenId] === "'" || $tokens[$tokenId] === '"')
        {
            if ($tokens[$tokenId] === $tokens[$tokenId+2] && count($tokens) === $tokenId+3)
            {
                $replacementText = $tokens[$tokenId+1];
                $replacementText = $this->evaluatePEReferencesIn($replacementText, Internal\PEStyle::InEntityDeclaration);
                if (strpos($replacementText, "%") !== false)
                {
                    $this->addFatalError("Entities cannot contain the character '%' unless as part of a parameter entity reference.", $this->line);
                    return;
                }
                $tokenId += 3;
            }
            else
            {
                $this->addFatalError("'" . $markupDeclaration . "' is not a well-formed ENTITY because it contains additional illegal markup.", $this->line);
                return;
            }
        }
        else
        {
            $this->addFatalError("'" . $markupDeclaration . "' is not a well-formed ENTITY.", $this->line);
            return;
        }
        if ($tokenId !== count($tokens))
        {
            $this->addFatalError("'" . $markupDeclaration . "' contains additional illegal tokens near the end.", $this->line);
            return;
        }
        if ($isParametric)
        {
            if (!array_key_exists($name, $this->parameterEntities))
            {
                 // We could issue a warning (at user option), but we must not issue an error.
                 $this->parameterEntities[$name] = new ParameterEntity($name, $replacementText, $isExternal, $systemIdentifier, $publicIdentifier);
            }
        }
        else
        {
            if (!array_key_exists($name, $this->generalEntities))
            {
                $this->generalEntities[$name] = new GeneralEntity($name, $replacementText, $isExternal, $systemIdentifier, $publicIdentifier, $notation);
            }
        }
    }

    /**
     * Parses the specified string as a DTD markup declaration.
     * @param string $markupDeclaration A DTD markup declaration to parse.
     */
    private function parseMarkupDeclaration($markupDeclaration)
    {
        if ($this->startsWith($markupDeclaration, "<!ELEMENT ") || $this->startsWith($markupDeclaration, "<!ELEMENT\n") || $this->startsWith($markupDeclaration, "<!ELEMENT\t"))
            $this->parseElement(substr($markupDeclaration, strlen("<!ELEMENT "), -1));
        else if ($this->startsWith($markupDeclaration, "<!ATTLIST ")|| $this->startsWith($markupDeclaration, "<!ATTLIST\n") || $this->startsWith($markupDeclaration, "<!ATTLIST\t"))
            $this->parseAttlist(substr($markupDeclaration, strlen("<!ATTLIST "), -1));
        else if ($this->startsWith($markupDeclaration, "<!NOTATION ")|| $this->startsWith($markupDeclaration, "<!NOTATION\n") || $this->startsWith($markupDeclaration, "<!NOTATION\t"))
            $this->parseNotation(substr($markupDeclaration, strlen("<!NOTATION "), -1));
        else if ($this->startsWith($markupDeclaration, "<!ENTITY ")|| $this->startsWith($markupDeclaration, "<!ENTITY\n") || $this->startsWith($markupDeclaration, "<!ENTITY\t"))
            $this->parseEntityDeclaration(substr($markupDeclaration, strlen("<!ENTITY "), -1));
        else
        {
            $this->addFatalError("This declaration type does not exist (only ELEMENT, ATTLIST, NOTATION and ENTITY are possible).", $this->line);
        }
    }

    /**
     * Parses a processing instruction and adds it to the list of processing instruction. Adds an error if the parsing fails.
     * @param string $processingInstruction A processing instruction text, starting just after the left angle bracket and the question mark.
     */
    private function parseProcessingInstruction($processingInstruction)
    {
        $split = explode(' ', $processingInstruction, 2);
        if (count($split) !== 2)
        {
            $this->addFatalError("This processing instruction does not have a target.", $this->line);
            return;
        }
        if (!$this->isNameValid($split[0]))
        {
            $this->addFatalError("The target of a processing instruction must be a Name.", $this->line);
            return;
        }
        $this->processingInstructions = new ProcessingInstruction($split[0], $split[1]);
    }

    /**
     * Parses the given text as the contents of a DTD file.
     * @param string $text The text of the DTD file.
     * @param bool $isInternalSubset True, if the text is the contents of the internal subset of an XML file instead. There are additional restrictions by the specification on what can be present in the internal subset.
     */
    private function parseGlobalSpace($text, $isInternalSubset)
    {
        $this->line = 1;
        $this->currentOffset = 0;
        $includeSectionsOpened = 0;
        $ignoreSectionsOpened = 0;
        // 1. Normalize end-of-lines as per unicode spec
        $text = str_replace("\r\n", "\n", $text); // Quotes necessary, with apostrophes, it would not work.
        $text = str_replace("\r", "\n", $text);   // Quotes necessary, with apostrophes, it would not work.
                                                  // str_replace only counts a \n as a newline if it is within
                                                  // quotes.
        // 2. Remove comments
        // Comments should probably be saved as well. Someone might want to access them. In future versions of the
        // parser, this functionality should be added. Plus, multiline comments mess with line numbers in errors.
        $text = preg_replace('/<!--(([^-])|(-[^-]))*-->/', '', $text);
        $length = strlen($text);
        // 3. Go through the text, searching for
        //  a) %ref; Parameter entity reference.
        //  b) <!ELEMENT Name TextNoGt>
        //  c) <!ATTLIST Name TextNoGt>
        //  d) <!ENTITY (%) Name SYSTEMLITERALCONTAINSGT>
        //  e) <!NOTATION Name SYSTEMLITERALCONTAINSGT>
        //  f) <![ INCLUDE [ ]]>
        //  g) <![ IGNORE [ ]]>
        //  h) <!-- causes error, it should have been removed
        $this->currentOffset = $this->findNonSpace($text, $this->currentOffset, $length);
        while ($this->currentOffset !== false)
        {
             if (substr($text, $this->currentOffset, 3) === "]]>")
            {
                if ($ignoreSectionsOpened > 0)
                {
                    $ignoreSectionsOpened--;
                }
                else if ($includeSectionsOpened > 0)
                {
                    $includeSectionsOpened--;
                }
                else
                {
                    $this->addFatalError("The token ']]>' does not close any conditional section at this position.", $this->line);
                }
                $this->currentOffset += 3;
            }
            else if (substr($text, $this->currentOffset, 3) === "<![")
            {
                if ($isInternalSubset)
                {
                    $this->addFatalError("Internal subsets cannot contain conditional sections.", $this->line);
                }
                if ($ignoreSectionsOpened > 0)
                {
                    $ignoreSectionsOpened++;
                    $this->currentOffset += 3;
                }
                else
                {
                    // This is a conditional section.
                    $nextOpeningBrace = strpos($text, "[", $this->currentOffset + 3);
                    if ($nextOpeningBrace === false)
                    {
                        $this->addFatalError("The conditional section is missing its second opening bracket.", $this->line);
                        break;
                    }
                    $includeOrIgnore = substr($text, $this->currentOffset + 3, $nextOpeningBrace - $this->currentOffset - 3);
                    $includeOrIgnore = trim($this->evaluatePEReferencesIn($includeOrIgnore, Internal\PEStyle::IgnoreQuotedText));
                    if ($includeOrIgnore === "INCLUDE")
                    {
                        $includeSectionsOpened++;
                        $this->currentOffset = $nextOpeningBrace+1;
                    }
                    else if ($includeOrIgnore === "IGNORE")
                    {
                        $ignoreSectionsOpened++;
                        $this->currentOffset = $nextOpeningBrace+1;
                    }
                    else
                    {
                        $this->addFatalError("The marked section was neither INCLUDE nor IGNORE. No other marked sections are allowed in a DTD.", $this->line);
                        $this->currentOffset = $nextOpeningBrace + 1;
                    }
                }
            }
            elseif ($ignoreSectionsOpened == 0)
            {
                if (substr($text, $this->currentOffset, 1) === "%")
                {
                    // This is a parameter-entity reference.
                    $endingColon = strpos($text, ";", $this->currentOffset+1);
                    if ($endingColon === false)
                    {
                        $this->addFatalError("The parameter entity reference is not finished.", $this->line);
                        break;
                    }
                    else
                    {
                        $PEReferenceText = substr($text, $this->currentOffset+1, $endingColon - $this->currentOffset -1);
                        $this->parseGlobalPEReference($PEReferenceText);
                        $this->line += substr_count($PEReferenceText, "\n");
                        $this->currentOffset = $endingColon+1;
                    }
                }
                else if (substr($text, $this->currentOffset, 4) === "<!--")
                {
                    $this->addFatalError("The comment contained two consecutive dashes '--' which is not permitted. Perhaps your file contained nested comments?", $this->line);
                    break;
                }
                else if (substr($text, $this->currentOffset, 2) === "<!")
                {
                    // This is a declaration.
                    $tagBeginsAt = $this->currentOffset;
                    $inQuotes = false; $inApostrophes = false;
                    $this->currentOffset += 2;
                    $tagEndsAt = false;
                    while ($this->currentOffset < $length)
                    {
                        $character = substr($text, $this->currentOffset, 1);
                        if ($character === "'")
                        {
                            if (!$inQuotes) { $inApostrophes = !$inApostrophes;}
                        }
                        else if ($character === '"')
                        {
                            if (!$inApostrophes) { $inQuotes = !$inQuotes; }
                        }
                        else if ($character === '>')
                        {
                            if (!$inApostrophes && !$inQuotes)
                            {
                                $tagEndsAt = $this->currentOffset;
                                $this->currentOffset++;
                                break;
                            }
                        }
                        $this->currentOffset++;
                    }
                    if ($tagEndsAt === false)
                    {
                        $this->addFatalError("The markup declaration is not finished.", $this->line);
                        break;
                    }
                    else
                    {
                        $markupDeclaration = substr($text, $tagBeginsAt, $tagEndsAt - $tagBeginsAt+1);
                        $this->parseMarkupDeclaration($markupDeclaration);
                        $this->line += substr_count($markupDeclaration, "\n");
                    }
                }
                else if (substr($text, $this->currentOffset, 2) === "<?")
                {
                    $endAt = strpos($text, "?>", $this->currentOffset + 2);
                    if ($endAt === false)
                    {
                        $this->addFatalError("The processing instruction is not finished.", $this->line);
                        break;
                    }
                    $processing_instruction = substr($text, $this->currentOffset, $endAt - $this->currentOffset + 2);
                    $this->parseProcessingInstruction($processing_instruction);
                    $this->line += substr_count($processing_instruction, "\n");
                    $this->currentOffset = $endAt+2;
                }
                else if (substr($text, $this->currentOffset, 1) === "<")
                {
                    // This is a declaration.
                    $this->addFatalError("The character '<' here must be immediately followed by '!' or '?'." , $this->line);
                    break;
                }
                else
                {
                    $character = substr($text, $this->currentOffset, 1);
                    $this->addFatalError("The character '" . $character . "' is not permitted here (only '%', '< !' and '< ?' and possibly ']]>' are permitted)." , $this->line);
                    break;
                }
            }
            else
            {
                $this->currentOffset++;
            }
            // Find next character.
            $this->currentOffset = $this->findNonSpace($text, $this->currentOffset, $length);
        }
        if ($includeSectionsOpened > 0 || $ignoreSectionsOpened > 0)
        {
            $this->addFatalError("A conditional section was not closed by the end of the DTD.", $this->line);
        }
    }

    /**
     * Creates a new DTD object from the specified DTD text and internal subset. These texts are parsed immediately.
     * @param string $text The contents of a DTD file.
     * @param string $internalSubset The contents of an internal subset.
     */
    private function __construct($text, $internalSubset)
    {
        $this->xmlRegexes = new Internal\XmlRegexes();
        $this->parseGlobalSpace($internalSubset, true);
        $this->parseGlobalSpace($text, false);
    }

    /**
     * Parse the text given as though it were part of a .dtd file and return a \Soothsilver\DtdParser\DTD instance, even if
     * parsing fails.
     * @param string $text UTF-8 text to parse
     * @param string $internalSubset optionally, parse this XML internal subset in addition to the main DTD text given as the first parameter
     * @return DTD Object representing the parsed DTD document.
     */
    public static function parseText($text, $internalSubset = "")
    {
        $dtd = new DTD($text, $internalSubset);
        return $dtd;
    }
}

/**
 * Represents an XML notation declaration
 * @link http://www.w3.org/TR/REC-xml/#Notations
 * @ingroup SoothsilverDtdParser
 */
class Notation
{
    /**
     * @var string Notation name
     */
    public $name = "";
    /**
     * @var string Public ID or an empty string if there is no public ID
     */
    public $publicID = "";
    /**
     * @var string System ID (mandatory)
     */
    public $systemID = "";

    /**
     * Creates a new Notation.
     * @param string $name The notation name.
     * @param string $systemID The notation's system id.
     * @param string $publicID The notation's public id.
     */
    public function  __construct($name, $systemID, $publicID)
    {
        $this->name =$name;
        $this->systemID = $systemID;
        $this->publicID = $publicID;
    }
}
class Attribute
{
    const ATTTYPE_CDATA = "CDATA";
    const ATTTYPE_ID = "ID";
    const ATTTYPE_IDREF = "IDREF";
    const ATTTYPE_IDREFS = "IDREFS";
    const ATTTYPE_ENTITY = "ENTITY";
    const ATTTYPE_ENTITIES = "ENTITIES";
    const ATTTYPE_NMTOKEN = "NMTOKEN";
    const ATTTYPE_NMTOKENS = "NMTOKENS";
    const ATTTYPE_ENUMERATION = "##ENUMERATION_INTERNAL_IDENTIFIER##";
    const ATTTYPE_NOTATION = "NOTATION";
    const DEFAULT_REQUIRED = "#REQUIRED";
    const DEFAULT_IMPLIED = "#IMPLIED";
    const DEFAULT_FIXED = "#FIXED";
    const DEFAULT_IMPLICIT_DEFAULT = "##DEFAULT_VALUE_IF_EMPTY_INTERNAL_IDENTIFIER##";
    public $name;
    public $type;
    public $enumeration = array();
    public $defaultType;
    public $defaultValue;

    /**
     * @param      $name
     * @param      $type
     * @param      $defaultType
     * @param      $defaultValue
     * @param mixed $enumeration
     */
    public function __construct($name, $type, $defaultType, $defaultValue, $enumeration = false)
    {
        $this->name = $name;
        $this->enumeration = $enumeration;
        $this->type = $type;
        $this->defaultType = $defaultType;
        $this->defaultValue = $defaultValue;
    }
}
/**
 * Represents a processing instruction.
 */
class ProcessingInstruction
{
    /**
     * @var string $target The target of the processing instruction.
     */
    public $target;
    /**
     * @var string $data Data passed to the target of the processing instruction.
     */
    public $data;

    /**
     * Creates a new processing instruction.
     * @param string $target The target of the instruction.
     * @param string $data The data passed to the target.
     */
    public function __construct($target, $data)
    {
        $this->target = $target;
        $this->data = $data;
    }
}
class Element
{
    const CONTENT_SPECIFICATION_ANY = "ANY";
    const CONTENT_SPECIFICATION_EMPTY = "EMPTY";
    const CONTENT_SPECIFICATION_NOT_GIVEN = false;

    /**
     * @var boolean
     */
    public $mixed;

    /**
     * @var string
     */
    public $type = "";
    /**
     * @var string
     */
    public $contentSpecification = Element::CONTENT_SPECIFICATION_NOT_GIVEN;
    /**
     * @var Attribute[]
     */
    public $attributes = array();

    public function __construct($type, $contentModel, $mixed)
    {
        $this->mixed = $mixed;
        $this->type = $type;
        $this->contentSpecification = $contentModel;
    }
    public function isMixed()
    {
        return $this->mixed;
    }
    public function isPureText()
    {
        return $this->contentSpecification === "(#PCDATA)";
    }
}

class GeneralEntity
{
    /**
     * @var string
     */
    public $name = "";
    /**
     * @var string
     */
    public $replacementText = "";
    /**
     * @var string
     */
    public $notation = false;
    /**
     * @var bool
     */
    public $external = false;
    /**
     * @var string
     */
    public $systemId = false;
    /**
     * @var string
     */
    public $publicId = false;
    public function __construct($name, $replacementText, $external, $systemId, $publicId, $notation)
    {
        $this->name = $name;
        $this->replacementText = $replacementText;
        $this->notation = $notation;
        $this->external = $external;
        $this->systemId = $systemId;
        $this->publicId = $publicId;
    }
}
class ParameterEntity
{
    /**
     * @var string
     */
    public $name = "";
    /**
     * @var string
     */
    public $replacementText = "";
    /**
     * @var bool
     */
    public $external = false;
    /**
     * @var string
     */
    public $systemId = false;
    /**
     * @var string
     */
    public $publicId = false;
    public function __construct($name, $replacementText, $external, $systemId, $publicId)
    {
        $this->name = $name;
        $this->replacementText = $replacementText;
        $this->external = $external;
        $this->systemId = $systemId;
        $this->publicId = $publicId;
    }
}
class Error
{
    private $message;
    public function getMessage()
    {
        return $this->message;
    }
    public function __construct($message)
    {
        $this->message = $message;
    }
}

namespace Soothsilver\DtdParser\Internal;

/**
 * Contains regular expressions for various productions in the XML specification
 */
class XmlRegexes {
    /**
     * @var string The NameChar production.
     */
    public $NameChar;
    /**
     * @var string The NameStartChar production.
     */
    public $NameStartChar;
    /**
     * @var string The NAME production.
     */
    public $Name;
    /**
     * @var string The NMTOKEN production.
     */
    public $NmToken;

    /**
     * Initializes members with productions from the specification.
     */
    public function __construct()
    {
        $this->NameChar = "[:A-Z_a-z\\-.0-9\\xC0-\\xD6\\xD8-\\xF6\\xF8-\\x{2FF}\\x{370}-\\x{37D}\\x{37F}-\\x{1FFF}\\x{200C}-\\x{200D}\\x{2070}-\\x{218F}\\x{2C00}-\\x{2FEF}\\x{3001}-\\x{D7FF}\\x{F900}-\\x{FDCF}\\x{FDF0}-\\x{FFFD}\\x{10000}-\\x{EFFFF}]";
        $this->NameStartChar = "[:A-Z_a-z\-.0-9\\xB7\\xC0-\\xD6\\xD8-\\xF6\\xF8-\\x{37D}\\x{37F}-\\x{1FFF}\\x{200C}-\\x{200D}\\x{203F}-\\x{2040}\\x{2070}-\\x{218F}\\x{2C00}-\\x{2FEF}\\x{3001}-\\x{D7FF}\\x{F900}-\\x{FDCF}\\x{FDF0}-\\x{FFFD}\\x{10000}-\\x{EFFFF}]";
        $this->Name = "{$this->NameStartChar}{$this->NameChar}*";
        $this->NmToken = "{$this->NameChar}+";
    }
}

/**
 * Represents the parser state during the parsing of an ATTLIST declaration
 */
abstract class AttlistMode {
    const NeedName = 0;
    const NeedAttType = 1;
    const AfterNOTATION = 2;
    const InsideEnumeration_NeedValue = 3;
    const NeedDefaultDecl = 4;
    const InsideEnumeration_NeedSeparator = 5;
}

/**
 * Represents the state of the parser that determines what should be done about parameter entities found.
 */
abstract class PEStyle {
    /**
     * Do not expand parameter entities inside quotes. Expand all other parameter entities by adding a single space
     * before and after the replacement text, as per the specification.
     */
    const IgnoreQuotedText = 0;
    /**
     * Do not expand parameter entities inside quotes. Expand all other parameter entities by adding a single space
     * before and after the replacement text, as per the specification.
     *
     * In addition, add an error if, after replacement is done, there are unpaired parentheses. This is not currently
     * being done and should be improved in a future version.
     */
    const MatchingParentheses = 1;
    /**
     * Expand all parameter entities but do not add a single space before and after the replacement text, because we
     * are now in the middle of an entity declaration.
     */
    const InEntityDeclaration = 2;
}

/**
 * Represents the parser state.
 */
abstract class TokenizeMode {
    const Attlist = 0;
    const EntityDeclaration = 1;
    const NotationDeclaration = 2;
}
/**
 * @}
 */