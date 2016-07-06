<?php namespace Tattoo\Tests;
/**
 * Tattoo Integration tests
 ** 
 *
 * @package 		Tattoo
 * @copyright 		Mario Döring
 *
 * @group Tattoo
 * @group Tattoo_Integration
 */

use Tattoo\Tattoo;

class IntegrationTests extends \PHPUnit_Framework_TestCase
{
	/**
	 * Run some tattoo code and return the output
	 */
	protected function runTattooCode($code = null)
	{
		$tattoo = new Tattoo;

		ob_start();

		// Attention EEEVAAAAAALLLL COMMINNNGG
		eval($tattoo->compile($tattoo->parse($code)));

		return ob_get_clean();
	}

	/**
	 * Parse the give integration file contents
	 */
	protected function parseIntegrationFile($file)
	{
		$contents = file_get_contents($file);
		$parts = array();

		while (($pos = strpos($contents, '// *--')) !== false) 
		{
			$parts[] = substr($contents, 0, $pos);
			$contents = substr($contents, $pos + 6);
		}

		// add last one
		$parts[] = $contents;

		// filter the parts
		$parts = array_filter($parts);
		$tests = array();

		// now parse the code parts
		foreach ($parts as $part) 
		{
			// get the test title
			$test = array(
				'title' => trim(substr($part, 0, strpos($part, '--*'))),
				'file' => basename($file),
			);
			$part = substr($part, strpos($part, '--*') + 3);

			// now split code from exprected
			list($code, $expected) = explode('===', $part);

			// clean them for the test
			$test['code'] = trim($code);
			$test['expected'] = trim($expected);

			// add the test
			$tests[] = $test;
		}

		// execute the tests 
		$this->executeIntegrationTestArray($tests);
	}

	/**
	 * Execute the recieved tests array
	 */
	protected function executeIntegrationTestArray(array $tests)
	{
		foreach ($tests as $test) 
		{
			try {
				$output = $this->runTattooCode($test['code']);
			} catch (\Exception $e) 
			{
				throw new \Exception($test['title'] . ' integration test failed, exception has been thrown: ' . $e->getMessage() . ' in file: ' . $test['file']);
			}
			
			$this->assertEquals($test['expected'], $output);
		}
	}

	/**
	 * Runs the integration test files, not sure if "integration" is the correct term doe
	 */
	public function testIntegrations()
	{	
		foreach(glob(__DIR__ . '/../tests-integrity/*.test') as $file)
		{
			$this->parseIntegrationFile($file);
		}
	}
}