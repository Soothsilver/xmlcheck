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