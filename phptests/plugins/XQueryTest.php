<?php
use asm\utils\Filesystem;

require_once __DIR__ . "/checkerRunner.php";

class XQueryTest extends PHPUnit_Framework_TestCase {
    private function runXQuery($zipFile, $queryCount, $fulfillment = null, $details = "")
    {
        $result = CheckerRunner::runChecker(new XQueryMockChecker(), Filesystem::combinePaths(CheckerRunner::$root, "phptests/plugins/cases/XQUERY",  $zipFile), [$queryCount]);
        CheckerRunner::assert($this, $zipFile, $result, $fulfillment, $details);
    }

    public function testPetrHudecek()
    {
        $this->runXQuery("PetrHudecekXQuery.zip", 5, 100);
    }
}
class XQueryMockChecker
{
    function run($array)
    {
        $zipFile = $array[0];
        if (count($array) !== 2) { throw new InvalidArgumentException("This must receive 2 parameters in the array exactly."); }
        $launcher = new \asm\core\JavaLauncher();
        $pluginResults = ""; $response = null;
        $error = $launcher->launch(Filesystem::combinePaths(CheckerRunner::$root , "/files/plugins/XML XQuery/XQueryPlugin.jar"), array($zipFile, $array[1]), $responseString);
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