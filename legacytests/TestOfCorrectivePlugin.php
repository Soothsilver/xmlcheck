<?php
use asm\core\Config;
use asm\core\Core;
use asm\utils\Autoload;
use asm\utils\ErrorHandler;
use asm\core\UiResponse;
use asm\core\Error;
require_once '../vendor/autoload.php';
Config::init('../core/config.ini', '../core/internal.ini');


require_once('../files/plugins/XML XPath/XpathChecker.php');
require_once('../files/plugins/DTD2014/Dtd2014Checker.php');
require_once('../files/plugins/XML XMLSchema/XmlSchemaChecker.php');
require_once('../files/plugins/XML XSLT/XsltChecker.php');



abstract class PluginName
{
    const XQuery = 'XQuery';
    const DTD2014 = 'Dtd2014Checker';
    const XPath = 'XpathChecker';
    const DomSax ='DomSax';
    const XmlSchema = 'XmlSchemaChecker';
    const Xslt = 'XsltChecker';
}
class DomSax {
    function run($array)
    {
        $zipFile = $array[0];
        if (count($array) == 2)
        {
            $queryCount = $array[1];
        }
        else {
            $queryCount = 5;
        }
        $launcher = new \asm\core\JavaLauncher();
        $pluginResults = ""; $response = null;
        $error = $launcher->launch("../files/plugins/XML DomSax/DomSaxPlugin.jar", array($zipFile, $queryCount), $responseString);
        if (!$error)
        {
            if (isset($responseString))
            {
                try {
                    $response = \asm\plugin\PluginResponse::fromXml(simplexml_load_string($responseString));
                }
                catch (Exception $ex)
                {
                    $response = \asm\plugin\PluginResponse::createError('Internal error. Plugin did not supply valid response XML and this error occured: ' . $ex->getMessage());
                }
            }
        }
        else
        {
            $response = \asm\plugin\PluginResponse::createError('Plugin cannot be launched (' . $error . ').');
        }
        return $response;
    }
}
class XQuery {
    function run($array)
    {
        $zipFile = $array[0];
        if (count($array) == 2)
        {
            $queryCount = $array[1];
        }
        else {
            $queryCount = 5;
        }
        $launcher = new \asm\core\JavaLauncher();
        $pluginResults = ""; $response = null;
        $error = $launcher->launch("../files/plugins/XML XQuery/XQueryPlugin.jar", array($zipFile, $queryCount), $responseString);
        if (!$error)
        {
            if (isset($responseString))
            {
                try {
                    $response = \asm\plugin\PluginResponse::fromXml(simplexml_load_string($responseString));
                }
                catch (Exception $ex)
                {
                    $response = \asm\plugin\PluginResponse::createError('Internal error. Plugin did not supply valid response XML and this error occured: ' . $ex->getMessage());
                }
            }
        }
        else
        {
            $response = \asm\plugin\PluginResponse::createError('Plugin cannot be launched (' . $error . ').');
        }
        return $response;
    }
}

class TestOfCorrectivePlugin
{

    public $testsExecuted = 0;
    public $assertionsExecuted = 0;
    public $assertionsFailed = 0;
    public function runTest($testCaseName, $pluginName, $zipFile, array $arguments = null)
    {
        $this->testsExecuted++;
        echo "<br>" . $this->testsExecuted . ". <b>" . $testCaseName . "</b>: Testing " . $pluginName . " ";
        $tester = new $pluginName();
        array_unshift($arguments, $zipFile);
        $testResult = $tester->run($arguments);
      //  echo $testResult->getDetails();
        return $testResult;
    }
    public function assertFulfillment(\asm\plugin\PluginResponse $result, $fulfillmentExpected)
    {
        $this->assertionsExecuted++;
        if (round($result->getFulfillment()) == $fulfillmentExpected)
        {
            echo "[result OK (" . $fulfillmentExpected .")] ";
        }
        else
        {
            echo "<span style='color: red'>[fulfillment error (expected: " . $fulfillmentExpected . "; actual: " . round($result->getFulfillment()) . ")] [details: " . nl2br($result->getDetails()) . "]</span>";
            $this->assertionsFailed++;
        }
    }
    public function assertDetailsContains(\asm\plugin\PluginResponse $result, $partOfDetails)
    {
        $this->assertionsExecuted++;
        if (strpos($result->getDetails(), $partOfDetails) !== FALSE)
        {
            echo "[details OK] ";
        }
        else
        {
            echo "<span style='color: red'>[details error (wanted: " . $partOfDetails . " in details) [details: " . nl2br($result->getDetails()) . "]</span>";
            $this->assertionsFailed++;
        }
    }
}

