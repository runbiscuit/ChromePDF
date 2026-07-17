<?php

namespace Royalty\ChromePDF;

class ChromePDF {
	/**
	 * @var string Binary Path to Chrome
	 */
	private $binary_path;

	/**
	 * @var string URI to load in Chrome
	 */
	private $webpath = '';

	/**
	 * @var array Options
	 */
	private $options = [];

	public function __construct($binary_path = 'chrome') {
		$this->binary_path = $binary_path;
		$this->options['--disable-gpu'] = true;
	}
	
	/**
	 * Load a specified HTML string
	 * 
	 * @param string $html HTML String
	 * @return void
	 */
	public function loadHtml(string $html) {
		$this->webpath = 'data:text/html;base64,' . base64_encode($html);
	}

	/**
	 * Set a specified URL to be loaded by the browser.
	 * 
	 * @param string $url URL
	 * @return void
	 */
	public function setURL(string $url) {
		$this->webpath = $url;
	}

	/**
	 * Setting GPU acceleration.
	 * 
	 * @param bool $setting Setting Option
	 * @return void
	 */
	public function setGPUAcceleration(bool $setting) {
		$this->options['--disable-gpu'] = !$setting;
	}

	/**
	 * Turn on/off margins in output
	 * 
	 * @param bool $setting Setting Option
	 * @return void
	 */
	public function setMargins(bool $setting) {
		$this->options['--no-margin'] = !$setting;
	}

	/**
	 * Turn on/off headers and footers in output PDF
	 * 
	 * @param bool $setting Setting Option
	 * @return void
	 */
	public function setPDFHeaders(bool $setting) {
		$this->options['--print-to-pdf-no-header'] = !$setting;
	}

	/**
	 * Set window size
	 * 
	 * @param numeric $width Width
	 * @param numeric $height Height
	 * @return void
	 */
	public function setWindowSize($width, $height) {
		if (!is_numeric($width) || !is_numeric($height)) {
			throw new \Exception('$width or $height must be numeric values!');
		}

		$this->options['--window-size'] = $width . ',' . $height;
	}

	/**
	 * Set time to wait before rendering page
	 * 
	 * @param numeric $duration Duration (in ms)
	 * @return void
	 */
	public function setRenderWait($duration = 0) {
		if (!is_numeric($duration)) {
			throw new \Exception('$width or $height must be numeric values!');
		}

		$this->options['--virtual-time-budget'] = $duration;
	}

	/**
	 * Improve rendering quality (but may take longer to render)
	 * 
	 * @param bool $setting Setting Option
	 * @return void
	 */
	public function improveRenderingQuality(bool $setting = true) {
		$this->options['--run-all-compositor-stages-before-draw'] = $setting;
	}	

	/**
	 * Ignore certificate errors
	 * 
	 * WARNING: This disables Chrome's TLS/SSL certificate validation entirely,
	 * including checks for expired, self-signed, mismatched-hostname, or
	 * otherwise untrusted certificates. 
	 * This makes the tool vulnerable to man-in-the-middle attacks 
	 * and should NEVER be enabled when connecting over untrusted (external) networks 
	 * 
	 * Use ONLY for local development, internal testing against known-safe hosts, 
	 * or automated test suites where the target server and network 
	 * are fully controlled and trusted. 
	 * 
	 * @param bool $setting Setting Option
	 * @return void
	 */
	public function ignoreCertificateErrors(bool $setting = true) {
		$this->options['--ignore-certificate-errors'] = $setting;
	}

	/**
	 * Write options for the final command
	 * 
	 * @return string
	 */
	private function writeOptions() {
		$options = [];

		foreach ($this->options as $key => $value) {
			if (gettype($value) == 'boolean') {
				if ($value == true) $options[] = $key;
				else continue;
			}

			else {
				$options[] = $key . '=' . $value;
			}
		}

		return implode(' ', $options);
	}

	/**
	 * Render as HTML
	 * 
	 * @param string|null $output Output Path
	 * @param boolean $verbose Verbose?
	 * @return string $output_path
	 */
	public function save($output_path = null, $verbose = false) {
		if ($output_path == null) {
			$output_path = tempnam(sys_get_temp_dir(), 'output') . '.pdf';
		}

		$this->webpath = str_replace("'", "\'", $this->webpath);

		$command = "'$this->binary_path' --headless --print-to-pdf='$output_path' " . $this->writeOptions() . " '$this->webpath'";

		if ($verbose) echo "Running " . $command . PHP_EOL;
		$result = shell_exec(posix_getpwuid(posix_geteuid())['shell'] . ' -c "' . $command . '" 2>&1');
		if ($verbose) echo "File generated: " . $output_path . PHP_EOL;

		return $output_path;
	}
}