<?php
use asm\utils\Filesystem;

require_once __DIR__ . "/checkerRunner.php";

class DomSaxTest extends PHPUnit_Framework_TestCase {
    private function runDomSax($zipFile, $fulfillment = null, $details = "")
    {
        $result = CheckerRunner::runChecker(new DomSaxMockChecker(), Filesystem::combinePaths(CheckerRunner::$root, "phptests/plugins/cases/DOMSAX",  $zipFile), []);
        CheckerRunner::assert($this, $zipFile, $result, $fulfillment, $details);
    }

    public function testPetrHudecek()
    {
        $this->runDomSax("PetrHudecekDomSax.zip", 100);
    }
    public function testBotanickyUstav()
    {
        $this->runDomSax("domSax_correct.zip", 100);
    }
    public function testException()
    {
        $this->runDomSax("domSax_badDomScript_exception.zip", 50, "NullPointerException");
    }
    public function testNotCompilable()
    {
        $this->runDomSax("domSax_badSaxScript_notCompilable.zip", 50, "Ouch, this will not compile, I guess.");
    }
    public function testDtdMissing()
    {
        $this->runDomSax("domSax_badXml_dtdMissing.zip", 0, "The system cannot find the file specified");
    }
    public function testNotWellFormed()
    {
        $this->runDomSax("domSax_badXml_notWellFormed.zip", 0, "XML document structures must start and end within the same entity.");
    }

    public function testPrintingFromDom()
    {
        $this->runDomSax('domprint.zip', 100);
    }

    public function testEmptyZip()
    {
        $this->runDomSax('nofiles.zip', 0);
    }

    public function testCompileError()
    {
        $this->runDomSax('errorcompile.zip', 50, "throw new Exception(");
    }

    public function testSaxException()
    {
        $this->runDomSax('exception.zip', 50, "My User Exception");
    }



}
class DomSaxMockChecker
{
    function run($array)
    {
        $zipFile = $array[0];
        if (count($array) !== 1) { throw new InvalidArgumentException("This must receive 1 parameter in the array exactly."); }
        $launcher = new \asm\core\JavaLauncher();
        $pluginResults = ""; $response = null;
        $error = $launcher->launch(Filesystem::combinePaths(CheckerRunner::$root , "/files/plugins/XML DomSax/DomSaxPlugin.jar"), array($zipFile), $responseString);
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